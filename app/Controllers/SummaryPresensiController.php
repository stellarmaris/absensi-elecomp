<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;

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
            ->where('tanggal', $today) // Filter untuk tanggal hari ini
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
            'persen_alpha' => $dataPresensiBulan['persen_alpha']
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
}