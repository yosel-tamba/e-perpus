<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-PERPUS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($title === 'Dashboard') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Buku -->
    <li class="nav-item <?= ($title === 'Buku') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/buku') ?>">
            <i class="fas fa-fw fa-book"></i>
            <span>Buku</span>
        </a>
    </li>

    <!-- Nav Item - Kategori -->
    <li class="nav-item <?= ($title === 'Kategori') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/kategori') ?>">
            <i class="fas fa-fw fa-tags"></i>
            <span>Kategori</span>
        </a>
    </li>

    <!-- Nav Item - Peminjaman -->
    <li class="nav-item <?= ($title === 'Peminjaman') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/peminjaman') ?>">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Peminjaman</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item <?= ($title === 'Users') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/users') ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Tentang Perpustakaan</div>

    <!-- Nav Item - News -->
    <li class="nav-item <?= ($title === 'News') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/news') ?>">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>News</span>
        </a>
    </li>

    <!-- Nav Item - Gallery -->
    <li class="nav-item <?= ($title === 'Gallery') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/gallery') ?>">
            <i class="fas fa-fw fa-images"></i>
            <span>Gallery</span>
        </a>
    </li>

    <!-- Nav Item - Informasi -->
    <li class="nav-item <?= ($title === 'Informasi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/informasi') ?>">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Informasi</span>
        </a>
    </li>

    <!-- Nav Item - Profil -->
    <li class="nav-item <?= ($title === 'Profil') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('/admin/profil') ?>">
            <i class="fas fa-fw fa-university"></i>
            <span>Profil</span>
        </a>
    </li>

    <hr class="sidebar-divider">

</ul>