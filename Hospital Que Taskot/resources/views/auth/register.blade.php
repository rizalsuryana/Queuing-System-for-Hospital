@extends('layouts.unauthenticate')

@section('content')
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-1 pb-3">
                                    <h5 class="card-title text-center pb-0 fs-4">Daftar Akun Pasien</h5>
                                    <hr>
                                </div>
                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('register') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input placeholder="Masukan Nama lengkap" id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name"
                                            autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <input placeholder="Masukan alamat email aktif" id="yourEmail" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input placeholder="Masukan password" id="yourPassword" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPasswordConfirmation" class="form-label">Konfirmasi
                                            Password</label>
                                        <input placeholder="Masukan ulang password" id="yourPasswordConfirmation" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Daftar</button>
                                    </div>
                                    <div class="col-6">
                                        <p class="small mb-0 float-start">Sudah punya akun? <a href="{{ route('login') }}">Log in</a>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="small mb-0 float-end"><a href="/">Kembali</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</main>
@endsection
