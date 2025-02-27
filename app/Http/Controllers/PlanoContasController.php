<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use App\Models\PlanoContasModel;
use Illuminate\Http\Request;

class PlanoContasController extends Controller
{
    public function index()
    {
        $clientes = ClienteEmpresaModel::all();
        $planoContas = PlanoContasModel::all();


        return view('planocontas/index', [
            'title'=> 'Index | Plano de Contas',
            'clientes'=> $clientes,
            'planoContas'=> $planoContas,
        ]);
    }

    public function plano_editar(Request $request)
    {
        //dd($request);
        $id = $request->input('id');
        
        $planoConta = PlanoContasModel::findOrFail($id);
        //dd($planoConta ,$request->cnpj);
        $planoConta->update($request->all());

        return redirect()->route('plano_contas')->with('success', 'Conta do Plano atualizada com sucesso !');

    }
}
