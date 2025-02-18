@extends('templates.admin')

@section('content')

    <div class="content-wrapper">
        <div class="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                </ol>
            </nav>

            <div class="card search">
                <div class="card-header d-flex justify-content-between">
                    <h5>Pesquisa</h5>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                            class="fas fa-square-plus"></i></button>
                </div>
                <div class="card-body">
                    <x-alert/>

                    <p>Importação de arquivo .csv - (Contas)</p>
                    <form action="{{ route('importacoes.contas')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="col-4">
                            <label for="empresa" class="form-label">Selecione a empresa</label>
                            <select name="empresa" id="" class="form-control">
                                <option value="">Selecione a empresa ...</option>
                                {{-- <option value="Filtermaq">Filtermaq</option> --}}
                                {{-- <option value="Filterparts ">Filterparts</option> --}}
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-2">
                            <label for="conta" class="form-label">Importe o arquivo:</label>
                            <input type="file" name="conta" >

                            <button class="btn btn-sm btn-primary mt-2" type="submit"
                             onclick="this.innerText = 'Enviando...'">Enviar</button>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection