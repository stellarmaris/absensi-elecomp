<?= $this->extend('/layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/checkout.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php


 if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>


    <div class="title">
        <h2>Checkout</h2>
        <p>Sebelum pulang, checkout dulu yuk<p>
    </div>


    <form action="<?= base_url('/checkout')?>" method="POST" enctype="multipart/form-data">
        <div class="group">
            <div class="form">
                <div class="label"><label class="form-label">Tanggal:</label></div>
                <div class="input"><input type="date" class="form-control" name="tanggalKeluar" id="tanggalKeluar" readonly></div>   
            </div>
            <div class="form">
                <div class="label"><label class="form-label">Jam keluar:</label></div>
               <div class="input"><input type="time" class="form-control" name="jamKeluar" id="jamKeluar" readonly></div> 
            </div>
        </div>
        <div class="form-1">
            <div class="label"><label class="form-label">Progress:</label><div>
            <div class="input"><textarea rows="5" class="form-control" name="Progress" placeholder="Masukkan progress anda hari ini.." required ><?= set_value('Progress') ?></textarea></div>
            <p style="color: red;margin-top:2px"><em> *Catt: Pastikan kamu menuliskan progress dengan rinci</em></p>
        </div>
        <div class="form-1" >
            <label class="form-label">Lokasi:</label>
           
            <input type="hidden" class="form-control" id="latitude_checkout" name="latitude_checkout">
            <input type="hidden" class="form-control" id="longitude_checkout" name="longitude_checkout">
           
        </div>
        <div id="map" style="height: 325px; margin-top: 20px;"></div>
    
        <div class="d-grid">
                <button type="submit" class="btn mb-2" style="background-color: #130C90; color:white;"><strong>Simpan</strong></button>
            </div>
    </form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil jam saat ini
        var sekarang = new Date();
        var jam = String(sekarang.getHours()).padStart(2, '0');
        var menit = String(sekarang.getMinutes()).padStart(2, '0');
        var tanggal = String(sekarang.getDate()).padStart(2,'0');
        var bulan = String(sekarang.getMonth()+1).padStart(2,'0');
        var tahun = sekarang.getFullYear();
       
        // Setel value input jam keluar
        document.getElementById('jamKeluar').value = jam + ':' + menit;
        document.getElementById('tanggalKeluar').value = tahun+ "-" +bulan +"-" +tanggal;
    });
</script>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script >

    var map = L.map('map').fitWorld();
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map);

    map.locate({
        setView:true,
        maxZoom:16
    });

    function showPosition(position) {
        var radius = position.accuracy;
        var latiLongi = position.latlng;

        //masukkan longitude dan latitude ke form
        document.getElementById('latitude_checkout').value = latiLongi.lat;
        document.getElementById('longitude_checkout').value = latiLongi.lng;

        L.marker(latiLongi).addTo(map)
            .bindPopup("Lokasi anda saat ini")
            .openPopup();
        L.circle(latiLongi).addTo(map);
       
    }map.on('locationfound',showPosition );

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
    }map.on('locationerror',showError);

</script>

</div>
</div>

<!-- Your content here -->
<?= $this->endSection() ?>

