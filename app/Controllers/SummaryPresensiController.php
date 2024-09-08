<?php

namespace App\Controllers;

use App\Models\presensiModel;

class SummaryPresensiController extends BaseController
{
        public function index()
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Panggil method getHari untuk menghitung data harian
        $dataHarian = $this->getHari();

        // Dapatkan data presensi per bulan
        $dataPresensiBulan = $this->presensiPerBulan();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Statistik Absensi',
            'alphaCount' => $dataHarian['alphaCount'],
            'sakitCount' => $dataHarian['sakitCount'],
            'ijinCount' => $dataHarian['ijinCount'],
            'wfoCount' => $dataHarian['wfoCount'],
            'wfhCount' => $dataHarian['wfhCount'],
            'persen_wfo' => $dataPresensiBulan['persen_wfo'],
            'persen_wfh' => $dataPresensiBulan['persen_wfh'],
            'persen_izin' => $dataPresensiBulan['persen_izin'],
            'persen_sakit' => $dataPresensiBulan['persen_sakit'],
            'persen_alpha' => $dataPresensiBulan['persen_alpha'],
            'presensi_perbulan' => $this->getTahun()
        ];

        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
    }

    public function getHari($tanggal = null)
{
    // Jika tidak ada tanggal yang dipilih, gunakan tanggal hari ini
    $tanggal = $tanggal ? $tanggal : date('Y-m-d');

    // Inisialisasi Model Presensi
    $ModelPresensi = new presensiModel();

    // Hitung jumlah presensi untuk tanggal yang dipilih berdasarkan status
    $alphaCount = $ModelPresensi->where('status', 'Alpha')
        ->where('tanggal', $tanggal)
        ->countAllResults();
    $sakitCount = $ModelPresensi->where('status', 'Sakit')
        ->where('tanggal', $tanggal)
        ->countAllResults();
    $ijinCount = $ModelPresensi->where('status', 'Ijin')
        ->where('tanggal', $tanggal)
        ->countAllResults();
    $wfoCount = $ModelPresensi->where('status', 'WFO')
        ->where('tanggal', $tanggal)
        ->countAllResults();
    $wfhCount = $ModelPresensi->where('status', 'WFH')
        ->where('tanggal', $tanggal)
        ->countAllResults();

    return [
        'alphaCount' => $alphaCount,
        'sakitCount' => $sakitCount,
        'ijinCount' => $ijinCount,
        'wfoCount' => $wfoCount,
        'wfhCount' => $wfhCount
    ];
}


    public function presensiPerBulan()
    {
        $ModelPresensi = new presensiModel();

        $month = date('m'); // Bulan saat ini
        $year = date('Y'); // Tahun saat ini

        $query = $ModelPresensi->builder()
            ->select('status, COUNT(status) as jumlah')
            ->where('MONTH(tanggal)', $month)
            ->where('YEAR(tanggal)', $year)
            ->groupBy('status')
            ->get();

        $dataPresensi = $query->getResultArray();

        $totalPresensi = 0;
        $wfo = 0;
        $wfh = 0;
        $izin = 0;
        $sakit = 0;
        $alpha = 0;

        foreach ($dataPresensi as $presensi) {
            $totalPresensi += $presensi['jumlah'];

            switch ($presensi['status']) {
                case 'WFO':
                    $wfo = $presensi['jumlah'];
                    break;
                case 'WFH':
                    $wfh = $presensi['jumlah'];
                    break;
                case 'Izin':
                    $izin = $presensi['jumlah'];
                    break;
                case 'Sakit':
                    $sakit = $presensi['jumlah'];
                    break;
                case 'Alpha':
                    $alpha = $presensi['jumlah'];
                    break;
            }
        }

        // Hitung persentase
        $persen_wfo = ($totalPresensi > 0) ? ($wfo / $totalPresensi) * 100 : 0;
        $persen_wfh = ($totalPresensi > 0) ? ($wfh / $totalPresensi) * 100 : 0;
        $persen_izin = ($totalPresensi > 0) ? ($izin / $totalPresensi) * 100 : 0;
        $persen_sakit = ($totalPresensi > 0) ? ($sakit / $totalPresensi) * 100 : 0;
        $persen_alpha = ($totalPresensi > 0) ? ($alpha / $totalPresensi) * 100 : 0;

        return [
            'persen_wfo' => $persen_wfo,
            'persen_wfh' => $persen_wfh,
            'persen_izin' => $persen_izin,
            'persen_sakit' => $persen_sakit,
            'persen_alpha' => $persen_alpha
        ];
    }

    public function getTahun($tahun = null) {
        $tahun = $tahun ? $tahun : date('Y'); 
    
        $ModelPresensi = new presensiModel();
    
        $builder = $ModelPresensi->builder();
        $builder->select("MONTH(tanggal) as bulan, status, COUNT(*) as jumlah");
        $builder->where("YEAR(tanggal)", $tahun);
        $builder->groupBy("bulan, status");
        $query = $builder->get();
    
        $results = $query->getResultArray();
    
        $data = [];
        foreach ($results as $row) {
            $bulan = $row['bulan'];
            $status = $row['status'];
            $jumlah = $row['jumlah'];
    
            if (!isset($data[$bulan])) {
                $data[$bulan] = [
                    'WFO' => 0,
                    'WFH' => 0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alpha' => 0
                ];
            }
            $data[$bulan][$status] = $jumlah;
        }
    
        return $data;
    }
    
    public function filter()
    {
        // Ambil tahun yang dipilih
        $tahunDipilih = $this->request->getGet('tahun');
        // Default
        $tahun = $tahunDipilih ? $tahunDipilih : date('Y');
    
        // Inisialisasi model presensi
        $ModelPresensi = new presensiModel();
                
        // Hitung jumlah presensi berdasarkan status untuk tahun yang dipilih
        $totalAlphaPresensi = $ModelPresensi->where('status', 'Alpha')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        $totalSakitPresensi = $ModelPresensi->where('status', 'Sakit')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        $totalIjinPresensi = $ModelPresensi->where('status', 'Ijin')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        $totalWfoPresensi = $ModelPresensi->where('status', 'WFO')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

        $totalWfhPresensi = $ModelPresensi->where('status', 'WFH')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();

    
        // Data Harian
        $dataHarian = $this->getHari();
    
        // Data per bulan
        $dataPresensiBulan = $this->presensiPerBulan();
    
        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Statistik Absensi',
            'alphaCount' => $dataHarian['alphaCount'],
            'sakitCount' => $dataHarian['sakitCount'],
            'ijinCount' => $dataHarian['ijinCount'],
            'wfoCount' => $dataHarian['wfoCount'],
            'wfhCount' => $dataHarian['wfhCount'],
            'totalAlphaPresensi' => $totalAlphaPresensi,
            'totalSakitPresensi' => $totalSakitPresensi,
            'totalIjinPresensi' => $totalIjinPresensi,
            'totalWfoPresensi' => $totalWfoPresensi,
            'totalWfhPresensi' => $totalWfhPresensi,
            'persen_wfo' => $dataPresensiBulan['persen_wfo'],
            'persen_wfh' => $dataPresensiBulan['persen_wfh'],
            'persen_izin' => $dataPresensiBulan['persen_izin'],
            'persen_sakit' => $dataPresensiBulan['persen_sakit'],
            'persen_alpha' => $dataPresensiBulan['persen_alpha'],
            'presensi_perbulan' => $this->getTahun($tahun),
            'tahunDipilih' => $tahun
        ];
    
        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
    }
    
    public function filterHari()
    {
        // Ambil hari
        $hariDipilih = $this->request->getGet('hari');
    
        // Default hari 
        $hari = $hariDipilih ? $hariDipilih : date('l'); 
    
        // Mendapatkan tanggal untuk hari 
        $today = new \DateTime();
        $today->modify('this week ' . $hari);
        $selectedDate = $today->format('Y-m-d');
    
        // Data Harian
        $dataHarian = $this->getHari($selectedDate);
    
        // Data per bulan
        $dataPresensiBulan = $this->presensiPerBulan();
    
        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Statistik Absensi',
            'alphaCount' => $dataHarian['alphaCount'],
            'sakitCount' => $dataHarian['sakitCount'],
            'ijinCount' => $dataHarian['ijinCount'],
            'wfoCount' => $dataHarian['wfoCount'],
            'wfhCount' => $dataHarian['wfhCount'],
            'persen_wfo' => $dataPresensiBulan['persen_wfo'],
            'persen_wfh' => $dataPresensiBulan['persen_wfh'],
            'persen_izin' => $dataPresensiBulan['persen_izin'],
            'persen_sakit' => $dataPresensiBulan['persen_sakit'],
            'persen_alpha' => $dataPresensiBulan['persen_alpha'],
            'presensi_perbulan' => $this->getTahun(),
            'hariDipilih' => $hariDipilih
        ];
    
        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
    }
    
}
