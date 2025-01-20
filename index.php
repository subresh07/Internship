<?php declare(strict_types =1) ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // $name = "Subresh Thakulla";
    // $Age = 20;
    // $height = 5.9;
    // $tall = false;
    // echo $name . "<br>" , $Age. "<br>", $height. "<br>", $tall. "<br>";
    // var_dump($name,$Age,$height,$tall);
    // const pi_value = 2.14;
    // echo pi_value;
    // echo "<br>";

    // $my_arry = array(2,4,5,8,6);

    // echo $my_arry[1]; 

    $my_result = array("sci" => 99, "maths" => 86 ,"social" => 40 );
    echo $my_result['maths'];
    echo"<br>";

    // $inside_array = array(1,"fight",true,4.89,array("lovely",23,9.0,false,));
    // echo $inside_array[4][0];



    $inside_array = array(1,"fight",true,4.89);
    
         foreach ($inside_array as $f){
        echo $f;
    }
    echo"<br>";

   $myMoney = 25000.876567;
   echo $myMoney;
   echo var_dump($myMoney);
   echo "<br>";
   $meroPaisa = (int) $myMoney;
   echo $meroPaisa;
   echo var_dump($meroPaisa);





    ?>

    





    
</body>
</html>