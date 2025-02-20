<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/Student.php";

use Core\Database;

class GradeAnalyzer 
{
    private \mysqli $db;
    private array $subjects = ["Math", "Science", "English", "History", "Computer"];

    public function __construct()
    {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function addStudent(string $name, array $marks): void
    {
        $stmt = $this->db->prepare("INSERT INTO students (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $studentId = $stmt->insert_id;
        $stmt->close();

        $stmt = $this->db->prepare("INSERT INTO marks (student_id, subject, score) VALUES (?, ?, ?)");
        foreach ($marks as $subject => $score) {
            $stmt->bind_param("isi", $studentId, $subject, $score);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function getAllStudents(): array
    {
        $students = [];
        $stmt = $this->db->prepare("SELECT id, name FROM students");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($studentRow = $result->fetch_assoc()) {
            $marksStmt = $this->db->prepare("SELECT subject, score FROM marks WHERE student_id = ?");
            $marksStmt->bind_param("i", $studentRow['id']);
            $marksStmt->execute();
            $marksResult = $marksStmt->get_result();

            $marks = [];
            while ($mark = $marksResult->fetch_assoc()) {
                $marks[$mark['subject']] = $mark['score'];
            }
            $marksStmt->close();

            $students[] = new Student($studentRow['id'], $studentRow['name'], $marks);
        }

        return $students;
    }

    public function generateRecommendation(float $averageScore): string
    {
        if ($averageScore >= 90) return "Excellent performance! Keep it up!";
        if ($averageScore >= 75) return "Good job! You can push a little further!";
        if ($averageScore >= 50) return "Average performance. Focus on weak areas.";
        return "Needs improvement. Consider extra practice and guidance.";
    }

    public function getSubjects(): array {
        return $this->subjects;
    }
}
