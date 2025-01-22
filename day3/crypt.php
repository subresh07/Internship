<?php
$password = "my_secure_password";
$salt = "$2y$10$" . bin2hex(random_bytes(22));
$hashed_password = crypt($password, $salt);
echo $hashed_password;
?>

<!-- The crypt() function is used to hash strings (usually passwords) using a cryptographic algorithm and salt.
It helps store passwords securely by ensuring that the same password will have different hashes due to unique salts.
Use strong algorithms like bcrypt and high cost factors to improve security. -->

