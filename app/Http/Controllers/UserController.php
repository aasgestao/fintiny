<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
        // Recuperar os registros do banco dados
        //$users = User::orderByDesc('created_at')->paginate(20);
        $users = User::when($request->has('name'), function ($WhenQuery) use ($request) {
            $WhenQuery->where('name', 'like', "%{$request->name}%");
        })
            ->when($request->has('email'), function ($WhenQuery) use ($request) {
                $WhenQuery->where('email', 'like', "%{$request->email}%");
            })
            // ->when($request->filled('data_ini'), function ($WhenQuery) use ($request) {
            //     $WhenQuery->where('created_at', '>=', \Carbon\Carbon::parse($request->data_ini)->format('Y-m-d H:i:s'));
            // })
            // ->when($request->filled('data_fim'), function ($WhenQuery) use ($request) {
            //     $WhenQuery->where('created_at', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d H:i:s'));
            // })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();


        return view('users.index', 
    [
        'title'=> 'Tela de Usuários',
        'users'=> $users,
        'name'=> $request->name,
        'email'=> $request->email
    ]);
    }
    public function create()
    {
        return 'tela criar usuario';
    }
    public function store(UserRequest $request)
    {
        $request->validated();

        $dados = [
            'name'=> $request->name,
            'email'=> $request->email,
            'perfil'=> $request->perfil,
            'password'=> Hash::make($request->password, [ 'rounds'=> 12]),
        ];

        //dd($dados);

        $newUser = User::create($dados);

        $id = $newUser->id;

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!!!');
    }
    public function update(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|email',
            'perfil'=> 'required',
        ]);

        //dd($request);

        $user = User::findOrFail($request->id);
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', 'Usuário alterado com sucesso!!!');


    }
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
