<?= $this->extend('/Layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboard.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<style>
    .alert-custom {
        background-color: #cce5ff;
        /* Light blue background */
        color: #004085;
        /* Dark blue text */
        border: 1px solid #b8daff;
        /* Light blue border */
        border-radius: 5px;
        /* Rounded corners */
        padding: 10px;
        margin: 20px 0;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    .alert-custom h4 {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .alert-custom p {
        margin-bottom: 10px;
    }

    .alert-custom ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .alert-custom hr {
        border-top: 1px solid #b8daff;
        margin: 15px 0;
    }

    .alert-custom .mb-0 {
        margin-bottom: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <h2>Check In Form</h2>
</div>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>
<div class="alert-custom">
    <h4 class="alert-heading">Ketentuan Umum Check-In (WFH dan WFO)</h4>
    <p>Pastikan check-in Anda memenuhi kriteria berikut:</p>

    <strong>Untuk WFH (Work From Home):</strong>
    <ul>
        <li>Sudah mendapatkan izin WFH dari atasan melalui grup.</li>
        <li>Foto harus menyertakan watermark.</li>
        <li>Foto bukti harus relevan dengan alasan WFH (misalnya foto bersama dosen atau foto dengan kegiatan).</li>
    </ul>

    <strong>Untuk WFO (Work From Office) dan WFH:</strong>
    <ul>
        <li>Foto harus diambil dalam mode potret.</li>
        <li>Foto harus berupa selfie muka diri sendiri.</li>
        <li>Foto harus menyertakan watermark (jika ada).</li>
        <li>Pastikan lokasi Anda sudah sesuai.</li>
    </ul>

    <hr>
    <p class="mb-0">Pastikan untuk mengikuti panduan ini agar check-in Anda berhasil. Jika tidak sesuai ketentuan, check-in Anda tidak akan diverifikasi.</p>
</div>
<<<<<<< HEAD
=======

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4

<form action="/check-in-form" method="POST" enctype="multipart/form-data">
    <div class="group">
        <div class="form">
            <div class="label"><label for="date">Tanggal Check In</label></div>
            <div class="input"> <input type="date" name="date" id="date" readonly></div>
        </div>
        <div class="form">
            <div class="label"><label for="time">Waktu Check In</label></div>
            <div class="input">
                <input type="time" name="time" id="time" readonly>
            </div>
        </div>
    </div>
     <div class="form-1">
        <div class="label"><label for="status">Status (WFO/WFH)</label></div>
        <div class="input">
            <select name="status" id="status" required>
                <option value="">Pilih Status</option>
                <option value="WFO">Work From Office (WFO)</option>
                <option value="WFH">Work From Home (WFH)</option>
            </select>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="status">Status (WFO/WFH)</label></div>
        <div class="input">
            <select name="status" id="status" required>
                <option value="">Pilih Status</option>
                <option value="WFO">Work From Office (WFO)</option>
                <option value="WFH">Work From Home (WFH)</option>
            </select>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="foto">Upload Foto Check In</label></div>
        <div class="input">
           <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png" required >
        </div>
    </div>
    <div class="form-1" hidden>
        <div class="label"><label for="latitude">Latitude</label></div>
        <div class="input">
            <input type="text" name="latitude" id="latitude">
        </div>
    </div>
    <div class="form-1" hidden>
        <div class="label"><label for="longitude">Longitude</label></div>
        <div class="input">
            <input type="text" name="longitude" id="longitude">
        </div>
    </div>

    <!-- Tambahkan div untuk map -->
    <div id="map" style="height: 325px; margin-top: 20px;"></div>

    <div class="btn">
        <button type="submit">Upload</button>
    </div>
</form>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    const waktu = new Date();
    const year = String(waktu.getFullYear());
    const month = String(waktu.getMonth() + 1).padStart(2, '0');
    const date = String(waktu.getDate()).padStart(2, '0');
    const hour = String(waktu.getHours()).padStart(2, '0');
    const minute = String(waktu.getMinutes()).padStart(2, '0');

    const TimeNow = `${hour}:${minute}`
    const DateNow = `${year}-${month}-${date}`;
    document.getElementById('date').value = DateNow;
    document.getElementById('time').value = TimeNow;
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
        switch (error.code) {
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

<!-- ======== KOMPRES FOTO ============= -->
<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    const MAX_WIDTH = 800;  // Tentukan ukuran maksimum
                    const scaleSize = MAX_WIDTH / img.width;

                    canvas.width = MAX_WIDTH;
                    canvas.height = img.height * scaleSize;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Kompres gambar dengan kualitas 0.9
                    canvas.toBlob(function(blob) {
                        const compressedFile = new File([blob], file.name, {
                            type: file.type,
                            lastModified: Date.now()
                        });

                        // Ganti file asli dengan yang terkompresi
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        document.getElementById('foto').files = dataTransfer.files;
                    }, file.type, 0.9);  // Menurunkan kualitas ke 90%
                }
            }

            reader.readAsDataURL(file);
        }
    });
</script>

<?= $this->endSection() ?>