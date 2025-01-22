
<?php

// <!-- Quote string with slashes -->
$string = 'We\'ll , we\'ll \0  rock you!!!';
$escaped_String = addslashes($string);
echo $escaped_String;


?>

<!-- Use casea -->
<!-- When you need to safely include user input that contains special characters like quotes in SQL queries, HTML, or JavaScript.
When you need to escape backslashes, single quotes, double quotes, and other special characters to avoid confusion in processing user input. -->