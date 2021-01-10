<?php
function shitDump($variable){
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

function echoo($string, $variable) {
    echo $string . ' ' . $variable . '</br>';
}