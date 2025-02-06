<?php
declare(strict_types=1);    
function calculateAnalysis($students) {
    $all_scores = [];
    foreach ($students as $subjects) {
        foreach ($subjects as $score) {
            if (is_numeric($score)) {
                $all_scores[] = floatval($score);
            }
        }
    }

    if (empty($all_scores)) {
        return [
            'total' => count($students),
            'average' => 0.0,
            'highest' => ['name' => 'N/A', 'score' => 0],
            'lowest' => ['name' => 'N/A', 'score' => 0],
            'above_average' => 0
        ];
    }

    $average_score = array_sum($all_scores) / count($all_scores);
    $highest_score = max($all_scores);
    $lowest_score = min($all_scores);
    $highest_name = $lowest_name = "N/A";

    foreach ($students as $name => $subjects) {
        if (in_array($highest_score, $subjects)) $highest_name = $name;
        if (in_array($lowest_score, $subjects)) $lowest_name = $name;
    }

    $above_average_count = count(array_filter($all_scores, fn($score) => $score > $average_score));

    return [
        'total' => count($students),
        'average' => $average_score,
        'highest' => ['name' => $highest_name, 'score' => $highest_score],
        'lowest' => ['name' => $lowest_name, 'score' => $lowest_score],
        'above_average' => $above_average_count
    ];
}

?>
