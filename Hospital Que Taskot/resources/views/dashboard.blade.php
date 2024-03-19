<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->
    <link rel="stylesheet" id="picostra p-styles-css" href="https://cdn.livecanvas.com/media/css/library/bundle.css"
        media="all">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RSUD Tasikmalaya</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        /* Custom CSS */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .jumbotron {
    background-image: url('https://img.freepik.com/premium-vector/smiling-people-sitting-chairs-waiting-doctor-s-appointment-time-hospital-men-women-physician-s-office-clinic-colorful-vector-illustration-modern-flat-cartoon-style_198278-11315.jpg');
    background-size: contain;
    /* background-position: center;  */
    color: #000000;
    /* text-shadow: 2px 2px 4px rgba(252, 252, 253, 0.8); */
    padding: 100px 0;
    display: flex; /* Menggunakan display flex */
    justify-content: center; /* Pusatkan konten secara horizontal */
    align-items: center; /* Pusatkan konten secara vertikal */
}



/* Menambahkan lapisan semi-transparan di belakang teks */
.jumbotron .container {
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0.918), rgba(87, 172, 187, 0.5)); /* Atur warna lapisan di sini */
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    border-radius: 10px;
    padding: 20px;
    /* width: 96%;
    max-width: 100%;  */
}
        

        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight: bolder;
        }

        .jumbotron p {
            font-size: 1.5rem;
            font-weight: bolder;
        }

        .feature-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        a:hover{
            background: linear-gradient(to bottom, rgba(244, 230, 26, 0.57), rgba(87, 172, 187, 0.46)); /* Atur warna lapisan di sini */
           
        }
        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .feature-box h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .feature-box p {
            font-size: 1.25rem;
        }

        footer {
            margin-top: 100px;
        }

        @media screen and (max-width: 768px) {
    /* Menyesuaikan ukuran font untuk layar kecil */
    .feature-box {
        margin-top: 30px;
    }
     .jumbotron h1 {
                font-size: 2.5rem;
            }

            .jumbotron p {
                font-size: 1.2rem;
            }

            .feature-box {
                margin-top: 20px;
            }
}
    </style>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            {{-- <a href="/" class="logo d-flex align-items-center">
                <!-- <img src="{{ asset('img/logo.png') }}" alt=""> -->
                <span class="d-block">RSUD Tasikmalaya</span>
            </a> --}}
            <span class="logo d-flex align-items-center">
                <!-- <img src="{{ asset('img/logo.png') }}" alt=""> -->
                <span class="d-block">RSUD Tasikmalaya</span>
            </span>
        </div><!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    @if (Route::has('login'))
                        <div class="d-flex justify-content-around">
                            @auth
                                <a href="{{ url('/logout') }}"
                                    class="nav-link nav-profile ps-2 pe-0"><span>Logout</span></a>
                                {{-- <a href="{{ url('/home') }}" class="nav-link nav-profile ps-2 pe-0"> --}}
                                {{-- <span>User</span> --}}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link nav-profile ps-2 pe-0">
                                    <span>Login</span>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="nav-link nav-profile ps-2 pe-0">
                                        <span>Daftar</span>
                                    </a>
                                @endif
                            @endauth

                        </div>
                    @endif
                </li>
            </ul>
        </nav>

    </header><!-- End Header -->
    <!-- Hero Section -->
    @if (isset($patient))
    <div class="jumbotron text-center">
        <div class="container">
            <h1 class="display-3">Selamat Datang di Antrian Online RSUD</h1>
            <p class="lead">Layanan antrian online untuk kenyamanan Anda.</p>
        </div>
    </div>
    @else
    <div class="jumbotron text-center">
        <div class="container">
    <h1 class="display-3">Selamat Datang di Antrian Online RSUD</h1>
    <p class="lead">Layanan antrian online untuk kenyamanan Anda.</p>
        <a href="{{ route('register') }}" class="btn btn-warning btn-lg px-4">
            <span>Daftar</span>
        </a>
        <a href="{{ route('login') }}" class="btn btn-warning btn-lg px-4">
            <span>Login</span>
        </a>
    </div>
