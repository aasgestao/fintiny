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
                        <form action="{{ route('financeiro.lancamentos')}}" method="get">
                            <div class="row">
                                <div class="form-floating col-8">
                                    <input type="text" class="form-control" id="floatingInput" placeholder="Digite dua busca ..." name="busca" value="{{ old('busca', $busca) }}">
                                    <label for="floatingInput">Busca</label>
                                </div>

                                <div class="form-floating col-2">
                                    <input type="date" class="form-control" id="data_inicial"  name="data_inicial" value="{{ old('data_inicial', $data_inicial) }}">
                                    <label for="data_inicial">Data Inicial</label>
                                </div>

                                <div class="form-floating col-2">
                                    <input type="date" class="form-control" id="data_final"  name="data_final" value="{{ old('data_final', $data_final) }}">
                                    <label for="data_final">Data Final</label>
                                </div>

                            </div>
                                <div class="d-flex justify-content-end mt-2 col me-2">
                                    <button type="submit" class="btn btn-sm btn-primary me-2"><i class="fas fa-search"></i>Buscar</button>
                                    <a class="btn btn-sm btn-warning me-2" href="{{ route('financeiro.lancamentos')}}"><i class="fas fa-trash"></i>Limpar</a>
                                    <a class="btn btn-sm btn-success me-2" href="{{ route('exportLancamentos')}}"><i class="fa-regular fa-file-excel"></i> Exportar</a>
                                </div>
                        </form>
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