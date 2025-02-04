<?php
session_start();

if (!isset($_SESSION['input'])) {
    $_SESSION['input'] = '';
}

if (!isset($_SESSION['result'])) {
    $_SESSION['result'] = '';
}

if (!isset($_SESSION['expression'])) {
    $_SESSION['expression'] = ''; 
}

if (!isset($_SESSION['memory'])) {
    $_SESSION['memory'] = 0;
}
?>
