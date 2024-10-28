<?= $this->extend('/Layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<title>Dashboard</title>
<link rel="stylesheet" href="/css/dashboarduser.css">

<!-- Tambahkan CSS khusus untuk mendisable link -->
<style>
.disabled-link {
    pointer-events: none;
    color: gray;
    background-color: #ccc; /* Warna background untuk menunjukkan bahwa tombol tidak aktif */
    border-color: #ccc;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="title-card custom-font">
    <div class="card-body">
        <h2 class="card-title bold-text">Selamat Datang Kembali, <?= $nama ?>!</h2>
        <p class="card-text">Silakan pilih opsi di bawah ini untuk mencatat kehadiran Anda.</p>
    </div>
</div>

<!-- kartu check-in -->
<div class="card check-in custom-font">
    <div class="card-body d-flex justify-content-between align-items-center">
        <a href="/check-in-form" class="btn btn-primary custom-btn <?= $hasPresensi ? 'disabled-link' : '' ?>">CHECK - IN</a>
        <div class="right-aligned-text">
            <h1 class="card-title bold-text">CHECK - IN</h1>
            <p class="card-text bold-text">Gunakan tombol "Check In" untuk mencatat kehadiran Anda dengan tepat.</p>
        </div>
    </div>
</div>

<!-- kartu check-out -->
<div class="card check-in custom-font card-checkout">
    <div class="card-body d-flex justify-content-between align-items-center">
  
        <div>
            <h1 class="card-title bold-text">CHECK - OUT</h1>
            <p class="card-text bold-text">Gunakan tombol "Check Out" untuk mencatat kehadiran Anda dengan tepat.</p>
        </div>
        <a href="/checkout" class="btn btn-primary custom-btn <?= $hasCheckedin && !$hasCheckedOut && $isHadir ? '' : 'disabled-link' ?>" id="btn-checkout">CHECK - OUT</a>
        <script>
            document.getElementById('btn-checkout').addEventListener('click',function(event){
                var isPending = <?= json_encode($isPending)?>;

                if(isPending){
                    event.preventDefault();
                    alert('Statusmu masih pending, kamu tidak bisa melakukan check-out. Silahkan hubungi admin untuk verifikasi statusmu');
                }
            });
        </script>
      
    </div>
</div>

<!-- kartu absen -->
<div class="card check-in custom-font">
    <div class="card-body d-flex justify-content-between align-items-center">
        <a href="/izin-form"  class="btn btn-primary custom-btn <?= $hasPresensi ? 'disabled-link' : '' ?>">TIDAK HADIR</a>
        <div class="right-aligned-text">
            <h1 class="card-title bold-text">TIDAK HADIR</h1>
            <p class="card-text bold-text">Gunakan "Tidak Hadir" untuk mencatat status izin atau sakit.</p>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Piket -->
<div class="card check-in custom-font card-piket">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h1 class="card-title bold-text">Piket</h1>
            <p class="card-text bold-text">Gunakan tombol "Piket" untuk mencatat piket Anda dengan tepat.</p>
        </div>
        <a href="/piket" class="btn btn-primary custom-btn <?= $hasCheckedin && !$hasCheckedOut && $isHadir ? '' : 'disabled-link' ?>" id="btn-checkout">Piket</a>
        <script>
            document.getElementById('btn-piket').addEventListener('click',function(event){
                var isPending = <?= json_encode($isPending)?>;

                if(isPending){
                    event.preventDefault();
                    alert('Statusmu masih pending, kamu tidak bisa melakukan piket. Silahkan hubungi admin untuk verifikasi statusmu');
                }
            });
        </script>
      
    </div>
</div>
=======

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<?= $this->endSection() ?>