<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TrocarCnpj extends Controller
{
    public function mudarCNPJ(Request $request)
    {
        $cnpj = $request->input('cnpj');

        // Verifica se o CNPJ existe antes de trocar
        if (!ClienteEmpresaModel::where('cnpj', $cnpj)->exists()) {
            return redirect()->back()->with('error', 'CNPJ não encontrado');
        }

        Session::put('cnpj_filtro', $cnpj);

        return redirect()->back()->with('success', 'CNPJ alterado com sucesso');
    }
}
