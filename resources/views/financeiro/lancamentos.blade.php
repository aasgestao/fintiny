@extends('templates.admin')

@section('content')

    <div class="content-wrapper">
        <div class="content">
            <div class="d-flex justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('main.index')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contas</li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h6>Lançamentos Contabeis</h6>
                    <a href="#" class="btn btn-sm btn-info">
                        <i class="fas fa-square-plus"></i>
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-resposive table-striped">
                        <thead>
                            <tr class="text-center text-white dark">
                                <th>Empresa</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Débito</th>
                                <th>Crédito</th>
                                <th>Histórico</th>
                                <th>Id Tiny</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lancamentos as $lancamento)
                                <tr>
                                    <td>{{ $lancamento->empresa }}</td>
                                    <td>{{ Carbon\Carbon::parse($lancamento->data)->format('d/m/Y')}}</td>
                                    <td>{{ number_format($lancamento->valor, 2,',','.')}}</td>
                                    <td>{{ $lancamento->conta_debito}}</td>
                                    <td>{{ $lancamento->conta_credito}}</td>
                                    <td>{{ $lancamento->historico}}</td>
                                    <td>{{ $lancamento->id_tiny}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"> Não há lancamentos !</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                {{ $lancamentos->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection