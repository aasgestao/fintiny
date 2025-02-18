<?php

namespace App\Http\Controllers;

use App\Models\ContasModel;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function index()
    {
        $contas = ContasModel::paginate(20);

        return view('financeiro/contas', [
            'title'=> 'Listagem de Contas',
            'contas'=> $contas
        ]);
    }
}
