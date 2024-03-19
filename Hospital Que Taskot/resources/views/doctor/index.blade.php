@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Data Dokter</li>
        </ol>
    </nav>
</div>
<section class="section">
    @if(session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="row mt-4 mb-3">
        <div class="col-6">
            <a href="#" class="btn btn-warning">Cetak Data</a>
        </div>
        <div class="col-6">
            <a href="{{route('doctor.showAdd')}}" class="btn btn-success float-end">Tambah Dokter</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">&nbsp;</h5>
              <!-- Table with stripped rows -->
              <div class="table-responsive">
              <table class="table table-stripped" id="doctorTable">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Spesialis/Poli</th>
                    <th>Jam Kerja</th>
                    <th>Alamat</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
              </div>
              <!-- End Table with stripped rows -->

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
            var poliScheduleDataTable = $('#doctorTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: "{{ route('doctor.showData') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nik',
                        name: 'poli'
                    },
                    {
                        data: 'nik',
                        name: 'work_hour'
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
            $('body').on('click', '.delete', function () {
                if (confirm("Hapus dokter?") == true) {
                    var id = $(this).data('id');
                    // ajax
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('doctor.delete') }}",
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (res) {
                            var oTable = $('#doctorTable').dataTable();
                            oTable.fnDraw(false);
                        }
                    });
                }
            });
        });

    </script>
@endpush
