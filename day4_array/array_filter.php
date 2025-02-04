<?php
function odd($var)
{
    //returns weather the input integer is odd
    return $var & 1;
}

function even($var)
{
    // retun weather the input integer is even
    return !($var & 1);
}

$array1 = ['a' => 1,
           'b' => 2,
           'c' => 3,
           'd' => 4,
           'e'=> 5];
$array2 = [6 , 12 , 7 , 8 , 9];
echo "odd :\n ";
print_r(array_filter($array1, "odd"));
echo"<br>";
echo "even :\n ";
print_r(array_filter($array2, "even"));



echo "<br>";
echo "<br>";

$array = range(1, 20);
$result = array_filter($array,function($value){
    return $value % 2 == 0;
});
print_r($result);

?>