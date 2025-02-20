<?php
require_once __DIR__ . "/Student.php";

class MarksheetGene
{
    private array $students;

    public function __construct(array $students)
    {
        $this->students = $students;
    }

    public function displayMarksheets(): void
    {
        if (empty($this->students)) {
            echo "<p>No students available.</p>";
            return;
        }

        echo "<h2>Student Marksheets</h2>";

        foreach ($this->students as $student) {
            echo "<h3>Marksheet for " . htmlspecialchars($student->getName()) . "</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Subject</th><th>Score</th></tr>";
            foreach ($student->getMarks() as $subject => $score) {
                echo "<tr><td>" . htmlspecialchars($subject) . "</td><td>" . htmlspecialchars($score) . "</td></tr>";
            }
            echo "</table>";

            echo "<p><strong>Total Score:</strong> " . htmlspecialchars($student->getTotalScore()) . "</p>";
            echo "<p><strong>Average Score:</strong> " . number_format($student->getAverageScore(), 2) . "</p>";
            echo "<p><strong>Recommendation:</strong> " . htmlspecialchars($this->generateRecommendation($student->getAverageScore())) . "</p>";
            echo "<hr>";
        }

        echo '<a href="index.php">Start Over</a>';
    }

    private function generateRecommendation(float $averageScore): string
    {
        if ($averageScore >= 90) return "Excellent performance! Keep it up!";
        if ($averageScore >= 75) return "Good job! You can push a little further!";
        if ($averageScore >= 50) return "Average performance. Focus on weak areas.";
        return "Needs improvement. Consider extra practice and guidance.";
    }
}
