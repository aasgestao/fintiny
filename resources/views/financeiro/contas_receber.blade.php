@extends('templates.admin')

@section('content')

    <div class="content-wrapper">
        <div class="content">
            <div class="d-flex justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contas a receber</li>
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
                                <form action="#" method="post">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="cliente" class="form-label"> Cliente: </label>
                                            <select name="cliente" id="cliente" class="form-control" required>
                                                <option value="">Selecione ...</option>
                                                @foreach ($clientes as $cliente)
                                                    <option value="{{ $cliente->id}}">{{ $cliente->nome_cliente}}</option>
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
                    <h5>Contas Receber</h5>
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
                                    <td>{{ $conta->categoria}}</td>
                                    <td>
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

@endsection