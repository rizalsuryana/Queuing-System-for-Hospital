@extends('layouts.app')
{{-- admin Live antrian --}}
@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('patientQueue') }}">Antrian Online</a></li>
            <li class="breadcrumb-item active">{{ $patientQueue->poli_name }}</li>
        </ol>
    </nav>
</div>
<div class="modal modal-small fade" id="manageQuota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('patientQueue.changeQuota') }}" id="manageQuotaForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row row-cols-auto">
                        <input type="hidden" name="patientQueueId" @isset($patientQueue)
                            value="{{ $patientQueue->id }}" @endisset>
                        <div class="col-6 col-lg-4">
                            <div>
                                <label for="manageQuotaInput" class="form-label">Jumlah Kuota Harian</label>
                                <input type="text" class="form-control" id="manageQuotaInput" name="quota" value="{{$patientQueue->quota}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</a>
                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<section class="section">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Antrian {{ $patientQueue->poli_name }}
                        [{{ date('d-m-Y',strtotime($patientQueue->queue_at)) }}]</h5>
                    <div class="row">
                        <div class="col-12">
                            <label for="queueQuota" class="form-label">
                                <h6> Kuota Antrian : {{ $patientQueue->quota }}</h6>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="queueQuota" class="form-label">
                                <h6> Terisi : {{ $patientDetailCount }}</h6>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="queueQuota" class="form-label">
                                <h6> Sisa : {{ $patientQueue->quota-$patientDetailCount }}</h6>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{route('patientQueue')}}" class="btn btn-danger">Kembali</a>
                            {{-- <button class="btn btn-success" role="button" data-bs-toggle="modal"
                                data-bs-target="#manageQuota">Atur Kuota</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Tunggu</h5>
                    <hr>
                    <div class="table-responsive">
                        <table id="wai" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Antrian</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingPatients as $pp)                                    
                                <tr>
                                    <td>{{$pp->queue_number}}</td>
                                    <td>{{$pp->patient_name}}</td>
                                    <td><a href="#" class="btn btn-sm btn-primary btnAct" data-id="{{$pp->id}}" data-goto="called">Lanjutkan</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pasien Yang Sudah Dipanggil</h5>
                    <hr>
                    <div class="table-responsive">
                        <table id="wai" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Antrian</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calledPatients as $pp)                                    
                                <tr>
                                    <td>{{$pp->queue_number}}</td>
                                    <td>{{$pp->patient_name}}</td>
                                    <td><a href="#" class="btn btn-sm btn-primary btnAct" data-id="{{$pp->id}}" data-goto="inroom">Lanjutkan</a>
                                        <form action="{{ route('patientQueue.cancelOne') }}" method="GET">
                                            <input type="hidden" id="custId" name="id" value="{{$pp->id}}">
                                            <button type="submit" class="btn btn-danger text-left" style="padding: 5px 10px; font-size: 12px;" value="Tidak datang">Tidak Datang</button>
                                        </form> 
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sedang Diperiksa</h5>
                    <hr>
                    <div class="table-responsive">
                        <table id="wai" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Antrian</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inroomPatients as $pp)                                    
                                <tr>
                                    <td>{{$pp->queue_number}}</td>
                                    <td>{{$pp->patient_name}}</td>
                                    <td><a href="#" class="btn btn-sm btn-primary btnAct" data-id="{{$pp->id}}" data-goto="completed">Lanjutkan</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Selesai Kunjungan</h5>
                    <hr>
                    <div class="table-responsive">
                        <table id="wai" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Antrian</th>
                                    <th>Nama</th>
                                    <th>Waktu Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($completedPatients as $pp)                                    
                                <tr>
                                    <td>{{$pp->queue_number}}</td>
                                    <td>{{$pp->patient_name}}</td>
                                    <td>{{date('d-m-Y H:i',strtotime($pp->out_room_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>
@endsection

@push('childScripts')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btnAct').click(function(e){
                e.preventDefault();
                var dataId = $(this).data('id');
                var dataGoto = $(this).data('goto');
                $.post("{{route('patientQueue.changeStatus')}}", {
                        id: dataId,
                        status: dataGoto
                    })
                    .done(function (response) {
                        console.log(response)
                        alert("berhasil update");
                        location.reload();
                    })
                    .fail(function () {
                        alert("gagal update");
                    });
            });
            $('#manageQuotaForm').submit(function (e) {
                e.preventDefault();
                var ell = $('#manageQuotaForm');
                var url = ell.attr("action");
                var formData = new FormData(document.getElementById("manageQuotaForm"));

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        console.log(response);
                        location.reload();
                    },
                    error: function (response) {
                        $('#manageQuotaForm').find(".print-error-msg").find("ul").html('');
                        $('#manageQuotaForm').find(".print-error-msg").css('display',
                            'block');
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#manageQuotaForm').find(".print-error-msg").find(
                                    "ul")
                                .append(
                                    '<li>' + value + '</li>');
                        });
                    }
                });

            });
        });

    </script>
@endpush
