<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST)){
        require VIEWS . '/tpl/auth-modal.html';
    }
}