</div>
    @endif

    <!-- Menu Section -->
    <div class="container">
        @if (isset($patient))
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Daftar Antrian</h2>
                    <p>Sekarang kamu bisa mendaftar nomor antrian secara online.</p>
                    <a class="btn btn-warning btn-lg px-4" href="#" role="button" data-bs-toggle="modal"
                    data-bs-target="#formDaftar">Daftar Disini</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Cek Status Pendaftaran</h2>
                    <p>Mengecek Status pendaftaran / Mencetak Ulang tiket antrian</p>
                    <a class="btn btn-warning btn-lg px-4" href="#" role="button" data-bs-toggle="modal"
                    data-bs-target="#statusDaftar">Cek Disini</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Live Status Antrian</h2>
                    <p>Melihat nomor antrian yang sedang dilayani.</p>
                    <a class="btn btn-warning btn-lg px-4" href="{{ route('patientQueue.checkAllQueue') }}"
                    role="button">Lihat Disini</a>
                </div>
            </div>
        </div>
        @else
        <div class="row text-center">
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Daftar Antrian</h2>
                    <p>Sekarang kamu bisa mendaftar nomor antrian secara online.</p>
                    <a class="btn btn-warning btn-lg px-4" href="{{ route('login') }}">Daftar Antrian</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Cek Status Pendaftaran</h2>
                    <p>Mengecek Status pendaftaran / Mencetak Ulang tiket antrian</p>
                    <a class="btn btn-warning btn-lg px-4" href="{{ route('login') }}">Cek Status Pendaftaran</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box">
                    <h2>Live Status Antrian</h2>
                    <p>Melihat nomor antrian yang sedang dilayani.</p>
                    <a class="btn btn-warning btn-lg px-4" href="{{ route('patientQueue.checkAllQueue') }}"
                    role="button">Lihat Status Antrian</a>
                </div>
            </div>
        </div>
    @endif
    </div>
{{-- Form registrasi  --}}

