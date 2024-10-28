<header class="header">
    <div class="user-profile" style="width:100%">
        <div class="head-header" style="display:flex; justify-content:end; width:100%; align-items:center;">
            <div id="icon-header">
                <i class="fa-solid fa-bars"></i>
            </div>
            <img src="/images/man.png" alt="User Profile" id="profile-img">
        </div>
        <ul class="menu-header" hidden>
            <li><a href="/home"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="/Profile"><i class="fas fa-user"></i>Profil Pengguna</a></li>
            <li><a href="/riwayat"><i class="fas fa-clock"></i>Riwayat Absensi</a></li>
                   <li><a href="/HitungNilaiUser"><i class="fa-solid fa-file-invoice"></i>Rekapitulasi Absensi</a></li>
            <li><a href="/help-support"><i class="fas fa-info-circle"></i>Help & Support</a></li>
            <li><a href="/checklist"><i class="fas fa-clock"></i>Checklist Piket</a></li>
        
        </ul>
        <ul class="dropdown-menu" id="dropdown-menu" hidden>
            <li><a href="/Profile">Tampilan User</a></li>
            <li><a href="/logout">Log Out</a></li>
        </ul>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var iconHeader = document.getElementById("icon-header");
        var menuHeader = document.querySelector(".menu-header");

        // Function to handle screen resize and initial load
        function handleScreenResize() {
            if (window.innerWidth > 768) {
                menuHeader.setAttribute("hidden", "true"); // Always hide menu on larger screens
            } else {
                menuHeader.setAttribute("hidden", "true"); // Start hidden on mobile until clicked
            }
        }

        // Execute the function to handle screen size on page load
        handleScreenResize();

        // Toggle show/hide menu on icon click for mobile screen only
        iconHeader.addEventListener("click", function() {
            // Check if the screen width is 768px or smaller (mobile view)
            if (window.innerWidth <= 768) {
                if (menuHeader.hasAttribute("hidden")) {
                    menuHeader.removeAttribute("hidden"); // Show the menu
                } else {
                    menuHeader.setAttribute("hidden", "true"); // Hide the menu
                }
            }
        });

        // Automatically handle window resize to toggle the visibility of the menu
        window.addEventListener("resize", function() {
            handleScreenResize();
        });
    });
</script>