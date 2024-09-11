<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/hitungnilai.css">
<link rel="stylesheet" href="/css/pagination.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- kartu judul2 -->
<div class="card title-card">
    <h3 class="card-title bold-text">Rekapitulasi Penilaian</h3>
    <div class="card-body">
        <p class="subtitle-card"><em>Rekapitulasi Nilai Magang</em></p>
    </div>
</div>

<!--Form filter  -->
<div class="row mb-2 form-container">
    <div class="search-form">
        <form action="<?= site_url('/HitungNilai') ?>" method="get" class="d-flex">
            <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama ....." value="<?= isset($search) ? $search : '' ?>">
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
</div>

<!-- Tabel data presensi -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Asal Institusi</th>
                <th>WFO</th>
                <th>WFH</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpha</th>
                <th>Total</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_presensi)): ?>
                <tr>
                    <td colspan="10" style="text-align: center;">Data Tidak Ditemukan</td>
                </tr>
            <?php else: ?>
                <?php
                    $nomor = 0;
                    foreach ($data_presensi as $k => $v) {
                        $nomor++;
                ?>
                    <tr>
                        <td><?php echo $nomor ?></td>
                        <td><?= $v['Nama'] ?></td>
                        <td><?= $v['AsalInstitusi'] ?></td>
                        <td><?= $v['WFO'] ?></td>
                        <td><?= $v['WFH'] ?></td>
                        <td><?= $v['Sakit'] ?></td>
                        <td><?= $v['Izin'] ?></td>
                        <td><?= $v['Alpha'] ?></td>
                        <td><?= $v['totalHariMagang'] ?></td>
                        <td><?= $v['Nilai'] ?></td>
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
