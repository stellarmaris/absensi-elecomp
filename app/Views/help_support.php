<?= $this->extend('/Layouts/user_layout') ?>

<?= $this->section('customStyles') ?>
<<<<<<< HEAD
<title>Help & Support</title>
=======
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<link rel="stylesheet" href="/css/profileedit.css">
<style>
    .help-container {
        margin: 0 auto;
        padding: 30px 50px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .help-header {
        font-size: 28px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        color: #343a40;
    }

    .help-section {
        margin-bottom: 20px;
    }

    .help-section h2 {
        font-size: 16px;
        margin-bottom: 10px;
        color: #495057;
    }

    .help-section p {
        padding-left: 20px;
        margin-bottom: 10px;
        line-height: 1.6;
        font-size: 14px;
        color: #6c757d;
    }

    .help-section ul {
        padding-left: 35px;
        margin-top: 10px;
    }

    .help-section ul li {
        margin-bottom: 15px;
        color: #6c757d;
        font-size: 14px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="help-header">Bantuan dan Dukungan</div>

<div class="help-section">
    <h2>1. Mendaftar & Masuk</h2>
    <ul>
        <li><strong>Mendaftar:</strong> Jika Anda belum memiliki akun, silakan daftar untuk membuat akun baru.</li>
        <li><strong>Masuk:</strong> Jika sudah memiliki akun, Anda dapat langsung masuk.</li>
        <li><strong>Lupa Password?</strong> Jika lupa password, hubungi Admin Eli di [+62 822-7694-4556].</li>
    </ul>
</div>

<div class="help-section">
    <h2>2. Mengatasi Masalah Login & Pendaftaran</h2>
    <p>Jika Anda mengalami bug atau masalah saat mencoba masuk atau mendaftar, silakan hubungi Admin Al di [+62 896-1686-870].</p>
</div>

<div class="help-section">
    <h2>3. Proses Check-In</h2>
    <ul>
        <li><strong>Wajib Check-In:</strong> Peserta magang wajib melakukan check-in dengan mengirimkan foto sesuai ketentuan.</li>
        <li><strong>Verifikasi Lokasi:</strong> Pastikan lokasi Anda sudah sesuai. Jika lokasi tidak tampil dengan benar atau peta tidak muncul:
            <ul>
                <li>Buka aplikasi Google Maps.</li>
                <li>Klik pada titik di pojok kanan atas untuk melihat lokasi Anda saat ini.</li>
                <li>Kembali ke halaman website dan periksa apakah peta dan lokasi sudah muncul.</li>
            </ul>
        </li>
        <li><strong>Bantuan Lebih Lanjut:</strong> Jika masalah masih terjadi, hubungi Admin Al di [+62 896-1686-870].</li>
    </ul>
</div>

<div class="help-section">
    <h2>4. Mengirimkan Formulir Izin</h2>
    <ul>
        <li><strong>Pengajuan Izin:</strong> Anda dapat mengajukan izin melalui formulir izin yang tersedia.</li>
        <li><strong>Masalah Verifikasi Izin:</strong> Jika mengalami kendala dalam verifikasi izin, hubungi Admin Bintang di [+62 895-3394-32220].</li>
    </ul>
</div>

<div class="help-section">
    <h2>5. Proses Check-Out</h2>
    <p><strong>Check-Out Harian:</strong> Setelah selesai bekerja, lakukan check-out dengan mencatat progres kegiatan harian Anda.</p>
</div>

<div class="help-section">
    <h2>6. Riwayat Absensi & Izin</h2>
    <ul>
        <li><strong>Cek Riwayat:</strong> Untuk melihat riwayat absensi dan izin Anda, buka menu "Riwayat Presensi".</li>
        <li><strong>Absensi Belum Terverifikasi:</strong> Jika ada absensi atau izin yang belum diverifikasi dalam waktu 1 x 24 jam, hubungi Admin Bintang [+62 895-3394-32220].</li>
    </ul>
</div>

<div class="help-section">
    <h2>7. Manajemen Profil</h2>
    <p><strong>Lihat & Edit Profil:</strong> Anda dapat melihat dan mengedit profil Anda di menu "Profile".</p>
</div>

<div class="help-section">
    <h2>8. Jam Operasional Admin</h2>
    <p><strong>Jam Kerja:</strong> Admin tersedia dari pukul 08:00 hingga 16:00.</p>
    <p><strong>Respon Lambat:</strong> Harap diperhatikan bahwa Admin Bintang, Eli, dan Al mungkin merespon dengan lambat di luar jam kerja tersebut.</p>
</div>
</div>
<?= $this->endSection() ?>