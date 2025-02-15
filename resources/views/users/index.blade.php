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
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createUsuario"><i
                                class="fas fa-square-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.index')}}" method="get">
                            <div class="row">
                                <div class="col-9">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Nome do Cliente"
                                        name="name" value="{{ $name }}">
                                    {{-- <label for="floatingInput">Cliente</label> --}}
                                </div>
                                <div class="d-flex mx-auto col mb-2">
                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                            class="fas fa-search me-2"></i>Pesquisar</button>
                                    <a class="btn btn-sm btn-warning" href="{{ route('users.index')}}"><i
                                            class="fas fa-trash me-3"></i>Limpar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="container-fluid">
                        <table class="table table-resposive table-stripped border-none">
                            <thead>
                                <tr>
                                    <th>Id:</th>
                                    <th>Nome:</th>
                                    <th>E-mail:</th>
                                    <th>Perfil:</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->perfil }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning editClientes" 
                                                data-id="{{ $user->id }}" 
                                                data-nome="{{ $user->nome }}"
                                                data-perfil="{{ $user->perfil }}"  
                                                data-bs-toggle="modal"
                                                data-bs-target="#editClientes"><i class="fas fa-edit"></i></button>
                                            <form action="{{ route('users.destroy', ['id' => $user->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" onclick="return confirm('Quer realmente apagar esse registro? ')"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-trash "></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-danger">Nenhum Usuario Localizado !!!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="createUsuario" tabindex="-1" aria-labelledby="createUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createUsuarioLabel">Criar Usuário:</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="cnpj" class="form-label">Nome do Usuário: </label>
                            <input type="text" class="form-control" id="input_name" placeholder="digite o nome do usuário" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Email do Cliente: </label>
                            <input type="email" class="form-control" id="input_email" placeholder="digite o e-mail do usuário" name="email">
                        </div>

                        <div class="mb-3">
                            <label for="perfil" class="form-label">Perfil: </label>
                            {{-- <input type="text" class="form-control" id="perfil"  name="perfil"> --}}
                            <select name="perfil" id="input_perfil" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection