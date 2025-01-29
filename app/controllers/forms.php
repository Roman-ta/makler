<?php

use Makler\Register;
use Makler\Db;
$db = Db::getInstance();


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['register'])){
        $register = new Register($_POST);
        $register->validateEmail();
    }
}