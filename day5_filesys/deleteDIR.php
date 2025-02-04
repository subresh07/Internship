<?php
$dir = "youtube";
if(!is_dir($dir)){
    echo "the directory exist $dir";
    rmdir($dir);
}

?>
