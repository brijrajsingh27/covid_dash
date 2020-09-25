<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
//    echo "Want to load $className.\n";
//    throw new Exception("Unable to load $className.");
    $path = 'classes/';
    $ext = '.php';
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $full_path = $path . $className . $ext;
//echo $full_path,"<br/>";
    if (!file_exists($full_path)) {
        return false;
    }
    require $full_path;
}
