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
                                    <h5 class="card-title text-center pb-0 fs-4">Masuk Aplikasi Antrian</h5>
                                    <hr>
                                </div>

                                <form class="row g-3 needs-validation" method="POST"
                                    action="{{ route('login') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">{{ __('Email') }}</label>
                                        <div class="input-group has-validation">
                                            <input placeholder="Masukan email anda" type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="yourUsername"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">{{ __('Password') }}</label>
                                        <input placeholder="Masukan password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button class="btn btn-success w-100" type="submit">{{ __('Masuk') }}</button>
                                    </div>                                    
                                    <div class="col-6">
                                        <p class="small mb-0 float-start">Belum punya akun? &nbsp;<a href="{{ route('register') }}">Daftar</a></p>
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
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>
@endsection
