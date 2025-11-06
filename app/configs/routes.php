<?php

use App\Controllers\HomeController;
use App\Controllers\QuartosController;
use App\Middlewares\AuthenticateMiddleware;
use Fmk\Facades\Router;

// use Fmk\Facades\Config;
// Config::get('middlewares.NoAuth');
// Config::get('middlewares.Auth');


Router::get('/', [HomeController::class, 'index'])->name('home');

// Quartos (room) registration
Router::get('/quartos/create', [QuartosController::class, 'create'])->name('quartos.create');
Router::post('/quartos', [QuartosController::class, 'store'])->name('quartos.store');

Router::get('/login', function() {echo "login";})->middleware('NoAuth')->name('login');

Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

Router::post('/logout', function() {echo "logout";})->middleware('Auth');