<?php

function pr($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function errorLog($msg){
    if(!is_dir('errors')){
        mkdir('errors');
    } else{

    }
}