<?php

namespace App\Http\Controllers;

use App\Models\ClienteEmpresaModel;
use App\Models\ContasModel;
use App\Models\ContasPagarModel;
use App\Models\ContasReceberModel;
use App\Models\DetailsContasPagarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        //$contas = ContasModel::paginate(20);

        $contas = ContasModel::when($request->has("conta"), function ($query) use ($request) {
            $query->where("conta", $request->input("conta"));
        })
            ->when($request->has("empresa"), function ($query) use ($request){
                $query->where("empresa", $request->input("empresa"));
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('financeiro/contas', [
            'title'=> 'Listagem de Contas',
            'contas'=> $contas
        ]);
    }
    public function contas_pagar()
    {
        $clientes = ClienteEmpresaModel::all();
        $contas = ContasPagarModel::paginate(20);
        return view('financeiro/contas_pagar', [
            'title' => 'Listagem de Contas',
            'contas' => $contas,
            'clientes'=> $clientes
        ]);
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
        //dd($request);
        $idEmpresa = $request->cliente;
        $empresa = ClienteEmpresaModel::where('id', $idEmpresa)->first();
        $token = $empresa->token_tiny;
        $empresa = $empresa->nome;
        //dd($empresa, $idEmpresa);
        $data_inicial = Carbon::parse($request->data_inicio)->format('d/m/Y');
        $data_final = Carbon::parse($request->data_final)->format('d/m/Y');
        $pagina = 1;
        $maisResultados = true;
        //dd($data_inicial == '');
        if($request->has('data_inicial')){
            $data_inicial = 'estou aqui';
        }
        //dd($data_inicial);
        if ($request->has('data_inicial')) {
            $data_final = 'data 2';
        }
        //dd($data_inicial, $data_final );



        try {
            while($maisResultados){
                //Parametros da chamada

                $url = 'https://api.tiny.com.br/api2/contas.pagar.pesquisa.php';
                $data = "token=$token&formato=JSON&data_ini_vencimento=$data_final&data_fim_vencimento=$data_final&pagina=$pagina";

                $response = $this->lerContasPagar($url, $data, $optional_headers = null);
                $dados = json_decode($response, true);

                //dd($dados);

                if (isset($dados['retorno']['status_processamento']) && ($dados['retorno']['status_processamento'] == 3)) {
                    $contas = $dados['retorno']['contas'];


                    if (empty($contas)) {
                        //nao teve contas

                    } else {
                        //processar as contas
                        foreach ($contas as $conta) {
                            $conta = $conta['conta'];

                            //dd($conta);
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

                            $contaCriada = ContasPagarModel::create($novaConta);

                            //dd($idConta = $contaCriada->id_tiny);
                            //parametros nova chamada
                            $url2 = 'https://api.tiny.com.br/api2/conta.pagar.obter.php';
                            $idConta = $contaCriada->id_tiny;
                            $data2 = "token=$token&id=$idConta&formato=JSON";

                            //detalhes da nova chamada ( detalhes )
                            $response2 = $this->lerDetalhesContaPgar($url2, $data2, $optional_headers = null);
                            //dd($response2);
                            $dados2 = json_decode($response2, true);

                            //dd(isset($dados2['retorno']['status_processamento']) && ($dados2['retorno']['status_processamento']== 3));

                            if (isset($dados2['retorno']['status_processamento']) && ($dados2['retorno']['status_processamento'] == 3)) {
                                $detalhesConta = $dados2['retorno']['conta'];

                                //dd($detalhesConta);

                                $inputDetalhes = [
                                    "id_tiny" => $contaCriada->id_tiny,
                                    "data" => Carbon::createFromFormat('d/m/Y', $detalhesConta['data'])->format('Y-m-d'),
                                    "vencimento" => Carbon::createFromFormat('d/m/Y', $detalhesConta['vencimento'])->format('Y-m-d'),
                                    "valor" => $detalhesConta['valor'],
                                    "nro_documento" => $detalhesConta['nro_documento'] ?? '',
                                    "competencia" => $detalhesConta['competencia'] ?? '',
                                    "codigo" => $detalhesConta['codigo'] ?? '', //
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

                                if (!DetailsContasPagarModel::where('id_tiny', $contaCriada->id_tiny)->first()) {
                                    //dd('estou aqui 1');
                                    $detalhesOK = DetailsContasPagarModel::create($inputDetalhes);
                                    //dd($detalhesOK);
                                }
                                //dd('estou aqui 2');

                                $idExiste = DetailsContasPagarModel::where('id_tiny', $contaCriada->id_tiny)->first();

                                $contaAtualizar = DetailsContasPagarModel::findOrFail($idExiste->id);
                                $contaAtualizar->update($inputDetalhes);

                                //dd('atualizado');
                            }
                        }


                    }
                }else{
                    $maisResultados = false;
                }
                // Incrementa a página para a próxima iteração
                $pagina++;
            }

            return redirect()->route('financeiro.contas_pagar')->with('success', 'Contas importadas com sucesso!!!');


        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('financeiro.contas_pagar')->with('error', "Contas não importadas!!!");


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
}