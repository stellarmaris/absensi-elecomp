<?php

namespace App\Controllers;
use App\Models\presensiModel;

class checklistController extends BaseController
{
    public function checklist()
    {
        // Pastikan pengguna telah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $ModelPresensi = new presensiModel();
        $viewAll = $this->request->getGet('view_all');

        // Periksa apakah dalam mode "View All" atau pagination biasa
        if ($viewAll) {
            // Jika View All, ambil semua data tanpa pagination
            $data['presensi'] = $ModelPresensi->where('id_magang', $userId)->findAll();
            $data['pager'] = null; // Tidak perlu pager
        } else {
            // Jika pagination, ambil data dengan paginate
            $dataPerPage = 10; // Jumlah data per halaman
            $data['presensi'] = $ModelPresensi->where('id_magang', $userId)->paginate($dataPerPage, 'presensi');
            $data['pager'] = $ModelPresensi->pager; // Menyimpan pager untuk view
        }

        $data['title'] = 'Checklist';
        $data['viewAll'] = $viewAll;

        // Tampilkan view dengan data yang dikirim
        echo view('checklist', $data);
    }
}
