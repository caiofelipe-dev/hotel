<?php

use App\Controllers\HomeController;
use App\Middlewares\AuthenticateMiddleware;
use Fmk\Facades\Router;

// use Fmk\Facades\Config;
// Config::get('middlewares.NoAuth');
// Config::get('middlewares.Auth');


// Router::get('/', [HomeController::class, 'index'])->middleware('Auth')->name('home');
Router::get('/teste/{a}/teste/{b}', [HomeController::class, 'index']);

// Router::get('/login', function() {
    
// })->middleware('NoAuth')->name('login');

// Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

// Router::post('/logout', function() {echo "logout";})->middleware('Auth');