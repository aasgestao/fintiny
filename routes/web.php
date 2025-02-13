<?php

use App\Http\Controllers\ClienteEmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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