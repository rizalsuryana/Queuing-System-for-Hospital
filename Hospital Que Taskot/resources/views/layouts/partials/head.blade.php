
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>RSUD Tasikmalaya</title>

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
<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])