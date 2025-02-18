<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use App\Models\ContasPagarModel;
use App\Models\ContasReceberModel;
use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        //$contas = ContasModel::paginate(20);

        $contas = ContasModel::when($request->has("conta"), function ($query) use ($request) {
            $query->where("conta", $request->input("conta"));
        })
            ->when($request->has("empresa"), function ($query) use ($request){
                $query->where("empresa", $request->input("empresa"));
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('financeiro/contas', [
            'title'=> 'Listagem de Contas',
            'contas'=> $contas
        ]);
    }
    public function contas_pagar()
    {
        $clientes = ClienteEmpresaModel::all();
        $contas = ContasPagarModel::paginate(20);
        return view('financeiro/contas_pagar', [
            'title' => 'Listagem de Contas',
            'contas' => $contas,
            'clientes'=> $clientes
        ]);
    }
    public function contas_receber()
    {
        $clientes = ClienteEmpresaModel::all();
        $contas = ContasReceberModel::paginate(30);
        return view('financeiro/contas_receber', [
            'title' => 'Listagem de Contas',
            'contas' => $contas,
            'clientes'=> $clientes
        ]);
    }
}
