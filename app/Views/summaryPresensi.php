<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">
<link rel="stylesheet" href="/css/pagination.css">
<style>
    .btn-alpha {
        justify-content: center;
        align-items: center;
        display: flex;
        background-color: red;
        color: white;
        width: 100px;
        height: 40px;
    }

    button {}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- kartu judul -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Summary Presensi</h3>
    </div>
</div>


<canvas id="myPieChart" width="100" height="100" style="max-width: 300px; max-height:300px;"></canvas>

<script>
    // Ambil elemen canvas
    const ctx = document.getElementById('myPieChart').getContext('2d');

    // Data untuk Pie Chart, ambil dari PHP
    const data = {
        labels: ['Alpha', 'Sakit', 'Ijin', 'WFO', 'WFH'],
        datasets: [{
            label: 'Presensi Status',
            data: [
                <?= $alphaCount ?>,
                <?= $sakitCount ?>,
                <?= $ijinCount ?>,
                <?= $wfoCount ?>,
                <?= $wfhCount ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)', // Alpha
                'rgba(54, 162, 235, 0.7)', // Sakit
                'rgba(255, 206, 86, 0.7)', // Ijin
                'rgba(75, 192, 192, 0.7)', // WFO
                'rgba(153, 102, 255, 0.7)' // WFH
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Opsi untuk Pie Chart
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                enabled: true,
            }
        }
    };

    // Inisialisasi Pie Chart
    const myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: options
    });
</script>

<?= $this->endSection() ?>