@extends('layouts.app')
{{-- Cek status / Reprint --}}
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('patient') }}">Antrian Online</a></li>
                <li class="breadcrumb-item active">Cek Status Pendaftaran</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cek Status Pendaftaran</h5>
                        <form method="POST" action="{{ route('patient.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="">
                                            <label for="inputName5" class="form-label">NIK</label>
                                            <input type="text" class="form-control " id="inputName5" name="nik">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Cek</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
