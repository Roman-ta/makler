<?php

use Makler\Register;
use Makler\Db;
$db = Db::getInstance();


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['action']) && !empty($_POST['action'])){
        if($_POST['action'] == 'register'){
            require VIEWS . '/tpl/register-modal.html';
            $register = new Register($_POST);
            $register->validateEmail();
        }
        if($_POST['action'] == 'auth'){
            require VIEWS . '/tpl/auth-modal.html';
        }
    }

}