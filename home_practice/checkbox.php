<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="checkbox.php" method="post">
        <input type = "checkbox" name = "foods[]" value = "Pizza">Pizza<br>
        <input type = "checkbox" name = "foods[]" value = "Hamburger">Hamburger<br>
        <input type = "checkbox" name = "foods[]" value = "Burger">Burger<br>
        <input type = "checkbox" name = "foods[]" value = "Hotdog">Hotdog<br><br>
        <input type = "submit" name = "submit">
    </form>
    
</body>
</html>

<?php
if(isset($_POST ["submit"] )){
    // $message = '';
    // if(empty($_post["submit"])){
    //     $message = "you dont choose any food yet!";
    // }

    // if(isset($_POST["pizza"])){
    //     $message = "you like pizza";
    // }
    // if(isset($_POST["hamburger"])){
    //     $message = "you like Hamburger";

    // }
    // if(isset($_POST["burger"])){
    //     $message = "you like burger";

    // }
    // if(isset($_POST["hotdog"])){
    //     $message = "you like hotdog";

    // }
    // echo $message;
    $foods = $_POST["foods"];
    foreach($foods as $food){
        echo "you like {$food}" ."<br>";
    }
    

}
?>