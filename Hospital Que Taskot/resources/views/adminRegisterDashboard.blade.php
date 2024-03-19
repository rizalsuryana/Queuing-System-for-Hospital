@extends('adminRegisterDashboard.app')

@section('content')

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Registrasi Antrian</li>
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
            <h3>
<form action="{{ route('adminRegister.store') }}" id="registerForm" method="POST">
    @csrf
    <div class="modal-header">
        <!-- <h5 class="modal-title">Daftar Antrian</h5> -->
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <div class="row">
            <input type="hidden" name="patientId" @isset($patient) value="{{ $patient->id }}" @endisset>
            <div class="col-lg-6">
                <div class="mb-3 row">
                    <label for="inputEmail5" class="col-sm-4 col-form-label fw-bold fs-6">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input placeholder="Nama lengkap pasien" class="form-control" id="inputEmail5" name="fullName">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputDate" class="col-sm-4 col-form-label fw-bold fs-6">Tanggal Lahir</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="birthDate"
                            @isset($patient) value="{{ $patient->birth_date }}" @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nik1" class="col-sm-4 col-form-label fw-bold fs-6">NIK</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan NIK pasien" type="text" class="form-control nik" id="nik1" name="nik"
                            pattern="[0-9]{16}" title="NIK harus berisi 16 digit angka" @isset($patient) value="{{ $patient->nik }}" @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phoneNumber" class="col-sm-4 col-form-label fw-bold fs-6">Nomor Handphone</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan nomer handphone pasien" type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                            pattern="[0-9]{10,15}" title="Nomor telepon harus berisi 10-15 digit angka" @isset($patient) value="{{ $patient->phone }}" @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label fw-bold fs-6">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <select class="form-select" aria-label="Default select example" name="gender">
                            <option value="" @if (!isset($patient) || !$patient->gender) selected @endif>Pilih</option>
                            <option value="1" @if (isset($patient) && $patient->gender == '1') selected @endif>
                                Laki-laki</option>
                            <option value="2" @if (isset($patient) && $patient->gender == '2') selected @endif>
                                Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="inputText" class="col-sm-4 col-form-label fw-bold fs-6">Alamat</label>
                    <div class="col-sm-8">
                        <textarea placeholder="Alamat Pasien" name="address" class="form-control" cols="30" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label fw-bold fs-6">Penjamin</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_umum" value="Umum" checked>
                                    <label class="form-check-label" for="penjamin_umum">Umum</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_bpjs" value="BPJS">
                                    <label class="form-check-label" for="penjamin_bpjs">BPJS</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_asuransi" value="Asuransi">
                                    <label class="form-check-label" for="penjamin_asuransi">Asuransi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="bpjsNumber" class="col-sm-4 col-form-label fw-bold fs-6">Nomor BPJS</label>
                    <div class="col-sm-8">
                        <input placeholder="Silahkan masukan nomor BPJS, Untuk Pasien BPJS" type="text" class="form-control " id="bpjsNumber"
                            name="bpjsNumber" @isset($patient) value="{{ $patient->bpjsNubmer }}" @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label fw-bold fs-6">Poli</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="poliId" id="poliId">
                            <option selected>Pilih Poli</option>
                            @isset($polis)
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="visitDate" class="col-sm-4 col-form-label fw-bold fs-6">Tanggal Layanan</label>
                    <div class="col-sm-8">
                        <input placeholder="Pilih tanggal" type="date" id="visitDate" class="form-control" name="visitDate">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <!-- <a href="#" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Tutup</a> -->
        <button type="submit" class="btn btn-lg btn-success">Daftar</button>
    </div>
</form>

        </div>
    </div>
    {{-- <div class="row row-cols-1 row-cols-md-2 g-4">
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
    </div> --}}
    <div class="modal fade" id="afterRegisterModal" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div id="printThis" class="modal-body">
                    <div class="text-center font-monospace lh-sm" style="display: block;">
                        <p>RSUD Kota Tasikmalaya</p>
                        <p>Jl Rumah Sakit No.55</p>
                        <p>Telp: (027)8923923</p>
                    </div>
                    <hr>
                    <div class="text-center font-monospace">
                        <p id="afterRegPoliName" class="text-uppercase" style="margin-top: 0.5rem;">Poli Gigi</p>
                        <h1>
                            <p class="fw-bold" id="afterRegQueueNumber">2</p>
                        </h1>
                        <p id="afterRegPatientName">Surya</p>
                        <p id="afterRegGuarantor">Umum</p>
                        <p>Tanggal Antrian</p>
                        <p id="afterRegQueueAt">15 Juli 2023</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                    <button id="btnPrintRegister" type="button" class="btn btn-warning">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
