@extends('templates.admin')

@section('content')

<div class="content-wrapper">
        <div class="content">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb d-flex justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('main.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('email.index') }}">Emails</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Escrevendo</li>
                </ol>
            </nav>

        <div class="row">
          <div class="col-md-3">
            <a href="{{ route('email.index')}}" class="btn btn-primary btn-block mb-3"> Voltar para Cx. Entrada</a>

            <div class="card">
              <div class="card-header">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Pastas
                        </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                    <div class="card-body p-0">
                                        <ul class="nav nav-pills flex-column">
                                        <li class="nav-item active">
                                            <a href="#" class="nav-link">
                                            <i class="fas fa-inbox"></i> Caixa de Entrada
                                            <span class="badge bg-primary float-right">{{ $count}}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            <i class="far fa-envelope"></i> Enviadas
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            <i class="far fa-file-alt"></i> Rascunhos
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            <i class="fas fa-filter"></i> Lixeira
                                            <span class="badge bg-warning float-right">65</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                            <i class="far fa-trash-alt"></i> Trash
                                            </a>
                                        </li>
                                        </ul>
                                    </div>
                            </div>
                         </div>
                    </div>
                </div>
              </div>
            </div> 
            <!-- /.card -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Criando nova mensagem</h3>
                <x-alert/>
              </div>
              <form action="{{ route('email.send')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('POST')

              
              <!-- /.card-header -->
              <div class="card-body">
                <input type="hidden" name="cliente_id" value="1">
                <input type="hidden" name="id" value="" class="form-control">
                <input type="hidden" name="de" value="fintiny@teste.com" class="form-control">
                <div class="form-floating mb-3">
                  <input  placeholder="Para:" name="para" class="form-control">
                  <label for="para">Para: </label>
                </div>
                <div class="form-floating mb-3">
                  <input class="form-control" placeholder="Assunto:" name="assunto" class="form-control">
                  <label for="assunto"> Assunto: </label>
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 200px" name="corpo_email" placeholder="Digite sua mensagem"></textarea>
                </div>
                <div class="form-group">
                  <div class="btn btn-default btn-file">
                    <i class="fas fa-paperclip"></i> Anexos:
                    {{-- <input type="file" name="anexo" > --}}
                    <input type="file" name="anexo" multiple>
                  </div>
                  <p class="help-block">Max. 32MB</p>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Rascunho</button>
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Enviar</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Cancelar</button>
              </div>

              </form>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@endsection