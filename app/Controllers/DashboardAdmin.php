<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;

class dashboardadmin extends BaseController
{
    public function index()
    {
        
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $ModelPresensi = new presensiModel();

        // Dapatkan tanggal hari ini
        $tanggalHariIni = date('Y-m-d');
        $perPage = 10; // Users per page

        $data['data_presensi'] = $ModelPresensi
            ->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->where('tanggal', $tanggalHariIni)
            ->orderBy('jam_masuk', 'desc')
            ->paginate($perPage, 'presensi');

         // Generate pagination links
         $data['pager'] = $ModelPresensi->pager;

        $data['tanggal_hari_ini'] = $this->getTanggalHariIni();
        $this->rekapitulasiHariIni($data);
        
        $data['total_user'] = $this->getTotalUser();
        
        $data['title'] = 'Dashboard Admin';
        return view('dashboardadmin', $data);
    }

    
    private function getTanggalHariIni(): string
    {
        $hari = date('l');
        $tanggal = date('j');
        $bulan = date('F');
        $tahun = date('Y');

        $namaHari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $namaBulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $namaHari[$hari] . ', ' . $tanggal . ' ' . $namaBulan[$bulan] . ' ' . $tahun;
    }

    private function rekapitulasiHariIni(&$data)
    {
        $ModelPresensi = new presensiModel();
        $tanggal_hari_ini = date('Y-m-d');
        $data['total_hadir'] = $ModelPresensi->groupStart()
            ->where('status', 'WFO')
            ->orWhere('status', 'WFH')
            ->groupEnd()
            ->where('tanggal', $tanggal_hari_ini)
            ->countAllResults();
        $data['total_sakit'] = $ModelPresensi->where('status', 'SAKIT')->where('tanggal', $tanggal_hari_ini)->countAllResults();
        $data['total_izin'] = $ModelPresensi->where('status', 'IZIN')->where('tanggal', $tanggal_hari_ini)->countAllResults();
        $data['total_alpha'] = $ModelPresensi->where('status', 'ALPHA')->where('tanggal', $tanggal_hari_ini)->countAllResults();
        $data['total_rekap'] = $data['total_hadir'] + $data['total_sakit'] + $data['total_izin'] + $data['total_alpha'];
    }
    
    private function getTotalUser(): int
    {
        $ModelUser = new UserModel();
        return $ModelUser->where('role', 'user')->countAllResults();
    }

}