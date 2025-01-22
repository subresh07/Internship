<?php

$hex = bin2hex('Hello world!');

var_dump($hex);
var_dump(hex2bin($hex));
?>

<!-- bin2hex() converts binary data into a hexadecimal string.
Useful for transmitting or storing binary data in a format that's readable or compatible with text-based systems.
Converts data like files, strings, or raw binary content into hexadecimal representation for easier handling or inspection. -->