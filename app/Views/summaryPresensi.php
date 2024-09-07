<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/grafik.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- kartu judul -->
    <div class="card title-card">
        <div class="card-body">
            <h3 class="card-title bold-text">Statistik Absensi</h3>
            <p>Rekapitulasi Absensi Dalam Bentuk Diagram dan Grafik</p>
        </div>
    </div>


    <!-- Chart per hari dan per bulan -->
    <div class="chart-container">
        <div class="kartu">
            <h5>Chart Presensi Per Hari</h5>
            <canvas id="myPieChart"></canvas>
        </div>
        <div class="kartu">
            <h5>Chart Presensi Per Bulan</h5>
            <canvas id="chart2"></canvas>
        </div>
    </div>

    <div class="kartu2">
        <h5>Chart Presensi Per Tahun</h5>
        <!-- Filter form -->
        <div class="filter">
            <form action="<?= site_url('/SummaryPresensiController/filter') ?>" method="get" class="d-flex">
                <select id="year" name="tahun" class="form-control custom">
                    <option value="">Pilih Tahun</option>
                    <?php
                    $currentYear = date('Y');
                    for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                        $selected = (isset($tahunDipilih) && $tahunDipilih == $i) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn custom-btn">Tampilkan Data</button>
            </form>

        </div>

        <!-- Chart per tahun -->
        <div class="chart-container">
            <canvas id="presensiChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Data dari PHP
    const dataPerBulan = <?= json_encode($presensi_perbulan) ?>;
    const allMonths = {
        1: 'Januari', 2: 'Februari', 3: 'Maret', 4: 'April', 5: 'Mei', 6: 'Juni',
        7: 'Juli', 8: 'Agustus', 9: 'September', 10: 'Oktober', 11: 'November', 12: 'Desember'
    };
    const labelsBulan = Object.keys(allMonths).map(bulan => allMonths[bulan]);
    const datasetLabels = ['WFO', 'WFH', 'Sakit', 'Izin', 'Alpha'];
    const datasetColors = ['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350'];

    const datasets = datasetLabels.map((label, index) => ({
        label: label,
        data: labelsBulan.map((_, index) => {
            const bulan = index + 1;
            return dataPerBulan[bulan] ? dataPerBulan[bulan][label] || 0 : 0;
        }),
        backgroundColor: datasetColors[index],
        borderColor: datasetColors[index],
        borderWidth: 1
    }));

    const ctx = document.getElementById('presensiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labelsBulan,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: { display: true, text: 'Bulan' }
                },
                y: {
                    title: { display: true, text: 'Jumlah' },
                    ticks: { min: 1, stepSize: 1 }
                }
            }
        }
    });

    // Pie Chart per hari
    const ctxPie = document.getElementById('myPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['WFO', 'WFH', 'Sakit', 'Izin', 'Alpha'],
            datasets: [{
                label: 'Presensi Status',
                data: [<?= $wfoCount ?>, <?= $wfhCount ?>, <?= $sakitCount ?>, <?= $ijinCount ?>, <?= $alphaCount ?>],
                backgroundColor: ['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' }, tooltip: { enabled: true } }
        }
    });

    // Pie Chart per bulan
    const ctxPie2 = document.getElementById('chart2').getContext('2d');
    new Chart(ctxPie2, {
        type: 'pie',
        data: {
            labels: ['WFO', 'WFH', 'Sakit', 'Izin', 'Alpha'],
            datasets: [{
                data: [<?= $persen_wfo ?>, <?= $persen_wfh ?>, <?= $persen_sakit ?>, <?= $persen_izin ?>, <?= $persen_alpha ?>],
                backgroundColor: ['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' }, tooltip: { enabled: true } }
        }
    });
</script>

<?= $this->endSection() ?>
