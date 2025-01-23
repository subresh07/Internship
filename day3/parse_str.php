<?php
$str = "name=John&age=25";
parse_str($str, $output); 

echo $output['name'];  
echo $output['age'];   
?>

<!-- This function is often used when you want to convert a URL-encoded query string (like those found in the query part of URLs) into PHP variables for further processing. -->