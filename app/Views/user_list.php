<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<<<<<<< HEAD
<title>Daftar Pengguna</title>
=======
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<style>
    /* Styling CSS */
    .custom-font {
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 10px;
        margin-bottom: 30px;
        max-width: 100%;
        box-shadow: 0.1px 4px 6px rgba(0, 0, 0, 0.1);
        padding-left: 20px;
        border: 2px solid #130C90;
    }

    .btn-danger {
        background-color: #130C90;
        color: white;
        border: none;
        text-decoration: none;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: rgba(19, 12, 144, 0.04);
        font-size: 14px;
    }

    thead {
        background-color: #130C90;
    }

    th,
    td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    th {
        color: white;
    }

    .date-picker {
        width: 200px;
        height: 40px;
        padding-left: 10px;
    }

    .custom-btn {
        width: 150px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 15px;
        font-weight: bold;
        background-color: #130C90;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        margin-top: 10px;
    }

    .custom-btn:hover {
        background-color: #0C074F;
    }

    .pagination {
        display: flex;
        justify-content: right;
        list-style-type: none;
    }

    .page-item {
        margin: 0 2px;
        margin-top: 12px;
        list-style-type: none;
    }

    .page-link {
        display: block;
        color: #130C90;
        padding: 8px 18px;
        border: 1px solid #130C90;
        border-radius: 4px;
        text-decoration: none;
    }

    .page-link:hover {
        background-color: rgba(19, 12, 144, 0.04);
        color: #130C90;
        border-color: #130C90;
    }

    .page-item.active .page-link {
        background-color: #130C90;
        color: white;
        border-color: #130C90;
    }

    .btn-search {
        padding: 10px 15px;
        background-color: #130C90;
        color: white;
        font-weight: 600;
    }

    .btn-search:hover {
        background-color: #0C074F;
    }

    #search {
        padding: 10px 20px;
        width: 200px;
    }

</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text"><?= esc($title) ?></h3>
        <p><em>Daftar Seluruh User</em></p>
    </div>
</div>


<form method="get" action="<?= site_url('user-list') ?>">
    <input type="text" name="search" id="search" placeholder="Search users..." value="<?= esc($search) ?>">
    <button type="submit" class="btn-search btn-primary">Search</button>
</form>



<?php if (!empty($data_user) && is_array($data_user)): ?>
    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jenis Kelamin</th>
                <th>Nomor Telepon</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data_user as $user): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($user['Nama']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['Jenis_kelamin']) ?></td>
                    <td><?= esc($user['Nomor_telepon']) ?></td>
                    <td>
                        <a href="<?= site_url('detail-user/' . $user['id_magang']) ?>" class="custom-btn">Detail</a>
                        <form action="<?= site_url('delete-user/' . $user['id_magang']) ?>" method="post" style="display:inline;">
                            <button type="submit" class="custom-btn" style="background-color:red" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <?php if ($pager): ?>
        <div class="pagination">
            <?= $pager->links('presensi', 'custom') ?>

        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-warning">Tidak ada data pengguna yang ditemukan.</div>
<?php endif; ?>

<?= $this->endSection() ?>