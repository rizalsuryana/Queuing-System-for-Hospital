@extends('layouts.patientLayout')
{{-- Live --}}
@section('content')
<div class="container-fluid px-4 py-5 my-5 ">

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Antrian
                                    Online</a></li>
                            <li class="breadcrumb-item active">Live Antrian Pasien</li>
                        </ol>
                    </nav>
                    
                    <a style="font-size: 2.5rem;" href="{{ route('dashboard') }}"><i
                                class="bi bi-arrow-left-circle"></i></a>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    @foreach($chunckData as $data )
                        <div class="col">
                            <div class="card bg-danger-light">
                                <div class="card-body text-center">
                                    <span class="card-title" style="font-size: 2rem;">Antrian {{ $data['poliName'] }}
                                    </span>
                                    <div class="row" style="min-height: 150px;">
                                        <div class="col-12 text-center" style="font-size: 1.3rem;">
                                            <p>Pasien Yang Sedang Dilayani :</p>
                                            <p style="font-size: 2rem;">{{ isset($data['inRoom'])?$data['inRoom']:'Belum ada' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="float-start">Sebelumnya :
                                                {{ isset($data['completed']) ? $data['completed']: 'Belum ada' }}</span>
                                            <span class="float-end">Selanjutnya dfdsf:
                                                {{ isset($data['pending']) ? $data['pending']:'Belum ada' }}</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </section>

</div>
@endsection
