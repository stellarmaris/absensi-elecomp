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

        //panggil tanggal grafik garis
        $endDate = $this->request->getGet('end_date')?? date('Y-m-d');
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));

        //data grafik garis per tanggal
        $presensiPerTanggal = $this->getPresensiperTanggal($startDate, $endDate);


        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Statistik Absensi',
            'alphaCount' => $dataHarian['alphaCount'],
            'sakitCount' => $dataHarian['sakitCount'],
            'ijinCount' => $dataHarian['ijinCount'],
            'wfoCount' => $dataHarian['wfoCount'],
            'wfhCount' => $dataHarian['wfhCount'],
            'presensi_perbulan' => $this->getTahun(),  
            'presensiPerTanggal'=>$presensiPerTanggal,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
        $ijinCount = $ModelPresensi->where('status', 'Izin')
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

        $totalIjinPresensi = $ModelPresensi->where('status', 'Izin')
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
        
          //panggil tanggal dan method grafik garis
          $endDate = $this->request->getGet('end_date')?? date('Y-m-d');
          $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
          $presensiPerTanggal = $this->getPresensiperTanggal($startDate, $endDate);
    
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
            'presensi_perbulan' => $this->getTahun($tahun),
            'tahunDipilih' => $tahun,
             'startDate' => $startDate,
             'endDate' => $endDate,
            'presensiPerTanggal'=>$presensiPerTanggal,
        ];
    
        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
    }
    
    public function filterTanggal()
    {
        // Ambil tanggal yang dipilih dari form
        $tanggalDipilih = $this->request->getGet('tanggal');
        
        // Jika tidak ada tanggal yang dipilih, gunakan tanggal hari ini
        $tanggal = $tanggalDipilih ? $tanggalDipilih : date('Y-m-d');
    
        // Ambil data presensi berdasarkan tanggal yang dipilih menggunakan method getHari()
        $dataHarian = $this->getHari($tanggal);
        
        //panggil tanggal dan method grafik garis
        $endDate = $this->request->getGet('end_date')?? date('Y-m-d');
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $presensiPerTanggal = $this->getPresensiperTanggal($startDate, $endDate);

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Statistik Absensi',
            'alphaCount' => $dataHarian['alphaCount'],
            'sakitCount' => $dataHarian['sakitCount'],
            'ijinCount' => $dataHarian['ijinCount'],
            'wfoCount' => $dataHarian['wfoCount'],
            'wfhCount' => $dataHarian['wfhCount'],
            'presensi_perbulan' => $this->getTahun(),
            'tanggalDipilih' => $tanggal,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'presensiPerTanggal'=>$presensiPerTanggal,
        ];
    
        // Return view dengan data yang sudah difilter berdasarkan tanggal
        return view('summaryPresensi', $data);
    }

    // ================= GRAFIK GARIS ==========
    public function getPresensiperTanggal($startDate, $endDate){
        $ModelPresensi = new presensiModel();

        $builder = $ModelPresensi->builder();
        $builder->select("tanggal, status, COUNT(*) as jumlah");
        $builder->where("tanggal >=", $startDate);
        $builder->where ("tanggal <=",$endDate);
        $builder->groupBy("tanggal, status");
        $query = $builder->get();

        $results=$query->getResultArray();

        // DATA UNTUK CHARTNYA

        $data = [];
        foreach($results as $row){
            $tanggal = $row['tanggal'];
            $status = $row['status'];
            $jumlah = $row['jumlah'];

            if(!isset($data[$tanggal])){
                $data[$tanggal] =[
                    'WFO'=>0,
                    'WFH'=>0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alpha' => 0
                ];
            }

            $data[$tanggal][$status]= $jumlah;
        }

        return $data;
    }


    
    
}