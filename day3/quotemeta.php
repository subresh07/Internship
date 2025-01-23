<?php
$pattern = "hello! (world) this is me";
$escaped_pattern = quotemeta($pattern);
echo $escaped_pattern;
?>
<!-- It escapes all characters that have special meaning in regular expressions. -->