<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\ClienteEmpresaModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        

        return view('login/login', ['title' => 'Login | Fin-Tiny']);
    }
    public function acessar (LoginRequest $request)
    {
        $request->validated();
        
        $empresa = ClienteEmpresaModel::where('cnpj', $request->cnpj)->first();
        
        $login = $empresa->cnpj ?? '';

        
        if($login == $request->cnpj){
            $authenticated = Auth::attempt(['email' => $request->email, 'password'=>$request->password]);

            if (!$authenticated) {
                //redirecionar para a pagina de login

                return back()->withInput()->with('error', "Email ou senha incorreto");


            }

            $user = Auth::user();
        
            $user = User::find($user->id);

            return redirect()->route('main.index');

        }
        
        return redirect()->route('login.index')->with('error', 'E-mail ou senha incorretos!');
        
    }
    public function logout()
    {

        Auth::logout();

        return redirect()->route('login.index')->with('success', 'Deslogado com sucesso !');
    }

        

}
