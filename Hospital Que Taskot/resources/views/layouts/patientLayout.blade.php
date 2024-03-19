<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.partials.head')
</head>
<body>    
     <!-- ======= Header ======= -->
     <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center">
                <!-- <img src="{{ asset('img/logo.png') }}" alt=""> -->
                <span class="d-block">RSUD Tasikmalaya</span>
            </a>
        </div><!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    @if (Route::has('login'))
                    <div class="d-flex justify-content-around">
                        @auth
                        <a href="{{ url('/logout') }}" class="nav-link nav-profile ps-2 pe-0"><span>Logout</span></a>
                        <a href="{{ url('/home') }}" class="nav-link nav-profile ps-2 pe-0 d-none">
                            <span>User</span>
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
    <main style="min-height: 70vh;">
        @yield('content')
    </main>
    
    <footer class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>RSUD Tasikmalaya</span></strong>. All Rights Reserved
        </div>
    </footer>
    
    @stack('childScripts')
</body>
</html>
