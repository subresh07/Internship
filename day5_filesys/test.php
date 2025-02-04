<?php
define("DS" , DIRECTORY_SEPARATOR);

$cwd = getcwd() . DS;

if(is_dir("test"))
{
    echo "it is a directory";
}
else 
{
    echo "it is not a directory";
}

?>