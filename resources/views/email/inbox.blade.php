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

            <div class="card">
                <x-alert />
                <div class="card-header">
                    Inbox
                </div>
                <section>
                    <div class="row">
                        <div class="card-body col-md-3 col-sm-12">
                            <a href="{{ route('email.compose' )}}" class="btn btn-primary btn-sm col-11 ms-3">
                                <i class="fas fa-envelope"></i>
                                Criar Novo
                            </a>
                            <div class="card col-11 ms-3">
                                <ul class="list-group">
                                <li class="list-group-item list-group-item-action active mt-1">Cx. Entrada</li>
                                <li class="list-group-item list-group-item-action mt-1">Enviadas</li>
                                <li class="list-group-item list-group-item-action mt-1">Rascunhos</li>
                                <li class="list-group-item list-group-item-action mt-1">Lixeira</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body col-md-9 col-sm-12">
                            <h6 class="text-start">
                                Mensagens
                            </h6>

                            <div class="table">
                                <table class="table table-sm table-stripped">
                                    <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Remetente</th>
                                            <th> Destinatário</th>
                                            <th> Assunto </th>
                                            <th> Data </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($emails as $email)
                                            <tr>
                                            <td> {{ $email->id}} </td>
                                            <td class="text-start "><a href="{{ route('email.read', ['id'=>$email->id ])}}"  style="text-decoration: none; color:black">
                                                {{ $email->de }}
                                            </a>
                                                </td>
                                            <td>{{ $email->para }}</td>
                                            <td>{{ $email->assunto}}</td>
                                            <td>{{ Carbon\Carbon::parse($email->created_at)->format('d/m/Y - H:i')}}</td>
                                        </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center">Nenhum registro encontrado !</td></tr>
                                        @endforelse
                                        
                                        
                                    </tbody>
                                </table>
                                {{ $emails->links() }}
                            </div>
                        </div>
                    </div>

                </section>




            </div>
        </div>
    </div>
@endsection
