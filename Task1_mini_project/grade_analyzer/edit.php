<?php
declare(strict_types=1);
require 'session.php';

$students = $_SESSION['student_data'] ?? [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST['students'] as $name => $subjects) {
        foreach ($subjects as $subject => $score) {
            $students[$name][$subject] = floatval($score);
        }
    }
    $_SESSION['student_data'] = $students;
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Student Data</h1>
    <form method="POST">
        <?php foreach ($students as $name => $subjects): ?>
            <h3><?= htmlspecialchars($name) ?></h3>
            <?php foreach ($subjects as $subject => $score): ?>
                <label><?= htmlspecialchars($subject) ?>:</label>
                <input type="number" name="students[<?= htmlspecialchars($name) ?>][<?= htmlspecialchars($subject) ?>]" value="<?= $score ?>" min="0" step = "0.5" max="100" required>
            <?php endforeach; ?>
            <br><br>
        <?php endforeach; ?>
        <button type="submit">Save Changes</button>
    </form>
</div>
</body>
</html>
