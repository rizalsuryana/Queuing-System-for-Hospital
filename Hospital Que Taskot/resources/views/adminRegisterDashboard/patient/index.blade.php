@extends('layouts.app')
{{-- Patien user data --}}
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Data Pasien</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        {{-- <div class="row mt-4 mb-3"> --}}
            {{-- <div class="col-6">
                <a href="{{ route('patient.downloadRegisterPatient', ['print' => 1]) }}" class="btn btn-warning">Cetak Data</a>
            </div> --}}
            {{-- <div class="modal-header mb-3">
                <a href="{{ route('patient.showAdd') }}" class="btn btn-success float-end">Tambah Pasien</a>
            </div> --}}
        {{-- </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">&nbsp;</h5>
                        <div class="table-responsive">
                            <table class="table table-striped" id="patientTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var poliScheduleDataTable = $('#patientTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: "{{ route('patient.showData') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'address',
                        name: 'address'
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

            //action delete
            $('body').on('click', '.delete', function() {
                if (confirm("Hapus jadwal?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('patient.deleteData') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function(res) {
                            var oTable = $('#patientTable').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
            });
        });
    </script>
@endpush
