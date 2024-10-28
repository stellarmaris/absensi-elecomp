<?php

namespace App\Controllers;
use App\Models\presensiModel;
use App\Models\UserModel;

class PiketController extends BaseController
{

    public function piket()
    {
    
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');


        $ModelPresensi= new presensiModel();
        
        $tanggal = $this->request->getGet('tanggal');
        $currentPage = $this->request->getGet('page_presensi') ?? 1;
        $perPage=6;
        
        $viewAll = $this->request->getGet('view_all');

        $query = $ModelPresensi->where('id_magang',$userId);

        if ($tanggal) {
            $query = $query->where('tanggal', $tanggal);
        }
        
        if($viewAll){
            $data['data_presensi'] = $query->orderBy('tanggal', 'ASC')->findAll();
        }else{
            $data['data_presensi'] = $query ->orderBy('tanggal','DESC')
                                        ->paginate($perPage,'presensi');
        }
        $data['pager'] = $ModelPresensi->pager;

       $data['tanggal'] = $tanggal;
       $data['title'] = 'piket';
       $data['currentPage'] = $currentPage;
       $data['perPage'] = $perPage;
       $data['viewAll'] = $viewAll;
    
       echo view ('piket',$data);

    //      // $data['data_presensi'] = $ModelPresensi->findAll();
    //     $data['data_presensi'] = $ModelPresensi->getPresensiUser($userId,$tanggal, $perPage,$offset);
        
    // //    $data['data_presensi'] = $ModelPresensi->where('id_magang',$userId)
    // //                             ->where('tanggal',$tanggal)
    // //                             ->findAll();
       
    //    $data['id_magang']= $userId;
    //     $data['tanggal'] = $tanggal;
    //     $data['title'] = 'Riwayat';
    //     $pager = \Config\Services::pager();
    //     $data['pager'] = $pager->makeLinks($page,$perPage, $total,'custom');
    //     echo view('riwayat', $data);
    }
    

  
}
