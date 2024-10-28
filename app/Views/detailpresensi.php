<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/detailpresensiview.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="title">
    <h2>Detail Presensi</h2>
</div>
<div class="card profile custom-font">
    <div class="card-body">
        <div class="form-group">
            <label for="nama" class="form-label custom-font">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control custom-font" value="<?= $presensi['Nama']; ?>" readonly>
        </div>
        <div class="form-row">
            <div class="form-group flex-item">
                <label for="tanggal" class="form-label custom-font">Tanggal</label>
                <input type="text" id="tanggal" name="tanggal" class="form-control custom-font" value="<?= $presensi['tanggal']; ?>" readonly>
            </div>
            <div class="form-group flex-item">
                <label for="status" class="form-label custom-font">Status Kehadiran</label>
                <input type="text" id="status" name="status" class="form-control custom-font" value="<?= $presensi['status']; ?>" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group flex-item">
                <label for="jam_masuk" class="form-label custom-font">Jam Masuk</label>
                <input type="text" id="jam_masuk" name="jam_masuk" class="form-control custom-font" value="<?= $presensi['jam_masuk']; ?>" readonly>
            </div>
            <div class="form-group flex-item">
                <label for="jam_keluar" class="form-label custom-font">Jam Keluar</label>
                <input type="text" id="jam_keluar" name="jam_keluar" class="form-control custom-font" value="<?= $presensi['jam_keluar']; ?>" readonly>
            </div>
        </div>
        <div class="form-group">
  <label for="kegiatan" class="form-label custom-font">Kegiatan</label>
  <textarea id="kegiatan" name="kegiatan" class="form-control custom-font" rows="4" readonly><?= $presensi['kegiatan']; ?></textarea>
</div>


        <div class="form-group">
            <label for="foto" class="form-label custom-font">Foto</label>
            <?php if ($presensi['foto']): ?>
                <div class="img-container">
                    <img src="/uploads/photos/<?= $presensi['foto'] ?>" alt="Foto Presensi" class="img-fluid rounded bordered-image">
                </div>
            <?php else: ?>
                <div class="img-container">
                    <img src="/images/nophotoexisted.jpg" alt="Foto Presensi" class="img-fluid rounded">
                    <p class="no-photo-text">Tidak Ada Foto</p>
                </div>
            <?php endif; ?>
        </div>


        <a href="<?= site_url('/RekapitulasiAbsen/delete/' . $presensi['id_presensi']); ?>" 
                class="btn btn-danger" 
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus Data</a>

        <a href="<?= site_url('RekapitulasiAbsen') ?>" class="btn btn-primary custom-btn">Kembali</a>
    </div>
</div>
<?= $this->endSection() ?>
