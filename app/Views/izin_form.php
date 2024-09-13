<?= $this->extend('/layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboard.css">
<style>
    /* Tambahkan atau sesuaikan CSS sesuai kebutuhan Anda */
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

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .group,
    .form,
    .form-1 {
        margin-bottom: 15px;
    }

    .label {
        margin-bottom: 5px;
    }

    .input input,
    .input select {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .btn button {
        padding: 10px 20px;
        background-color: #130C90;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn button:hover {
        background-color: #0C074F;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div>
    <h2>Form Perizinan</h2>
</div>

<!-- Tampilkan pesan error jika ada -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('message')) ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('/izin-form') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="group">
        <div class="form">
            <div class="label"><label for="date">Tanggal Perizinan</label></div>
            <div class="input">
                <input type="date" name="date" id="date" value="<?= esc(old('date')) ?>">
            </div>
        </div>
        <div class="form">
            <div class="label"><label for="time">Waktu Perizinan</label></div>
            <div class="input">
                <input type="time" name="time" id="time" value="<?= esc(old('time')) ?>">
            </div>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="status">Status Perizinan</label></div>
        <div class="input">
            <select name="status" id="status">
                <option value="">-- Pilih Status --</option>
                <option value="sakit" <?= old('status') == 'sakit' ? 'selected' : '' ?>>Sakit</option>
                <option value="izin" <?= old('status') == 'izin' ? 'selected' : '' ?>>Izin</option>
            </select>
        </div>
    </div>

    <div class="form-1">
        <div class="label"><label for="foto">Foto Bukti</label></div>
        <div class="input">
            <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png" required>
        </div>
    </div>
    <div class="form-1">
        <div class="label"><label for="kegiatan">Keterangan Perizinan</label></div>
        <div class="input">
            <input type="text" name="kegiatan" id="kegiatan"  required style="height:100px">
        </div>
    </div>

    <div class="btn">
        <button type="submit">Upload</button>
    </div>
</form>

<script>
    // Mengatur nilai default untuk tanggal dan waktu
    window.onload = function() {
        const waktu = new Date();
        const year = String(waktu.getFullYear());
        const month = String(waktu.getMonth() + 1).padStart(2, '0');
        const date = String(waktu.getDate()).padStart(2, '0');
        const hour = String(waktu.getHours()).padStart(2, '0');
        const minute = String(waktu.getMinutes()).padStart(2, '0');

        const TimeNow = `${hour}:${minute}`;
        const DateNow = `${year}-${month}-${date}`;
        document.getElementById('date').value = DateNow;
        document.getElementById('time').value = TimeNow;
    };

    // Geolocation untuk mendapatkan posisi saat ini (Jika diperlukan)
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation tidak didukung oleh browser ini.");
        }
    }

    function showPosition(position) {
        // Implementasikan logika untuk menyimpan posisi
        // Misalnya, mengisi hidden input dengan lat dan lng
        // document.getElementById('latitude').value = position.coords.latitude;
        // document.getElementById('longitude').value = position.coords.longitude;
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }
</script>
<?= $this->endSection() ?>