{{-- Register Biodata Start --}}
    <div class="modal modal-xl fade" id="formDaftar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <form action="{{ route('patientQueue.store') }}" id="registerForm" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Registrasi Nomor Antrian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <div class="row">
            <input type="hidden" name="patientId" @isset($patient) value="{{ $patient->id }}" @endisset>
            <div class="col-lg-6">
                <div class="mb-3 row">
                    <label for="inputEmail5" class="col-sm-4 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan Nama lengkap" class="form-control" id="inputEmail5" name="fullName">
                    </div>                    
                </div>
                <div class="mb-3 row">
                    <label for="inputDate" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="birthDate">
                    </div>                    
                </div>
                <div class="mb-3 row">
                    <label for="nik1" class="col-sm-4 col-form-label">NIK</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan NIK" type="text" class="form-control nik" id="nik1" name="nik" pattern="[0-9]{16}" title="NIK harus berisi 16 digit angka" @isset($patient) 
                        @if($patient->nik != '-') value="{{ $patient->nik }}" 
                        @else placeholder="NIK Anda" 
                        @endif 
                    @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="phoneNumber" class="col-sm-4 col-form-label">Nomor Handphone</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan nomer handphone" type="text" class="form-control" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10,15}" title="Nomor telepon harus berisi 10-15 digit angka" @isset($patient) 
                        @if($patient->phone != '0') value="{{ $patient->phone }}" 
                        @else placeholder="Nomor Telepon Anda" 
                        @endif 
                    @endisset>
                    </div>
                </div>
                
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-8">
                        <select class="form-select" aria-label="Default select example" name="gender">
                            <option value="" @if (!isset($patient) || $patient->gender === null) selected @endif>Pilih</option>
                            <option value="1" @if (isset($patient) && $patient->gender === 1) selected @endif>Laki-laki</option>
                            <option value="2" @if (isset($patient) && $patient->gender === 2) selected @endif>Perempuan</option>
                        </select>
                    </div>
                </div>
                
                
                <div class="mb-3 row">
                    <label for="inputText" class="col-sm-4 col-form-label">Alamat</label>
                    <div class="col-sm-8">
                        <textarea placeholder="Silahkan masukan alamat anda saat ini" name="address" class="form-control" cols="30" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Penjamin</label>
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_umum" value="Umum" checked>
                                    <label class="form-check-label" for="penjamin_umum">Umum</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_bpjs" value="BPJS">
                                    <label class="form-check-label" for="penjamin_bpjs">BPJS</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="guarantor" id="penjamin_asuransi" value="Asuransi">
                                    <label class="form-check-label" for="penjamin_asuransi">Asuransi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="bpjsNumber" class="col-sm-4 col-form-label">Nomor BPJS</label>
                    <div class="col-sm-8">
                        <input placeholder="Masukan nomor BPJS, Untuk Pasien BPJS" type="text" class="form-control " id="bpjsNumber" name="bpjsNumber" @isset($patient) value="{{ $patient->bpjsNubmer }}" @endisset>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Poli</label>
                    <div class="col-sm-8">
                        <select class="form-select" name="poliId" id="poliId">
                            <option selected>Pilih</option>
                            @isset($polis)
                                @foreach ($polis as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="visitDate" class="col-sm-4 col-form-label">Tanggal Layanan</label>
                    <div class="col-sm-8">
                        <input placeholder="Pilih tanggal" type="date" id="visitDate" class="form-control" name="visitDate">
                    </div>
                </div>
                {{-- <div class="mb-3 row">
                    <label for="visitDate" class="col-sm-4 col-form-label">kuota :</label>
                    <div class="col-sm-8">
                        <h2 id="kuota"></h2>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Tutup</a>
        <button type="submit" class="btn btn-lg btn-warning">Daftar</button>
    </div>
</form>

            </div>
        </div>
    </div>
{{-- form pendaftaran end --}}


    <div class="modal fade" id="statusDaftar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
                        <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                        <button type="submit" class="btn btn-warning">Cek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="afterRegisterModal" tabindex="-1" data-bs-backdrop="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div id="printThis" class="modal-body">
                    <div class="text-center font-monospace lh-sm" style="display: block;">
                        <p>RSUD Kota Tasikmalaya</p>
                        <p>Jl Rumah Sakit No.55</p>
                        <p>Telp: (027)8923923</p>
                    </div>
                    <hr>
                    <div class="text-center font-monospace">
                        <p id="afterRegPoliName" class="text-uppercase" style="margin-top: 0.5rem;">Poli Gigi</p>
                        <h1>
                            <p class="fw-bold" id="afterRegQueueNumber">2</p>
                        </h1>
                        <p id="afterRegPatientName">Surya</p>
                        <p id="afterRegGuarantor">Umum</p>
                        <p>Tanggal Antrian</p>
                        <p id="afterRegQueueAt">15 Juli 2023</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                    <button id="btnPrintRegister" type="button" class="btn btn-warning">Cetak</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>RSUD Tasikmalaya</span></strong>. All Rights Reserved
        </div>
    </footer>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
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
                //today.setDate(today.getDate() + 1); //jika pendaftaran minimal hari besok
                today.setDate(today.getDate()); // mengganti hari pendaftaran diperbolehkan di hari ini
                var minDate = today.toISOString().split('T')[0]; // Mengubah tanggal menjadi format YYYY-MM-DD
                dateInput.attr('min', minDate);
            }

            // Panggil fungsi setminDate saat halaman dimuat
            setMinDate();

            // Panggil fungsi setminDate saat nilai input berubah (misalnya ketika halaman dimuat kembali setelah error form)
            dateInput.on('change', setMinDate);
            //tamppilkan quota
            
            $('#visitDate, #poliId').on('change',function(e){
                 
                var selectedDate = $('#visitDate').val();
                var selectedPoli = $('#poliId').val();
                if(selectedDate !== null && selectedPoli !== null ){
                    $.ajax({
                    url: '/getQuota/' + selectedDate +'/' +selectedPoli,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        // Update the display element with the fetched data
                        $("#kuota").text(data); // Replace 'text_column' with the actual column name
                    },
                    error: function (error) {
                        console.error('Error fetching data:', error);
                    }
                });

                }
                // Make AJAX request to fetch data

            });


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
        



    </script>
</body>

</html>
