  <!-- ======= Sidebar ======= -->
{{-- Super Admin --}}


  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('home')) collapsed @endif" href="{{ route('home') }}">
          <i class="bi bi-grid"></i>
          <span>{{ __('Beranda') }}</span>
        </a>
      </li>
            <!-- Tidak diapakai karena sudah di pindah ke admin regist -->
      <!-- <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('patient')) collapsed @endif" href="{{ route('patient') }}">
          <i class="bi bi-person"></i>
          <span>{{ __('Data Pasien') }}</span>
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('poli')) collapsed @endif" href="{{ route('poli') }}">
          <i class="bi bi-hospital"></i>
          <span>{{ __('Data Poli') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('patientQueue')) collapsed @endif" href="{{ route('patientQueue') }}">
          <i class="bi bi-hourglass"></i>
          <span>{{ __('Data Antrian') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('registrasiAdminPoli')) collapsed @endif" href="{{ route('adminPoli.Register.Page') }}">
          <i class="bi bi-person-plus"></i>
          <span>{{ __('Daftar Akun Admin Poli') }}</span>
        </a>
      </li>
      <li class="nav-item d-none">
        <a class="nav-link @if(!request()->routeIs('doctor')) collapsed @endif" href="{{ route('doctor') }}">
          <i class="bi bi-person-badge"></i>
          <span>{{ __('Data Dokter') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('logout')}}">
          <i class="bi bi-box-arrow-left"></i>
          <span>{{ __('Log Out') }}</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->