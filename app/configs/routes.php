<?php

use Fmk\Facades\CSRF;
use Fmk\Facades\Request;
use Fmk\Facades\Router;

Router::get('/', function() {echo "home";});
Router::get('/login', function() {
    echo "
        <form action='/logar' method='POST'>
            <input type='text' name='nome'>
            <input type='hidden' name='" . CSRF::TOKEN_NAME . "' value='" . CSRF::token() . "'>
            <input type='submit' value='Enviar'>
        </form>
    ";
});

Router::post('/logar', function() {
    echo "
            logar
         ";
});