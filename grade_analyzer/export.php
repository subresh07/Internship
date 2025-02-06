<?php
declare(strict_types=1);
require 'session.php';

// Set headers for CSV download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=students_data.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write header row
$header = ["Student Name", "English", "Nepali", "Maths", "Science", "Social", "Computer"];
fputcsv($output, $header, "\t");  // Use tab as separator

// Write student data
foreach ($_SESSION['student_data'] as $name => $subjects) {
    // Ensure all subjects exist and fill missing values with 0
    $row = [$name];
    foreach (["English", "Nepali", "Maths", "Science", "Social", "Computer"] as $subject) {
        $row[] = $subjects[$subject] ?? 0; // Default missing scores to 0
    }
    fputcsv($output, $row, "\t");  // Use tab as separator
}

// Close output stream
fclose($output);
exit();
?>
