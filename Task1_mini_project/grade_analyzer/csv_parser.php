<?php
declare(strict_types=1);

function parseCSV($filename) {
    $students = [];
    if (($handle = fopen($filename, "r")) !== false) {
        $header = fgetcsv($handle, 1000, "\t"); // Read header row (subjects)

        if ($header === false || count($header) < 7) {
            return []; // Invalid file format
        }

        while (($data = fgetcsv($handle, 1000, "\t")) !== false) {
            if (count($data) < 7) continue; // Ensure there are enough columns

            $name = trim($data[0]);
            $scores = array_map(fn($score) => is_numeric($score) ? floatval($score) : 0.0, array_slice($data, 1));

            if (!empty($name) && count($scores) === 6) {
                // Assign subjects dynamically from header
                $students[$name] = array_combine(["English", "Nepali", "Maths", "Science", "Social", "Computer"], $scores);
            }
        }
        fclose($handle);
    }
    return $students;
}
?>
