<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="isset&empty" method = "post">
        <label> username:</label>
        <input type ="text" name = "username">
        <label> password:</label>
        <input type ="password" name = "password">
        <input type ="submit" name = "login" value = "Log in">
    </form>
    
</body>
</html>

<?php
/*foreach($_POST as $key => $value){
    echo "{$key} = {$value}<br>";
}
 */   

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if(empty($username)){
        echo "username is missing";

    }
    echo "hello {$username}";
}

?>