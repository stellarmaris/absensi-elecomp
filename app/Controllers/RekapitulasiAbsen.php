<?php

namespace App\Controllers;

use App\Models\presensiModel;
<<<<<<< HEAD
=======
use App\Models\UserModel;
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4

class RekapitulasiAbsen extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $modelPresensi = new presensiModel();
    
        // Ambil nilai pencarian dan tanggal dari input
        $search = $this->request->getGet('search');
        $tanggal = $this->request->getGet('tanggal');
<<<<<<< HEAD
        $perPage = 12; // Records per page

        // Ambil data dengan pagination
        $builder = $modelPresensi->select('presensi.*, user.nama as Nama')
                                 ->join('user', 'user.id_magang = presensi.id_magang');
=======
        $perPage = 10; // Records per page

        // Ambil data dengan pagination
        $builder = $modelPresensi->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang');
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4

        if ($search) {
            $builder->like('user.nama', $search);
        }
    
        if ($tanggal) {
            $builder->where('presensi.tanggal', $tanggal);
        }
    
        // Pagination logic
        $data['data_presensi'] = $builder
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage, 'presensi');
        
        $data['pager'] = $modelPresensi->pager;
        $data['search'] = $search;
        $data['tanggal_pilih'] = $tanggal;
        $data['title'] = 'Rekapitulasi Absensi';
<<<<<<< HEAD
    
=======

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        return view('rekapitulasi', $data);
    }

    public function Filtertanggal()
    {
        $tanggal = $this->request->getGet('tanggal');
        $modelPresensi = new presensiModel();
    
        $perPage = 5; // Records per page

        // Filter data sesuai tanggal
        $builder = $modelPresensi->select('presensi.*, user.nama as Nama')
<<<<<<< HEAD
                                 ->join('user', 'user.id_magang = presensi.id_magang');
    
=======
            ->join('user', 'user.id_magang = presensi.id_magang');

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        if ($tanggal) {
            $builder->where('tanggal', $tanggal);
        }
    
        // Pagination logic
        $data['data_presensi'] = $builder
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage, 'presensi');
        
        $data['pager'] = $modelPresensi->pager;
        $data['tanggal_pilih'] = $tanggal;
        $data['title'] = 'Rekapitulasi Absensi';
<<<<<<< HEAD
    
=======

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        return view('rekapitulasi', $data);
    }

    public function delete($id_presensi)
    {
        $modelPresensi = new presensiModel();
        $modelPresensi->delete($id_presensi);
<<<<<<< HEAD
        
        return redirect()->to(site_url('/RekapitulasiAbsen'))->with('success', 'Data berhasil dihapus.');
=======

        return redirect()->to(site_url('rekapitulasi'))->with('success', 'Data berhasil dihapus.');
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
    }

    public function detail($id_presensi)
    {
        $modelPresensi = new presensiModel();

        $data['presensi'] = $modelPresensi
            ->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->where('id_presensi', $id_presensi)
            ->first();

<<<<<<< HEAD
=======
        if (!$data['presensi']) {
            return redirect()->to(site_url('rekapitulasi'))->with('error', 'Data tidak ditemukan.');
        }

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        $data['title'] = 'Detail Presensi';
        return view('detailpresensi', $data);
    }
}
