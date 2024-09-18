<?= $this->extend('/layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/riwayat.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>


    <div class="title">
        <h2>Riwayat</h2>
        <p>Daftar riwayat presensi</p>
    </div>

    <div class="col-md-3 mb-2 mb-md-0">
        <form action="/riwayat" method="get" class="input-group mb-3">
            <input type="date" name="tanggal" id="date" class="form-control" value="<?= esc($tanggal) ?>">
            <button type="submit" class="btn" style="background-color: #130C90; color:white">Filter</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 14%">Tanggal</th>
                    <th style="width: 8%">Jam Masuk</th>
                    <th style="width: 8%">Jam Keluar</th>
                    <th style="width:10%">Status</th>
                    <th style="width: 45%; word-wrap: break-word;">Kegiatan</th>
                    <th style="width: 10%; text-align: center;">Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data_presensi) > 0): ?>

                    <?php

                    foreach ($data_presensi as $index => $v): ?>
                        <tr <?php if ($v['status'] == 'Alpha'): ?>
                                style="background-color: #F9A4A3;"  
                            <?php elseif ($v['status'] == 'Izin'): ?>
                                style="background-color:  #FFC8B0"  
                            <?php elseif ($v['status'] == 'Sakit'): ?>
                                style="background-color: #FFE7A8 ;"  
                               
                            <?php endif; ?>
                            >
                            <td><?= (($currentPage - 1) * $perPage) + ($index + 1) ?></td>
                            <td><?php echo $v['tanggal'] ?></td>
                            <td><?php echo $v['jam_masuk'] ?></td>
                            <td><?php echo $v['jam_keluar'] ?></td>
                            <td><?php echo $v['status'] ?></td>
                            <td style="width: 200px;word-wrap:break-word;"><?php echo nl2br(esc($v['kegiatan']))?></td>

                            <td style="width: 150px; text-align: center;">
                                    <?php if ($v['verifikasi'] == 'Pending'): ?>
                                        <span style="color:white; background-color:orange ; padding: 5px 15px; border-radius:50px"><?php echo $v['verifikasi'] ?></span>
                                    <?php else: ?>
                                        <span style="color:white; background-color:green ; padding: 5px 15px; border-radius:50px" ><?php echo $v['verifikasi']?></span>
                                    <?php endif?>
                            </td>   
                        </tr>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center;"> Data Tidak Ditemukan</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($viewAll): ?>
            <!-- Jika dalam mode "View All", tampilkan tombol kembali ke pagination -->
            <a href="/riwayat" class="btn btn-secondary">Back to Pagination</a>
        <?php else: ?>
            <!-- Jika tidak dalam mode "View All", tampilkan pagination dan tombol "View All" -->
            <a href="/riwayat?view_all=1" class="btn btn-primary">View All</a>
            <?= $pager->links('presensi', 'custom') ?>
        <?php endif; ?>
    </div>




<!-- Your content here -->
<?= $this->endSection() ?>