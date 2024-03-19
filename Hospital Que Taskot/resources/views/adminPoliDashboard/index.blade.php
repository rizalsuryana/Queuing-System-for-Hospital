@extends('layouts.app')
{{-- Add akun poli --}}
@section('content')
<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Data Akun</li>
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
        {{-- <div class="col-6">
            <a href="#" class="btn btn-warning">Cetak Data</a>
        </div> --}}
        {{-- <div class="col-6 d-none">
            <a href="#" class="btn btn-success float-end">Tambah Antrian</a>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1></h1>
                    <h5 class="card-title">&nbsp;</h5>
                    <!-- Table with stripped rows -->
                    <div class="row">
                        <div class="mt-3 col-md-6">
                            <a class="btn btn-primary px-4" href="#" role="button" data-bs-toggle="modal"
                    data-bs-target="#formDaftar">Daftar Akun Poli</a>
                        </div>
                        {{-- search --}}
                        <div class="col-md-6">
                            <div class="input-group mt-3 mb-3">
                                <input type="text" class="form-control" placeholder="Search" id="searchInput">
                                <button class="btn btn-primary" type="button" id="searchButton">Search</button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Register Biodata akun Poli --}}
                        <div class="modal modal-xl fade" id="formDaftar" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <form action="{{ route('adminPoli.Register') }}" id="registerForm" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Daftar Akun Poli</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="row">
                                @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <div class="col-lg-6">
                                    <div class="mb-3 row">
                                        <label for="inputEmail5" class="col-sm-4 col-form-label">Nama</label>
                                        <div class="col-sm-8">
                                            <input placeholder="Masukan Nama lengkap" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-4 col-form-label">Poli</label>
                                        <div class="col-sm-8">
                                            <select class="form-select" name="poliId" id="poliId" required>
                                                <option selected>Pilih</option>
                                                @isset($polis)
                                                    @foreach ($polis as $poli)
                                                        <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 row">
                                        <label for="inputEmail5" class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input placeholder="Masukan Email lengkap" class="form-control" type="email" id="Email" name="Email" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="inputEmail5" class="col-sm-4 col-form-label">Password</label>
                                        <div class="col-sm-8">
                                            <input placeholder="Masukan Password"type="password" class="form-control" id="Password" name="Password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-lg btn-secondary" data-bs-dismiss="modal">Tutup</a>
                            <button type="submit" class="btn btn-lg btn-primary">Daftar</button>
                        </div>
                    </form>

            </div>
        </div>
    </div>




        <table id="userTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" >Nama</th>
                    <th scope="col" >Email</th>
                    <th scope="col" >Poli</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td scope="row">{{ $user->name }}</td>
                        <td scope="row">{{ $user->email }}</td>
                        <td scope="row">Admin {{ $user->poliName }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Edit</button>
                            <div class="modal modal-xl fade" id="editModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('adminPoli.Update', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Akun Poli</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                    <div class="col-lg-6">
                                                        <div class="mb-3 row">
                                                            <label for="inputEmail5" class="col-sm-4 col-form-label">Nama</label>
                                                            <div class="col-sm-8">
                                                                <input placeholder="Masukan Nama lengkap" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label class="col-sm-4 col-form-label">Poli</label>
                                                            <div class="col-sm-8">
                                                                <select class="form-select" name="poliId" id="poliId" required>
                                                                    <option selected>Pilih</option>
                                                                    @isset($polis)
                                                                        @foreach ($polis as $poli)
                                                                            <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                                                        @endforeach
                                                                    @endisset
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3 row">
                                                            <label for="inputEmail5" class="col-sm-4 col-form-label">Email</label>
                                                            <div class="col-sm-8">
                                                                <input placeholder="Masukan Email lengkap" class="form-control" type="email" id="Email" name="Email" value="{{ $user->email }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <label for="inputEmail5" class="col-sm-4 col-form-label">Password</label>
                                                            <div class="col-sm-8">
                                                                <input placeholder="Masukan Password"type="password" class="form-control" id="Password" name="Password" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form action="{{ route('adminPoli.Delete', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

                    <!-- End Table with stripped rows -->   
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // Validasi pada sisi klien menggunakan JavaScript
    document.getElementById('poliId').addEventListener('change', function() {
        if (this.value === "") {
            this.setCustomValidity('Pilih salah satu opsi.');
        } else {
            this.setCustomValidity('');
        }
    });

    // search
$(document).ready(function(){
    $('#searchButton').on('click', function(){
        var searchText = $('#searchInput').val().toLowerCase();
        $('#userTable tbody tr').filter(function(){
            // Cari teks pada kolom nama dan email
            var name = $(this).find('td:eq(0)').text().toLowerCase();
            var email = $(this).find('td:eq(1)').text().toLowerCase();
            // Cari teks pada kolom poli
            var poli = $(this).find('td:eq(2)').text().toLowerCase();
            // Filter baris yang memiliki teks pencarian pada salah satu kolom
            $(this).toggle(name.indexOf(searchText) > -1 || email.indexOf(searchText) > -1 || poli.indexOf(searchText) > -1);
        });
    });
});

</script>
@endsection

