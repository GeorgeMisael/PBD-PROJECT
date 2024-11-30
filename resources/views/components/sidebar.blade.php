<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Route::is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    {{-- <li class="nav-heading">Data Master</li> --}}

    <li class="nav-item">
      <a 
        class="nav-link {{ Route::is('role', 'user', 'vendor', 'satuan') ? '' : 'collapsed' }}" 
        href="#"
        data-bs-target="#role" 
        data-bs-toggle="collapse"
      >
      <i class="bi bi-person"></i>
        <span>Data Master</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul 
        id="role" 
        class="nav-content {{ Route::is('role', 'user', 'vendor', 'satuan') ? '' : 'collapse' }}" 
        data-bs-parent="#sidebar-nav"
      >
        <li>
          <a 
            href="{{ route('role') }}" 
            class="{{ Route::is('role') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Role</span>
          </a>
        </li>
        <li>
          <a 
            href="{{ route('user') }}" 
            class="{{ Route::is('user') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Pengguna</span>
          </a>
        </li>
        <li>
          <a 
            href="{{ route('vendor') }}" 
            class="{{ Route::is('vendor') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Vendor</span>
          </a>
        </li>
        <li>
          <a 
            href="{{ route('satuan') }}" 
            class="{{ Route::is('satuan') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Satuan</span>
          </a>
        </li>
      </ul>
    </li>
    
    {{-- <li class="nav-item ">
      <a class="nav-link {{ Route::is('role') ? '' : 'collapsed' }}" href="{{ route('role') }}">
        <i class="bi bi-envelope"></i>
        <span>Role</span>
      </a>
    </li>

    <li class="nav-item ">
      <a class="nav-link {{ Route::is('user') ? '' : 'collapsed' }}" href="{{ route('user') }}">
        <i class="bi bi-person"></i>
        <span>Pengguna</span>
      </a>
    </li>

    <li class="nav-item ">
      <a class="nav-link {{ Route::is('vendor') ? '' : 'collapsed' }}" href="{{ route('vendor') }}">
        <i class="bi bi-file-earmark"></i>
        <span>Vendor </span>
      </a>
    </li>

    <li class="nav-item ">
      <a class="nav-link {{ Route::is('satuan') ? '' : 'collapsed' }}" href="{{ route('satuan') }}">
        <i class="bi bi-person"></i>
        <span>Satuan</span>
      </a>
    </li> --}}

    <li class="nav-item">
      <a 
        class="nav-link {{ Route::is('barang', 'kartustok') ? '' : 'collapsed' }}" 
        href="#"
        data-bs-target="#barang" 
        data-bs-toggle="collapse"
      >
        <i class="bi bi-journal-text"></i>
        <span>Barang</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul 
        id="barang" 
        class="nav-content {{ Route::is('barang', 'kartustok') ? '' : 'collapse' }}" 
        data-bs-parent="#sidebar-nav"
      >
        <li>
          <a 
            href="{{ route('barang') }}" 
            class="{{ Route::is('barang') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Barang</span>
          </a>
        </li>
        <li>
          <a 
            href="{{ route('kartustok') }}" 
            class="{{ Route::is('kartustok') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Kartu Stok</span>
          </a>
        </li>
      </ul>
    </li>
    
    <li class="nav-item">
      <a 
        class="nav-link {{ Route::is('pengadaan', 'penerimaan') ? '' : 'collapsed' }}" 
        href="#"
        data-bs-target="#pengadaan" 
        data-bs-toggle="collapse"
      >
        <i class="bi bi-journal-text"></i>
        <span>Pengadaan</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul 
        id="pengadaan" 
        class="nav-content {{ Route::is('pengadaan', 'penerimaan') ? '' : 'collapse' }}" 
        data-bs-parent="#sidebar-nav"
      >
        <li>
          <a 
            href="{{ route('pengadaan') }}" 
            class="{{ Route::is('pengadaan') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Pengadaan</span>
          </a>
        </li>
        <li>
          <a 
            href="{{ route('penerimaan') }}" 
            class="{{ Route::is('penerimaan') ? 'active' : '' }}"
          >
            <i class="bi bi-circle"></i>
            <span>Penerimaan</span>
          </a>
        </li>
      </ul>
    </li>
    


    <li class="nav-item ">
      <a class="nav-link collapsed" href="pages-error-404.html">
        <i class="bi bi-dash-circle"></i>
        <span>Penjualan</span>
      </a>
    </li>

    <li class="nav-item ">
      <a class="nav-link collapsed" href="pages-blank.html">
        <i class="bi bi-file-earmark"></i>
        <span>Retur </span>
      </a>
    </li>

  </ul>

