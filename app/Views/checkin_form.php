<?= $this->extend('/layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <h2>Form Perizinan</h2>
</div>

<form action="/check-in-form" method="post" enctype="multipart/form-data">
    <div class="group">
        <div class="form">
            <div class="label"><label for="date">Tanggal Perizinan</label></div>
            <div class="input"> <input type="date" name="date" id="date"></div>
        </div>
        <div class="form">
            <div class="label"><label for="time">Waktu Perizinan</label></div>
            <div class="input">
                <input type="time" name="time" id="time">
            </div>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="status">Status Perizinan</label></div>
        <div class="input">
            <input type="text" name="status" id="status">
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="foto">Upload Foto</label></div>
        <div class="input">
            <input type="file" name="foto">
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="latitude">Latitude</label></div>
        <div class="input">
            <input type="text" name="latitude" id="latitude" readonly>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="longitude">Longitude</label></div>
        <div class="input">
            <input type="text" name="longitude" id="longitude" readonly>
        </div>
    </div>

    <!-- Tambahkan div untuk map -->
    <div id="map" style="height: 300px; margin-top: 20px;"></div>

    <div class="btn">
        <button type="submit">Upload</button>
    </div>
</form>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    // Geolocation untuk mendapatkan posisi saat ini
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    }

    function showPosition(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;

        // Inisialisasi peta
        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Tambahkan marker pada lokasi saat ini
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup('Lokasi Anda Saat Ini')
            .openPopup();
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Pengguna menolak permintaan Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Informasi lokasi tidak tersedia.");
                break;
            case error.TIMEOUT:
                alert("Permintaan lokasi pengguna timeout.");
                break;
            case error.UNKNOWN_ERROR:
                alert("Terjadi kesalahan yang tidak diketahui.");
                break;
        }
    }

    // Panggil fungsi getLocation ketika halaman dimuat
    window.onload = getLocation;
</script>

<?= $this->endSection() ?>