@extends('templates.admin')

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
                                    Pesquisa de Contas / Importação de Contas
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

                    <div class="card search">
                        <div class="card-header d-flex justify-content-between">
                            <h5>Contas Pagar</h5>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                                    class="fas fa-square-plus"></i></button>
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
                                        <tr>
                                            <td>{{ $conta->id_tiny}}</td>
                                            <td>{{ $conta->empresa}}</td>
                                            <td>{{ $conta->cliente}}</td>
                                            <td>{{ Carbon\Carbon::parse($conta->vencimetno)->format('d/m/Y')}}</td>
                                            <td>{{ $conta->valor}}</td>
                                            <td>{{ $conta->situacao}}</td>
                                            <td>{{ $conta->categoria}}</td><td>
                                                <button class="btn btn-sm btn-warning">
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
    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="verDetalheConta" aria-labelledby="verDetalheContaLabel"
        style="width: 800px">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="verDetalheContaLabel">Detalhes Conta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="<?= base_url('financeiro/baixaConta') ?>" method="post">
                <div class="row">
                    <div class="col-6">
                        <input type="hidden" id="inputEmpresa" value="" name="empresa">
                        <label for="id_tiny" class="form-label">ID (Tiny): </label>
                        <input type="text" id="id_tiny" value="" class="form-control" name="id_tiny" readonly>
                    </div>
                    <div class="col-6">
                        <label for="contaOrigem" class="form-label">Banco: </label>
                        <select name="contaOrigem" id="contaOrigem" class="form-control">
                            <?php if ($bancos): ?>
                            <?php    foreach ($bancos as $banco): ?>
                            <option value="<?= $banco['nome'] ?>"><?= $banco['nome'] ?></option>
                            <?php    endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="data" class="form-label">Data: </label>
                        <input type="date" id="data" value="" class="form-control" name="data">
                    </div>
                    <div class="col-6">
                        <label for="categoria" class="form-label">Categoria: </label>
                        <select name="categoria" id="categoria" class="form-control">
                            <?php if ($detalhes): ?>
                            <?php    foreach ($detalhes as $detalhe): ?>
                            <option value="<?= $detalhe['categoria'] ?>"><?= $detalhe['categoria'] ?></option>
                            <?php    endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                </div>
                <div class="me-1 ms-1 mx-auto">
                    <label for="historico" class="form-label">Detalhes / Informações adicionais: </label>
                    <textarea class="form-control" name="historico" id="historico" cols="30" rows="5"></textarea>
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
    </div>


        <!-- Modal criar conta -->
        <div class="modal fade" id="criarConta" tabindex="-1" aria-labelledby="criarContaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="criarContaLabel">Criar Conta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?=base_url('financeiro/criarConta')?>" method="post">
                            <div class="col-12">
                                <label for="data" class="form-label">Empresa:</label>
                                <select name="empresa_id" id="" class="form-control" required>
                                    <option value="">Selecione ...</option>
                                    <?php if (isset($clientes)): ?>
                                    <?php    foreach ($clientes as $clienteEmpresa): ?>
                                    <option value="<?= $clienteEmpresa['id'] ?>"><?= $clienteEmpresa['nome'] ?></option>
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
                                        <option value="<?= $clienteInterno['nome'] ?>"><?= $clienteInterno['nome'] ?></option>
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
                                        <option value="<?= esc($categoria) ?>"><?= esc($categoria) ?></option>
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
        </div>

            <script>
                document.querySelectorAll('.verConta').forEach(button => {
                    button.addEventListener('click', function () {
                        //ler as informaçores via botao
                        const dataIdTiny = this.getAttribute('data-idTiny');
                        const dataValor = this.getAttribute('data-valor');
                        const dataHistorico = this.getAttribute('data-historico');
                        const empresa = this.getAttribute('data-empresa');
                        //armazena o dado para ser exibido
                        const inputdataIdTiny = document.querySelector('#id_tiny');
                        const inputdataValor = document.querySelector('#valorPago');
                        const inputdataHistorico = document.querySelector('#historico');
                        const inputdataEmpresa = document.querySelector('#inputEmpresa')


                        // Atualiza o input com os dados
                        inputdataIdTiny.value = dataIdTiny;
                        inputdataValor.value = dataValor;
                        inputdataHistorico.value = dataHistorico;
                        inputdataEmpresa.value = empresa;



                    });
                });




            </script> --}}
@endsection