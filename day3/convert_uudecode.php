<?php
$base64_string = "begin 644 test.txt\nM0&%T=P=U=0=P=0I9A0D0H=0U\nend\n";
$decoded_string = base64_decode($base64_string);
echo $decoded_string;  

?>
