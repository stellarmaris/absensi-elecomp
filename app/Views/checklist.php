<?= $this->extend('/Layouts/user_layout') ?>
<?= $this->section('customStyles') ?>
<title>Riwayat</title>
<link rel="stylesheet" href="/css/riwayat.css">
<style>
        .pagination a.btn {
                margin-top: 20px;
                padding: 8px 10px;
                font-size: 18px;
        }
        .pagination a.btn:hover{
            color: rgb(0, 7, 62)
        }
       @media (max-width: 768px) {
            .page-link {
                display: block;
                color: #130C90; /* Mengubah warna teks */
                padding: 4px 10px;
                border: 1px solid #130C90; /* Menambahkan border */
                border-radius: 4px;
                text-decoration: none;
                }
                 .pagination a.btn {
                    margin-top: 12px;
                    padding: 8px 10px;
                    font-size: 18px;
                }
        }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


    <div class="title">
        <h2>Riwayat</h2>
        <p>Daftar riwayat piket</p>
    </div>

    <div class="col-md-3 mb-2 mb-md-0">
        <form action="/chechlist" method="get" class="input-group mb-3">
        </form>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th style="width: 5%">No</th>
                <th style="width: 8%">Jam piket</th>
                <th style="width: 45%; word-wrap: break-word;">Kegiatan Piket</th>
                </tr>
            </thead>
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