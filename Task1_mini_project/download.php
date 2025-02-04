<?php
session_start();
if (!isset($_SESSION['student_data'])) {
    die("No data available for download.");
}

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=grade_report.csv");

$output = fopen("php://output", "w");
fputcsv($output, ["Student", "Subject", "Score"]);

foreach ($_SESSION['student_data'] as $name => $subjects) {
    foreach ($subjects as $subject => $score) {
        fputcsv($output, [$name, $subject, $score]);
    }
}

fclose($output);
exit();
?>
