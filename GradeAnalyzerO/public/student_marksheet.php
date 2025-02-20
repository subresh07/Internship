<?php
if (!isset($students)) {
    echo "<p>No students available.</p>";
    return;
}
?>
<h2>Student Marksheets</h2>
<?php foreach ($students as $student): ?>
    <h3>Marksheet for <?php echo htmlspecialchars($student->getName()); ?></h3>
    <table border="1">
        <tr><th>Subject</th><th>Score</th></tr>
        <?php foreach ($student->getMarks() as $subject => $score): ?>
            <tr><td><?php echo htmlspecialchars($subject); ?></td><td><?php echo htmlspecialchars($score); ?></td></tr>
        <?php endforeach; ?>
    </table>
    <p><strong>Total Score:</strong> <?php echo htmlspecialchars($student->getTotalScore()); ?></p>
    <p><strong>Average Score:</strong> <?php echo number_format($student->getAverageScore(), 2); ?></p>
    <p><strong>Recommendation:</strong> <?php echo htmlspecialchars($analyzer->generateRecommendation($student->getAverageScore())); ?></p>
    <hr>
<?php endforeach; ?>
<a href="index.php">Start Over</a>
