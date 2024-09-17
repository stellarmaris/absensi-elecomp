<?php

namespace App\Controllers;

use App\Models\UserModel; 
use App\Models\PresensiModel; 

class HitungNilaiUser extends BaseController
{
    public function index()
    {
        // Pastikan pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Dapatkan ID pengguna dari session
        $userId = session()->get('user_id');
    
        // Inisialisasi model Presensi
        $modelPresensi = new PresensiModel(); 

        // Query untuk mendapatkan total status kehadiran
        $presensi = $modelPresensi->select('
            COUNT(CASE WHEN status = "WFO" THEN 1 END) as WFO,
            COUNT(CASE WHEN status = "WFH" THEN 1 END) as WFH,
            COUNT(CASE WHEN status = "Sakit" THEN 1 END) as Sakit,
            COUNT(CASE WHEN status = "Izin" THEN 1 END) as Izin,
            COUNT(CASE WHEN status = "Alpha" THEN 1 END) as Alpha
        ')
        ->where('id_magang', $userId)
        ->get()
        ->getRowArray();

        // Data yang akan dikirim ke view
        $data = [
            'total_hadir' => $presensi['WFO'] + $presensi['WFH'],
            'total_sakit' => $presensi['Sakit'],
            'total_izin' => $presensi['Izin'],
            'total_alpha' => $presensi['Alpha'],
            'total_user' => array_sum($presensi),
            'nilai_user' => $this->hitungAbsen($presensi),
            'title' => 'Rekapitulasi Absensi'
        ];

        return view('hitungnilaiuser', $data);
    }

    private function hitungAbsen($presensi)
    {
        $totalHariMagang = array_sum($presensi);
        $totalHadir = $presensi['WFO'] + $presensi['WFH'];
        $totalTidakHadir = $presensi['Izin'] + $presensi['Sakit'];

        // Jika total hari magang nol, kembalikan nilai 0
        if ($totalHariMagang == 0) return 0;

        // Hitung nilai berdasarkan kehadiran dan ketidakhadiran
        return round(($totalHadir / $totalHariMagang * 100) + ($totalTidakHadir / $totalHariMagang * 50));
    }
}
