<div class="sidebar">

    <div class="logo">
        <img src="<?= base_url('/images/Logo.jpeg') ?>" alt="ELECOMP Indonesia">
        <i class="fa-solid fa-bars"></i>
    </div>



    <ul class="nav">
        <li class="nav-item">
            <span class="nav-header">MAIN</span>
            <a href="/home" class="nav-link">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <span class="nav-header">APPS</span>
            <a href="/Profile" class="nav-link">
                <i class="fa-regular fa-user"></i> Profil Pengguna
            </a>
            <a href="/riwayat" class="nav-link">
                <i class="fa-regular fa-clock"></i> Riwayat Absensi
            </a>
            <a href="/HitungNilaiUser" class="nav-link">
                <i class="fa-solid fa-file-invoice"></i> Rekapitulasi Absensi
            </a>
            <a href="/help-support" class="nav-link">
                <i class="fa-solid fa-circle-info"></i> Help & Support
            </a>
        </li>
    </ul>
    <div class="logout">
        <a href="<?= base_url('/logout') ?>" class="nav-link">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
</div>
<script>
    // Function to toggle nav and logout visibility on mobile
    function toggleMobileMenu() {
        const nav = document.querySelector('.nav');
        const logout = document.querySelector('.logout');

        // Toggle the 'show' class on nav and logout
        nav.classList.toggle('show');
        logout.classList.toggle('show');
    }

    // Run the script only on screens less than 768px wide
    if (window.innerWidth <= 768) {
        const hamburgerIcon = document.querySelector('.logo i');

        // Add click event listener to the hamburger icon
        hamburgerIcon.addEventListener('click', toggleMobileMenu);
    }
</script>