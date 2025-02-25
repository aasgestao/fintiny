@extends('templates.admin')

@section('content')
    
    <!-- Color System -->
    {{-- <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    Primary
                    <div class="text-white-50 small">#4e73df</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    Success
                    <div class="text-white-50 small">#1cc88a</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    Info
                    <div class="text-white-50 small">#36b9cc</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 mb-4">
            <div class="card bg-warning text-white shadow">
                <div class="card-body">
                    Warning
                    <div class="text-white-50 small">#f6c23e</div>
                </div>
            </div>
        </div>

    </div> --}}
    <div class="card">
        <div class="card-header">
            <h6>Graficos</h6>
            <form action="{{ route('main.index') }}" method="get">
                <div class="row">
                    <div class="form-floating  col-md-3 col-sm-12">
                        <select name="empresa" id="" class="form-control">
                            <option value="">{{ $empresa }}</option>
                            {{-- <option value="Filtermaq">Filtermaq</option> --}}
                            {{-- <option value="Filterparts ">Filterparts</option> --}}
                            @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->nome }}">{{ $cliente->nome }}</option>
                            @endforeach
                        </select>
                        <label for="empresa" class="form-label">Empresa</label>
                        </div>
                    <!-- Ano -->
                    <div class="form-floating mb-3 col-md-3 col-sm-12">
                        <select name="year" class="form-control" required>
                            <option value="">Selecione o ano</option>
                            @for ($ano = date('Y'); $ano >= date('Y') - 5; $ano--)
                                <option value="{{ $ano }}" {{ request('year') == $ano ? 'selected' : '' }}>
                                    {{ $ano }}
                                </option>
                            @endfor
                        </select>
                        <label for="year">Ano</label>
                    </div>

                    @php
                        $meses = [
                            1 => 'Janeiro',
                            2 => 'Fevereiro',
                            3 => 'Março',
                            4 => 'Abril',
                            5 => 'Maio',
                            6 => 'Junho',
                            7 => 'Julho',
                            8 => 'Agosto',
                            9 => 'Setembro',
                            10 => 'Outubro',
                            11 => 'Novembro',
                            12 => 'Dezembro',
                        ];
                    @endphp

                    {{-- <!-- Mês Inicial -->
                    <div class="form-floating mb-3 col-md-3 col-sm-12">
                        <select class="form-control" id="mes_inicial" name="mes_inicial">
                            <option value="">Mês Inicial</option>
                            @foreach ($meses as $num => $nome)
                                <option value="{{ $num }}" {{ request('mes_inicial') == $num ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                        <label for="mes_inicial">Mês Inicial</label>
                    </div>

                    <!-- Mês Final -->
                    <div class="form-floating mb-3 col-md-3 col-sm-12">
                        <select class="form-control" id="mes_final" name="mes_final">
                            <option value="">Mês Final</option>
                            @foreach ($meses as $num => $nome)
                                <option value="{{ $num }}" {{ request('mes_final') == $num ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                        <label for="mes_final">Mês Final</label>
                    </div> --}}

                    <!-- Botão de Pesquisa -->
                    <div class="col">
                        <button class="btn btn-sm btn-info mx-auto mt-auto">
                            <i class="fas fa-search me-2"></i> Pesquisar
                        </button>
                    </div>
                </div>
            </form>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <canvas id="faturamento"></canvas>
                </div>
                {{-- Total de Janeiro: R$ {{ number_format($janeiro, 2, ',', '.') }}
                                                Total de Fevereiro: R$ {{ number_format($fevereiro, 2, ',', '.') }} --}}
            </div>
        </div>
    </div>


    {{-- grafico de faturamento --}}

    <script>
        var faturamentoMensal = {!! json_encode([
            $janeiro,
            $fevereiro,
            $marco,
            $abril,
            $maio,
            $junho,
            $julho,
            $agosto,
            $setembro,
            $outubro,
            $novembro,
            $dezembro,
        ]) !!};

        var faturamentoMensalD = {!! json_encode([
            $janeiroD,
            $fevereiroD,
            $marcoD,
            $abrilD,
            $maioD,
            $junhoD,
            $julhoD,
            $agostoD,
            $setembroD,
            $outubroD,
            $novembroD,
            $dezembroD,
        ]) !!};

        console.log("Faturamento Mensal:", [faturamentoMensal, faturamentoMensalD]); // Teste no Console

        const ctx = document.getElementById('faturamento');

        new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ],
        datasets: [
            {
                label: 'Receitas',
                data: faturamentoMensal, // 🚀 Dados da primeira coluna
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Despesas',
                data: faturamentoMensalD, // 🚀 Dados da segunda coluna
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
    </script>
@endsection
