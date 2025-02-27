@extends('templates.admin')

@section('content')

<div class="content">
    <div class="card">
        <div class="card-header">
            <h6>Plano de contas</h6>
        </div>

        <div class="body">
            <x-alert/>
            <table class="table table-stripped table-sm">
                <thead>
                    <tr>
                        <th>CNPJ</th>
                        <th>CNPJ_Plano</th>
                        <th>Conta</th>
                        <th>Analitica (?)</th>
                        <th>Conta Resumida</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($planoContas as $p_conta)
                        <tr>
                            <td>{{ $p_conta->cliente_id}}</td>
                            <td>{{ $p_conta->cnpj}}</td>
                            <td>{{ $p_conta->conta}}</td>
                            <td>{{ $p_conta->analitica}}</td>
                            <td>{{ $p_conta->conta_resumida}}</td>
                            <td>{{ $p_conta->descricao}}</td>
                            <td>
                                <button class="btn btn-sm btn-warning editarConta" data-bs-toggle="modal" data-bs-target="#editarConta" 
                                data-id="{{ $p_conta->id}}"
                                >
                                    <i class="fas fa-edit text-dark"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center bg-red-500 white">Não encontrado registros !</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editarConta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarContaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editarContaLabel">Editando Conta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('plano_editar')}}" method="post">
            @csrf
            @method('POST')

            <input class="form-control" type="text" name="id" id="input_id" readonly >
            <div class="form-floating mb-3 mt-2">
                <input type="text" class="form-control" name="cnpj" placeholder="Digite o cnpj sem pontos">
                <label for="cnpj">CNPJ Plano</label>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<script>
    document.querySelectorAll('.editarConta').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const input_id = document.querySelector('#input_id');
            //alert(id + input_id);
            input_id.value = id;

        })
    })
</script>

@endsection