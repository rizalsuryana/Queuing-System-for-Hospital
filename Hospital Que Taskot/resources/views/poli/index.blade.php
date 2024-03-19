@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Data Poli</li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row mt-4 mb-3">
        <div class="col-12">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">Tambah Poli</a>
        </div>
        <div class="modal fade" id="verticalycentered" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('poli.store') }}" id="modalAddForm" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Poli</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="row row-cols-auto">
                                <div class="col">
                                    <label for="poliName" class="form-label">Nama Poli</label>
                                    <input type="text" name="poliName" id="poliName" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center justify-content-center">
                    <h2>{{$poli->name}}</h2>
                    <a href="{{route('poli.showDetail', ['id'=>$poli->id])}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@push('childScripts')
    <script>
        $('#modalAddForm').submit(function (e) {
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
                    alert('Poli Berhasil ditambahkan');
                    location.reload();
                },
                error: function (response) {
                    $('#modalAddForm').find(".print-error-msg").find("ul").html('');
                    $('#modalAddForm').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function (key, value) {
                        $('#modalAddForm').find(".print-error-msg").find("ul").append(
                            '<li>' + value + '</li>');
                    });
                }
            });

        });
    </script>
@endpush
