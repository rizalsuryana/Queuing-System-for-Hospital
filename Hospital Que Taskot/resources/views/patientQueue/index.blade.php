@extends('layouts.app')
{{-- Data Antrian Header --}}
@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Data Antrian</li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1></h1>
                    <h5 class="card-title">&nbsp;</h5>
                    <div class="row g-3">
                        <div class="col-lg-3 col-4">
                            <label for="startDate" class="form-label">Mulai</label>
                            <input type="date" id="startDate" class="form-control" name="startDate" oninput="updateHiddenValue()">
                        </div>
                        <div class="col-lg-3 col-4">
                            <label for="endDate" class="form-label">Sampai</label>
                            <input type="date" id="endDate" class="form-control" name="endDate" oninput="updateHiddenValue()">
                        </div>
                        {{-- cetak laporan sesuai tanggal yang dipilih --}}
                        {{-- <div class="col-lg-5 col-4">
                            <form action="{{route('exportHariIni.pdf')}}" method="GET" style="margin-top: 30px;">
                                <input type="hidden" id="start" name="start" value="">
                                <input type="hidden" id="end" name="end" value="">
                                <button type="submit" class="btn btn-primary">Cetak Laporan</button>
                            </form>
                        </div> --}}
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="table datatable table-striped" id="queueTable">
                            <thead>
                                <tr>
                                    <th scope="col">Poli</th>
                                    <th scope="col">Tanggal Antrian</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- Table with stripped rows -->
                    
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
            var poliScheduleDataTable = $('#queueTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: {
                    "url": "{{ route('patientQueue.showData') }}",
                    "type": "GET",
                    "datatype": "json",
                    data: function (d) {
                        d.startDate = $('#startDate').val();
                        d.endDate = $('#endDate').val();
                        return d;
                    }
                },
                columns: [{
                        data: 'poli_name',
                        name: 'poli_name'
                    },
                    {
                        data: 'queue_at',
                        name: 'queue_at',
                        render: function (data, type, row) {
                            var date = new Date(data);
                            var formattedDate = date.getDate() + '-' + (date.getMonth() + 1) +
                                '-' + date.getFullYear();
                            return formattedDate;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#startDate, #endDate').on('change', function () {
                var startDate = new Date($('#startDate').val());
                var endDate = new Date($('#endDate').val());

                if (startDate && endDate) {
                    poliScheduleDataTable.draw();
                }

            });
        });
    </script>
    <script>
    function updateHiddenValue() {
      // Get the values from the date inputs
      var startDateValue = document.getElementById('startDate').value;
      var endDateValue = document.getElementById('endDate').value;

      // Set the concatenated value to the hidden input
      document.getElementById('start').value = startDateValue;
      document.getElementById('end').value = endDateValue;
    }
    </script>
@endpush
