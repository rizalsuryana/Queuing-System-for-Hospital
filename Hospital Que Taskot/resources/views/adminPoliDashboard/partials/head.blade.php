
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>RSUD Tasikmalaya</title>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"
integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
<link href="{{asset('vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
<link href="{{asset('vendor/quill/quill.snow.css')}}" rel="stylesheet">
<link href="{{asset('vendor/quill/quill.bubble.css')}}" rel="stylesheet">
<link href="{{asset('vendor/remixicon/remixicon.css')}}" rel="stylesheet">
<!-- <link href="{{asset('vendor/simple-datatables/style.css')}}" rel="stylesheet"> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
{{-- <script>
    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
    $(document).ready(function() {
        var dateInput = $('#visitDate');

        // Fungsi untuk membatasi tanggal maksimal h-1
        function setMinDate() {
            var today = new Date();
            today.setDate(today.getDate() + 1); // Mengurangi satu hari dari tanggal sekarang
            var minDate = today.toISOString().split('T')[0]; // Mengubah tanggal menjadi format YYYY-MM-DD
            dateInput.attr('min', minDate);
        }

        // Panggil fungsi setminDate saat halaman dimuat
        setMinDate();

        // Panggil fungsi setminDate saat nilai input berubah (misalnya ketika halaman dimuat kembali setelah error form)
        dateInput.on('change', setMinDate);



        $('#phoneNumber').on('keydown', function(event) {
            var key = event.key;
            var phoneValue = $(this).val();
            var phoneLength = phoneValue.length;
            var isDigit = /^\d$/.test(key);
            if ((phoneLength >= 14 || !isDigit) && (key !== 'Backspace' && key !== 'Delete' && key !==
                    'ArrowLeft' && key !== 'ArrowRight')) {
                event.preventDefault();
            }
        });

        // Cegah karakter selain digit untuk NIK
        $('.nik').on('keydown', function(event) {
            var nikValue = $(this).val();
            var nikLength = nikValue.length;
            var key = event.key;
            var isDigit = /^\d$/.test(key);
            if ((nikLength >= 16 || !isDigit) && (key !== 'Backspace' && key !== 'Delete' && key !==
                    'ArrowLeft' && key !== 'ArrowRight')) {
                event.preventDefault();
            }
        });

        $('#bpjsNumber').on('keydown', function(event) {
            var key = event.key;
            var nikValue = $(this).val();
            var nikLength = nikValue.length;
            var isDigit = /^\d$/.test(key);
            if ((nikLength >= 13 || !isDigit) && (key !== 'Backspace' && key !== 'Delete' && key !==
                    'ArrowLeft' && key !== 'ArrowRight')) {
                event.preventDefault();
            }
        });

        $('#poliId').change(function() {
            var selectedPoliId = $(this).val();
            if (!selectedPoliId || selectedPoliId == 'Pilih') {
                let notes = '<ol class="list-group list-group-numbered"></ol>';
                $('#poliNote').html(notes);
                return;
            }
            $.ajax({
                url: "poli/getPoliNote/" + selectedPoliId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    let bodyNote = '';
                    if (response && response.note) {
                        let notes = response.note.split(';');
                        if (Array.isArray(notes)) {
                            bodyNote += '<ol class="list-group list-group-numbered">';
                            for (let index = 0; index < notes.length; index++) {
                                const element = notes[index];
                                bodyNote += '<li class="list-group-item">' + element +
                                    '</li class="list-group-item">';
                            }
                            bodyNote += '</ol>';
                        } else {
                            bodyNote = response.note;
                        }
                    }
                    $('#poliNote').html(bodyNote);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        $('#btnPrintRegister').on('click', function() {

            var afterRegPoliName = $('#afterRegPoliName').text();
            var afterRegQueueNumber = $('#afterRegQueueNumber').text();
            var afterRegPatientName = $('#afterRegPatientName').text();
            var afterRegQueueAt = $('#afterRegQueueAt').text();
            var afterRegGuarantor = $('#afterRegGuarantor').text();

            var downloadUrl = "{{ route('patientQueue.downloadRegisterNumber') }}" + '?poliName=' +
                afterRegPoliName + '&queueNumber=' + afterRegQueueNumber + '&patientName=' +
                afterRegPatientName + '&queueAt=' + afterRegQueueAt +'&guarantor=' + afterRegGuarantor;

            $.ajax({
                url: downloadUrl,
                method: 'GET',
                xhrFields: {
                    responseType: 'blob' // Set the response type to 'blob' to handle binary data
                },
                success: function(data) {
                    // On success, create a temporary URL to trigger the file download
                    var url = window.URL.createObjectURL(new Blob([data]));
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'print.pdf';
                    a.click();
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    console.error('Error downloading the file: ' + error);
                }
            });
        });

        $('#registerForm').submit(function(e) {
            e.preventDefault();
            var ell = $('#registerForm');
            var url = ell.attr("action");

            var formData = new FormData(document.getElementById("registerForm"));

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log(response);
                    // location.reload();
                    $("#formDaftar .btn-close").click();
                    $('#registerForm').trigger('reset');
                    if (response && response.queueData) {
                        $('#afterRegPoliName').text(response.queueData.poliName);
                        $('#afterRegQueueNumber').text(response.queueData.queueNumber);
                        $('#afterRegPatientName').text(response.queueData.patientName);
                        $('#afterRegQueueAt').text(response.queueData.queueAt);
                        $('#afterRegGuarantor').text(response.queueData.guarantor);
                    }
                    $('#afterRegisterModal').modal('show');
                },
                error: function(response) {
                    $('#registerForm').find(".print-error-msg").find("ul").html('');
                    $('#registerForm').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#registerForm').find(".print-error-msg").find("ul")
                            .append(
                                '<li>' + value + '</li>');
                    });
                }
            });

        });
    });


    // Quota




</script> --}}
<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])