<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
        // Recuperar os registros do banco dados
        //$users = User::orderByDesc('created_at')->paginate(20);
        $users = User::when($request->has('name'), function ($WhenQuery) use ($request) {
            $WhenQuery->where('name', 'like', "%{$request->name}%");
        })
            // ->when($request->has('email'), function ($WhenQuery) use ($request) {
            //     $WhenQuery->where('email', 'like', "%{$request->name}%");
            // })
            // ->when($request->filled('data_ini'), function ($WhenQuery) use ($request) {
            //     $WhenQuery->where('created_at', '>=', \Carbon\Carbon::parse($request->data_ini)->format('Y-m-d H:i:s'));
            // })
            // ->when($request->filled('data_fim'), function ($WhenQuery) use ($request) {
            //     $WhenQuery->where('created_at', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d H:i:s'));
            // })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();


        return view('users.index', 
    [
        'title'=> 'Tela de Usuários',
        'users'=> $users,
        'name'=> $request->name
    ]);
    }
    public function create()
    {
        return 'tela criar usuario';
    }
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
