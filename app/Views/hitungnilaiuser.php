<?= $this->extend('/Layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- kartu judul -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Rekapitulasi Absensi</h3>
    </div>
</div>

<!-- container khusus untuk box -->
<div class="box-container">
    <!-- kartu hadir -->
    <div class="box box1">
        <p>HADIR</p>
        <h1><?= $total_hadir ?></h1>
    </div>
    <!-- kartu sakit -->
    <div class="box box2">
        <p>SAKIT</p>
        <h1><?= $total_sakit ?></h1>
    </div>
    <!-- kartu izin -->
    <div class="box box3">
        <p>IZIN</p>
        <h1><?= $total_izin ?></h1>
    </div>
    <!-- kartu alpha -->
    <div class="box box4">
        <p>ALPHA</p>
        <h1><?= $total_alpha ?></h1>
    </div>
</div>

<div class="box-container">
    <!-- kartu nilai -->
    <div class="box box5">
        <p>NILAI</p>
        <h1><?= $nilai_user ?></h1>
    </div>
</div>

<?= $this->endSection() ?>
