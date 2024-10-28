<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
         <link rel="shortcut icon" id="favicon" href="<?= base_url('/images/Logo1.jpeg') ?>">
       <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading {
            animation: spin 1s linear infinite;
        }
    </style>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .sidebar {
            width: 250px;
            background-color: #2c2f33;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }

        .logo img {
            width: 150px;
        }

        .menu {
            list-style: none;
            margin-top: 30px;
            width: 100%;
        }

        .menu li {
            width: 100%;
        }

        .menu li a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
        }

        .menu li a:hover {
            background-color: #23272a;
        }

        .menu li a.active {
            background-color: #1d2124;
        }

        .menu li a i {
            margin-right: 10px;
        }

        .main-content {
            flex-grow: 1;
            background-color: #eef0f5;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #fff;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 15px;
            padding-right: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            /* Ensure header is positioned relative for dropdown positioning */
        }

        .menu-header {
            list-style: none;
            margin-top: 10px;
            width: 100%;
        }

        .menu-header li {
            width: 100%;
        }

        .menu-header li a {
            display: block;
            padding: 15px 20px;
            color: #1d2124;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
        }



        .menu-header li a:hover {
            background-color: #1d2124;
            color: #fff
        }

        .menu-header li a.active {
            background-color: #1d2124;
            color: #fff
        }

        .menu-header li a i {
            margin-right: 10px;
        }


        .user-profile {
            position: relative;
            /* Ensure dropdown is positioned relative to this container */
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            margin-right: 25px;
            border-radius: 50%;
            cursor: pointer;
            /* Indicate clickable */
        }

        .dropdown-menu {
            display: none;
            /* Initially hidden */
            position: absolute;
            /* Position absolutely within the user-profile container */
            top: 50px;
            /* Adjust as needed */
            right: 0;
            background-color: #fff;
            border: 1px solid lightgray;

            list-style: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* Ensure dropdown is on top */
        }

        .dropdown-menu li {
            width: 100%;

        }

        .dropdown-menu li a {
            color: #333;
            text-decoration: none;
            display: block;
            padding: 15px 20px;

        }

        .dropdown-menu li a:hover {
            background-color: #f1f1f1;
        }

        .content {
            padding: 15px 20px;
            overflow: auto;
        }

        /* Default untuk tampilan desktop */
        #icon-header {
            display: none;
            /* Tidak tampil di desktop */
        }

        .head-header {
            display: flex;
            justify-content: end;
            /* Gambar profil berada di kanan */
            width: 100%;
            align-items: center;
        }

   

        /* Tampilan untuk layar mobile (dibawah 768px) */
        @media (max-width: 768px) {
            #icon-header {
                display: block;
                /* Tampilkan ikon burger */
                cursor: pointer;
                /* Tampilkan sebagai tombol */
                margin-right: auto;
                /* Posisikan di kiri */
                padding-left: 15px;
            }

         

            .head-header {
                justify-content: space-between;
                /* Ikon di kiri, gambar profil di kanan */
            }

            .main-content {
                width: 100%;
            }

            .sidebar {
                display: none;
            }
        }
    </style>
    <?= $this->renderSection('customStyles') ?>
</head>

<body>
    <div class="container">
        <?= $this->include('/Partials/sidebar') ?>
        <main class="main-content">
            <?= $this->include('/Partials/header_user') ?>

            <section class="content">
                <?= $this->renderSection('content') ?>
            </section>

        </main>

    </div>

   <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Highlight the current page link
            var currentUrl = window.location.href;
            var navLinks = document.querySelectorAll(".menu li a");

            navLinks.forEach(function(link) {
                var linkHref = link.getAttribute("href");
                if (currentUrl.indexOf(linkHref) !== -1) {
                    link.classList.add("active");
                }
            });

            // Toggle dropdown menu
            var profileImg = document.getElementById("profile-img");
            var dropdownMenu = document.getElementById("dropdown-menu");

            profileImg.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent click from closing the menu immediately
                dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
            });

            // Close dropdown if clicking outside
            document.addEventListener("click", function(event) {
                if (!profileImg.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.style.display = "none";
                }
            });
        });

        // Function to change favicon during loading
        function setLoadingFavicon() {
            const favicon = document.getElementById('favicon');
            favicon.href = '<?= base_url('/images/loading-icon.gif') ?>'; // Ganti dengan favicon loading
        }

        // Restore original favicon
        function restoreFavicon() {
            const favicon = document.getElementById('favicon');
            favicon.href = '<?= base_url('/images/Logo1.jpeg') ?>'; // Kembali ke favicon asli
        }

        window.addEventListener('load', function() {
            restoreFavicon(); // Kembali ke favicon asli saat loading selesai
        });

        // Set loading favicon saat halaman dimuat
        setLoadingFavicon();
    </script>

</body>

</html>