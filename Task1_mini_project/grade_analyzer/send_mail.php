<?php
declare(strict_types=1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send_email"])) {
    $parent_email = $_POST["parent_email"];
    $student_name = $_POST["student_name"];
    
    // Decode the student data
    $student_data = json_decode($_POST["student_data"], true);
    
    // Ensure recommendation is passed correctly
    $recommendation = $_POST["recommendation"] ?? "No specific recommendation.";

    if (!$student_data) {
        die("Error: No student data found.");
    }

    // Calculate percentage
    $total_marks = array_sum($student_data);
    $total_subjects = count($student_data);
    $percentage = ($total_subjects > 0) ? ($total_marks / ($total_subjects * 100)) * 100 : 0;

    // Prepare HTML email content
    $subject = "Student Performance Report - $student_name";
    $message = "<html><body>";
    $message .= "<h2>Dear Parent,</h2>";
    $message .= "<p>Here is the performance report for your child, <strong>$student_name</strong>:</p>";

    // Create the result table
    $message .= "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
    $message .= "<tr style='background-color: #f2f2f2;'>
                    <th>Subject</th>
                    <th>Score (out of 100)</th>
                 </tr>";

    foreach ($student_data as $subject => $score) {
        $message .= "<tr>
                        <td style='padding: 8px;'>$subject</td>
                        <td style='padding: 8px; text-align: center;'>$score</td>
                     </tr>";
    } 

    $message .= "<tr style='background-color: #d9edf7;'>
                    <th>Overall Percentage</th>
                    <td style='text-align: center;'><strong>" . number_format($percentage, 2) . "%</strong></td>
                 </tr>";

    $message .= "</table>";

    // Add recommendation section
    $message .= "<h3>Feedback:</h3>";
    $message .= "<p><strong>$recommendation</strong></p>";

    $message .= "<p>Thank you.</p>";
    $message .= "<p><strong>Best Regards,<br>Intujii School of Codes.</strong></p>";
    $message .= "</body></html>";

    // Mailtrap SMTP Configuration
    $smtp_host = "smtp.mailtrap.io";
    $smtp_port = 2525;
    $smtp_user = "8ff290caeecef1"; // Replace with your Mailtrap username
    $smtp_pass = "552b41b345cd33"; // Replace with your Mailtrap password

    // Email headers
    $headers = "From: school@example.com\r\n";
    $headers .= "Reply-To: school@example.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Use HTML content

    // Open connection to Mailtrap SMTP server
    $smtp_conn = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
    if (!$smtp_conn) {
        die("Could not connect to SMTP server: $errno - $errstr");
    }

    // Read SMTP server response
    function smtp_read($conn) {
        $data = "";
        while ($str = fgets($conn, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) == " ") {
                break;
            }
        }
        return $data;
    }

    smtp_read($smtp_conn); // Read server response
    fputs($smtp_conn, "EHLO localhost\r\n");
    smtp_read($smtp_conn);

    // Authenticate
    fputs($smtp_conn, "AUTH LOGIN\r\n");
    smtp_read($smtp_conn);
    fputs($smtp_conn, base64_encode($smtp_user) . "\r\n");
    smtp_read($smtp_conn);
    fputs($smtp_conn, base64_encode($smtp_pass) . "\r\n");
    smtp_read($smtp_conn);

    // Send email
    fputs($smtp_conn, "MAIL FROM: <school@example.com>\r\n");
    smtp_read($smtp_conn);
    fputs($smtp_conn, "RCPT TO: <$parent_email>\r\n");
    smtp_read($smtp_conn);
    fputs($smtp_conn, "DATA\r\n");
    smtp_read($smtp_conn);

    fputs($smtp_conn, "To: $parent_email\r\n");
    fputs($smtp_conn, "From: school@example.com\r\n");
    fputs($smtp_conn, "Subject: $subject\r\n");
    fputs($smtp_conn, "MIME-Version: 1.0\r\n");
    fputs($smtp_conn, "Content-Type: text/html; charset=UTF-8\r\n");
    fputs($smtp_conn, "\r\n$message\r\n.\r\n");
    smtp_read($smtp_conn);

    // Close connection
    fputs($smtp_conn, "QUIT\r\n");
    fclose($smtp_conn);

    echo "<script>alert('Email sent successfully to $parent_email!'); window.location.href='index.php';</script>";
}
?>
