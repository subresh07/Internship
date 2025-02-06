<?php
declare(strict_types=1);
require 'session.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Step 1: Get the number of students
    if (isset($_POST['num_students'])) {
        $_SESSION['num_students'] = (int) $_POST['num_students'];
        $_SESSION['subjects'] = ['Science', 'Maths', 'English', 'Social Studies', 'Computer', 'Nepali']; // Fixed subjects
        $_SESSION['step'] = 2;
        header("Location: index.php");
        exit();
    }

    // Step 2: Collect student names
    if (isset($_POST['name_0'])) { // Checking if at least one student name exists
        $_SESSION['student_names'] = [];
        for ($i = 0; $i < $_SESSION['num_students']; $i++) {
            $name = trim($_POST["name_$i"] ?? '');
            if (empty($name)) {
                $_SESSION['error'] = "Student name cannot be empty!";
                header("Location: index.php");
                exit();
            }
            
            if (preg_match('/[0-9]/',$name) ||  preg_match('/[\*\!\#\@\$\%\^\&\(\)\+\=\_\-]/', $name)) {
                $_SESSION['error'] = "Student name cannot be numeric!";
                header("Location: index.php");
                exit();
            }

            $_SESSION['student_names'][] = $name;
        }
        $_SESSION['step'] = 3;
        header("Location: index.php");
        exit();
    }

    // Step 3: Collect subject marks for each student
    if (isset($_POST['submit_grades'])) {
        $students = [];

        for ($i = 0; $i < $_SESSION['num_students']; $i++) {
            $name = $_SESSION['student_names'][$i];

            foreach ($_SESSION['subjects'] as $subject) {
                $subject_score = isset($_POST["subject_score_{$i}"][$subject]) ? floatval($_POST["subject_score_{$i}"][$subject]) : -1;

                // Ensure the score is within 0-100
                if ($subject_score < 0 || $subject_score > 100) {
                    $_SESSION['error'] = "Invalid score for " . htmlspecialchars($subject) . " for student " . htmlspecialchars($name) . ".";
                    header("Location: index.php");
                    exit();
                }

                $students[$name][$subject] = $subject_score;
            }
        }

        $_SESSION['student_data'] = $students;
        $_SESSION['step'] = 4;
        header("Location: index.php");
        exit();
    }
}
?>
