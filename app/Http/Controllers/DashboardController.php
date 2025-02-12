<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index ()
    {

        return view('main/index', [
            'title'=> 'Dashboard | Fin-tiny',
        ]);
    }
}
