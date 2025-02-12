@extends('templates.admin')

@section('content')
    <!-- Color System -->
    <div class="row">
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
        
    </div>

@endsection