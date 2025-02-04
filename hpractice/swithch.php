<?php
$grade = "F";
switch($grade){
    case "A":
        echo "You did grate";
        break;
    case "B":
            echo "You did good";
            break;
    case "C":
        echo "you did okey";
        break;
    case "D":
        echo " you did poorly";
        break;
    case "F":
        echo "you are failed";
        break;
    default:
     echo "{$grade} is not a valid";
    

     
}
?>