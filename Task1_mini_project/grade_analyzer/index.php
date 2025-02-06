<?php
declare(strict_types=1);
// Start the session at the very top to avoid issues with headers already being sent
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include required files
require 'csv_parser.php';
require 'data_analysis.php';
require 'recommendations.php';

// Handle form submission for deleting student data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_student'])) {
    $student_name = $_POST['delete_student'];
    unset($_SESSION['student_data'][$student_name]);
    header("Location: index.php");
    exit();
}

// Handle form submission for saving student data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['students'])) {
    $students = $_SESSION['student_data'] ?? [];

    // Process student data
    foreach ($_POST['students'] as $name => $subjects) {
        foreach ($subjects as $subject => $score) {
            $students[$name][$subject] = floatval($score);
        }
    }
    $_SESSION['student_data'] = $students;
    header("Location: index.php");
    exit();
}

// Handle CSV upload for parsing and skipping manual entry
if (isset($_FILES['file_upload']) && $_FILES["file_upload"]["error"] === UPLOAD_ERR_OK) {
    $_SESSION['student_data'] = parseCSV($_FILES["file_upload"]["tmp_name"]);
    $_SESSION['step'] = 4; // Skip manual entry and go directly to results
    header("Location: index.php");
    exit();
}

// Handle step-by-step processing
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1: Choose number of students
    if (isset($_POST['num_students'])) {
        $_SESSION['num_students'] = (int) $_POST['num_students'];
        $_SESSION['step'] = 2;
        header("Location: index.php");
        exit();
    }

    // Step 2: Enter student names
    if (isset($_POST['name_0'])) {
        $students = [];
        foreach ($_POST['name_0'] as $i => $name) {
            $name = trim($name);
            if (empty($name)) {
                echo "<p class='error'>Student name cannot be empty!</p>";
                return;
            }
            $students[$name] = $_POST['subjects'][$i]; // Add subject data
        }
        $_SESSION['student_data'] = $students;
        $_SESSION['step'] = 3;
        header("Location: index.php");
        exit();
    }
}

// Reset session data (if requested)
if (isset($_POST['reset'])) {
    resetSession();
    header("Location: index.php");
    exit();
}

// Generate recommendations and analysis if data is available
$students = $_SESSION['student_data'] ?? [];
$analysis = !empty($students) ? calculateAnalysis($students) : null;
$recommendations = generateRecommendations($students);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade analyzer System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Student Recommendation System</h1>

        <form method="POST">
            <button type="submit" name="reset">Reset</button>
        </form>

        <?php if (!isset($_SESSION['step']) || $_SESSION['step'] == 1): ?>
            <h2>Step 1: Choose Input Method</h2>

            <h3>Upload CSV File</h3>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="file_upload" required>
                <button type="submit">Upload</button>
            </form>

            <h3>
                <p class=or>OR</p>
            </h3>

            <h3>Enter Data Manually</h3>
            <form action="process.php" method="POST">
                <label>Number of Students:</label>
                <input type="number" name="num_students" min="1" max="150" required>
                <button type="submit">Next</button>
            </form>

        <?php elseif ($_SESSION['step'] == 2): ?>
            <h2>Step 2: Enter Student Names</h2>
            <form action="process.php" method="POST">
                <?php for ($i = 0; $i < $_SESSION['num_students']; $i++): ?>
                    <label>Student <?= $i + 1 ?> Name:</label>
                    <input type="text" name="name_<?= $i ?>" required>
                    <br><br>
                <?php endfor; ?>
                <button type="submit">Next</button>
            </form>

        <?php elseif ($_SESSION['step'] == 3): ?>
            <h2>Step 3: Enter Marks for Each Student</h2>
            <form action="process.php" method="POST">
                <?php for ($i = 0; $i < $_SESSION['num_students']; $i++): ?>
                    <fieldset>
                        <legend>Student <?= $i + 1 ?> - <?= htmlspecialchars($_SESSION['student_names'][$i]) ?></legend>
                        <fieldset>
                            <legend>Subjects & Marks</legend>
                            <?php foreach ($_SESSION['subjects'] as $subject): ?>
                                <label><?= $subject ?>:</label>
                                <input type="number" name="subject_score_<?= $i ?>[<?= $subject ?>]" min="0" max="100" step="0.5"
                                    required>

                                <br>
                            <?php endforeach; ?>
                        </fieldset>
                    </fieldset>
                <?php endfor; ?>
                <button type="submit" name="submit_grades">Submit Grades</button>
            </form>

        <?php elseif ($_SESSION['step'] == 4): ?>
            <h2>Results</h2>
            <p>Total Students: <?= count($students) ?></p>

            <?php
            // Pagination Settings
            $students_per_page = 10; // Show 50 students per page
            $total_students = count($students);
            $total_pages = ceil($total_students / $students_per_page);
            $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
            if ($current_page < 1)
                $current_page = 1;
            if ($current_page > $total_pages)
                $current_page = $total_pages;

            // Get students for the current page
            $start_index = ($current_page - 1) * $students_per_page;
            $students_on_page = array_slice($students, $start_index, $students_per_page, true);
            ?>

            <h3>Student Records (Page <?= $current_page ?> of <?= $total_pages ?>)</h3>
            <ul>
                <?php foreach ($students_on_page as $name => $subjects): ?>
                    <li><strong><?= htmlspecialchars($name) ?>:</strong>
                        <ul>
                            <?php foreach ($subjects as $subject => $score): ?>
                                <li><?= htmlspecialchars($subject) ?> - <?= $score ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Pagination Controls -->
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?= $current_page - 1 ?>">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $i == $current_page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?= $current_page + 1 ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>


            <h2>Analysis</h2>
            <p>Total Students: <?= $analysis['total'] ?></p>
            <p>Average Score: <?= number_format($analysis['average'], 2) ?></p>
            <p>Highest Score: <?= $analysis['highest']['score'] ?> by <?= $analysis['highest']['name'] ?></p>
            <p>Lowest Score: <?= $analysis['lowest']['score'] ?> by <?= $analysis['lowest']['name'] ?></p>

            <h3>Recommendations</h3>
            <ul>
                <?php
                // Show recommendations only for students on the current page
                $recommendations_on_page = array_slice($recommendations, $start_index, $students_per_page, true);
                foreach ($recommendations_on_page as $student => $message): ?>
                    <li><strong><?= htmlspecialchars($student) ?>:</strong> <?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>

            <h2>Edit Data</h2>
            <a href="edit.php">Edit Uploaded Data</a>

            <h2>Export Data</h2>
            <a href="export.php">Download CSV</a>

            <h2>Delete Student Records</h2>
            <form method="POST" action="delete.php">
                <select name="delete_student">
                    <?php foreach ($_SESSION['student_data'] as $name => $subjects): ?>
                        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Delete</button>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>

<?php
// Function to reset the session
function resetSession()
{
    session_unset();
    session_destroy();
    session_start();
}
?>