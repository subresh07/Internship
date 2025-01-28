<?php
#INitialize result variables 
$_result = " ";

#check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_1 = $_POST['num1'];
    $num_2 = $_POST['num2'];
    $operation = $_post['operation'];


    #perform calculator based operation
    if(is_numeric($num1) && is_numeric($num2)){
        switch ($operation){
            case 'add':
                $result = $num1+$num2;
                break;
            case 'subtract':
                $result = $num1 - $num2;
                break;
            case 'multiply':
                $result = $num1 * $num2;
                break;
            case 'divide':
                if($num2 != 0){
                   $result = $num1 / $num2;
                } else {
                    $result = "cannot divide by zero";
                }
                break;
            default:
                $result = "Invalid operation";
                break;

                
            }
                           
    } else {
            $result = "please enter valid numbers.";
    }
    





}

?>