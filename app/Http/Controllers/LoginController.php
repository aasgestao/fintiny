<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        

        return view('login/login', ['title' => 'Login | Fin-Tiny']);
    }
    public function acessar (Request $request)
    {
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
            'errors'=> [
                'email'=> 'Necessario informar o email',
                'password'=> 'favor informar a senha',
            ] 
            
        ]);

        return redirect()->route('main.index');
    }

}
