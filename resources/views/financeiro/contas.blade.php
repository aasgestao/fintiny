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
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Pesquisa / Filtros: 
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="{{ route('financeiro.index')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="empresa" placeholder="Digite o nome da empresa:">
                                    <label for="empresa">Empresa</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="conta" placeholder="Digite o nome da empresa:">
                                    <label for="conta">Banco</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="contato" placeholder="Digite o contato:">
                                    <label for="contato">Contato</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="historico" placeholder="Digite o historico:">
                                    <label for="historico">Historico</label>
                                </div>
                            </div>
                            <div class="footer d-flex justify-content-end">
                                <button class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-search text-white"></i>
                                    Enviar</button>
                                <a class="btn btn-sm btn-warning" href="{{ route('financeiro.index') }}">
                                    <i class="fas fa-edit text-dark"></i>
                                    Limpar</a>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
            </div>
            <div class="card search">
                <div class="card-header d-flex justify-content-between">
                    <h5>Contas</h5>
                    <a class="btn btn-sm btn-info" href="{{ route('importacoes.index')}}" >
                        <i class="fa-solid fa-file-import"></i>
                    </a>
                </div>
                <div class="card-body">
                    <x-alert/>
                    <table   class="table table-sm table-striped border-none table-responsive-sm table-bordered table-hover display" >
                        <thead>
                            <tr>
                                <th>ID(tiny)</th>
                                <th>Banco:</th>
                                <th>Empresa:</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th>Contato</th>
                                <th>Categoria</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contas as $conta)
                                <tr style="size: 10px">
                                    <td>{{ $conta->id_tiny}}</td>
                                    <td>{{ $conta->conta}}</td>
                                    <td>{{  $conta->empresa}}</td>
                                    @if ($conta->tipo   == "D" )
                                      <td>  Entrada</td>
                                    @else
                                    <td>  Saída</td>
                                    @endif
                                         
                                    <td>{{ Carbon\Carbon::parse($conta->data)->format('d/m/Y')}}</td>
                                    <td>{{ $conta->contato}}</td>
                                    <td>{{ $conta->categoria}}</td>
                                    <td>R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                    {{-- <td>{{ str_replace('.',',', $conta->valor)->format(2)}}</td> --}}
                                    <td>
                                        <button class="btn btn-sm btn-warning" 
                                        data-id="{{ $conta->id_tiny}}"
                                        data-tiny="{{ $conta->id_tiny}}"
                                        data-empresa="{{ $conta->empresa}}"
                                        data-data="{{ Carbon\Carbon::parse($conta->data)->format('d/m/Y')}}"
                                        data-contato="{{ $conta->contato }}"
                                        data-categoria="{{ $conta->categoria }}"
                                        data-tipo="{{ $conta->tipo }}"
                                        data-valor="{{ number_format($conta->valor, 2, ',', '.') }}"
                                        >
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
                    
                    
                    <div class="d-flex justify-content-between">
                        {{ $contas->links() }}
                        Total: {{ $count }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
