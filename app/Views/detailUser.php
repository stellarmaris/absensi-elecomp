<<<<<<< HEAD
<?= $this->extend('/Layouts/admin_layout') ?>
=======
<?= $this->extend('/layouts/admin_layout') ?>
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<?= $this->section('customStyles') ?>
<style>
    .title {
        margin-left: 12px;
        margin-bottom: 10px;
    }

    .custom-font {
        font-family: 'Inter', sans-serif;
    }

    .custom-btn,
    .btn-danger {
        width: 100px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        font-weight: 500;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        margin-top: 20px;
    }

    a.custom-btn,
    .btn-danger {
        display: flex;
        justify-content: center;
        font-size: 16px;
    }

    .custom-btn {
        background-color: #130C90;
    }

    .custom-btn:hover {
        background-color: #0C074F;
    }

    .btn-danger {
        background-color: #d11326;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .card {
        margin-bottom: 20px;
        border-radius: 10px;
        padding: 20px;
        background-color: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        /* Memberikan efek bayangan */
    }

    .profile .form-control[readonly],
    textarea.form-control {
        padding: 12px;
        font-size: 14px;
        font-weight: bold;
        width: 100%;
        border: none;
        box-shadow: none;
        background-color: #F6F5FB;
        border-radius: 10px;
    }

    textarea.form-control {
        line-height: 2;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group.flex-item {
        width: 48%;
    }

    .img-container {
        margin-top: 10px;
        text-align: center;
    }

    .img-fluid {
        width: 100%;
        max-width: 500px;
        border-radius: 10px;
    }

    .bordered-image {
        border: 4px solid #5087F7;
    }

    .no-photo-text {
        margin-top: -20px;
        font-size: 16px;
        color: #d11326;
        font-weight: bold;
    }

    .button-group {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        display: flex;
        justify-content: space-between;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="title">
    <h2>Detail Pengguna</h2>
</div>
<div class="card profile custom-font">
    <div class="card-body">
        <div class="form-group">
            <label for="nama" class="form-label custom-font">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control custom-font" value="<?= esc($user['Nama']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="email" class="form-label custom-font">Email</label>
            <input type="text" id="email" name="email" class="form-control custom-font" value="<?= esc($user['email']); ?>" readonly>
        </div>
        <div class="form-row">
            <div class="form-group flex-item">
                <label for="jenis_kelamin" class="form-label custom-font">Jenis Kelamin</label>
                <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control custom-font" value="<?= esc($user['Jenis_kelamin']); ?>" readonly>
            </div>
            <div class="form-group flex-item">
                <label for="nomor_telepon" class="form-label custom-font">Nomor Telepon</label>
                <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control custom-font" value="<?= esc($user['Nomor_telepon']); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="alamat" class="form-label custom-font">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control custom-font" rows="4" readonly><?= esc($user['alamat']); ?></textarea>
        </div>
        <div class="btn">
<<<<<<< HEAD
              <a href="<?= site_url('/user-list') ?>" class="btn btn-primary custom-btn">Kembali</a>
            <a href="<?= site_url('detail-user/edit-user/' . $user['id_magang']); ?>" class="btn btn-primary custom-btn">Edit Data</a>

          
=======
            <a href="<?= site_url('detail-user/edit-user/' . $user['id_magang']); ?>" class="btn btn-primary custom-btn">Edit Data</a>

            <a href="<?= site_url('dashboardadmin') ?>" class="btn btn-primary custom-btn">Kembali</a>
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        </div>

    </div>
</div>
<?= $this->endSection() ?>