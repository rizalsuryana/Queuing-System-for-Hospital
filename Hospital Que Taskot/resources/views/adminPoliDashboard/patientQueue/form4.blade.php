@extends('layouts.app')
{{-- teu ka anggo --}}
@section('content')
    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('patient') }}">Antrian Online</a></li>
                <li class="breadcrumb-item active">Daftar Antrian</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row mt-4 mb-3">
            <div class="col-12">
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#smallModal">Daftar Antrian</a>
            </div>
            <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ route('poli.store') }}" id="modalAddForm" method="POST">
                            @csrf
                            <div class="modal-header text-center font-monospace lh-sm" style="display: block;">
                                <p>RSUD Kota Tasikmalaya</p>
                                <p>Jl Rumah Sakit No.55</p>
                                <p>Telp: (027)8923923</p>
                            </div>

                            <div class="modal-body">
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="text-center font-monospace">
                                    <p class="text-uppercase" style="margin-top: 0.5rem;">Poli Gigi</p>
                                    <h1><p class="fw-bold">2</p></h1>
                                    <p>32662313543534535</p>
                                    <p>Surya</p>
                                    <p>Tanggal Antrian</p>
                                    <p>15 Juli 2023</p>
                                    <p style="margin-bottom: 0.5rem;">Barcode</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                <button type="submit" class="btn btn-warning">Cetak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($polis as $poli)
                <div class="col">
                    <div class="card card-poli h-100 shadow">
                        <div
                            class="card-body profile-card pt-4 d-flex flex-column align-items-center justify-content-center">
                            <h2>{{ $poli->name }}</h2>
                            <a href="/poli" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('childScripts')
    <script>
        $('#modalAddForm').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr("action");
            let formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    alert('Form submitted successfully');
                    location.reload();
                },
                error: function(response) {
                    $('#modalAddForm').find(".print-error-msg").find("ul").html('');
                    $('#modalAddForm').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#modalAddForm').find(".print-error-msg").find("ul").append(
                            '<li>' + value + '</li>');
                    });
                }
            });

        });
    </script>
@endpush
