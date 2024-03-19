@extends('adminRegisterDashboard.app')
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
                        <div class="row g-3">
                            <div class="col-lg-3 col-4">
                                <label for="startDate" class="form-label">Mulai</label>
                                <input type="date" id="startDate" class="form-control" name="startDate" >
                            </div>
                            <div class="col-lg-3 col-4">
                                <label for="endDate" class="form-label">Sampai</label>
                                <input type="date" id="endDate" class="form-control" name="endDate" >
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="patientTable">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Telepon</th>
                                        <th>Alamat</th>
                                        <th>Poli</th>
                                        <th>Waktu</th>
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
                ajax: {
                    "url": "{{ route('antrian.ShowData') }}",
                    "type": "GET",
                    "datatype": "json",
                    data: function (d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        return d;
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'patient_name'
                    },
                    {
                        data: 'nik',
                        name: 'patients.nik'
                    },
                    {
                        data: 'phone',
                        name: 'patients.phone'
                    },
                    {
                        data: 'address',
                        name: 'patients.address'
                    },
                    {
                        data: 'poli_name',
                        name: 'patient_queues.poli_name'
                    },
                    {
                        data: 'queue_at',
                        name: 'patient_queues.queue_at',
                        render: function (data, type, row) {
                            var date = new Date(data);
                            var formattedDate = date.getDate() + '-' + (date.getMonth() + 1) +
                                '-' + date.getFullYear();
                            return formattedDate;
                        }
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

            $('#startDate, #endDate').on('change', function(){
                var startDate = new Date($('#startDate').val());
                var endDate = new Date($('#endDate').val());

                if(startDate && endDate) {
                    poliScheduleDataTable.draw();
                }
            });

            // action delete
            $('body').on('click', '.delete', function() {
                if (confirm("Hapus jadwal?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('antrian.deleteData') }}",
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
