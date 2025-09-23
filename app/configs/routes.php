<?php

use App\Middlewares\AuthenticateMiddleware as Auth;
use App\Middlewares\NoAuthenticateMiddleware as NoAuth;
use Fmk\Facades\Router;
use Fmk\Facades\Session;

Router::get('/', function() {echo "home";})->middleware(Auth::class)->name('home');

Router::get('/login', function() {
    require '..\views\login.view.php';
})->middleware(NoAuth::class)->name('login');

Router::post('/logar', function() {echo "logar";})->middleware(NoAuth::class);

Router::post('/logout', function() {echo "logout";})->middleware(Auth::class);