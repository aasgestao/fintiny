@extends('templates.admin')

@php
 use App\Models\DetailsContasPagarModel;
 use App\Models\BancosModel;
@endphp
@section('content')


            <div class="content-wrapper">
                <div class="content">
                    <div class="d-flex justify-content-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Importação de Contas - Via API Tiny
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <form action="{{ route('financeiro.getPedidos')}}" method="post">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="cliente" class="form-label"> Cliente: </label>
                                                    <select name="cliente" id="cliente" class="form-control" required>
                                                        <option value="">Selecione ...</option>
                                                        @foreach ($clientes as $cliente)
                                                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label for="data_inicio" class="form-label"> Data inicio: </label>
                                                    <input type="date" name="data_inicio" class="form-control">
                                                </div>
                                                <div class="col-2">
                                                    <label for="data_final" class="form-label"> Data final: </label>
                                                    <input type="date" name="data_final" class="form-control">
                                                </div>
                                                <div class="col-auto mt-auto">
                                                    <button class="btn btn-primary btn-sm text-center"
                                                        onclick="this.innerText = 'Lendo dados...'"><i class="fas fa-search me-3"></i>
                                                        Pesquisar</button>
                                                </div>
                                            </div>




                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card search">
                        <div class="card-header d-flex justify-content-between">
                            <h5>Contas Pagar</h5>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                                    class="fas fa-square-plus"></i></button>
                        </div>
                        <div class="accordion accordion-flush" id="accordionFlushExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne2" aria-expanded="false" aria-controls="flush-collapseOne">
                                        Filtros / Pesquisa:
                                    </button>
                                </h2>
                                <div id="flush-collapseOne2" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample2">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <form action="{{ route('financeiro.contas_pagar')}}" method="get" class="form-sm">

                                                <div class="row">
                                                    <div class="col-3">
                                                        <label for="empresa" class="form-label"> Empresa: </label>
                                                        <select name="empresa" id="empresa" class="form-control" >
                                                            <option value="{{ $empresa }}">Selecione ...</option>
                                                            @foreach ($clientes as $cliente)
                                                                <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="nome_cliente" class="form-label"> Nome do cliente: </label>
                                                        <input type="text" name="nome_cliente" class="form-control" value="{{ $nome_cliente }}">
                                                    </div>

                                                    <div class="col-2">
                                                        <label for="situacao" class="form-label"> Situação: </label>
                                                        <select name="situacao" id="situacao" class="form-control">
                                                            <option value="{{ $situacao }}">Selecione ...</option>
                                                            @foreach ($situacoes as $situacao)
                                                                <option value="{{ $situacao->situacao }}">{{ $situacao->situacao }}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-2">
                                                        <label for="data_inicial" class="form-label"> Data inicio: </label>
                                                        <input type="date" name="data_inicial" class="form-control" value="{{ $data_inicial }}">
                                                    </div>
                                                    <div class="col-2">
                                                        <label for="data_final" class="form-label"> Data final: </label>
                                                        <input type="date" name="data_final" class="form-control" value="{{ $data_final }}">
                                                    </div>



                                                </div>
                                                {{-- Linha dois pesquisa --}}
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label for="historico" class="form-label"> Historico: </label>
                                                        <input name="historico" id="historico" class="form-control" value="{{ $historico }}">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="valor" class="form-label"> Valor: </label>
                                                        <input type="text" name="valor" class="form-control" value="{{ $valor }}">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="numero_doc" class="form-label"> Número Docto: </label>
                                                        <input type="text" name="numero_doc" class="form-control" value="{{ $numero_doc }}">
                                                    </div>

                                                    {{-- <div class="col-2">
                                                        <label for="situacao" class="form-label"> Situação: </label>
                                                        <select name="situacao" id="situacao" class="form-control">
                                                            <option value="">Selecione ...</option>
                                                            @foreach ($situacoes as $situacao)
                                                                <option value="{{ $situacao->situacao }}">{{ $situacao->situacao }}</option>

                                                            @endforeach
                                                        </select>
                                                    </div> --}}

                                                    <div class="d-flex justify-content-end mt-2">
                                                        <button class="btn btn-primary btn-sm text-center me-2" ><i
                                                            class="fas fa-search me-3"></i>
                                                            Pesquisar</button>
                                                        <a href="{{ route('financeiro.contas_pagar')}}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit text-dark me-2"></i> Limpar
                                                        </a>
                                                    </div>
                                                </div>




                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <x-alert />
                            <table class="table  table-striped border-none">
                                <thead>
                                    <tr>
                                        <th>ID(tiny)</th>
                                        <th>Empresa</th>
                                        <th>Cliente</th>
                                        <th>Vencimento</th>
                                        <th>Valor</th>
                                        <th>Situação</th>
                                        <th>Categoria</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                     @forelse ($contas as $conta)
                                        @if ($conta)
                                            @php 
                                                $categoria = DetailsContasPagarModel::where('id_tiny', $conta->id_tiny)->first();
                                                $categoria_nome = $categoria ? $categoria->categoria : 'Sem Categoria';
                                            @endphp   
                                        @endif
                                        
                                        <tr>
                                            <td>{{ $conta->id_tiny}}</td>
                                            <td>{{ $conta->empresa}}</td>
                                            <td>{{ $conta->nome_cliente}}</td>
                                            <td>{{ Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y')}}</td>
                                            <td>{{ $conta->valor}}</td>
                                            <td>{{ $conta->situacao}}</td>
                                            <td>{{ $categoria_nome }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning verConta"
                                                data-id="{{ $conta->id}}"
                                                data-id_tiny="{{ $conta->id_tiny}}"
                                                data-nome_cliente="{{ $conta->nome_cliente}}"
                                                data-vencimento="{{ $conta->vencimento}}"
                                                data-valor="{{ $conta->valor}}"
                                                data-empresa="{{ $conta->empresa}}"
                                                data-situacao="{{ $conta->situacao}}"
                                                data-categoria="{{ $categoria_nome}}"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#verConta"
                                                >
                                                    <i class="fas fa-edit text-dark me-2"></i>Editar
                                                </button>
                                            </td>
                                        </tr>
                                            
                                    @empty
                                    
                                        <tr>
                                            <td colspan="9" class="text-center danger">Nenhum registro localizado !!!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $contas->links() }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
    <!--offcanvas ver -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="verConta" aria-labelledby="verContaLabel"
        style="width: 800px">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="verContaLabel">Detalhes Conta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="#" method="post">
                <div class="row">
                    <div class="col-6">
                        <input type="text" id="input_id" value="" name="id">
                        <label for="id_tiny" class="form-label">ID (Tiny): </label>
                        <input type="text" id="input_id_tiny" value="" class="form-control" name="id_tiny" readonly>
                    </div>
                    <div class="col-6">
                        <label for="contaOrigem" class="form-label">Banco: </label>
                        <input type="text" id="input_conta" value="" name="conta">
                        {{-- <select name="contaOrigem" id="contaOrigem" class="form-control">
                            @if ($banco_nome)
                                <option value="{{ $banco_nome}}">{{ $banco_nome}}</option>
                             @endif
                            
                        </select> --}}
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="data" class="form-label">Data Vencimento: </label>
                        <input type="date" id="input_data" value="" class="form-control" name="data">
                    </div>
                    <div class="col-6">
                        <label for="categoria" class="form-label">Categoria: </label>
                        <select name="categoria" id="categoria" class="form-control"> 
                            @if ($categoria_nome)
                                <option value="{{ $categoria_nome }}">{{ $categoria_nome }}</option>
                            @endif
                        </select>
                        {{-- <input type="text" id="input_categoria" name="categoria" value=""> --}}
                    </div>

                </div>
                <div class="me-1 ms-1 mx-auto">
                    <label for="historico" class="form-label">Detalhes / Informações adicionais: </label>
                    <textarea class="form-control" name="historico" id="input_historico" cols="30" rows="5"></textarea>
                </div>
                <div class="row mx-auto">
                    <div class="col-md-3">
                        <label for="valorTaxas" class="form-label">Taxas: </label>
                        <input class="form-control" type="text" name="valorTaxas">
                    </div>
                    <div class="col-md-2">
                        <label for="valorJuros" class="form-label">Juros: </label>
                        <input class="form-control" type="text" name="valorJuros">
                    </div>
                    <div class="col-md-2">
                        <label for="valorDesconto" class="form-label">Desconto: </label>
                        <input class="form-control" type="text" name="valorDesconto">
                    </div>
                    <div class="col-md-2">
                        <label for="valorAcrescimo" class="form-label">Acréscimo: </label>
                        <input class="form-control" type="text" name="valorAcrescimo">
                    </div>
                    <div class="col-md-3">
                        <label for="valorPago" class="form-label">Pago: </label>
                        <input class="form-control" type="text" name="valorPago" id="valorPago">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-5">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-edit me-3"></i> Baixar
                        Conta</button>
                </div>
            </form>

        </div>
    </div>


                <!-- Modal criar conta -->
       {{-- <div class="modal fade" id="criarConta" tabindex="-1" aria-labelledby="criarContaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="criarContaLabel">Criar Conta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('financeiro/criarConta')?>" method="post">
                            <div class="col-12">
                                <label for="data" class="form-label">Empresa:</label>
                                <select name="empresa_id" id="" class="form-control" required>
                                    <option value="">Selecione ...</option>
                                    <?php if (isset($clientes)): ?>
                                    <?php    foreach ($clientes as $clienteEmpresa): ?>
                                    <option value="{{ $clienteEmpresa['id'] ?>">{{ $clienteEmpresa['nome'] ?></option>
                                    <?php    endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="data" class="form-label">Data Atual:</label>
                                    <input type="text" name="data" class="form-control" value="<?php echo date('d/m/Y')?>"
                                        readonly>
                                </div>
                                <div class="col-6">
                                    <label for="vencimento" class="form-label">Vencimento:</label>
                                    <input type="date" name="vencimento" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="nome" class="form-label">Cliente:</label>
                                    <!-- <input type="text" name="nome" class="form-control"> -->
                                    <select name="nome" id="" class="form-control" required>
                                        <option value="">Selecione ...</option>
                                        <?php if (isset($clientesInternos)): ?>
                                        <?php    foreach ($clientesInternos as $clienteInterno): ?>
                                        <option value="{{ $clienteInterno['nome'] ?>">{{ $clienteInterno['nome'] ?></option>
                                        <?php    endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="valor" class="form-label">Valor:</label>
                                    <input type="text" name="valor" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="categoria" class="form-label">Categorias:</label>
                                    <select name="categoria" id="" class="form-control">
                                        <option value="">Selecione ...</option>
                                        <?php if (!empty($categorias)): ?>
                                        <?php    foreach ($categorias as $categoria): ?>
                                        <option value="{{ esc($categoria) ?>">{{ esc($categoria) ?></option>
                                        <?php    endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="historico" class="form-label">historico:</label>
                                <textarea name="historico" id="" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary btn-sm" type="submit"><i
                                        class="fas fa-save me-3"></i>Salvar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div> --}}

            <script>
                document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.verConta').forEach(button => {
        button.addEventListener('click', function () {
            // Ler as informações via botão
            const id = this.getAttribute('data-id');
            const data = this.getAttribute('data-data');
            const id_tiny = this.getAttribute('data-id_tiny');
            const nome_cliente = this.getAttribute('data-nome_cliente');
            const vencimento = this.getAttribute('data-vencimento');
            const valor = this.getAttribute('data-valor');
            const empresa = this.getAttribute('data-empresa');
            const situacao = this.getAttribute('data-situacao');
            const categoria = this.getAttribute('data-categoria'); 
            let form = 

            // Armazena os dados nos inputs
            document.querySelector('#input_id').value = id;
            document.querySelector('#input_id_tiny').value = id_tiny;
            document.querySelector('#input_nome_cliente').value = nome_cliente;
            document.querySelector('#input_vencimento').value = vencimento;
            document.querySelector('#input_valor').value = valor;
            document.querySelector('input_data').value = data;
            document.querySelector('#input_empresa1').value = empresa;
            document.querySelector('#input_situacao').value = situacao;
            document.querySelector('#input_categoria').value = categoria;

            alert("Empresa: " + empresa + " - Input Empresa: " + document.querySelector('#input_empresa1').value);
        });
    });
});


            </script> 
@endsection