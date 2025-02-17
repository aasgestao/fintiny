<?php

use App\Http\Controllers\ClienteEmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportacoesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class , 'index'])->name('login.index');
Route::post('/', [LoginController::class , 'index'])->name('login.index');
Route::post('/login/acessar', [LoginController::class , 'acessar'])->name('login.acessar');
Route::get('/login/logout', [LoginController::class, 'logout'])->name('login.logout');

//Dashboard

Route::get('/dashboard', [DashboardController::class, 'index'])->name('main.index');


//configuraçoes empresa
Route::get('/clientes-empresa', [ClienteEmpresaController::class , 'index'])->name('empresa.index');
Route::post('/clientes-create', [ClienteEmpresaController::class , 'store'])->name('empresa.create');
Route::put('/clientes-update/{id}', [ClienteEmpresaController::class, 'update'])->name('empresa.update');
Route::delete('/clientes-delete/{id}', [ClienteEmpresaController::class , 'destroy'])->name('empresa.destroy');


//Rotas de usuarios
Route::get('/users', [UserController::class , 'index'])->name('users.index');
Route::get('/users-create', [UserController::class, 'create'])->name('users.create');
Route::delete('/users-destroy/{id}', [UserController::class , 'destroy'])->name('users.destroy');
Route::get('/users-edit/{id}', [UserController::class , 'edit'])->name('users.edit');
Route::put('/users-update/{id}', [UserController::class , 'update'])->name('users.update');
Route::post('/users-store', [UserController::class , 'store'])->name('users.store');

//Rotas para importação
Route::get('/importacoes' , [ImportacoesController::class, 'index'])->name('importacoes.index');
Route::post('/importacoes/import_contas', [ImportacoesController::class, 'import_contas'])->name('importacoes.contas');