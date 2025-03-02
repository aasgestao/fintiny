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
                        <h5>Pesquisa de cliente</h5>
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                                class="fas fa-square-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empresa.index')}}" method="get">
                            <div class="row">
                                <div class="col-9">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Nome do Cliente" name="nome" value="{{ old('nome', $nome) }}">
                                    {{-- <label for="floatingInput">Cliente</label> --}}
                                </div>
                                <div class="d-flex mx-auto col mb-2">
                                    <button type="submit" class="btn btn-sm btn-primary me-2"><i class="fas fa-search me-2"></i>Pesquisar</button>
                                    <a class="btn btn-sm btn-warning me-2" href="{{ route('empresa.index')}}"><i class="fas fa-trash me-3"></i>Limpar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="container-fluid">
                        <x-alert/>
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>Id: </th>
                                    <th>Nome: </th>
                                    <th>CNPJ:</th>
                                    <th>Token(Tiny)</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($empresas as $empresa)
                                    <tr>
                                        <td>{{ $empresa->id }}</td>
                                        <td>{{ $empresa->nome }}</td>
                                        <td>{{ $empresa->cnpj }}</td>
                                        <td>
                                            <span id="token" style="display: none;">{{ $empresa->token_tiny }}</span>
                                            <button onclick="toggleToken()"  class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye me-2"></i>Mostrar</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editClientes"
                                            data-id="{{ $empresa->id }}" 
                                            data-nome="{{ $empresa->nome }}"
                                            data-cnpj="{{ $empresa->cnpj }}"
                                            data-token="{{ $empresa->token_tiny }}"
                                            data-bs-toggle="modal"data-bs-target="#editClientes"><i class="fas fa-edit"></i></button>

                                            <a href="{{ route('empresa.show', ['id'=> $empresa->id ])}}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-primary insertBank" data-banco-id="{{$empresa->id }}" data-bs-toggle="modal" data-bs-target="#insertBank">
                                                <i class="fa-solid fa-building-columns"></i>
                                            </button>
                                            {{-- <form action="{{ route('empresa.destroy', ['id' => $empresa->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Quer realmente apagar esse registro? ')" class="btn btn-sm btn-danger"><i class="fas fa-trash "></i></button>
                                            </form> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center" style="color: red"> Nenhum Cliente Carregado !</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="createClientes" tabindex="-1" aria-labelledby="createClientesLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createClientesLabel">Criando CLientes: </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('empresa.create') }}" method="post">
                            @csrf
                            @method('post')

                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ do Cliente: </label>
                                <input type="text" class="form-control"  placeholder="cnpj do Cliente" name="cnpj">
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Cliente: </label>
                                <input type="text" class="form-control"  placeholder="Nome do Cliente" name="nome">
                            </div>

                            <div class="mb-3">
                                <label for="token_tiny" class="form-label">Token(TINY): </label>
                                <input type="text" class="form-control" placeholder="token ERP Tiny "name="token_tiny">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-sm btn-info "><i class="fas fa-save me-3"></i> Salvar</button>
                            </div>

                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- modal editar  conta --}}

        <!-- Modal -->
        <div class="modal fade" id="editClientes" tabindex="-1" aria-labelledby="editClientesLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editClientesLabel">Criando CLientes: </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editClienteForm" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="input_id" value="">
                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ do Cliente: </label>
                                <input type="text" class="form-control" id="input_cnpj" placeholder="cnpj do Cliente" name="cnpj">
                            </div>

                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do Cliente: </label>
                                <input type="text" class="form-control" id="input_nome" placeholder="Nome do Cliente" name="nome">
                            </div>

                            <div class="mb-3">
                                <label for="token_tiny" class="form-label">Token(TINY): </label>
                                <input type="text" class="form-control" id="input_token_tiny" placeholder="token ERP Tiny "
                                    name="token_tiny" value="">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-sm btn-info "><i class="fas fa-save me-3"></i>
                                    Salvar</button>
                            </div>

                        </form>
                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>

    <!-- Modal -->
<div class="modal fade" id="insertBank" tabindex="-1" aria-labelledby="insertBankLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="insertBankLabel">Inserir Banco</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('empresa.banco')}}" method="post">
            @csrf
            @method('POST')

            <div class="form-floating mb-3">
                <input type="text" class="form-control"  name="nome">
                <label for="nome">Nome do Banco: </label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control"  name="conta_tiny">
                <label for="conta_tiny">Código do Banco: </label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control"  name="plano_conta">
                <label for="plano_conta">Código Plano Contas: </label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="input_banco_id" name="cliente_id" readonly>
                <label for="cliente_id">Cliente (ID): </label>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

    <script>
        document.querySelectorAll('.editClientes').forEach(button => {
            button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            const token = this.getAttribute('data-token');
            const cnpj = this.getAttribute('data-cnpj');
                //alert(cnpj);
            const form = document.querySelector('#editClienteForm');
            const inputId = document.querySelector('#input_id');
            const inputNome = document.querySelector('#input_nome');
            const inputCnpj = document.querySelector('#input_cnpj')
            const inputToken = document.querySelector('#input_token_tiny');

            inputId.value = id;
            inputNome.value = nome;
            inputToken.value = token;
            inputCnpj.value = cnpj;

            // Define o action do formulário dinamicamente
            form.action = `/clientes-update/${id}`;

        })
    });


    document.querySelectorAll('.insertBank').forEach(button => {
            button.addEventListener('click', function () {
                id_cliente = this.getAttribute('data-banco-id');

                inputDataBancoId = document.querySelector('#input_banco_id');

                inputDataBancoId.value = id_cliente;
            });
        });
    </script>

<script>
    function toggleToken() {
        let token = document.getElementById('token');
        if (token.style.display === 'none') {
            token.style.display = 'inline';
        } else {
            token.style.display = 'none';
        }
    }
    </script>

@endsection
