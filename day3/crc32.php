<?php
$quote = "Quick Brown Fox Jumps Over the Lazy dog!";
$dum = crc32($quote);
echo $dum;

?>



<!-- crc32() computes a CRC-32 checksum (a 32-bit integer) for a string.
It's typically used for error-checking or ensuring data integrity in non-secure applications.
CRC-32 is fast but not suitable for cryptographic security. -->

