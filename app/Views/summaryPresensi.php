<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">
<link rel="stylesheet" href="/css/pagination.css">
<style>
.chart-container{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.kartu{
    width: 40%;
    margin: 8px;
    padding:15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: #fff;
}
.kartu3{
    width: 100%;
    margin: 8px;
    padding:15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: #fff;
}

@media (max-width: 768px) {
      .kartu {
        width: 100%; /* Lebar penuh pada layar kecil */
      }
    }
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


<div class="chart-container">
    <div class="kartu">
        <h5>Data Presensi Per Hari</h5>
        <canvas id="myPieChart"></canvas>
    </div>
    <div class="kartu">
        <h5> Data Presensi Per Bulan</h5>
        <canvas id="chart2"></canvas>
    </div>
    
</div>
<div class="kartu3">
        <h5>Data Presensi Per Tahun</h5>
        <canvas id="chart3" ></canvas>
    </div>

<script>
    // Ambil elemen canvas
    const ctx = document.getElementById('myPieChart').getContext('2d');

    // Data untuk Pie Chart, ambil dari PHP
    const data = {
        labels: ['WFO','WFH','Sakit','Izin', 'Alpha'],
        datasets: [{
            label: 'Presensi Status',
            data: [
                <?= $alphaCount ?>,
                <?= $sakitCount ?>,
                <?= $ijinCount ?>,
                <?= $wfoCount ?>,
                <?= $wfhCount ?>
            ],
            backgroundColor: ['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350'],
        
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

<script>
        var ctx3 = document.getElementById('chart2').getContext('2d');
        var chart2 = new Chart(ctx3, {
        type: 'pie',
        data: {
            labels: [ 'WFO','WFH','Sakit','Izin', 'Alpha'],
            datasets: [{
            data: [
                <?= $persen_sakit ?? 0 ?>,
                <?= $persen_alpha ?? 0 ?>,
                <?= $persen_wfo ?? 0 ?>,
                <?= $persen_izin ?? 0 ?>,
                <?= $persen_wfh ?? 0 ?>
            ],
            backgroundColor:['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350'],
            hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                enabled: true,
            }
            }
        }
        });

        
    
    </script>

    

<?= $this->endSection() ?>