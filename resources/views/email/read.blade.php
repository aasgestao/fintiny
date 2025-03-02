@extends('templates.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb d-flex justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('email.index') }}">Caixa de Entrada</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lendo Email</li>
                </ol>
            </nav>

            <div class="card">
                <x-alert />
                
                <div class="card-header">
                    Inbox
                </div>
                <div class="card-body">

                    <table class="table border-spacing-1" style="border: 1px;">
                        <thead>
                            <tr>
                                <td class="col-1"></td>
                                <td class="d-flex justify-content-end">Detalhes do Email - Recebido em:   {{ Carbon\Carbon::parse($recebido_em)->format('d/m/Y - H:i:s') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>De: </th>
                                <td>{{ $de }}</td>
                            </tr>
                            <tr>
                                <th>Para: </th>
                                <td>{{ $para }}</td>
                            </tr>
                            <tr>
                                <th>Copia: </th>
                                <td>{{ $copia ?? '' }}</td>
                            </tr>
                            <tr>
                                <th>Assunto: </th>
                                <td>{{ $assunto }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="content">
                        <div class="card">
                            {{  $corpo_email }}
                        </div>
                    </div>

                    
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-primary me-md-2" type="button">
                            <i class="fa-solid fa-reply"></i>
                            Responder</a>
                        <a class="btn btn-primary" type="button">
                            <i class="fa-solid fa-share"></i>
                            Encaminhar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
