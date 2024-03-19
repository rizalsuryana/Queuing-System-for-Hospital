@extends('adminRegisterDashboard.app')

@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{ route('patient') }}">Pasien</a></li> --}}
                <li class="breadcrumb-item active">Tambah Pasien</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $formName }}</h5>
                        <form id="patientForm" method="{{ $formMethod }}" action="{{ $formUrl }}">
                            @csrf
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>

                            @if(isset($patient))
                                <input type="hidden" name="patientId" value="{{ $patient->id }}">
                            @endif
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control nik" id="nik" name="nik"
                                        value="{{ old('nik', $patient->nik ?? '') }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="inputEmail5" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="inputEmail5" name="fullName"
                                        placeholder="Nama Lengkap"
                                        value="{{ old('fullName', $patient->name ?? '') }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="inputDate" class="form-label">Tanggal Lahir</label>
                                        <div class="">
                                            <input type="date" class="form-control" name="birthDate"
                                            value="{{ old('birthDate', $patient->birth_date ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div class="">
                                            <select class="form-select" name="gender">
                                                <option selected>Pilih</option>
                                                <option value="1"
                                                    {{ (isset($patient) && $patient->gender == '1') ? 'selected':'' }}>
                                                    Laki-laki</option>
                                                <option value="2"
                                                    {{ (isset($patient) && $patient->gender == '2') ? 'selected':'' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="">
                                        <label for="phoneNumber" class="form-label">No HP</label>
                                        <input type="text" class="form-control " id="phoneNumber" name="phoneNumber"
                                        value="{{ old('phoneNumber', $patient->phone ?? '') }}">
                                    </div>
                                    <div class="mt-3">
                                        <label for="inputText" class="form-label">Alamat</label>
                                        <div class="">
                                            <textarea name="address" class="form-control" cols="30"
                                                rows="4">{{ old('address', $patient->address ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="">
                                            <label for="bpjsNumber" class="form-label">No BPJS</label>
                                            <input type="text" class="form-control " id="bpjsNumber" name="bpjsNumber"
                                            value="{{ old('bpjsNumber', $patient->bpjs_number ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

                
            </div>
        </div>
    </section>
@endsection
@push('childScripts')
    <script>
        $(document).ready(function () {
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

            $('#inputEmail5').on('input', function(event) {
                var nameValue = $(this).val();
                
                if (nameValue.length > 30) {
                    $(this).val(nameValue.substring(0, 30));
                }
            });

            $('#bpjsNumber').on('keydown', function(event) {
                var key = event.key;
                var bpjsValue = $(this).val();
                var bpjsLength = bpjsValue.length;
                var isDigit = /^\d$/.test(key);
                if ((bpjsLength >= 13 || !isDigit) && (key !== 'Backspace' && key !== 'Delete' && key !==
                        'ArrowLeft' && key !== 'ArrowRight')) {
                    event.preventDefault();
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#patientForm').submit(function (e) {
                e.preventDefault();
                var ell = $('#patientForm');
                var url = ell.attr("action");

                var formData = new FormData(document.getElementById("patientForm"));

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        window.location.href = "{{ route('daftarAntrian') }}";
                    },
                    error: function (response) {
                        $('#patientForm').find(".print-error-msg").find("ul").html('');
                        $('#patientForm').find(".print-error-msg").css('display',
                            'block');
                        $.each(response.responseJSON.errors, function (key, value) {
                            $('#patientForm').find(".print-error-msg").find("ul")
                                .append(
                                    '<li>' + value + '</li>');
                        });
                    }
                });

            });

        });

    </script>
@endpush
