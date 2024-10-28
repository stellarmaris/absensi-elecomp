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
<<<<<<< HEAD
        $perPage=6;
        
        $viewAll = $this->request->getGet('view_all');
=======
       
        $viewAll = $this->request->getGet('view_all');

        $perPage= 5;
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4

        $query = $ModelPresensi->where('id_magang',$userId);

        if ($tanggal) {
            $query = $query->where('tanggal', $tanggal);
        }
<<<<<<< HEAD
        
        if($viewAll){
            $data['data_presensi'] = $query->orderBy('tanggal', 'ASC')->findAll();
        }else{
            $data['data_presensi'] = $query ->orderBy('tanggal','DESC')
                                        ->paginate($perPage,'presensi');
        }
=======

        if($viewAll){
            $data['data_presensi'] = $query->orderBy('tanggal', 'ASC')->findAll();
        }else{
            $data['data_presensi'] = $query ->orderBy('tanggal','DESC')      
                                      ->paginate($perPage,'presensi');
        }
        
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
        $data['pager'] = $ModelPresensi->pager;

       $data['tanggal'] = $tanggal;
       $data['title'] = 'Riwayat';
       $data['currentPage'] = $currentPage;
       $data['perPage'] = $perPage;
<<<<<<< HEAD
       $data['viewAll'] = $viewAll;
    
       echo view ('riwayat',$data);
=======
       //$data['makeClickableLinks'] = [$this, 'makeClickableLinks'];
        $data['viewAll'] = $viewAll;
       echo view ('riwayat', $data);
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4

    
    }

     // Fungsi untuk membuat URL menjadi link
     public function makeClickableLinks($text) {
        $pattern = '/(https?:\/\/[^\s]+)/';
        $text = preg_replace($pattern, '<a href="$1" target="_blank">$1</a>', $text);
        return $text;
    }
    

  
}
