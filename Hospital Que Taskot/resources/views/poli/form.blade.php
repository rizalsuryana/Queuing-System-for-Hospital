@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('poli') }}">Data Poli</a></li>
            <li class="breadcrumb-item active">{{ $poli->name }}</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row mt-4 mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Poli</h5>
                                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
                    <div class="d-flex">
                        <div class="row mb-2">
                            <div class="col-12 col-md-6">
                                <form action="{{ route('poli.save') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div id="formErrValidation" class="alert alert-danger print-error-msg"
                                                style="display:none">
                                                <ul></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="poliId" value="{{ $poli->id }}">
                                    <div class="row">
                                    <div class="mb-3 row">
                                            <label for="poliName" class="col-sm-4 col-form-label">Nama Poli</label>
                                            <div class="col-sm-8">
                                            <input type="text" name="poliName" id="poliName" class="form-control"
                                                value="{{ $poli->name }}">
                                            </div>
                                    </div>
    
                                    <div class="mb-3 row">
                                    <label for="quota" class="col-sm-4 col-form-label">Kuota</label>
                                        <div class="col-sm-8">
                                            <input type="number" name="quota" id="quota" class="form-control"
                                                value="{{ $poli->quota }}">
                                        </div>  
                                    </div>
    
                                    <div class="mb-3 row">
                                        <label for="Jadwal" class="col-sm-4 col-form-label">Jadwal</label>
                                        <div class="col-sm-8">
                                        <a href="#" class="btn btn-secondary" data-bs-toggle="modal"
                                                data-bs-target="#addScheduleModal">Atur Jadwal</a>
                                        </div>
                                    </div>
                                    
        
                                        <div class="mb-3 row">
                                            <label for="note" class="col-sm-4 col-form-label">Catatan</label>
                                            <div class="col-sm-8">
                                            <textarea type="textarea" name="note" id="note" class="form-control"
                                                cols="30" rows="4">{{ $poli->note }}</textarea>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
    
                                    <div class="row">
                                        <div class="col-sm-6 text-end">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            &nbsp;
                                        </div>
                                </form>
                                <div class="col-sm-6 text-end" >
                                    @if (auth()->user()->name == "Admin")    
                                    <form method="POST" action="{{ route('adminPoli.destroy', $poli->id) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" value="delete" class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus poli ini?')">Hapus Poli</button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            </div>
                        </div >
                    </div>


                    <div class="row align-items-center mt-3">
                        <div class="col-10 offset-1">
                            <div class="table-responsive">
                                
                            <table id="poliScheduleTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
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
            </div>
        </div>

        <div class="modal fade" id="addScheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('poli.addSchedule') }}" id="modalAddForm" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="row">
                                <input type="hidden" name="poliId" value="{{ $poli->id }}">
                                <div class="col-12 col-md-3">
                                    <label for="scheduleDay" class="form-label">Hari</label>
                                    <select name="scheduleDay" id="scheduleDay" class="form-control">
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="scheduleStart" class="form-label">Mulai</label>
                                    <input type="time" name="scheduleStart" id="scheduleStart" class="form-control">
                                </div>

                                <div class="col-12 col-md-4">
                                    <label for="scheduleEnd" class="form-label">Berakhir</label>
                                    <input type="time" name="scheduleEnd" id="scheduleEnd" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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
            var poliScheduleDataTable = $('#poliScheduleTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: "{{ route('poli.showDetail', ['id'=>$poli->id]) }}",
                columns: [{
                        data: 'day',
                        name: 'day'
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
            $('body').on('click', '.delete', function () {
                if (confirm("Hapus jadwal?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('poli.deleteSchedule') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            var oTable = $('#poliScheduleTable').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
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
        });

    </script>
@endpush