</aside>


    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="components-alerts.html">
            <i class="bi bi-circle"></i><span>Alerts</span>
          </a>
        </li>
        <li>
          <a href="components-accordion.html">
            <i class="bi bi-circle"></i><span>Accordion</span>
          </a>
        </li>
        <li>
          <a href="components-badges.html">
            <i class="bi bi-circle"></i><span>Badges</span>
          </a>
        </li>
        <li>
          <a href="components-breadcrumbs.html">
            <i class="bi bi-circle"></i><span>Breadcrumbs</span>
          </a>
        </li>
        <li>
          <a href="components-buttons.html">
            <i class="bi bi-circle"></i><span>Buttons</span>
          </a>
        </li>
        <li>
          <a href="components-cards.html">
            <i class="bi bi-circle"></i><span>Cards</span>
          </a>
        </li>
        <li>
          <a href="components-carousel.html">
            <i class="bi bi-circle"></i><span>Carousel</span>
          </a>
        </li>
        <li>
          <a href="components-list-group.html">
            <i class="bi bi-circle"></i><span>List group</span>
          </a>
        </li>
        <li>
          <a href="components-modal.html">
            <i class="bi bi-circle"></i><span>Modal</span>
          </a>
        </li>
        <li>
          <a href="components-tabs.html">
            <i class="bi bi-circle"></i><span>Tabs</span>
          </a>
        </li>
        <li>
          <a href="components-pagination.html">
            <i class="bi bi-circle"></i><span>Pagination</span>
          </a>
        </li>
        <li>
          <a href="components-progress.html">
            <i class="bi bi-circle"></i><span>Progress</span>
          </a>
        </li>
        <li>
          <a href="components-spinners.html">
            <i class="bi bi-circle"></i><span>Spinners</span>
          </a>
        </li>
        <li>
          <a href="components-tooltips.html">
            <i class="bi bi-circle"></i><span>Tooltips</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <!-- End Components Nav -->

    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="forms-elements.html">
            <i class="bi bi-circle"></i><span>Form Elements</span>
          </a>
        </li>
        <li>
          <a href="forms-layouts.html">
            <i class="bi bi-circle"></i><span>Form Layouts</span>
          </a>
        </li>
        <li>
          <a href="forms-editors.html">
            <i class="bi bi-circle"></i><span>Form Editors</span>
          </a>
        </li>
        <li>
          <a href="forms-validation.html">
            <i class="bi bi-circle"></i><span>Form Validation</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <!-- End Forms Nav -->

    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="tables-general.html">
            <i class="bi bi-circle"></i><span>General Tables</span>
          </a>
        </li>
        <li>
          <a href="tables-data.html">
            <i class="bi bi-circle"></i><span>Data Tables</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <!-- End Tables Nav -->

    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="charts-chartjs.html">
            <i class="bi bi-circle"></i><span>Chart.js</span>
          </a>
        </li>
        <li>
          <a href="charts-apexcharts.html">
            <i class="bi bi-circle"></i><span>ApexCharts</span>
          </a>
        </li>
        <li>
          <a href="charts-echarts.html">
            <i class="bi bi-circle"></i><span>ECharts</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <!-- End Charts Nav -->

    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="icons-bootstrap.html">
            <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
          </a>
        </li>
        <li>
          <a href="icons-remix.html">
            <i class="bi bi-circle"></i><span>Remix Icons</span>
          </a>
        </li>
        <li>
          <a href="icons-boxicons.html">
            <i class="bi bi-circle"></i><span>Boxicons</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <!-- End Icons Nav -->