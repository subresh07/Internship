
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="whileloop.php" method="post">
    <button> <input type="text" name = "stop" value = "stop">
    </button>

    </form>
    
</body>
</html>
<?php
$second = 0;
$runnig = true;
while ($runnig) {

    if (isset($_POST["stop"])){
        $runnig = false;

    }else{

        $second++;
        echo $second . "<br>";
    }



}

?>
