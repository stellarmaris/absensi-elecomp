<?php

namespace App\Controllers;

use App\Models\presensiModel;

class RekapitulasiAbsen extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $userId = session()->get('user_id');
        $modelPresensi = new presensiModel();
    
        // Ambil nilai pencarian dari input search
        $search = $this->request->getGet('search');
        $tanggal = $this->request->getGet('tanggal');
        $currentPage = $this->request->getGet('page') ?? 1;
        $perPage = 5;

        $builder = $modelPresensi->select('presensi.*, user.nama as Nama')
                                 ->join('user', 'user.id_magang = presensi.id_magang');

        // Jika ada filter pencarian
        if ($search) {
            $builder->like('user.nama', $search);
        }
    
        // Jika ada filter tanggal
        if ($tanggal) {
            $builder->where('presensi.tanggal', $tanggal);
        }
    
        // Ambil data dengan pagination
        $data['data_presensi'] = $builder
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage, 'presensi', $currentPage);

        $data['pager'] = $modelPresensi->pager;
        $data['search'] = $search;
        $data['tanggal_pilih'] = $tanggal;
        $data['title'] = 'Rekapitulasi Absensi';
    
        return view('rekapitulasi', $data);
    }

    public function Filtertanggal()
    {
        $tanggal = $this->request->getGet('tanggal');
        $modelPresensi = new presensiModel();
    
        $currentPage = $this->request->getGet('page') ?? 1;
        $perPage = 5;

        // paginate sesuai tanggal
        $builder = $modelPresensi->select('presensi.*, user.nama as Nama')
                                 ->join('user', 'user.id_magang = presensi.id_magang');
    
        if ($tanggal) {
            $builder->where('tanggal', $tanggal);
        }
    
        // Ambil data dengan pagination
        $data['data_presensi'] = $builder
            ->orderBy('tanggal', 'desc')
            ->paginate($perPage, 'presensi', $currentPage);

        $data['pager'] = $modelPresensi->pager;
        $data['tanggal_pilih'] = $tanggal;
        $data['title'] = 'Rekapitulasi Absensi';
    
        return view('rekapitulasi', $data);
    }

    public function delete($id_presensi)
    {
        $modelPresensi = new presensiModel();
        $modelPresensi->delete($id_presensi);
        
        return redirect()->to(site_url('rekapitulasi'))->with('success', 'Data berhasil dihapus.');
    }

    public function detail($id_presensi)
    {
        $modelPresensi = new presensiModel();

        // Dapatkan data presensi berdasarkan id
        $data['presensi'] = $modelPresensi
            ->select('presensi.*, user.nama as Nama')
            ->join('user', 'user.id_magang = presensi.id_magang')
            ->where('id_presensi', $id_presensi)
            ->first();

        if (!$data['presensi']) {
            return redirect()->to(site_url('rekapitulasi'))->with('error', 'Data tidak ditemukan.');
        }

        $data['title'] = 'Detail Presensi';
        return view('detailpresensi', $data);
    }
}