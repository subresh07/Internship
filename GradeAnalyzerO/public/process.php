<?php
session_start();
require_once __DIR__ . "/../classes/GradeAnalyzer.php";
require_once __DIR__ . "/../classes/MarksheetGene.php";

$analyzer = new GradeAnalyzer();
$subjects = $analyzer->getSubjects();

if (isset($_POST['student_name'])) {
    $marks = [];
    foreach ($subjects as $subject) {
        $marks[$subject] = $_POST["marks"][$subject] ?? 0;
    }
    $analyzer->addStudent($_POST['student_name'], $marks);
    header("Location: process.php?step=3");
    exit;
}

if (isset($_GET['step']) && $_GET['step'] == 3) {
    $students = $analyzer->getAllStudents();
    $marksheet = new MarksheetGene($students);
    $marksheet->displayMarksheets();
}
