<?php

use App\Controllers\HomeController;
use App\Controllers\QuartosController;
use Fmk\Facades\Router;

// use Fmk\Facades\Config;
// Config::get('middlewares.NoAuth');
// Config::get('middlewares.Auth');


Router::get('/', [HomeController::class, 'index'])->name('home');

Router::get('/login', function() {echo "login";})->middleware('NoAuth')->name('login');

Router::post('/logar', function() {echo "logar";})->middleware('NoAuth');

Router::post('/logout', function() {echo "logout";})->middleware('Auth');

// Quartos CRUD
Router::get('/quartos', [QuartosController::class, 'index'])->name('quartos.index');
Router::get('/quartos/create', [QuartosController::class, 'create'])->name('quartos.create');
Router::post('/quartos', [QuartosController::class, 'store'])->name('quartos.store');
Router::get('/quartos/{id}/edit', [QuartosController::class, 'edit'])->name('quartos.edit');
Router::post('/quartos/{id}/update', [QuartosController::class, 'update'])->name('quartos.update');
Router::post('/quartos/{id}/delete', [QuartosController::class, 'destroy'])->name('quartos.destroy');