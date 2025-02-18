<?php
require_once 'Student.php';
require_once 'Database.php';

class GradeAnalyzer 
{
    private mysqli $db;
    private array $subjects = ["Math", "Science", "English", "History", "Computer"];

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function addStudent(string $name, array $marks): void
     {
        $stmt = $this->db->prepare("INSERT INTO students (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $studentId = $stmt->insert_id;
        $stmt->close();

        $stmt = $this->db->prepare("INSERT INTO marks (student_id, subject, score) VALUES (?, ?, ?)");
        foreach ($marks as $subject => $score) 
        {
            $stmt->bind_param("isi", $studentId, $subject, $score);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function getStudentMarksheet(int $studentId): ?array 
    {
        $stmt = $this->db->prepare("SELECT name FROM students WHERE id = ?");
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $student = $result->fetch_assoc();
        $stmt->close();

        if (!$student) return null;

        $marksStmt = $this->db->prepare("SELECT subject, score FROM marks WHERE student_id = ?");
        $marksStmt->bind_param("i", $studentId);
        $marksStmt->execute();
        $result = $marksStmt->get_result();

        $marks = [];
        while ($row = $result->fetch_assoc()) 
        {
            $marks[$row['subject']] = $row['score'];
        }
        $marksStmt->close();

        $totalScore = array_sum($marks);
        $averageScore = $totalScore / count($marks);
        $recommendation = $this->generateRecommendation($averageScore);

        return [
            "name" => $student['name'],
            "marks" => $marks,
            "totalScore" => $totalScore,
            "averageScore" => $averageScore,
            "recommendation" => $recommendation
        ];
    }
    public function getAllStudents(): array
     {
        $students = [];
    
        // Fetch all students from the database
        $stmt = $this->db->query("SELECT * FROM students");
        while ($studentRow = $stmt->fetch_assoc()) {
            $marksStmt = $this->db->prepare("SELECT subject, score FROM marks WHERE student_id = ?");
            $marksStmt->bind_param("i", $studentRow['id']);
            $marksStmt->execute();
            $result = $marksStmt->get_result();
            
            $marks = [];
            while ($mark = $result->fetch_assoc()) {
                $marks[$mark['subject']] = $mark['score'];
            }
            $marksStmt->close();
    
            // Create a Student object with retrieved data
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
