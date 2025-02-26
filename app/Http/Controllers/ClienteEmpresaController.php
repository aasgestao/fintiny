<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use Illuminate\Http\Request;

class ClienteEmpresaController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->nome;

        //var_dump($busca);

        //$empresas = ClienteEmpresaModel::all();
        $empresas = ClienteEmpresaModel::where('nome', 'like', "%{$busca}%")->get();

        return view('/empresa/index', [
            'title' => 'Clientes da empresa | Fin-tiny',
            'empresas' => $empresas,
            'nome'=> $busca,
        ]);
    }
    public function show($id)
    {
        $empresa = ClienteEmpresaModel::where('id', $id)->first();
        
        //dd($empresa);
        return view('empresa.show' , [
            'title'=> 'Visualizado Cliente',
            'empresa'=> $empresa,
        ]);
    }
    public function store(Request $request)
    {

        ClienteEmpresaModel::create([
            'nome'=> strtoupper($request->nome),
            'token_tiny'=>$request->token_tiny,
            'cnpj'=> $request->cnpj
        ]);

        return redirect()->route('empresa.index')->with('success', 'Cliente cadastrado com sucesso');
    }
    public function update(Request $request, $id)
    {
        $empresa = ClienteEmpresaModel::findOrFail($id);
        //dd($empresa);
        $empresa->update([
            'nome'=> $request->nome,
            'token_tiny'=>$request->token_tiny,
        ]);

        return redirect()->route('empresa.index')->with('success', 'Cliente atualizado com sucesso !');
    }
    public function destroy(Request $request, $id)
    {

        //dd($request, $id);
        $empresa = ClienteEmpresaModel::findOrFail($id);
        //dd($empresa);
        $empresa->delete();

        return redirect()->route('empresa.index')->with('success', 'Cliente excluido com sucesso !');
    }
    
}
