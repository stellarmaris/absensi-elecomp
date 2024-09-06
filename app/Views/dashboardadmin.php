<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">
<link rel="stylesheet" href="/css/pagination.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- kartu judul -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Rekapitulasi</h3>
        <p><em><?= $tanggal_hari_ini ?></em></p>
    </div>
</div>

<!-- container khusus untuk box -->
<div class="box-container">
    <!-- kartu sakit, izin, hadir -->    
    <div class="box box1">
        <p>HADIR</p>
        <h1><?= $total_hadir ?></h1>
    </div>
    <div class="box box2">
        <p>SAKIT</p>
        <h1><?= $total_sakit ?></h1>
    </div>
    <div class="box box3">
        <p>IZIN</p>
        <h1><?= $total_izin ?></h1>
    </div>
    <div class="box box4">
        <p>TOTAL</p>
        <h1><?= $total_rekap ?></h1>
    </div>
</div>

<div class="box-container">
    <div class="box box5">
        <p>PENGGUNA</p>
        <h1><?= $total_user ?></h1>
    </div>
</div>

<!-- kartu judul2 -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Data Absensi</h3>
        <p><em><?= $tanggal_hari_ini ?></em></p>
    </div>
</div>

<!-- Tabel data presensi -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($data_presensi)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">Data Tidak Ditemukan</td>
            </tr>
        <?php else: ?>
            <?php
            // Nomor urut
            $nomor = 0;
            foreach ($data_presensi as $k => $v) {
                $nomor++;
                // Ubah warna sesuai kondisi
                if (!empty($v['jam_keluar']) && ($v['status'] == 'WFO' || $v['status'] == 'WFH')) {
                    $rowClass = 'row-blue'; 
                } elseif ($v['status'] == 'Sakit' || $v['status'] == 'Izin') {
                    $rowClass = 'row-yellow';
                } else {
                    $rowClass = ''; 
                }
            ?>
            <tr class="<?= $rowClass ?>">
                <td><?php echo $nomor ?></td>
                <td><?php echo $v['tanggal'] ?></td>
                <td><?php echo $v['Nama'] ?></td>
                <td><?php echo $v['jam_masuk'] ?></td>
                <td><?php echo $v['jam_keluar'] ?></td>
                <td><?php echo $v['status']; ?></td>
            </tr>
            <?php }?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination Links -->
<?php if ($pager): ?>
    <div class="pagination">
        <?= $pager->links('presensi', 'custom') ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
