<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="practice.php" method="post">
        <label> username:</label>
        <input type="text" name="username"><br>

        <label> password:</label>
        <input type="password" name="password">
        <br>
        <input type = "submit" value = "login">

    </form>


</body>

</html>

<?php
echo $_POST["username"];
echo"<br>";
echo $_POST["password"];
?>