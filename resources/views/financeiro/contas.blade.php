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
                  <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="{{ route('financeiro.index')}}" method="get">
                            @csrf
                            <div class="row">
                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="empresa" value="{{ $empresa }}">
                                    <label for="empresa">Empresa</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="conta" value="{{ $conta }}">
                                    <label for="conta">Banco</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="date" class="form-control" name="data_inicial" value="{{ $data_inicial }}">
                                    <label for="data_inicial">Data Inicial:</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="date" class="form-control" name="data_final" value="{{ $data_final }}">
                                    <label for="data_final">Data Final:</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="categoria" value="{{ $categoria}}">
                                    <label for="categoria">Empresa</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    {{-- <input type="text" class="form-control" name="tipo" placeholder="Digite o nome da empresa:"> --}}
                                    <select name="tipo" class="form-control" >
                                        <option  value="" >{{ $tipo}}</option>
                                        <option  value="" ></option>
                                        <option value="D">Débito</option>
                                        <option value="C">Crédito</option>
                                    </select>

                                    <label for="tipo">Tipo Movimento</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="contato" value="{{ $contato }}" >
                                    <label for="contato">Contato</label>
                                </div>

                                <div class="form-floating mb-3 col-3">
                                    <input type="text" class="form-control" name="historico" value="{{ $historico }}">
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
                <div class="card-header">
                    <div class=" d-flex justify-content-start"><h5>Contas</h5></div>
                    <div class=" d-flex justify-content-end">

                        <a class="btn btn-sm btn-info me-2" href="{{ route('importacoes.index')}}" >
                            <i class="fa-solid fa-file-import"></i>
                        </a>
                        <form action="{{ route('exportExcel') }}" method="GET">
                            <input type="hidden" name="conta" value="{{ request('conta') }}">
                            <input type="hidden" name="empresa" value="{{ request('empresa') }}">
                            <input type="hidden" name="contato" value="{{ request('contato') }}">
                            <input type="hidden" name="historico" value="{{ request('historico') }}">
                            <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                            <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                            <input type="hidden" name="data_inicial" value="{{ request('data_inicial') }}">
                            <input type="hidden" name="data_final" value="{{ request('data_final') }}">

                            <button type="submit" class="btn btn-success btn-sm me-2">
                                <i class="fa-solid fa-file-excel"></i>
                            </button>
                        </form>
                        {{-- <a class="btn btn-sm btn-success" href="{{ route('exportExcel')}}" >
                            <i class="fa-solid fa-file-excel"></i>
                        </a> --}}
                    </div>
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
                                    @if ($conta->tipo == "D")
                                      <td>  Saída</td>
                                    @else
                                    <td>  Entrada</td>
                                    @endif

                                    <td>{{ Carbon\Carbon::parse($conta->data)->format('d/m/Y')}}</td>
                                    <td>{{ $conta->contato}}</td>
                                    <td>{{ $conta->categoria}}</td>
                                    <td>R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                                    {{-- <td>{{ str_replace('.',',', $conta->valor)->format(2)}}</td> --}}
                                    <td>
                                        <button class="btn btn-sm btn-warning seeDetails" 
                                        data-id="{{ $conta->id}}"
                                        data-tiny="{{ $conta->id_tiny}}"
                                        data-conta="{{ $conta->conta}}"
                                        data-categoria="{{ $conta->categoria}}"
                                        data-historico="{{ $conta->historico}}"
                                        data-empresa="{{ $conta->empresa}}"
                                        data-data="{{ Carbon\Carbon::parse($conta->data)->format('d/m/Y')}}"
                                        data-contato="{{ $conta->contato }}"
                                        data-categoria="{{ $conta->categoria }}"
                                        data-tipo="{{ $conta->tipo }}"
                                        data-valor="{{ number_format($conta->valor, 2, ',', '.') }}"
                                        data-bs-target="#seeDetails"
                                        data-bs-toggle="modal"
                                        >
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


                    <div class="d-flex justify-content-between">
                        {{ $contas->links() }}
                        {{-- Total: {{ $count }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MOdal - seeDetails --}}
    <div class="modal fade" id="seeDetails" tabindex="-1" aria-labelledby="seeDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="seeDetailsLabel">Detalhes Conta</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{route('financeiro.contas-update')}}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" id="input_id" name="id">
                <div class="row">
                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_id_tiny" name="id_tiny" value="">
                        <label for="input_id_tiny">ID (Tiny):</label>
                    </div>

                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_contato" name="contato" value="">
                        <label for="input_contato">Cliente</label>
                    </div>
                </div>
                <hr>
                <h6 class="text-center"><b>Informações de pagamento: </b></h6>
                <hr>
                <div class="row">
                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_conta" name="conta" value="">
                        <label for="input_conta">Conta Bancária:</label>
                    </div>

                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_data" name="data" value="">
                        <label for="input_data">Data de Pagamento:</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_categoria" name="categoria" value="">
                        <label for="input_categoria">Categoria:</label>
                    </div>

                    <div class="form-floating mb-3 col-md-6 col-sm-12">
                        <input type="text" class="form-control" id="input_empresa" name="empresa" value="">
                        <label for="input_empresa">Empresa:</label>
                    </div>
                </div>

                <div class="form-floating mb-3 col-md-12 col-sm-12">
                    <textarea type="text" class="form-control" id="input_historico" name="historico" value="" style="height: 120px"></textarea>
                    <label for="input_historico">Historico / Detalhes:</label>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    {{-- Final Modal - seeDetails --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll('.seeDetails').forEach(button => {
                    button.addEventListener('click', function () {
                        let id = this.getAttribute('data-id');
                        let id_tiny = this.getAttribute('data-tiny');
                        let conta = this.getAttribute('data-conta');
                        let data = this.getAttribute('data-data');
                        let historico = this.getAttribute('data-historico');
                        let empresa = this.getAttribute('data-empresa');
                        let contato = this.getAttribute('data-contato');
                        let categoria = this.getAttribute('data-categoria');
                        let tipo = this.getAttribute('data-tipo');
                        let valor = this.getAttribute('data-valor');

                        let inputid = document.querySelector('#input_id');
                        let inputempresa = document.querySelector('#input_empresa');
                        let inputcontato = document.querySelector('#input_contato');
                        let inputtipo = document.querySelector('#input_tipo');
                        let inputcategoria = document.querySelector('#input_categoria');
                        let inputvalor = document.querySelector('#input_valor');
                        let inputdata = document.querySelector('#input_data');
                        let inputtiny = document.querySelector('#input_id_tiny');
                        let inputconta = document.querySelector('#input_conta');
                        let inputhistorico = document.querySelector('#input_historico');

                        console.log("Contato:", contato);
                        console.log("Input contato:", inputcontato);

                        if (inputcontato) {
                            inputcontato.value = contato;
                        } else {
                            console.error("Elemento #input_contato não encontrado.");
                        }

                        if (inputid) inputid.value = id;
                        if (inputempresa) inputempresa.value = empresa;
                        if (inputtipo) inputtipo.value = tipo;
                        if (inputvalor) inputvalor.value = valor;
                        if (inputtiny) inputtiny.value = id_tiny;
                        if (inputconta) inputconta.value = conta;
                        if (inputcategoria) inputcategoria.value = categoria;
                        if (inputdata) inputdata.value = data;
                        if (inputhistorico) inputhistorico.value = historico;
                    });
                });
            });

    </script>

@endsection
