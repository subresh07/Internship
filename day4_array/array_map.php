<?php
$array = range(1, 4);
$result = array_map(function($item) { return $item * 2; }, $array);
print_r($result);  
?>