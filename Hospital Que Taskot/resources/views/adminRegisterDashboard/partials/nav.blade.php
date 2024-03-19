  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('daftarOffline')) collapsed @endif" href="{{ route('daftarOffline') }}">
          <i class="bi bi-person-lines-fill"></i>
          <span>{{ __('Pendaftaran Nomor Antrian') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('daftarOffline')) collapsed @endif" href="{{ route('cekDaftar') }}">
          <i class="bi bi-person-check"></i>
          <span>{{ __('Cek Pasien Terdaftar') }}</span>
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('daftarAntrian')}}">
          <i class="bi bi-people"></i>
          <span>{{ __('Daftar Pasien Antrian') }}</span>
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