<?php

use App\Controllers\HomeController;
use App\Middlewares\AuthenticateMiddleware;
use Fmk\Facades\Router;

// Router::get('/', [HomeController::class, 'index'])->middleware('Auth')->name('home');
Router::get('/la/{a}/ele/{b}', [HomeController::class, 'index'])->middleware(AuthenticateMiddleware::class);

// Router::get('/login', function() {
    
// })->middleware('NoAuth')->name('login');

// Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

// Router::post('/logout', function() {echo "logout";})->middleware('Auth');