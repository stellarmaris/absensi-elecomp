<?php

namespace App\Controllers;

use App\Models\UserModel; // Ubah menjadi PascalCase
use App\Models\PresensiModel; // Ubah menjadi PascalCase

class HitungNilai extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $modelPresensi = new PresensiModel(); 
    
        $search = $this->request->getGet('search');
        $perPage = 10; // Records per page
    
        $builder = $modelPresensi->select('presensi.id_magang, user.nama as Nama, user.asal_institusi as AsalInstitusi, 
            COUNT(CASE WHEN presensi.status = "WFO" THEN 1 END) as WFO,
            COUNT(CASE WHEN presensi.status = "WFH" THEN 1 END) as WFH,
            COUNT(CASE WHEN presensi.status = "Sakit" THEN 1 END) as Sakit,
            COUNT(CASE WHEN presensi.status = "Izin" THEN 1 END) as Izin,
            COUNT(CASE WHEN presensi.status = "Alpha" THEN 1 END) as Alpha')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->groupBy('presensi.id_magang');
    
        if ($search) {
            $builder->like('user.nama', $search)
                    ->orLike('user.asal_institusi', $search);
        }
    
        $data['data_presensi'] = $builder
            ->orderBy('user.nama', 'asc')
            ->paginate($perPage, 'presensi');
    
        $data['pager'] = $modelPresensi->pager;
        $data['search'] = $search;
        $data['title'] = 'Rekapitulasi Absensi';
    
        // Hitung nilai untuk setiap entri dan total hari magang
        foreach ($data['data_presensi'] as &$presensi) {
            $presensi['totalHariMagang'] = $presensi['WFO'] + $presensi['WFH'] + $presensi['Izin'] + $presensi['Sakit'] + $presensi['Alpha'];
            $presensi['Nilai'] = $this->hitungAbsen($presensi);
        }
    
        return view('hitungnilai', $data);
    }
    
    public function hitungAbsen($presensi)
    {
        $totalHariMagang = $presensi['WFO'] + $presensi['WFH'] + $presensi['Izin'] + $presensi['Sakit'] + $presensi['Alpha'];
        $totalHadir = $presensi['WFO'] + $presensi['WFH'];
        $totalTidakHadir = $presensi['Izin'] + $presensi['Sakit'];

        if ($totalHariMagang == 0) {
            return 0;
        }

        $nilai = ($totalHadir / $totalHariMagang * 100) + ($totalTidakHadir / $totalHariMagang * 50);

        return round($nilai);//membulatkan nilai
    }
}
