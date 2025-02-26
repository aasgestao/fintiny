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
                    <div class="row">
                        <div class="form-floating col-md-3 col-sm-12">
                            <input type="text" class="form-control" id="id_empresa" value="{{ $empresa['id'] }}" readonly>
                            <label for="id_empresa">ID (Interno)</label>
                        </div>

                        <div class="form-floating col-md-9 col-sm-12">
                            <input type="text" class="form-control" id="nome" value="{{ $empresa['nome'] }}">
                            <label for="nome">Nome</label>
                        </div>
                    </div>

                    <div class="form-floating col-md-12 col-sm-12 mt-2" >
                        <input type="text" class="form-control" id="token_tiny" value="{{ $empresa['token_tiny'] }}">
                        <label for="token_tiny">Token (Tiny)</label>
                    </div>
                </div>
            </div>

            <a href="{{ route('empresa.index')}}" class="btn btn-sm btn-danger text-white mt-3">
                <i class="fa-solid fa-arrow-left me-3"></i>Voltar
            </a>
        </div>
    </div>
@endsection
    