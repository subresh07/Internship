<?php
$dir = "youtube";  
if (!is_dir($dir)) {
    mkdir($dir);
    echo "Directory '$dir' created.";
} else {
    echo "Directory '$dir' already exists.";
}
?>
