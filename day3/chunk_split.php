<?php
$string = "HelloworldpeaceNepal";
$hunked_string = chunk_split($string, 5,"<br>");
echo $hunked_string;
?>

<!-- chunk_split() splits a string into smaller chunks of a specified size.
The function can add a custom separator between the chunks (default is a newline).
It's commonly used to format base64-encoded data or break long text strings into more readable pieces. -->