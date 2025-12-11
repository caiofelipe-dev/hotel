<?php

use App\Controllers\HomeController;
use App\Controllers\QuartosController;
use App\Controllers\HospedesController;
use App\Controllers\ReservasController;
use App\Controllers\AdicionaisController;
use App\Controllers\FuncionariosController;
use App\Controllers\CargosController;
use Fmk\Facades\Router;

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

// Hospedes CRUD
Router::get('/hospedes', [HospedesController::class, 'index'])->name('hospedes.index');
Router::get('/hospedes/create', [HospedesController::class, 'create'])->name('hospedes.create');
Router::post('/hospedes', [HospedesController::class, 'store'])->name('hospedes.store');
Router::get('/hospedes/{id}/edit', [HospedesController::class, 'edit'])->name('hospedes.edit');
Router::post('/hospedes/{id}/update', [HospedesController::class, 'update'])->name('hospedes.update');
Router::post('/hospedes/{id}/delete', [HospedesController::class, 'destroy'])->name('hospedes.destroy');

// Reservas CRUD
Router::get('/reservas', [ReservasController::class, 'index'])->name('reservas.index');
Router::get('/reservas/create', [ReservasController::class, 'create'])->name('reservas.create');
Router::post('/reservas', [ReservasController::class, 'store'])->name('reservas.store');
Router::get('/reservas/{id}/edit', [ReservasController::class, 'edit'])->name('reservas.edit');
Router::post('/reservas/{id}/update', [ReservasController::class, 'update'])->name('reservas.update');
Router::post('/reservas/{id}/delete', [ReservasController::class, 'destroy'])->name('reservas.destroy');
Router::get('/reserva/{token}', [ReservasController::class, 'guest'])->name('reserva.guest');

// Adicionais CRUD
Router::get('/adicionais', [AdicionaisController::class, 'index'])->name('adicionais.index');
Router::get('/adicionais/create', [AdicionaisController::class, 'create'])->name('adicionais.create');
Router::post('/adicionais', [AdicionaisController::class, 'store'])->name('adicionais.store');
Router::get('/adicionais/{id}/edit', [AdicionaisController::class, 'edit'])->name('adicionais.edit');
Router::post('/adicionais/{id}/update', [AdicionaisController::class, 'update'])->name('adicionais.update');
Router::post('/adicionais/{id}/delete', [AdicionaisController::class, 'destroy'])->name('adicionais.destroy');

// Funcionarios CRUD
Router::get('/funcionarios', [FuncionariosController::class, 'index'])->name('funcionarios.index');
Router::get('/funcionarios/create', [FuncionariosController::class, 'create'])->name('funcionarios.create');
Router::post('/funcionarios', [FuncionariosController::class, 'store'])->name('funcionarios.store');
Router::get('/funcionarios/{id}/edit', [FuncionariosController::class, 'edit'])->name('funcionarios.edit');
Router::post('/funcionarios/{id}/update', [FuncionariosController::class, 'update'])->name('funcionarios.update');
Router::post('/funcionarios/{id}/delete', [FuncionariosController::class, 'destroy'])->name('funcionarios.destroy');

// Cargos CRUD
Router::get('/cargos', [CargosController::class, 'index'])->name('cargos.index');
Router::get('/cargos/create', [CargosController::class, 'create'])->name('cargos.create');
Router::post('/cargos', [CargosController::class, 'store'])->name('cargos.store');
Router::get('/cargos/{id}/edit', [CargosController::class, 'edit'])->name('cargos.edit');
Router::post('/cargos/{id}/update', [CargosController::class, 'update'])->name('cargos.update');
Router::post('/cargos/{id}/delete', [CargosController::class, 'destroy'])->name('cargos.destroy');
