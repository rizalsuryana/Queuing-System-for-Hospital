  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('jalanntrian')) collapsed @endif" href="{{ route('patientQueue') }}">
          <i class="bi bi-grid"></i>
          <span>{{ __('Jalankan Antrian') }}</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(!request()->routeIs('poli.showDetail')) collapsed @endif" href="{{ route('poli.showDetail' , ['id' => $user->fk_poli_id]) }}">
          <i class="bi bi-hospital"></i>
          <span>{{ __('Edit Poli') }}</span>
        </a>
      </li>
      </li> 
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('logout')}}">
          <i class="bi bi-box-arrow-left"></i>
          <span>{{ __('Log Out') }}</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->