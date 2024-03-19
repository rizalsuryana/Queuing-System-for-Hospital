@extends('adminRegisterDashboard.app')

@section('content')

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Cek Pendaftaran</li>
        </ol>
    </nav>
</div>
<section class="section notif">
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('patientQueue.checkQueue') }}" id="modalCheckForm" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">Cek Status Pendaftaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>

            <div class="row mb-3">
                <label for="nik2" class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                    <input type="text" name="nik" id="nik2" class="nik form-control"
                        pattern="[0-9]{16}" title="NIK harus berisi 16 digit angka">
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <!-- <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a> -->
            <button type="submit" class="btn btn-primary">Cek</button>
        </div>
    </form>
</section>
@endsection
