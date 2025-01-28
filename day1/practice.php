<!-- <!-- <?php
phpinfo();
?>

<?php
echo "Tommarow I'll learn php global variables." . "\n";

echo "This is a bad command line: del c:\\*.*" . "\n";
?> -->

<?php
$var = 'PHP Tutorial';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $var; ?> -w3resource!   </title>
</head>
<body>
    <h3><?php echo $var; ?></h3>
    <p>PHP, an acronym for Hypertext Preprocessor, is a widely-used open source general-purpose scripting language. It is a cross-platform, HTML embedded server-side scripting language and is especially suited for web development. </p>
    <p> <a href = "https://www.w3resource.com/php/php-home.php" > Go to the <?php echo $var; ?> </a>.</p>


    
</body>
</html>

 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<>
    <form method = 'POST'>
        <h2>Please Enter Your name:</h2>
        <input type = "text" name ="name">
        <input type = "submit" value = "submit Name">

    </form>
    <?php
    if($_SERVER["REQUEST_METHOD"]  == "POST" && isset($_POST['name'])){
        $name = $_POST['name'];
        echo "<h3> Hellow $name </h3>";
    }
    ?>
    <form method = 'POST'>
        <h2>Please Enter your name:</h2>
        <input type = "text" name = "name">
        <input type = "submit" value = "Submit Name">
    </form>

    <?php
    if($_server["REQUEST_METHOD"] == "POST" && isset($_POST['name'])){
        $name = $_POST['name'];
        echo "<h2> Hello $name </h2>";
    }
    ?>
    
</body>
</html>
