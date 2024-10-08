<div class="sidebar">
    <div class="logo">
        <img src="<?= base_url('/images/Logo.jpeg') ?>" alt="ELECOMP Indonesia">
        <i class="fa-solid fa-bars"></i>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <span class="nav-header">MAIN</span>
            <a href="/dashboardadmin" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <span class="nav-header">APPS</span>
            <a href="/VerifyUser" class="nav-link">
                <i class="fa-solid fa-check"></i> Verifikasi Absensi
            </a>
            <a href="/lokasiSemua" class="nav-link">
                <i class="fa-solid fa-location-dot"></i> Lokasi Pengguna
            </a>
            <a href="/summary-presensi" class="nav-link">
                <i class="fa-solid fa-chart-area"></i> Statistik Absensi
            </a>
            <a href="/RekapitulasiAbsen" class="nav-link">
                <i class="fa-solid fa-file-alt"></i> Rekapitulasi Absensi
            </a>
            <a href="/HitungNilai" class="nav-link">
                <i class="fa-solid fa-file-invoice"></i> Rekapitulasi Penilaian
            </a>
            <a href="/user-list" class="nav-link">
                <i class="fa-solid fa-user-group"></i> Daftar Pengguna
            </a>
        </li>
    </ul>
    <div class="logout">
        <a href="<?= base_url('/logout') ?>" class="nav-link">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
</div>