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
                 <li class="sidebar-title">Menu</li>

                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanDashboard*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanDashboard') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Dashboard</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanKategori*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanKategori') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Kategori</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanProduk*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanProduk') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Produk</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanBanner*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanBanner') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Banner</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('admin.HalamanSlider*') ? 'active' : '' }}">
                     <a href="{{ route('admin.HalamanSlider') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Slider</span>
                     </a>
                 </li>
                 <li class="sidebar-item {{ request()->routeIs('UserLogout*') ? 'active' : '' }}">
                     <a href="{{ route('UserLogout') }}" class='sidebar-link'>
                         <i class="bi bi-grid-fill"></i>
                         <span>Keluar</span>
                     </a>
                 </li>
             </ul>
         </div>

         <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
     </div>
 </div>
