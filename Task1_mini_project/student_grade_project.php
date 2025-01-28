<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Analysis Program</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-size: 14px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f7f7f7;
        }
        .results {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Grade Analysis</h1>

        <?php
        
        function collectStudentData() {
            if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST['num_students'])) {
                return [];
            }
        
            $num_students = (int) $_POST['num_students'];
        
         
            if ($num_students <= 0) {
                echo "<p style='color: red;'>Invalid number of students. Please enter a positive number.</p>";
                return [];
            }
        
            $students = [];
            for ($i = 0; $i < $num_students; $i++) {
                $name = trim($_POST["name_$i"] ?? '');
                $score = isset($_POST["score_$i"]) ? (float) $_POST["score_$i"] : -1;
        
               
                if (empty($name)) {
                    // echo "<p style='color: red;'>Student name for entry " . ($i + 1) . " cannot be empty.</p>";
                    return [];
                }
        
                if ($score < 0 || $score > 100) {
                    echo "<p style='color: red;'>Invalid score for $name. Scores must be between 0 and 100.</p>";
                    return [];
                }
        
                $students[$name] = $score;
            }
        
            return $students;
        }
        

        function calculateAnalysis($students) {
            $total_students = count($students);
            $average_score = $total_students > 0 ? array_sum($students) / $total_students : 0;
            $highest_score = max($students);
            $lowest_score = min($students);
            $highest_name = array_search($highest_score, $students);
            $lowest_name = array_search($lowest_score, $students);
            $above_average_count = count(array_filter($students, fn($score) => $score > $average_score));

            return [
                'total' => $total_students,
                'average' => $average_score,
                'highest' => ['name' => $highest_name, 'score' => $highest_score],
                'lowest' => ['name' => $lowest_name, 'score' => $lowest_score],
                'above_average' => $above_average_count
            ];
        }

    
        function displayResults($students, $analysis) {
            echo "<h2>Student Data</h2>";
            echo "<table>";
            echo "<thead><tr><th>Student Name</th><th>Score</th></tr></thead>";
            echo "<tbody>";
            foreach ($students as $name => $score) {
                echo "<tr><td>$name</td><td>$score</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";

            echo "<div class='results'>";
            echo "<h2>Analysis Results</h2>";
            echo "<p>Total students: " . $analysis['total'] . "</p>";
            echo "<p>Average score: " . number_format($analysis['average'], 2) . "</p>";
            echo "<p>Highest score: " . $analysis['highest']['score'] . " by " . $analysis['highest']['name'] . "</p>";
            echo "<p>Lowest score: " . $analysis['lowest']['score'] . " by " . $analysis['lowest']['name'] . "</p>";
            echo "<p>Students above average: " . $analysis['above_average'] . "</p>";
            echo "</div>";
        }

   
function main() {
    $students = collectStudentData();

    if (empty($students) && !isset($_POST['num_students'])) {
        echo '<form method="POST">';
        echo '<div class="form-group">';
        echo '<label for="num_students">Number of students:</label>';
        echo '<input type="number" id="num_students" name="num_students" min="1" required>';
        echo '</div>';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    } elseif (empty($students)) {
        $num_students = $_POST['num_students'] ?? 0;
        echo '<form method="POST">';
        for ($i = 0; $i < $num_students; $i++) {
            echo '<div class="form-group">';
            echo "<label for='name_$i'>Student " . ($i + 1) . " Name:</label>";
            echo "<input type='text' id='name_$i' name='name_$i' required>";
            echo "<label for='score_$i' style='grid-column: 2; grid-row: " . (2 * $i + 1) . "'>Student " . ($i + 1) . " Score:</label>";
            echo "<input type='number' id='score_$i' name='score_$i' min='0' max='100' required style='grid-column: 2; grid-row: " . (2 * $i + 2) . "'>";
            echo '</div>';
        }
        echo "<input type='hidden' name='num_students' value='$num_students'>";
        echo '<input type="submit" value="Submit Grades">';
        echo '</form>';
    } else {
        $analysis = calculateAnalysis($students);
        displayResults($students, $analysis);
    }
}

main();

        ?>
    </div>
</body>
</html>
