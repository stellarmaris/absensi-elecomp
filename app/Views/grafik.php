<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/grafik.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- kartu judul -->
    <div class="card title-card">
        <div class="card-body">
            <h3 class="card-title bold-text">Grafik Rekapitulasi</h3>
            <p>Per Tahun</p>
        </div>
    </div>

    <div class="filter">
        <form action="<?= site_url('/GrafikController/filter') ?>" method="get" class="d-flex">
            <select id="year" name="tahun" class="form-control custom">
                <option value="">Pilih Tahun</option>
                <?php
                $currentYear = date('Y');
                
                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                    $selected = isset($_GET['tahun']) && $_GET['tahun'] == $i ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn custom-btn">Tampilkan Data</button>
        </form>
    </div>

    <div class="chart-container">
        <canvas id="presensiChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari PHP
        const dataPerBulan = <?php echo json_encode($presensi_perbulan); ?>;

        // Semua bulan dari Januari sampai Desember
        const allMonths = {
            1: 'Januari', 2: 'Februari', 3: 'Maret', 4: 'April', 5: 'Mei', 6: 'Juni',
            7: 'Juli', 8: 'Agustus', 9: 'September', 10: 'Oktober', 11: 'November', 12: 'Desember'
        };

        // Labels untuk grafik (bulan)
        const labelsBulan = Object.keys(allMonths).map(bulan => allMonths[bulan]);

        // Dataset untuk grafik
        const datasetLabels = ['WFO', 'WFH', 'Sakit', 'Izin', 'Alpha'];
        const datasetColors = ['#66BB6A', '#42A5F5', '#FFCA28', '#FF8A65', '#EF5350'];

        // Membuat datasets untuk setiap status
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

        // Grafik batang
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
                    legend: {
                        position: 'top',
                    },
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
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    },
                    y: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        },
                        ticks: {
                            // Atur nilai minimum
                            min: 1,
                            // Set langkah interval untuk sumbu Y
                            stepSize: 1,
                            // Format angka di sumbu Y
                            callback: function(value) {
                                return value; // Menampilkan angka pada sumbu Y
                            }
                        }
                    }
                }
            }
        });
    </script>
<?= $this->endSection() ?>
