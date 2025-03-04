<?php

use App\Http\Controllers\ClienteEmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\ImportacoesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlanoContasController;
use App\Http\Controllers\TrocarCnpj;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;



Route::get('/', [LoginController::class , 'index'])->name('login.index');
Route::post('/', [LoginController::class , 'index'])->name('login.index');
Route::post('/login/acessar', [LoginController::class , 'acessar'])->name('login.acessar');
Route::get('/login/logout', [LoginController::class, 'logout'])->name('login.logout');


Route::group(['middleware' => 'auth'], function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('main.index');
    
    
    //configuraçoes empresa
    Route::get('/clientes-empresa', [ClienteEmpresaController::class , 'index'])->name('empresa.index');
    Route::get('/ver-empresa/{id}', [ClienteEmpresaController::class , 'show'])->name('empresa.show');
    Route::post('/clientes-create', [ClienteEmpresaController::class , 'store'])->name('empresa.create');
    Route::put('/clientes-update/{id}', [ClienteEmpresaController::class, 'update'])->name('empresa.update');
    Route::delete('/clientes-delete/{id}', [ClienteEmpresaController::class , 'destroy'])->name('empresa.destroy');
    Route::post('empresa-banco', [ClienteEmpresaController::class, 'insertBank'])->name('empresa.banco');
    Route::put('empresa-banco/{id}', [ClienteEmpresaController::class, 'editBank'])->name('empresa.editBanco');
    Route::post('empresa-categoria', [ClienteEmpresaController::class, 'novaCategoria'])->name('empresa.categoria');


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
    Route::post('/importacoes/import_planocontas', [ImportacoesController::class, 'import_planocontas'])->name('importacoes.planocontas');

    //Rotas para exportação
    Route::get('financeiro/export/', [FinanceiroController::class, 'export'])->name('exportExcel');
    Route::get('financeiro/exportLancamentos/', [FinanceiroController::class, 'exportLancamentos'])->name('exportLancamentos');
    

    Route::get('/financeiro' , [FinanceiroController::class, 'index'])->name('financeiro.index');
    Route::get('/financeiro/contas_pagar' , [FinanceiroController::class, 'contas_pagar'])->name('financeiro.contas_pagar');
    Route::get('/financeiro/contas_receber' , [FinanceiroController::class, 'contas_receber'])->name('financeiro.contas_receber');
    Route::post('/financeiro/getContas' , [FinanceiroController::class, 'getContas'])->name('financeiro.getContas');
    Route::put('/financeiro.contas-update', [FinanceiroController::class , 'contas_update'])->name('financeiro.contas-update');
    Route::post('/financeiro/contas_pagar/baixar_conta/{id}', [FinanceiroController::class , 'pagarConta'])->name('financeiro_pagarConta');
    Route::get('financeiro/lancamentos_contabeis' , [FinanceiroController::class , 'lancamentosIndex'])->name('financeiro.lancamentos');
    
    //Plano de contas
    Route::get('/plano_contas', [PlanoContasController::class , 'index'])->name('plano_contas');
    Route::post('/plano_editar', [PlanoContasController::class , 'plano_editar'])->name('plano_editar');

    //Rotas para email comunicações
    Route::get('/email-index', [EmailController::class, 'index'])->name('email.index');
    Route::get('/email-read/{id}', [EmailController::class, 'read'])->name('email.read');
    Route::get('/email-compose', [EmailController::class, 'compose'])->name('email.compose');
    Route::post('/email-send', [EmailController::class, 'send'])->name('email.send');
    Route::get('/email-reflesh', [EmailController::class , 'receberEmails'])->name('email.reflesh');

    //Mudar CNPJ
    Route::post('/mudar-cnpj', [TrocarCnpj::class, 'mudarCnpj'])->name('mudar.cnpj');

    //Rota de download
    Route::get('/download/{file}' , function($file) {
        return Storage::download("uploads/$file");
    })->name('file.download');
    
    
});