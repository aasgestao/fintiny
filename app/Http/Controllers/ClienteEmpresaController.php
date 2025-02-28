<?php

namespace App\Http\Controllers;

use App\Models\BancosModel;
use App\Models\ClienteEmpresaModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $bancos = BancosModel::where('cliente_id', $id)->orderBY('nome')->get();
        //dd($empresa);
        return view('empresa.show' , [
            'title'=> 'Visualizado Cliente',
            'empresa'=> $empresa,
            'bancos'=> $bancos,
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
    public function insertBank(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'conta_tiny'=> 'required',
            'plano_conta'=>'required',
            'cliente_id'=> 'required',
        ]);

        $banco = BancosModel::where('plano_conta',$request->input('plano_conta') )->first();
        DB::beginTransaction();

        try {
            if($banco){
                $banco->update($request->all());

                DB::commit();

                Log::info('Banco Atualizado com sucesso .');

                return redirect()->route('empresa.show', ['id' => $request->input('cliente_id')])->with('success', 'Banco inserido com sucesso!!!');


            }

            $novoBanco = BancosModel::create([
                'nome' => $request->input('nome'),
                'conta_tiny' => $request->input('conta_tiny'),
                'plano_conta' => $request->input('plano_conta'),
                'cliente_id' => $request->input('cliente_id'),
            ]);

            DB::commit();

            Log::info('Banco Criado com sucesso id:'.$novoBanco->id );

            return redirect()->route('empresa.show', ['id'=> $request->input('cliente_id')])->with('success', 'Banco inserido com sucesso!!!');
        } catch (Exception $e) {
            //throw $th;

            DB::rollBack();

            Log::info('Banco erro ao cadastrar id:' . $request->input('nome').  $e->getMessage());

            return redirect()->route('empresa.index')->with('error', 'Erro ao cadastrar banco!!!' . $e->getMessage());


        }

        
    }
    public function editBank(Request $request, $id)
    {
        $banco = BancosModel::findOrFail($request->id);

        DB::beginTransaction();

        try {
            
           $banco->update($request->all());

           DB::commit();

           return redirect()->back()->with('success', 'Banco Editado');


        } catch (Exception $e) {
            
            LOG::info('Banco não alterado'. $e->getMessage() );

            DB::rollBack();
            return redirect()->back()->with('error', 'Banco não Editado');


        }
    }
    
}
