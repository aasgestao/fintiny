<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use Illuminate\Http\Request;
use Illiminate\Database\Eloquent\Collection;

class DashboardController extends Controller
{
    public function index (Request $request)
    {
        $ano = $request->input('year');
        $empresa = $request->input('empresa');
        $clientes = ClienteEmpresaModel::all();
        //dd($request);
        $contas = ContasModel::when($request->filled("year"), function ($query) use ($request) {
            $query->whereYear("data", $request->input("year"));
        })
            ->when($request->filled("mes_inicial"), function ($query) use ($request) {
                $query->whereMonth("data", '>=', $request->input("mes_inicial"));
            })
            ->when($request->filled("mes_final"), function ($query) use ($request) {
                $query->whereMonth("data", '<=', $request->input("mes_final"));
            })
            ->orderByDesc('data')
            ->paginate(1000)
            ->withQueryString();

            //$empresa = 'FILTERPARTS';
        $creditos = ContasModel::where('tipo', 'C')->where('empresa', $empresa)->get();
        //variaveis de credito    
        $janeiro = ContasModel::where('tipo', 'C')->where('empresa', $empresa)->whereMonth('data', 1)->whereYear('data', $ano)->sum('valor');
        $fevereiro = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 2)->whereYear('data', $ano)->sum('valor');
        $marco = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 3)->whereYear('data', $ano)->sum('valor');
        $abril = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 4)->whereYear('data', $ano)->sum('valor');
        $maio = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 5)->whereYear('data', $ano)->sum('valor');
        $junho = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 6)->whereYear('data', $ano)->sum('valor');
        $julho = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 7)->whereYear('data', $ano)->sum('valor');
        $agosto = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 8)->whereYear('data', $ano)->sum('valor');
        $setembro = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 9)->whereYear('data', $ano)->sum('valor');
        $outubro = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 10)->whereYear('data', $ano)->sum('valor');
        $novembro = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 11)->whereYear('data', $ano)->sum('valor');
        $dezembro = ContasModel::where('tipo', 'C' )->where('empresa', $empresa)->whereMonth('data', 12)->whereYear('data', $ano)->sum('valor');

        //variaveis de debito    
        $janeiroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 1)->whereYear('data', $ano)->sum('valor');
        $fevereiroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 2)->whereYear('data', $ano)->sum('valor');
        $marcoD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 3)->whereYear('data', $ano)->sum('valor');
        $abrilD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 4)->whereYear('data', $ano)->sum('valor');
        $maioD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 5)->whereYear('data', $ano)->sum('valor');
        $junhoD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 6)->whereYear('data', $ano)->sum('valor');
        $julhoD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 7)->whereYear('data', $ano)->sum('valor');
        $agostoD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 8)->whereYear('data', $ano)->sum('valor');
        $setembroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 9)->whereYear('data', $ano)->sum('valor');
        $outubroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 10)->whereYear('data', $ano)->sum('valor');
        $novembroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 11)->whereYear('data', $ano)->sum('valor');
        $dezembroD = ContasModel::where('tipo', 'D')->where('empresa', $empresa)->whereMonth('data', 12)->whereYear('data', $ano)->sum('valor');


        return view('main.index', [
            'title' => 'Dashboard | Fin-tiny',
            'empresa' => $request->input('empresa'),
            'clientes'=> $clientes,
            'janeiro' => $janeiro,
            'fevereiro' => $fevereiro,
            'marco' => $marco,
            'abril' => $abril,
            'maio' => $maio,
            'junho' => $junho,
            'julho' => $julho,
            'agosto' => $agosto,
            'setembro' => $setembro,
            'outubro' => $outubro,
            'novembro' => $novembro,
            'dezembro' => $dezembro,
            //VARIAVEIS DE DEBITO
            'janeiroD' => $janeiroD,
            'fevereiroD' => $fevereiroD,
            'marcoD' => $marcoD,
            'abrilD' => $abrilD,
            'maioD' => $maioD,
            'junhoD' => $junhoD,
            'julhoD' => $julhoD,
            'agostoD' => $agostoD,
            'setembroD' => $setembroD,
            'outubroD' => $outubroD,
            'novembroD' => $novembroD,
            'dezembroD' => $dezembroD,
        ]
        );

        
        //     $janeiro = $contas->filter(function ($conta) use ($ano) {
        //     return \Carbon\Carbon::parse($conta->data)->month == 1 && \Carbon\Carbon::parse($conta->data)->year == $ano;
        // })->sum('valor');
        // $fevereiro = $contas->filter(function ($conta) use ($ano) {
        //     return \Carbon\Carbon::parse($conta->data)->month == 2 && \Carbon\Carbon::parse($conta->data)->year == $ano;
        // })->sum('valor');

        // return view('main/index', [
        //     'title' => 'Dashboard | Fin-tiny',
        //     'janeiro' => $janeiro, // Total de Janeiro
        //     'fevereiro' => $fevereiro, // Total de fevereiro
        // ]);
    }
}
