<?php

namespace App\Http\Controllers;

use App\Exports\ContasExport;
use App\Exports\LancamentosContabeisExport;
use App\Models\BancosModel;
use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use App\Models\ContasPagarModel;
use App\Models\ContasReceberModel;
use App\Models\DetailsContasPagarModel;
use App\Models\LancamentosContabeisModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        $contas = ContasModel::when($request->filled("conta"), function ($query) use ($request) {
            $query->where("conta", "like", "%" . $request->input("conta") . "%");
        })
        ->when($request->filled("empresa"), function ($query) use ($request) {
            $query->where("empresa", "like", "%" . $request->input("empresa") . "%");
        })
        ->when($request->filled("contato"), function ($query) use ($request) {
            $query->where("contato", "like", "%" . $request->input("contato") . "%");
        })
        ->when($request->filled("historico"), function ($query) use ($request) {
            $query->where("historico", "like", "%" . $request->input("historico") . "%");
        })
        ->when($request->filled("tipo"), function ($query) use ($request) {
            $query->where("tipo",  $request->input("tipo") );
        })
        ->when($request->filled("categoria"), function ($query) use ($request) {
            $query->where("categoria", "like", "%" . $request->input("categoria") . "%");
        })
        ->when($request->filled("data_inicial"), function ($query) use ($request) {
            $query->where("data", ">=", $request->input("data_inicial"));
        })
        ->when($request->filled("data_final"), function ($query) use ($request) {
            $query->where("data", "<=", $request->input("data_final") );
        })
        ->orderByDesc('created_at')
        ->paginate(30)
        ->withQueryString();

        $count = $contas->count();

        return view('financeiro/contas', [
            'title'=> 'Listagem de Contas',
            'contas'=> $contas,
            'count'=> $count,
            'empresa'=> $request->input("empresa"),
            'conta'=> $request->input("conta"),
            'contato'=> $request->input("contato"),
            'tipo'=> $request->input("tipo"),
            'historico'=> $request->input("historico"),
            'categoria'=> $request->input("categoria"),
            'data_inicial'=> $request->input("data_inicial"),
            'data_final'=> $request->input("data_final"),
        ]);
    }
    public function lancamentosIndex(Request $request)
    {
        $lancamentos = LancamentosContabeisModel::when($request->filled("busca"), function ($query) use ($request) {
            $query->where("historico", "like", "%" . $request->input("busca") . "%");
        })
            ->when($request->filled("data_inicial"), function ($query) use ($request) {
                $query->where("data", ">=", $request->input("data_inicial"));
            })
            ->when($request->filled("data_final"), function ($query) use ($request) {
                $query->where("data", "<=", $request->input("data_final"));
            })
            ->when($request->filled("conta_debito"), function ($query) use ($request) {
                $query->where("conta_debito", $request->input("busca"));
            })
            ->when($request->filled("conta_credito"), function ($query) use ($request) {
                $query->where("conta_credito", $request->input("busca"));
            })
            ->when($request->filled("id_tiny"), function ($query) use ($request) {
                $query->where("id_tiny", $request->input("busca"));
            })

            ->when($request->filled("valor"), function ($query) use ($request) {
                $query->where("valor", $request->input("busca"));
            })
            ->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();


        return view('financeiro.lancamentos', [
            'title'=> 'Lançamentos Contabeis 2.0',
            'lancamentos'=> $lancamentos,
            'busca'=> $request->busca,
            'data_inicial'=> $request->data_inicial,
            'data_final'=> $request->data_final,
        ]);
    }

    public function contas_pagar(Request $request)
    {


        $clientes = ClienteEmpresaModel::all();

        $contas = ContasPagarModel::when($request->filled("empresa"), function ($query) use ($request) {
            $query->where("empresa", "like", "%" . $request->input("empresa") . "%");
        })
            ->when($request->filled("nome_cliente"), function ($query) use ($request) {
                $query->where("nome_cliente", "like", "%" . $request->input("nome_cliente") . "%");
            })
            ->when($request->filled("contato"), function ($query) use ($request) {
                $query->where("contato", "like", "%" . $request->input("contato") . "%");
            })
            ->when($request->filled("historico"), function ($query) use ($request) {
                $query->where("historico", "like", "%" . $request->input("historico") . "%");
            })
            ->when($request->filled("tipo"), function ($query) use ($request) {
                $query->where("tipo", $request->input("tipo"));
            })
            ->when($request->filled("categoria"), function ($query) use ($request) {
                $query->where("categoria", "like", "%" . $request->input("categoria") . "%");
            })
            ->when($request->filled("data_inicial"), function ($query) use ($request) {
                $query->where("data_vencimento", ">=", $request->input("data_inicial"));
            })
            ->when($request->filled("data_final"), function ($query) use ($request) {
                $query->where("data_vencimento", "<=", $request->input("data_final"));
            })
            ->when($request->filled("situacao"), function ($query) use ($request) {
                $query->where("situacao", $request->input("situacao"));
            })
            ->when($request->filled("historico"), function ($query) use ($request) {
                $query->where("historico", $request->input("historico"));
            })
            ->when($request->filled("valor"), function ($query) use ($request) {
                $query->where("valor", $request->input("valor"));
            })
            
            ->when($request->filled("numero_doc"), function ($query) use ($request) {
                $query->where("numero_doc", $request->input("numero_doc"));
            })
            ->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();

        


        return view('financeiro/contas_pagar', [
            'title' => 'Listagem de Contas',
            'contas' => $contas,
            'clientes'=> $clientes,
            'situacoes' => ContasPagarModel::select('situacao')->distinct()->get(),
            'empresa'=> $request->input("empresa"),
            'nome_cliente'=> $request->input("nome_cliente"),
            'situacao'=> $request->input("situacao"),
            'data_inicial'=> $request->input("data_inicial"),
            'data_final'=> $request->input("data_final"),
            'historico'=> $request->input("historico"),
            'valor'=> $request->input("valor"),
            'numero_doc'=> $request->input("numero_doc"),
        ]);
    }
    public function export(Request $request)
    {
        $data = date('dmY_Hsi');
        return Excel::download(new ContasExport($request), "contas_filtradas_$data.xlsx");
    }
    public function exportLancamentos(Request $request)
    {
        $data = date('dmY_Hsi');
        return Excel::download(new LancamentosContabeisExport($request), "lancamentos_$data.xlsx");
    }
    public function contas_receber()
    {
        $clientes = ClienteEmpresaModel::all();
        $contas = ContasReceberModel::paginate(30);
        return view('financeiro/contas_receber', [
            'title' => 'Listagem de Contas',
            'contas' => $contas,
            'clientes'=> $clientes
        ]);
    }
    public function getPedidos(Request $request)
    {
        $idEmpresa = $request->cliente;
        $empresa = ClienteEmpresaModel::where('id', $idEmpresa)->first();
        $token = $empresa->token_tiny;
        $empresa = $empresa->nome;

        // Verifica se as datas foram passadas e formata corretamente
        $data_inicial = $request->data_inicio ? Carbon::parse($request->data_inicio)->format('d/m/Y') : null;
        $data_final = $request->data_final ? Carbon::parse($request->data_final)->format('d/m/Y') : null;

        $pagina = 1;
        $maisResultados = true;

        try {
            while ($maisResultados) {
                // Parâmetros da chamada
                $url = 'https://api.tiny.com.br/api2/contas.pagar.pesquisa.php';
                $data = "token=$token&formato=JSON";

                // Se as datas foram informadas, adiciona ao request
                if ($data_inicial && $data_final) {
                    $data .= "&data_ini_vencimento=$data_inicial&data_fim_vencimento=$data_final";
                }

                $data .= "&pagina=$pagina";

                //dd($data);

                $response = $this->lerContasPagar($url, $data);
                $dados = json_decode($response, true);


                if (isset($dados['retorno']['status_processamento']) && $dados['retorno']['status_processamento'] == 3) {
                    $contas = $dados['retorno']['contas'] ?? [];

                    //dd(!empty($contas));
                    if (!empty($contas)) {
                        foreach ($contas as $conta) {
                            $conta = $conta['conta'];

                            $novaConta = [
                                'empresa' => $empresa,
                                'id_tiny' => $conta['id'],
                                'nome_cliente' => $conta['nome_cliente'],
                                'historico' => $conta['historico'],
                                'numero_doc' => $conta['numero_doc'],
                                'data_vencimento' => Carbon::createFromFormat('d/m/Y', $conta['data_vencimento'])->format('Y-m-d'),
                                'data_emissao' => Carbon::createFromFormat('d/m/Y', $conta['data_emissao'])->format('Y-m-d'),
                                'valor' => $conta['valor'],
                                'saldo' => $conta['saldo'],
                                'situacao' => $conta['situacao'],
                            ];

                            // Verifica se a conta já existe no banco
                            $contaExistente = ContasPagarModel::where('id_tiny', $conta['id'])->first();
                            //dd($contaExistente);
                            if ($contaExistente) {
                                $contaExistente->update($novaConta);
                                $contaCriada = $contaExistente;
                            } else {
                                $contaCriada = ContasPagarModel::create($novaConta);
                            }
                            //dd('estou aqui antes da 2 chamada');
                            // Parâmetros da segunda requisição (detalhes da conta)
                            $url2 = 'https://api.tiny.com.br/api2/conta.pagar.obter.php';
                            $idConta = $contaCriada->id_tiny;
                            $data2 = "token=$token&id=$idConta&formato=JSON";

                            $response2 = $this->lerDetalhesContaPgar($url2, $data2);
                            $dados2 = json_decode($response2, true);
                            
                            if (isset($dados2['retorno']['status_processamento']) && $dados2['retorno']['status_processamento'] == 3) {
                                $detalhesConta = $dados2['retorno']['conta'];
                                
                                $inputDetalhes = [
                                    "id_tiny" => $contaCriada->id_tiny,
                                    "data" => Carbon::createFromFormat('d/m/Y', $detalhesConta['data'])->format('Y-m-d'),
                                    "vencimento" => Carbon::createFromFormat('d/m/Y', $detalhesConta['vencimento'])->format('Y-m-d'),
                                    "valor" => $detalhesConta['valor'],
                                    "nro_documento" => $detalhesConta['nro_documento'] ?? '',
                                    "competencia" => $detalhesConta['competencia'] ?? '',
                                    "codigo" => $detalhesConta['codigo'] ?? '',
                                    "nome" => $detalhesConta['nome'] ?? '',
                                    "tipo_pessoa" => $detalhesConta['tipo_pessoa'] ?? '',
                                    "cpf_cnpj" => $detalhesConta['cpf_cnpj'] ?? '',
                                    "ie" => $detalhesConta['ie'] ?? '',
                                    "rg" => $detalhesConta['rg'] ?? '',
                                    "endereco" => $detalhesConta['endereco'] ?? '',
                                    "numero" => $detalhesConta['numero'] ?? '',
                                    "complemento" => $detalhesConta['complemento'] ?? '',
                                    "bairro" => $detalhesConta['bairro'] ?? '',
                                    "cep" => $detalhesConta['cep'] ?? '',
                                    "cidade" => $detalhesConta['cidade'] ?? '',
                                    "uf" => $detalhesConta['uf'] ?? '',
                                    "pais" => $detalhesConta['pais'] ?? '',
                                    "fone" => $detalhesConta['fone'] ?? '',
                                    "email" => $detalhesConta['email'] ?? '',
                                    "historico" => $detalhesConta['historico'] ?? '',
                                    "categoria" => $detalhesConta['categoria'] ?? '',
                                    "situacao" => $detalhesConta['situacao'] ?? '',
                                    "ocorrencia" => $detalhesConta['ocorrencia'] ?? '',
                                    "dia_vencimento" => $detalhesConta['dia_vencimento'] ?? '',
                                    "saldo" => $detalhesConta['saldo'] ?? '',
                                ];

                                //dd($inputDetalhes);
                                // Atualiza ou cria o registro na tabela de detalhes
                                $atualizado = DetailsContasPagarModel::updateOrCreate(
                                    ['id_tiny' => $contaCriada->id_tiny],
                                    $inputDetalhes
                                );

                                //dd($atualizado);
                            }
                        }
                    }
                } else {
                    $maisResultados = false;

                    return redirect()->route('financeiro.contas_pagar')->with('success', 'Contas importadas com sucesso!');

                }

                $pagina++;
            }

            
        } catch (\Throwable $th) {
            return redirect()->route('financeiro.contas_pagar')->with('error', "Erro ao importar contas.");
        }
    }


    private function lerContasPagar($url, $data, $optional_headers = null)
    {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data
            )
        );

        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }

        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problema com $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problema obtendo retorno de $url, $php_errormsg");
        }

        return $response;
    }

    private function lerDetalhesContaPgar($url2, $data2, $optional_headers = null)
    {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => $data2
            )
        );

        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }

        $ctx = stream_context_create($params);
        $fp = @fopen($url2, 'rb', false, $ctx);
        if (!$fp) {
            throw new Exception("Problema com $url2, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new Exception("Problema obtendo retorno de $url2, $php_errormsg");
        }

        return $response;
    }

    public function contas_update(Request   $request)
    {
        dd($request);
    }

    public function lancamentosContabeis($dados)
    {
        //dd($dados['data']);


        
        // $dados = [
        //     'data' => $dados->data,
        //     'valor' => $dados->valor,
        //     'conta_debito' => $dados->conta_debito,
        //     'conta_credito' => $dados->conta_credito,
        //     'historico' => $dados->historico,
        //     'id_tiny' => $dados->id_tiny,
        // ];

        $existeLancamento = LancamentosContabeisModel::where('id_tiny', $dados['id_tiny'])->first();

        if(!$existeLancamento){
            $novaconta = LancamentosContabeisModel::create([
            'empresa' => $dados['empresa'],
            'data' => $dados['data'],
            'valor' => $dados['valor'],
            'conta_debito' => $dados['conta_debito'],
            'conta_credito' => $dados['conta_credito'],
            'historico' => $dados['historico'],
            'id_tiny' => $dados['id_tiny'],
            ]);

            $id = $novaconta->id;

            Log::info("Conta criada com sucesso numero $id .");

        }else{

            $contaatualizada = LancamentosContabeisModel::where('id_tiny', $dados['id_tiny'])->update([
                'empresa' => $dados['empresa'],
                'data' => $dados['data'],
                'valor' => $dados['valor'],
                'conta_debito' => $dados['conta_debito'],
                'conta_credito' => $dados['conta_credito'],
                'historico' => $dados['historico'],
                'id_tiny' => $dados['id_tiny'],
            ]);
            
                

            Log::info("Conta atualizado com sucesso.");
        }

        
        
    }
}