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
            <a href="{{ route('email.index')}}" class="btn btn-primary btn-block mb-3">Back to Inbox</a>

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
                                            <span class="badge bg-primary float-right">12</span>
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
              <form action="{{ route('email.send')}}" method="post">
                @csrf
                @method('POST')

              
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group">
                  <input type="hidden" name="cliente_id" value="1">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="de" value="fintiny@teste.com">
                  <input class="form-control" placeholder="Para:" name="para">
                </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Assunto:" name="assunto">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 300px" name="corpo_email">
                      <h1><u>Heading Of Message</u></h1>
                      <h4>Subheading</h4>
                      <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain
                        was born and I will give you a complete account of the system, and expound the actual teachings
                        of the great explorer of the truth, the master-builder of human happiness. No one rejects,
                        dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know
                        how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again
                        is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,
                        but because occasionally circumstances occur in which toil and pain can procure him some great
                        pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
                        except to obtain some advantage from it? But who has any right to find fault with a man who
                        chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
                        produces no resultant pleasure? On the other hand, we denounce with righteous indignation and
                        dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so
                        blinded by desire, that they cannot foresee</p>
                      <ul>
                        <li>List item one</li>
                        <li>List item two</li>
                        <li>List item three</li>
                        <li>List item four</li>
                      </ul>
                      <p>Thank you,</p>
                      <p>John Doe</p>
                    </textarea>
                </div>
                <div class="form-group">
                  <div class="btn btn-default btn-file">
                    <i class="fas fa-paperclip"></i> Attachment
                    <input type="file" name="attachment">
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