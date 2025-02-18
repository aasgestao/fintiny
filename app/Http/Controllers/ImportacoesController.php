<?php

namespace App\Http\Controllers;

use App\Models\ArquivosModel;
use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ImportacoesController extends Controller
{
    public function index()
    {
        $clientes = ClienteEmpresaModel::all();

        return view('importacoes/import_contas', [
            'title'=> 'Importações | FINTINY - 2ACONT ',
            'clientes'=> $clientes,
        ]);
    }
    

//     public function import_contas(Request $request)
// {
//     $empresa = $request->empresa;
//     $data = date('Ymd_His');

//     $request->validate([
//         'conta' => 'required|file|mimetypes:text/csv,text/plain',
//     ]);

//     if ($request->hasFile('conta')) {
//         $file = $request->file('conta');
//         $name = "importacao_{$data}_{$empresa}.csv"; 
//         $path = $file->storeAs('uploads', $name); // Salva em storage/app/uploads/

//         // Obtém o caminho correto do arquivo
//         $fullPath = storage_path("app/$path");

//         // Verifica se o arquivo realmente existe
//         if (!file_exists($fullPath)) {
//             return back()->with('error', "Arquivo não encontrado: $fullPath");
//         }

//         // Lendo o arquivo CSV
//         $dados = [];

//         if (($handle = fopen($fullPath, "r")) !== FALSE) {
//             $cabecalho = fgetcsv($handle, 1000, ","); // Pega a linha de cabeçalho

//             while (($linha = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                 $dados[] = array_combine($cabecalho, $linha);
//             }
//             fclose($handle);

//             return response()->json($dados); // Retorna os dados como JSON para testar
//         }

//         return back()->with('success', 'Arquivo enviado com sucesso!');
//     }

//     return back()->with('error', 'Erro ao enviar o arquivo.');
// }

public function import_contas(Request $request)
{
    $request->validate([
        'conta' => 'required|file|mimetypes:text/csv,text/plain',
        'empresa' => 'required'
    ]); 

    $data = date('Ymd_Hsi');
    $nome = 'Arquivo_importado_';
    
    $empresa = $request->input('empresa');
    $file = $request->file('conta'); // Pega o arquivo do input
    
    if ($file->isValid()) {
        $newFileName = "$nome$data-$empresa.csv"; // Gera um nome único para o arquivo
        $filePath = $file->storeAs('uploads', $newFileName); // Salva o arquivo em storage/app/uploads/

        // Obtém o caminho completo do arquivo
        $fullPath = storage_path("app/private/$filePath");
        //$fullPath = public_path("app/private/$filePath");
        //dd(!file_exists($fullPath));
        // Verifica se o arquivo existe
        if (!file_exists($fullPath)) {
            return back()->with('error', 'O arquivo não foi encontrado no diretório.');
        }

        // Abre o arquivo para leitura
        if (($handle = fopen($fullPath, 'r')) !== FALSE) {
            $contasModel = new ContasModel();
            $primeira_linha = true;
            $linha = 0;

            while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                $linha++;

                // Pula a primeira linha (cabeçalho)
                if ($primeira_linha) {
                    $primeira_linha = false;
                    continue;
                }

                if ($data) {
                    Log::info("Processando linha: " . $linha);

                    // Verifica se o id_tiny já existe no banco
                    $idExistente = $contasModel->where('id_tiny', $data[5])->first();

                    // Formata valores
                    $valorFormatado = str_replace('.', '', $data[4]); // Remove milhar
                    $valorFormatado = str_replace(',', '.', $valorFormatado); // Substitui vírgula por ponto
                    $valorFloat = floatval($valorFormatado);


                    // Converte para o formato correto
                    $dataFormatada = Carbon::createFromFormat('d/m/Y', $data[0])->format('Y-m-d');
                    // Converte a data usando Carbon
                    // $dataFormatada = Carbon::parse($data[0])->format('Y-m-d');

                    // Monta os dados para inserção/atualização
                    $insertData = [
                        'empresa' => $empresa,
                        'data' => $dataFormatada,
                        'categoria' => $data[1],
                        'historico' => $data[2],
                        'tipo' => $data[3],
                        'valor' => $valorFloat,
                        'id_tiny' => $data[5],
                        'contato' => $data[6],
                        'cnpj' => $data[7],
                        'marcadores' => $data[8],
                        'conta' => $data[9],
                        'nro_documento' => $data[10],
                    ];

                    //dd($insertData);
                    // Insere ou atualiza os dados
                    if (!$idExistente) {
                        $contasModel->create($insertData);
                    } else {
                        $idExistente->update($insertData);
                    }
                }
            }

            fclose($handle);  // Fecha o arquivo após processar

            // Retorna uma mensagem de sucesso
            return redirect()->route('financeiro.index')->with('success', 'Contas importadas com sucesso!');
        }
    }

    return back()->with('error', 'Erro ao processar o arquivo.');
}
}
