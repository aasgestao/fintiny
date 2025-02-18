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
                    <h5>Contas</h5>
                    <a class="btn btn-sm btn-info" href="{{ route('importacoes.index')}}" >
                        <i class="fa-solid fa-file-import"></i>
                    </a>
                </div>
                <div class="card-body">
                    <x-alert/>
                    <table class="table table-responsive table-striped border-none">
                        <thead>
                            <tr>
                                <th>ID(tiny)</th>
                                <th>Data</th>
                                <th>Contato</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contas as $conta)
                                <tr>
                                    <td>{{ $conta->id_tiny}}</td>
                                    <td>{{ Carbon\Carbon::parse($conta->data)->format('d/m/Y')}}</td>
                                    <td>{{ $conta->contato}}</td>
                                    <td>{{ $conta->categoria}}</td>
                                    <td>{{ str_replace('.',',', $conta->valor)}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit text-dark me-2"></i>Editar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center danger">Nenhum registro localizado !!!</td>
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
