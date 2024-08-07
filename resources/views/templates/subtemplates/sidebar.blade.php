<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <img src="{{ asset('SPERO.png') }}" width="130px" alt="">
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <img src="{{ asset('SPERO2.png') }}" width="30px" alt="">
    </div>
    <ul class="sidebar-menu">
      @if(auth()->user()->hasPermission('dashboard'))
        <li class="{{ Route::is('dashboard.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-quote-right"></i><span>Dashboard</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('role-index'))
        <li class="{{ Route::is('role.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('role.index') }}"><i class="fas fa-star"></i><span>Role</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('permission-index'))
        <li class="{{ Route::is('permission.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('permission.index') }}"><i class="fas fa-lock"></i><span>Permission</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('karyawan-index'))
        <li class="{{ Route::is('karyawan.*', 'gaji.*', 'thr.*') || (Route::is('kasbon.*') && Request::get('id')) || (Route::is('reimburse.*') && Request::get('id')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('karyawan.index') }}"><i class="fas fa-user"></i><span>Karyawan</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('project-index'))
        <li class="{{ Route::is('project.*', 'price-submit.*', 'price-developer.*', 'paid-project.*', 'paid-developer.*') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('project.index') }}"><i class="fas fa-folder"></i><span>Project</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('kasbon-index'))
        <li class="{{ Route::is('kasbon.*') && !Request::get('id') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('kasbon.index') }}"><i class="fas fa-coins"></i><span>Kasbons</span></a>
        </li>
      @endif
      @if(auth()->user()->hasPermission('reimburse-index'))
        <li class="{{ Route::is('reimburse.*') && !Request::get('id') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('reimburse.index') }}"><i class="fas fa-coins"></i><span>Reimburses</span></a>
        </li>
      @endif
      <li class="{{ Route::is('jobdesk.*') && !Request::get('id') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jobdesk.karyawan') }}"><i class="fas fa-sync"></i><span>Jobdesk</span></a>
      </li>
    </ul>
  </aside>
</div>