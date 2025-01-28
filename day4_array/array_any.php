<?php

function array_any(array $array, callable $callback):bool{
    return !empty(array_filter($array,$callback));
}

$cart_price = [100, 0, 50];
$has_free_item = array_any($cart_price,fn($price) => $price === 0);

if ($has_free_item){
    echo "your cart contains a free item!";

} else{
    echo "no free items left in the cart.";
            
}
?>