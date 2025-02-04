<?php
session_start();

function resetSession() {
    session_unset();
    session_destroy();
    session_start();
}

if (isset($_POST['reset'])) {
    resetSession();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function parseCSV($filename) {
    $students = [];
    if (($handle = fopen($filename, "r")) !== false) {
        fgetcsv($handle); // Skip header row
        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) !== 3) continue;

            [$name, $subject, $score] = $data;
            $name = trim($name);
            $subject = trim($subject);
            $score = floatval($score);

            if (empty($name) || empty($subject) || $score < 0 || $score > 100) continue;

            $students[$name][$subject] = $score;
        }
        fclose($handle);
    }
    return $students;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['num_students'])) {
        $_SESSION['num_students'] = (int) $_POST['num_students'];
        $_SESSION['step'] = 2;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['num_subjects'])) {
        $_SESSION['subjects_per_student'] = $_POST['num_subjects'];
        $_SESSION['step'] = 3;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST['submit_grades'])) {
        $students = [];
        foreach ($_SESSION['subjects_per_student'] as $i => $num_subjects) {
            $name = trim($_POST["name_$i"] ?? '');
            if (empty($name)) {
                echo "<p class='error'>Student name cannot be empty!</p>";
                return;
            }

            for ($j = 0; $j < $num_subjects; $j++) {
                $subject_name = trim($_POST["subject_name_{$i}_$j"] ?? '');
                $subject_score = isset($_POST["subject_score_{$i}_$j"]) ? (float) $_POST["subject_score_{$i}_$j"] : -1;

                if (empty($subject_name) || $subject_score < 0 || $subject_score > 100) {
                    echo "<p class='error'>Invalid subject entry for " . htmlspecialchars($name) . ".</p>";
                    return;
                }

                $students[$name][$subject_name] = $subject_score;
            }
        }

        $_SESSION['student_data'] = $students;
        $_SESSION['step'] = 4;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_FILES["file_upload"]) && $_FILES["file_upload"]["error"] === UPLOAD_ERR_OK) {
        $_SESSION['student_data'] = parseCSV($_FILES["file_upload"]["tmp_name"]);
        $_SESSION['step'] = 4;
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

function calculateAnalysis($students) {
    $all_scores = [];
    foreach ($students as $subjects) {
        foreach ($subjects as $score) {
            $all_scores[] = $score;
        }
    }

    if (empty($all_scores)) {
        return [
            'total' => count($students),
            'average' => 0,
            'highest' => ['name' => 'N/A', 'score' => 0],
            'lowest' => ['name' => 'N/A', 'score' => 0],
            'above_average' => 0
        ];
    }

    $average_score = array_sum($all_scores) / count($all_scores);
    $highest_score = max($all_scores);
    $lowest_score = min($all_scores);

    $highest_name = '';
    $lowest_name = '';

    foreach ($students as $name => $subjects) {
        if (in_array($highest_score, $subjects)) $highest_name = $name;
        if (in_array($lowest_score, $subjects)) $lowest_name = $name;
    }

    $above_average_count = count(array_filter($all_scores, fn($score) => $score > $average_score));

    return [
        'total' => count($students),
        'average' => $average_score,
        'highest' => ['name' => $highest_name, 'score' => $highest_score],
        'lowest' => ['name' => $lowest_name, 'score' => $lowest_score],
        'above_average' => $above_average_count
    ];
}

$students = $_SESSION['student_data'] ?? [];
$analysis = !empty($students) ? calculateAnalysis($students) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Analyzer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div>
    <h1>Grade Analyzer</h1>

<form method="POST">
    <button type="submit" name="reset">Reset</button><br><br>
</form>

<?php if (!isset($_SESSION['step']) || $_SESSION['step'] == 1): ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Enter Number of Students:</label>
        <input type="number" name="num_students" min="1" max= "150" required>
        <br><br>
        <button type="submit">Next</button>

        <h2> OR </h2>

        <h2>  Upload CSV File </h2>
        <input type="file" name="file_upload">
        <button type="submit">Upload</button>
    </form>


<?php elseif ($_SESSION['step'] == 2): ?>
    <form method="POST">
        <?php for ($i = 0; $i < $_SESSION['num_students']; $i++): ?>
            <label>Number of Subjects for Student <?= $i + 1  ?>:</label>
            <input type="number" name="num_subjects[<?= $i ?>]" min="1" max="10" required>
            <br><br>
        <?php endfor; ?>
        <button type="submit">Next</button>
    </form>

<?php elseif ($_SESSION['step'] == 3): ?>
    <form method="POST">
    <?php for ($i = 0; $i < $_SESSION['num_students']; $i++): ?>
        <fieldset>
            <legend><strong>Student <?= $i + 1 ?> Details</strong></legend>

            <label for="name_<?= $i ?>"><strong>Student Name:</strong></label>
            <input type="text" id="name_<?= $i ?>" name="name_<?= $i ?>" required>
            <br><br>

            <fieldset>
                <legend><strong>Subjects & Scores</strong></legend>
                <?php for ($j = 0; $j < $_SESSION['subjects_per_student'][$i]; $j++): ?>
                    <div class="subject-container">
                        <label for="subject_name_<?= $i ?>_<?= $j ?>"><strong>Subject Name <?= $j + 1 ?>:</strong></label>
                        <input type="text" id="subject_name_<?= $i ?>_<?= $j ?>" name="subject_name_<?= $i ?>_<?= $j ?>" required>
                        <br><br>

                        <label for="subject_score_<?= $i ?>_<?= $j ?>"><strong>Score:</strong></label>
                        <input type="number" id="subject_score_<?= $i ?>_<?= $j ?>" name="subject_score_<?= $i ?>_<?= $j ?>" min="0" max="100" required>
                        <br><br>
                    </div>
                <?php endfor; ?>
            </fieldset>
        </fieldset>
        <br>
    <?php endfor; ?>

    <br><br>
    <button type="submit" name="submit_grades">Submit Grades</button>
</form>


<?php else: ?>

    <h2>Results</h2>
    <p>Total Students: <?= $analysis['total'] ?></p>
    <p>Average Score: <?= number_format($analysis['average'], 2) ?></p>
    <p>Maximum Score: <?= $analysis['highest']['score'] . "by" . $analysis['highest']['name'] ?> </p>
    <p></p>

<?php endif; ?>

    </div>

</div>
</body>
</html>



<!-- // echo "<div class='results'>";
//     echo "<h2>Analysis Results</h2>";
//     echo "<p>Total students: " . $analysis['total'] . "</p>";
//     echo "<p>Average score: " . number_format($analysis['average'], 2) . "</p>";
//     echo "<p>Highest score: " . $analysis['highest']['score'] . " by " . $analysis['highest']['name'] . "</p>";
//     echo "<p>Lowest score: " . $analysis['lowest']['score'] . " by " . $analysis['lowest']['name'] . "</p>";
//     echo "<p>Students above average: " . $analysis['above_average'] . "</p>";
//     echo "</div>"; -->
