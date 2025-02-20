<?php
session_start();
require_once __DIR__ . "/../classes/GradeAnalyzer.php";

$analyzer = new GradeAnalyzer();
$subjects = $analyzer->getSubjects();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Student Marks</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Enter Student Details</h2>
        <form action="process.php" method="post">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>

            <?php foreach ($subjects as $subject): ?>
                <label for="marks_<?php echo strtolower($subject); ?>"><?php echo $subject; ?>:</label>
                <input type="number" id="marks_<?php echo strtolower($subject); ?>" 
                    name="marks[<?php echo $subject; ?>]" required min="0" max="100">
            <?php endforeach; ?>

            <button type="submit">Submit</button>
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
