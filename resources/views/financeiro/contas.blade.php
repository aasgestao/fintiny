@extends('templates.admin')

@section('content')

    <div class="content-wrapper">
        <div class="content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                </ol>
            </nav>

            <div class="card search">
                <div class="card-header d-flex justify-content-between">
                    <h5>Pesquisa</h5>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#createClientes"><i
                            class="fas fa-square-plus"></i></button>
                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>

@endsection
