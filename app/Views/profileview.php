<?= $this->extend('/Layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<title>Profile</title>
<link rel="stylesheet" href="/css/profile.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="title">
    <h2>Profil</h2>
</div>
        <div class="card profile custom-font">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= $nama; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="institusi" class="form-label">Asal Institusi</label>
                    <input type="text" id="institusi" name="institusi" class="form-control" value="<?= $institusi; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control" value="<?= $jenis_kelamin; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="form-control" value="<?= $telepon; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= $email; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="alamat" id="alamat" name="alamat" class="form-control" value="<?= $alamat; ?>" readonly>
                </div>
                <a href="<?= site_url('profile/edit'); ?>" class="btn btn-primary custom-btn">Edit Profil</a>
                
                <a href="<?= site_url('profile/delete'); ?>" class="btn btn-danger custom-btn delete-btn"  
                   onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">Hapus Akun</a>

            </div>
        </div>
<?= $this->endSection() ?>