 <div id="sidebar" class="active">
     <div class="sidebar-wrapper active">
         <div class="sidebar-header">
             <div class="d-flex justify-content-between">
                 <div class="logo">
                     <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                 </div>
                 <div class="toggler">
                     <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                 </div>
             </div>
         </div>
         <div class="sidebar-menu">
             <ul class="menu">
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanDashboard*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanDashboard') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Dashboard</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanKategori*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanKategori') }}" class='sidebar-link'>
                         <i class="bi bi-box-arrow-in-down"></i>
                         <span>Kategori</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanProduk*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanProduk') }}" class='sidebar-link'>
                         <i class="bi bi-collection-fill"></i>
                         <span>Produk</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanBanner*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanBanner') }}" class='sidebar-link'>
                         <i class="bi bi-grid-1x2-fill"></i>
                         <span>Banner</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanSlider*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanSlider') }}" class='sidebar-link'>
                         <i class="bi bi-hexagon-fill"></i>
                         <span>Slider</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanPesanan*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanPesanan') }}" class='sidebar-link'>
                         <i class="bi bi-basket-fill"></i>
                         <span>Pesanan</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanLaporan*') ? 'active' : '' }} has-sub">
                     <a href="#" class='sidebar-link'>
                         <i class="bi bi-stack"></i>
                         <span>Laporan</span>
                     </a>
                     <ul class="submenu {{ request()->routeIs('admin.HalamanLaporan*') ? 'active' : '' }}">
                         <li
                             class="submenu-item {{ request()->routeIs('admin.HalamanLaporan.Pendapatan') ? 'active' : '' }}">
                             <a href="{{ route('admin.HalamanLaporan.Pendapatan') }}">Pendapatan</a>
                         </li>
                         <li
                             class="submenu-item {{ request()->routeIs('admin.HalamanLaporan.Produk') ? 'active' : '' }}">
                             <a href="{{ route('admin.HalamanLaporan.Produk') }}">Produk</a>
                         </li>
                         <li
                             class="submenu-item {{ request()->routeIs('admin.HalamanLaporan.Inventory') ? 'active' : '' }}">
                             <a href="{{ route('admin.HalamanLaporan.Inventory') }}">Inventory</a>
                         </li>
                         <li
                             class="submenu-item {{ request()->routeIs('admin.HalamanLaporan.Pembayaran') ? 'active' : '' }}">
                             <a href="{{ route('admin.HalamanLaporan.Pembayaran') }}">Pembayaran</a>
                         </li>
                     </ul>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('UserLogout*') ? 'active' : '' }}">
                     <a href="{{ route('UserLogout') }}" class='sidebar-link'>
                         <i class="bi bi-arrow-left-short"></i>
                         <span>Keluar</span>
                     </a>
                 </li>
             </ul>
         </div>

         <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
     </div>
 </div>
