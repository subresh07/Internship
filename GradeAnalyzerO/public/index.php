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
    <title>Grade Analyzer</title>
</head>
<body>
    <h2>Welcome to the Grade Analyzer</h2>
    <a href="user.php">Enter Student Details</a>
</body>
</html>
