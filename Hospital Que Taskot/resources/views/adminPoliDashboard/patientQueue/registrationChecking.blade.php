@extends('layouts.patientLayout')
{{-- Cek status pendaftaran --}}
@section('content')
<div class="container-fluid px-4 py-5 my-5 ">

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1">
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Antrian
                                    Online</a></li>
                            <li class="breadcrumb-item active">Cek Status Pendaftaran</li>
                        </ol>
                    </nav>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a style="font-size: 2.5rem;" href="{{ route('dashboard') }}"><i
                                class="bi bi-arrow-left-circle"></i></a>
                        <h5 class="card-title">Cek Status Pendaftaran</h5>

                        <div class="table-responsive">
                            <table class="table table-stripped" id="queueTable">
                                <thead>
                                    <tr>
                                        <th>No Antrian</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Poli</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>
@endsection

@push('childScripts')
    <script>
        $(document).ready(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.tesSajax').on('click', function (e) {
                alert('oke');
                e.preventDefault();
                var clickedRow = $(this).closest('tr').find('td');
                console.log(clickedRow);
                return;
                var poliName = $(this).data('poliName');
                var queueNumber = $(this).data('queueNumber');
                var patientName = $(this).data('patientName');
                var guarantor = $(this).data('guarantor');
                var queueAt = $(this).data('queueAt');
                

                var downloadUrl =
                    "{{ route('patientQueue.downloadRegisterNumber') }}" +
                    '?poliName=' + poliName + '&queueNumber=' + queueNumber +
                    '&patientName=' + patientName + '&queueAt=' + queueAt + '&guarantor=' + guarantor ;

                $.ajax({
                    url: downloadUrl,
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob' // Set the response type to 'blob' to handle binary data
                    },
                    success: function (data) {
                        // On success, create a temporary URL to trigger the file download
                        var url = window.URL.createObjectURL(new Blob([data]));
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'print.pdf';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error downloading the file: ' + error);
                    }
                });
            });

            var poliScheduleDataTable = $('#queueTable').DataTable({
                processing: true,
                serverSide: true,
                lengthChange: false,
                paging: false,
                info: false,
                ajax: "{{ route('patientQueue.getPatientQueue', ['nik'=>$nik]) }}",
                columns: [{
                        data: 'queue_number',
                        name: 'queue_number'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'poli_name',
                        name: 'poli_name'
                    },
                    {
                        data: 'queue_at',
                        name: 'queue_at',
                        render: function(data, type, row) {
                            var formattedDate = new Date(data).toLocaleDateString('id-ID');
                            return formattedDate;
                        }
                    },
                    {
                        data: "nik",
                        render: function (data, type, row, meta) {
                            return '<button class="tesSaja btn btn-warning" data-nik="' + data +
                                '" >Reprint</button>'
                        },
                        orderable: false
                    },
                    {
                        data: 'patient_bpjs_number',
                        name: 'patient_bpjs_number',
                        visible: false  // Hide the column
                    }
                ],
                order: [
                    [4, 'desc']
                ]
            });



            $('#queueTable').on('click', '.tesSaja', function () {
                var rowData = poliScheduleDataTable.row($(this).closest('tr')).data();
                var nik = rowData.nik;

                var poliName = rowData.poli_name;
                var queueNumber = rowData.queue_number;
                var patientName = rowData.name;
                var guarantor = rowData.guarantor;
                var queueAt = new Date(rowData.queue_at).toLocaleDateString('id-ID');

                var downloadUrl =
                    "{{ route('patientQueue.downloadRegisterNumber') }}" +
                    '?poliName=' + poliName + '&queueNumber=' + queueNumber +
                    '&patientName=' + patientName + '&queueAt=' + queueAt + '&guarantor=' + guarantor;

                $.ajax({
                    url: downloadUrl,
                    method: 'GET',
                    xhrFields: {
                        responseType: 'blob' // Set the response type to 'blob' to handle binary data
                    },
                    success: function (data) {
                        // On success, create a temporary URL to trigger the file download
                        var url = window.URL.createObjectURL(new Blob([data]));
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'print.pdf';
                        a.click();
                        window.URL.revokeObjectURL(url);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error downloading the file: ' + error);
                    }
                });
            });
        });

    </script>
@endpush
