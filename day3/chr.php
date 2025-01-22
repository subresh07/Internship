<?php
// 1. Converting ASCII Codes to Characters
echo chr(66);

echo "<br>";

$Ascii_codes = [71,85,91,71];
$string = "";
foreach($Ascii_codes as $codes){
    $string = chr($codes);
    echo $string;
}

?>