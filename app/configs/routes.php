<?php

use App\Controllers\HomeController;
use App\Middlewares\AuthenticateMiddleware;
use Fmk\Facades\Router;

// use Fmk\Facades\Config;
// Config::get('middlewares.NoAuth');
// Config::get('middlewares.Auth');


Router::get('/', [HomeController::class, 'index'])->middleware('Auth')->name('home');

Router::get('/login', function() {echo "login";})->middleware('NoAuth')->name('login');

Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

Router::post('/logout', function() {echo "logout";})->middleware('Auth');