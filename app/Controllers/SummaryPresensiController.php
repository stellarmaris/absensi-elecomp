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

        // Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Summary Presensi Hari Ini',
            'alphaCount' => $alphaCount,
            'sakitCount' => $sakitCount,
            'ijinCount' => $ijinCount,
            'wfoCount' => $wfoCount,
            'wfhCount' => $wfhCount
        ];

        // Return view dengan data yang sudah dihitung
        return view('summaryPresensi', $data);
    }
}
