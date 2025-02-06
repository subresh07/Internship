<?php
function generateCSV($students) {
    $filename = "exports/student_records.csv"; // Save CSV in the "exports" folder

    // Ensure the "exports" directory exists
    if (!is_dir("exports")) {
        mkdir("exports", 0777, true);
    }

    // Open file for writing
    $file = fopen($filename, "w");

    // Write header
    fputcsv($file, ["Student Name", "English", "Nepali", "Maths", "Science", "Social", "Computer"], "\t");

    // Write student data
    foreach ($students as $name => $subjects) {
        fputcsv($file, array_merge([$name], array_values($subjects)), "\t");
    }

    fclose($file);

    // Store CSV path in session for download link
    $_SESSION['csv_file_path'] = $filename;
}
?>
