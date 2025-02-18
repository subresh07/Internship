<?php
session_start();
require_once "classes/GradeAnalyzer.php";

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
    ?>
    <h2>Student Marksheets</h2>
    <?php foreach ($students as $student): ?>
        <h3>Marksheet for <?php echo $student->getName(); ?></h3>
        <table border="1">
            <tr><th>Subject</th><th>Score</th></tr>
            <?php foreach ($student->getMarks() as $subject => $score): ?>
                <tr><td><?php echo $subject; ?></td><td><?php echo $score; ?></td></tr>
            <?php endforeach; ?>
        </table>
        <p><strong>Total Score:</strong> <?php echo $student->getTotalScore(); ?></p>
        <p><strong>Average Score:</strong> <?php echo number_format($student->getAverageScore(), 2); ?></p>
        <p><strong>Recommendation:</strong> <?php echo $analyzer->generateRecommendation($student->getAverageScore()); ?></p>
        <hr>
    <?php endforeach; ?>
    <a href="index.php">Start Over</a>
    <?php
    exit;
}
