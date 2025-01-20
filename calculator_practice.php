<?php
$result = "";

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];

    if (is_numeric(num1) && is_numeric($num2)){
        switch($operation){
            case 'add':
        }
    }
}

?>