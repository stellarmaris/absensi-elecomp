<?php

namespace App\Controllers;
use App\Models\presensiModel;
use App\Models\UserModel;

class historyUserController extends BaseController
{

    public function riwayat()
    {
    
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');


        $ModelPresensi= new presensiModel();
        
        $tanggal = $this->request->getGet('tanggal');
        $currentPage = $this->request->getGet('page_presensi') ?? 1;
        $perPage=5;

        $query = $ModelPresensi->where('id_magang',$userId);

        if ($tanggal) {
            $query = $query->where('tanggal', $tanggal);
        }

        $data['data_presensi'] = $query ->orderBy('tanggal','DESC')
                                        ->paginate($perPage,'presensi');

        $data['pager'] = $ModelPresensi->pager;

       $data['tanggal'] = $tanggal;
       $data['title'] = 'Riwayat';
       $data['currentPage'] = $currentPage;
       $data['perPage'] = $perPage;
       $data['makeClickableLinks'] = [$this, 'makeClickableLinks'];
    
       echo view ('riwayat', $data);

    
    }

     // Fungsi untuk membuat URL menjadi link
     public function makeClickableLinks($text) {
        $pattern = '/(https?:\/\/[^\s]+)/';
        $text = preg_replace($pattern, '<a href="$1" target="_blank">$1</a>', $text);
        return $text;
    }
    

  
}
