@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Beranda</li>
        </ol>
    </nav>
</div>
<section class="section notif">
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row mt-4 mb-3">
        <div class="col-12">
            <h3>Daftar antrian hari ini</h3>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach ($datas as $data)
        <div class="col">
            <div class="card shadow">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <h2>{{$data->poli_name}}</h2>
                    <h5>{{$data->queueCount}} Antrian</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
