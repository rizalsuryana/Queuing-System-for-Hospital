@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('doctor') }}">Dokter</a></li>
            <li class="breadcrumb-item active">{{ $breadcrumbName }}</li>
        </ol>
    </nav>
</div>
<section class="section">
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $formName }}</h5>
                    <div class="row mb-4">
                        <div class="col-10 col-offset-2 mb-4">
                            <form id="doctorForm" method="{{ $formMethod }}" action="{{ $formUrl }}">
                                @csrf
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>

                                @if(isset($doctor))
                                    <input type="hidden" name="doctorId" value="{{ $doctor->id }}">
                                @endif
                                <div class="form-group">
                                    <label for="inputEmail5" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="inputEmail5" name="name"
                                        placeholder="nama lengkap dokter"
                                        value="{{ old('name', $doctor->name ?? '') }}">
                                </div>
                                <div class="mt-3">
                                    <label for="inputName5" class="form-label">No HP</label>
                                    <input type="text" class="form-control " id="inputName5" name="phone"
                                        value="{{ old('phone', $doctor->phone ?? '') }}">
                                </div>
                                <div class="mt-3">
                                    <label for="inputDate" class="form-label">Tanggal Lahir</label>
                                    <div class="">
                                        <input type="date" class="form-control" name="birthDate"
                                            value="{{ old('birthDate', $doctor->birth_date ?? '') }}">
                                    </div>
                                </div>
                                <div class="mt-3 mb-3">
                                    <label for="inputText" class="form-label">Alamat</label>
                                    <div class="">
                                        <textarea name="address" class="form-control" cols="30"
                                            rows="4">{{ old('address', $doctor->address ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="">
                                    <label for="inputName34" class="form-label">NIK</label>
                                    <input type="text" class="form-control " id="inputName34" name="nik"
                                        value="{{ old('nik', $doctor->nik ?? '') }}">
                                </div>
                                <div class="mt-3"><label class="form-label">Jenis Kelamin</label>
                                    <div class="">
                                        <select class="form-select" name="gender">
                                            <option selected>Pilih</option>
                                            <option value="1"
                                                {{ (isset($doctor) && $doctor->gender == '1') ? 'selected':'' }}>
                                                Laki-laki</option>
                                            <option value="2"
                                                {{ (isset($doctor) && $doctor->gender == '2') ? 'selected':'' }}>
                                                Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Poli</label>
                                    <div class="">
                                        <select class="form-select" name="poliId" id="poliId">
                                            <option selected>Pilih</option>
                                            @foreach($polis as $poli)
                                                <option value="{{ $poli->id }}"
                                                    {{ (isset($doctor) && $poli->id == $doctor->fk_poli_id) ? 'selected':'' }}>
                                                    {{ $poli->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <a href="{{ route('doctor') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form><!-- End Multi Columns Form -->
                        </div>
                        @if(isset($doctor))
                        <div class="col-12 col-lg-6 mt-3  d-none">
                            <div class="row">
                                <div class="col-12 p3">
                                    <button id="addScheduleButton" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#addScheduleModal" data-doctor-id="{{ $doctor->id }}"><i
                                            class="bi bi-calendar3 me-2"></i>Tambah
                                        Jadwal</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 p-3">
                                    <div class="table-responsive">
                                    <table id="scheduleTable" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Hari</th>
                                                <th>Kuota</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>

    @if(isset($doctor))
    
        <div class="modal fade d-none" id="addScheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('doctor.addSchedule') }}" id="modalAddForm" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <input type="hidden" name="doctorId" value="{{ $doctor->id }}">
    
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="scheduleQuota" class="form-label">Kuota</label>
                                    <input type="number" name="scheduleQuota" id="scheduleQuota" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="poliScheduleChoice" class="form-label">Pilih jadwal</label>
                                    <ul class="list-group" id="poliScheduleChoice">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif
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

            $('#doctorForm').submit(function (e) {
                e.preventDefault();
                var ell = $('#doctorForm');
                var url = ell.attr("action");

                var formData = new FormData(document.getElementById("doctorForm"));

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        window.location.href = "{{ route('doctor') }}";
                    },
                    error: function (response) {
                        $('#doctorForm').find(".print-error-msg").find("ul").html('');
                        $('#doctorForm').find(".print-error-msg").css('display',
                            'block');
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#doctorForm').find(".print-error-msg").find("ul")
                                .append(
                                    '<li>' + value + '</li>');
                        });
                    }
                });

            });

            $('#addScheduleButton').click(function (e) {
                e.preventDefault();

                var doctorId = $(this).data('doctor-id');
                if (!doctorId) {
                    return;
                }

                $('#poliScheduleChoice').empty();
                $.ajax({
                    type: 'GET',
                    url: "{{ route('doctor.getPoliSchedule', ['id'=>(isset($doctor)?$doctor->id:'babi')]) }}",
                    dataType: 'json',
                    processData: false,
                    success: (response) => {
                        if (Array.isArray(response)) {
                            response.forEach(el => {
                                $('#poliScheduleChoice').append(
                                    '<li class="list-group-item"><input class="form-check-input me-3" name="poliScheduleId[]" type="checkbox" value="' +
                                    el.id + '">' + el.day + ', mulai ' + el
                                    .start_time + ' sampai ' + el.end_time +
                                    '</li>');
                            });
                        }
                        console.log(response);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseJSON.error);
                    }
                });
            });

            var poliScheduleDataTable = $('#scheduleTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: "{{ route('doctor.getSchedule', ['id'=>(isset($doctor)?$doctor->id:'babi')]) }}",
                columns: [
                    {
                        data: 'day',
                        name: 'day'
                    },                    
                    {
                        data: 'quota',
                        name: 'quota'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#modalAddForm').submit(function (e) {
                e.preventDefault();
                var ell = $('#modalAddForm');
                var url = ell.attr("action");

                var formData = new FormData(document.getElementById("modalAddForm"));

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        poliScheduleDataTable.ajax.reload();
                        $("#addScheduleModal .btn-close").click()
                    },
                    error: function (response) {
                        $('#modalAddForm').find(".print-error-msg").find("ul").html('');
                        $('#modalAddForm').find(".print-error-msg").css('display',
                            'block');
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#modalAddForm').find(".print-error-msg").find("ul")
                                .append(
                                    '<li>' + value + '</li>');
                        });
                    }
                });

            });

            $('body').on('click', '.delete', function () {
                if (confirm("Hapus jadwal?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('doctor.deleteSchedule') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            var oTable = $('#scheduleTable').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
            });
        });

    </script>
@endpush
