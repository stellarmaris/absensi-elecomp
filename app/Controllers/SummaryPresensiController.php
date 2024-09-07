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

        // Mendapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Inisialisasi Model Presensi
        $ModelPresensi = new presensiModel();

        // Hitung jumlah presensi untuk hari ini berdasarkan status
        $alphaCount = $ModelPresensi->where('status', 'Alpha')
            ->where('tanggal', $today)
            ->countAllResults();
        $sakitCount = $ModelPresensi->where('status', 'Sakit')
            ->where('tanggal', $today)
            ->countAllResults();
        $ijinCount = $ModelPresensi->where('status', 'Ijin')
            ->where('tanggal', $today)
            ->countAllResults();
        $wfoCount = $ModelPresensi->where('status', 'WFO')
            ->where('tanggal', $today)
            ->countAllResults();
        $wfhCount = $ModelPresensi->where('status', 'WFH')
            ->where('tanggal', $today)
            ->countAllResults();

        // Dapatkan data presensi per bulan
        $dataPresensiBulan = $this->presensiPerBulan();

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Summary Presensi Hari Ini',
            'alphaCount' => $alphaCount,
            'sakitCount' => $sakitCount,
            'ijinCount' => $ijinCount,
            'wfoCount' => $wfoCount,
            'wfhCount' => $wfhCount,
            'persen_wfo' => $dataPresensiBulan['persen_wfo'],
            'persen_wfh' => $dataPresensiBulan['persen_wfh'],
            'persen_izin' => $dataPresensiBulan['persen_izin'],
            'persen_sakit' => $dataPresensiBulan['persen_sakit'],
            'persen_alpha' => $dataPresensiBulan['persen_alpha'],
            'presensi_perbulan' => $this->getTahun() // Panggil method getTahun untuk grafik per tahun
        ];

        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
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
        $tahun = $tahun ? $tahun : date('Y'); // Jika tidak ada tahun dipilih, gunakan tahun saat ini
    
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
        // Periksa apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $tahunDipilih = $this->request->getGet('tahun');
    
        // Jika tahun tidak dipilih, default ke tahun sekarang
        $tahun = $tahunDipilih ? $tahunDipilih : date('Y');

        $ModelPresensi = new presensiModel();
        $dataPresensiBulan = $this->presensiPerBulan(); 
    
        // Hitung jumlah presensi berdasarkan status untuk tahun yang dipilih
        $alphaCount = $ModelPresensi->where('status', 'Alpha')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
        $sakitCount = $ModelPresensi->where('status', 'Sakit')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
        $ijinCount = $ModelPresensi->where('status', 'Ijin')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
        $wfoCount = $ModelPresensi->where('status', 'WFO')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
        $wfhCount = $ModelPresensi->where('status', 'WFH')
            ->where('YEAR(tanggal)', $tahun)
            ->countAllResults();
    
        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Summary Presensi Tahun ' . $tahun,
            'alphaCount' => $alphaCount,
            'sakitCount' => $sakitCount,
            'ijinCount' => $ijinCount,
            'wfoCount' => $wfoCount,
            'wfhCount' => $wfhCount,
            'persen_wfo' => $dataPresensiBulan['persen_wfo'], 
            'persen_wfh' => $dataPresensiBulan['persen_wfh'],
            'persen_izin' => $dataPresensiBulan['persen_izin'],
            'persen_sakit' => $dataPresensiBulan['persen_sakit'],
            'persen_alpha' => $dataPresensiBulan['persen_alpha'],
            'presensi_perbulan' => $this->getTahun($tahun), 
            'tahunDipilih' => $tahun
        ];
    
        return view('summaryPresensi', $data);
    }
    

}
