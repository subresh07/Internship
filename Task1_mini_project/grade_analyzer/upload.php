<?php
declare(strict_types=1);
require 'session.php';
require 'csv_parser.php';
require 'csv_generator.php';

// Increase limits for large uploads
ini_set('memory_limit', '1024M');
ini_set('max_execution_time', '600');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file_upload"])) {
    // Check file size before processing
    if ($_FILES["file_upload"]["size"] > 100000000) {  // 100MB limit
        $_SESSION['error'] = "File size exceeds limit (100MB). Try a smaller file.";
        header("Location: index.php");
        exit();
    }

    // Ensure the file is a CSV
    $fileType = pathinfo($_FILES["file_upload"]["name"], PATHINFO_EXTENSION);
    if (strtolower($fileType) !== "csv") {
        $_SESSION['error'] = "Invalid file format! Please upload a CSV file.";
        header("Location: index.php");
        exit();
    }

    // Parse CSV
    $parsed_data = parseCSV($_FILES["file_upload"]["tmp_name"]);

    // Validate parsed data
    if (empty($parsed_data)) {
        $_SESSION['error'] = "The uploaded CSV file is empty or incorrectly formatted.";
        header("Location: index.php");
        exit();
    }

    // Store data in session
    $_SESSION['student_data'] = $parsed_data;
    generateCSV($_SESSION['student_data']);

    $_SESSION['step'] = 4;  // Move to results page
    header("Location: index.php");
    exit();
}
?>
