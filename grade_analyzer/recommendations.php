<?php
declare(strict_types=1);
function generateRecommendations($students) {
    $recommendations = [];
    foreach ($students as $name => $subjects) {
        $lowest_subject = array_search(min($subjects), $subjects);
        $lowest_score = min($subjects);
        
        if ($lowest_score < 50) {
            $recommendations[$name] = "You should work on $lowest_subject.";
        } else {
            $recommendations[$name] = "Great job! Keep improving.";
        }
    }
    return $recommendations;
}
?>
