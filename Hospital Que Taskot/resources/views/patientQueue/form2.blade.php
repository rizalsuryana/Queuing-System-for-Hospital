@extends('layouts.app')
{{-- /NaN teu dipake --}}
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('patient') }}">Antrian Online</a></li>
                <li class="breadcrumb-item active">Daftar Antrian</li>
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
                        <h5 class="card-title">Daftar Nomor Antrian</h5>
                        <form method="POST" action="{{route('patient.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Poli</label>
                                        <div class="">
                                            <select class="form-select" aria-label="Default select example" name="poli">
                                                <option selected>Pilih</option>
                                                <option value="1">Poli Gigi</option>
                                                <option value="2">Poli Mata</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label for="inputDate" class="form-label">Tanggal Layanan</label>
                                        <div class="">
                                            <input type="date" class="form-control" name="visitDate">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
