<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade Analyzer</title>
</head>
<body>
    <h2>Enter Student Details</h2>
    <form action="process.php" method="post">
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" required>
        <?php foreach (["Math", "Science", "English", "History", "Computer"] as $subject): ?>
            <label for="marks_<?php echo $subject; ?>"><?php echo $subject; ?>:</label>
            <input type="number" id="marks_<?php echo $subject; ?>" name="marks[<?php echo $subject; ?>]" required min="0" max="100">
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
