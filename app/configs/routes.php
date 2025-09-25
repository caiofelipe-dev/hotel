<?php

use Fmk\Facades\Router;

Router::get('/', function() {})->middleware('Auth')->name('home');

Router::get('/login', function() {
    
})->middleware('NoAuth')->name('login');

Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

Router::post('/logout', function() {echo "logout";})->middleware('Auth');