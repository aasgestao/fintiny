@extends('templates/admin')

@section('content')

    <div class="content-wrapper">
        <div class="content">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb d-flex justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Empresa</li>
                </ol>
            </nav>

            <div class="card search">
                <div class="card-header d-flex justify-content-between">
                    <h5>Visualizando cliente</h5>
                    <form action="{{ route('empresa.destroy', ['id' => $empresa->id])}}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Quer realmente apagar esse registro? ')" class="btn btn-sm btn-danger"><i class="fas fa-trash "></i></button>
                    </form>
                    {{-- <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                            class="fas fa-square-plus"></i></button> --}}
                </div>
                <div class="card-body">
                    <x-alert/>
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <label for="id_empresa">ID (Interno)</label>
                            <input type="text" class="form-control" id="id_empresa" value="{{ $empresa['id'] }}" readonly>
                        </div>

                        <div class="col-md-9 col-sm-12">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" value="{{ $empresa['nome'] }}">
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12" >
                        <label for="token_tiny">Token (Tiny)</label>
                        <input type="text" class="form-control" id="token_tiny" value="{{ $empresa['token_tiny'] }}">
                    </div>
                </div>
                <hr>
                    <div class="row">
                        <div class="col-6">
                            <table class="table table-sm table-bordered">
                                <h6>Bancos</h6>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Codigo</th>
                                        <th>Plano Contas</th>
                                        <th class="text-center"> Ações </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($bancos as $banco)
                                        <tr>
                                            <td>{{ $banco->nome }}</td>
                                            <td>{{ $banco->conta_tiny }}</td>
                                            <td>{{ $banco->plano_conta }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning text-dark editarBanco" 
                                                data-bs-toggle="offcanvas" 
                                                data-bs-target="#editarBanco"
                                                data-id="{{ $banco->id }}"
                                                data-nome="{{ $banco->nome }}"
                                                data-cliente_id="{{ $banco->cliente_id }}"
                                                data-conta_tiny="{{ $banco->conta_tiny }}"
                                                data-plano_conta="{{ $banco->plano_conta }}"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center bg-red-600">Nenhum banco encontrado !</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="col-6">
                            <table class="table table-sm table-bordered">
                                <h6>Categorias</h6>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Plano Contas</th>
                                        <th class="text-center"> Ações </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($categorias as $categoria)
                                        <tr>
                                            <td>{{ $categoria->nome }}</td>
                                            <td>{{ $categoria->plano_contas }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-warning text-dark editarBanco" 
                                                data-bs-toggle="offcanvas" 
                                                data-bs-target="#editarCategoria"
                                                data-id="{{ $categoria->id }}"
                                                data-nome="{{ $categoria->nome }}"
                                                data-cliente_id="{{ $categoria->cliente_id }}"
                                                data-plano_conta="{{ $categoria->plano_contas }}"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center bg-red-600">Nenhum banco encontrado !</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                <hr>
            </div>

            <a href="{{ route('empresa.index')}}" class="btn btn-sm btn-danger text-white mt-3">
                <i class="fa-solid fa-arrow-left me-3"></i>Voltar
            </a>
        </div>
    </div>

    {{-- offcanvas edicao --}}
    <div class="offcanvas offcanvas-start " tabindex="-1" id="editarBanco" aria-labelledby="editarBancoLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="editarBancoLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center">
            Editando Bancos
            </div>
            <form action="{{ route('empresa.editBanco', 0)}}" method="post">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="input_id" value="">
                <input type="hidden" name="cliente_id" id="input_cliente_id" value="">
                <div class="col-md-10 col-sm-12">
                    <label for="nome" class="form-label">Nome: </label>
                    <input type="text" id="input_nome" value="" class="form-control" name="nome">
                </div>

                <div class="col-md-10 col-sm-12">
                    <label for="conta_tiny" class="form-label">Conta_tiny: </label>
                    <input type="text" id="input_conta_tiny" value="" class="form-control" name="conta_tiny">
                </div>

                <div class="col-md-10 col-sm-12">
                    <label for="plano_conta" class="form-label">Plano_conta: </label>
                    <input type="text" id="input_plano_conta" value="" class="form-control" name="plano_conta">
                </div>

                <div class="offcanvas-footer mt-4 d-flex justify-content-end">
                    <button class="btn btn-sm btn-primary text-center">
                        <i class="fas fa-save me-3"></i> Atualizar
                    </button>
                </div>
                
            </form>
        </div>
    </div>
    {{-- final offcanvas --}}


    <script>
        document.querySelectorAll('.editarBanco').forEach(button => {
            button.addEventListener('click', function () {
                let data_id = this.getAttribute('data-id');
                let data_nome = this.getAttribute('data-nome');
                let data_conta_tiny = this.getAttribute('data-conta_tiny');
                let data_plano_conta = this.getAttribute('data-plano_conta');
                let data_cliente_id = this.getAttribute('data-cliente_id');
                //alert(data_conta_tiny);
                input_id = document.querySelector('#input_id');
                input_nome = document.querySelector('#input_nome');
                input_plano_conta = document.querySelector('#input_plano_conta');
                input_conta_tiny = document.querySelector('#input_conta_tiny');
                input_cliente_id = document.querySelector('#input_cliente_id');

                input_id.value = data_id;
                input_nome.value = data_nome;
                input_cliente_id.value = data_cliente_id;
                input_plano_conta.value = data_plano_conta;
                input_conta_tiny.value = data_conta_tiny;
                input_cliente_id.value = data_cliente_id;
            });
        });
    </script>
@endsection
    