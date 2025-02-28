<?php

namespace App\Http\Controllers;

use App\Models\ArquivosModel;
use App\Models\BancosModel;
use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use App\Models\PlanoContasModel;
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
//}

public function import_contas(Request $request)
{
    $financeiro = new FinanceiroController();

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

            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $linha++;

                // Pula a primeira linha (cabeçalho)
                if ($primeira_linha) {
                    $primeira_linha = false;
                    continue;
                }
                
                //dd($data);
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

                    $banco_conta = BancosModel::where('nome', $data[9])->first();
                    $banco_conta = $banco_conta->plano_conta ?? "";

                    //dd($insertData);
                    // Insere ou atualiza os dados
                    if (!$idExistente) {
                        $contasModel->create($insertData);
                    } else {
                        $idExistente->update($insertData);
                    }

                    if(!$data[7]){
                        $conta_parceiro = '';
                    }else{
                        $parceiro = PlanoContasModel::where('cnpj', $data[7])->first();
                    $conta_parceiro = $parceiro->conta_resumida ?? "";
                    }
                
                        //verificar de o banco tem plano de conta
                        if($banco_conta != null){
                            $contaContabil = $banco_conta;
                        }else{
                            $contaContabil = $data[9];
                        }
                    

                        if ($data[3] == 'C') {
                            $conta_debito = $contaContabil;
                            $conta_credito = $conta_parceiro ?? "";
                        } else {
                            $conta_debito = $conta_parceiro ?? "";
                            $conta_credito = $contaContabil;
                        }
                        

                        $dados = [
                            'empresa' => $empresa,
                            'data' => $dataFormatada,
                            'valor' => $valorFloat,
                            'conta_debito' => $conta_debito,
                            'conta_credito' => $conta_credito,
                            'historico' => $data[2],
                            'id_tiny' => $data[5],
                        ];
                        //dd($dados);

                    $financeiro->lancamentosContabeis($dados);
                    
                    
                }
            }
            fclose($handle);  // Fecha o arquivo após processar

            // Retorna uma mensagem de sucesso
            return redirect()->route('financeiro.index')->with('success', 'Contas importadas com sucesso!');
        }
    }

    return back()->with('error', 'Erro ao processar o arquivo.');
}
    public function import_planocontas(Request $request)
    {
        
        $request->validate([
            'planoconta' => 'required|file|mimetypes:text/csv,text/plain',
            'empresa' => 'required'
        ]);
        
        
        $empresa = ClienteEmpresaModel::where('nome', $request->input('empresa'))->first();
        $empresa = $empresa->cnpj;

        $date = date('Ymd_Hsi');
        $nome = 'Plano_importado_';
        //dd($empresa);
        //$empresa = $request->input('empresa');
        $file = $request->file('planoconta'); // Pega o arquivo do input

        if ($file->isValid()) {
            $newFileName = "$nome$date-$empresa.csv"; // Gera um nome único para o arquivo
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
                $planoContasModel = new PlanoContasModel();
                $primeira_linha = true;
                $linha = 0;

                while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                    //dd($data);
                    $linha++;

                    // Pula a primeira linha (cabeçalho)
                    if ($primeira_linha) {
                        $primeira_linha = false;
                        continue;
                    }

                    //dd($data);
                    if ($data) {
                        //dd($data);
                        Log::info("Processando linha: " . $linha);

                        // Verifica se o id_tiny já existe no banco
                        $idExistente = $planoContasModel->where('conta_resumida', $data[2])->first();

                        // Monta os dados para inserção/atualização
                        $insertData = [
                            'cliente_id'=> $empresa,
                            'cnpj'=> $data[4],
                            'conta' => $data[0],
                            'analitica' => $data[1],
                            'conta_resumida' => $data[2],
                            'descricao' => $data[3],
                        ];

                        //dd($insertData);
                        // Insere ou atualiza os dados
                        //$planoContasModel->create($insertData);

                        if (!$idExistente) {
                            $planoContasModel->create($insertData);
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

