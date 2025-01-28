<?php
function array_all(array $array, callable $callback): bool {
    foreach ($array as $value) {
        if (!$callback($value)) {
            return false;
        }
    }
    return true;
}

$numbers = [2,4,6,8];
$result = array_all($numbers, fn($num) => $num > 0);
var_dump($result);
 
echo "<br>";
$array = [
    'a' => 'dog',
    'b' => 'cat',
    'c' => 'cow',
    'd' => 'duck',
    'e' => 'goose',
    'f' => 'elephant'
];

// Check, if all animal names are shorter than 12 letters.
var_dump(array_all($array, function (string $value) {
    return strlen($value) < 12;
}));

// Check, if all animal names are longer than 5 letters.
var_dump(array_all($array , function(string $Value){
    return strlen($Value) > 5;
}));


// check if all array keys are string
var_dump(array_all($array, function(string $value, $key){
    return is_string($key);
}));
?>




