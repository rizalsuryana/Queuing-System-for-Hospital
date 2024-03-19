@extends('layouts.patientLayout')

{{-- Live --}}
@section('content')
<div class="container-fluid px-4 py-5 my-5 bg-light"> <!-- Atur warna latar belakang di sini -->

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Antrian
                                    Online</a></li>
                            <li class="breadcrumb-item active">Live antrian pasien</li>
                        </ol>
                    </nav>
                    
                    {{-- <a style="font-size: 2.5rem;" href="{{ route('dashboard') }}"><i
                                class="bi bi-arrow-left-circle"></i></a> --}}
                </div>
<div class="container">
<div class="row row-cols-1 row-cols-md-2 g-4">
@foreach($chunckData as $data)
<div class="col">
<div class="card bg-light shadow">
    <div class="card-body text-center">
        <h2 class="card-title mt-3">Antrian {{ $data['poliName'] }}</h2>
        <div class="row mb-3 shadow bg-info">
            <div class="col-12 shadow">
                <p class="fw-bold mt-3">Nomor antrian yang sedang dilayani:</p>
                <p class="fs-2">{{ isset($data['inRoom']) ? 'No.'.$data['inRoom'] : 'Belum ada' }}</p>
            </div>
        </div>
        <div class="row mb-3 shadow">
            <div class="col-6 bg-info text-center">
                <p class="fw-bold mt-3">Nomor antrian menunggu dilayani:</p>
                <p>{{ isset($data['called']) ? 'No.' .$data['called'] : 'Belum ada' }}</p>
                {{-- <p> @if(is_array($data['called']) && count($data['called']) > 0)
                                                {{ implode(', ', $data['called']) }}
                                                @else
                                                Belum ada
                                                @endif
                                            </p> --}}
            </div>
            <div class="col-6 bg-info text-center">
                <p class="fw-bold mt-3">Nomor antrian menuggu di panggil:</p>
                <p>{{ isset($data['pending']) ? 'No.' .$data['pending'] : 'Belum ada' }}</p>
            </div>
        </div>
        <div class="row shadow">
            <div class="col-12 bg-info text-center">
                <p class="fw-bold mt-3">Nomor Antrian yang sudah selesai dilayani sebelumnya:</p>
                <p>{{ isset($data['completed']) ? 'No.' .$data['completed'] : 'Belum ada' }}</p>
            </div>
        </div>
    </div>
</div>
</div>
@endforeach
</div>
</div>

                
            </div>

        </div>

    </section>

</div>
@endsection
