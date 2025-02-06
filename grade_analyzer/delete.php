<?php
declare(strict_types=1);
require 'session.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_student'])) {
    
    $student_name = $_POST['delete_student'];
    unset($_SESSION['student_data'][$student_name]);
}

header("Location: index.php");
exit();
?>
