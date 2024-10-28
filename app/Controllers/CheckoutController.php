<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\presensiModel;

class CheckoutController extends BaseController
{
    public function index()

    {
        if (!session()->get('logged_in')) {
            return redirect()->to('auth/login');
        }

        $userId = session()->get('user_id');

        // Ambil data user dari usermodel
        $userModel = new UserModel();
        $userData = $userModel->find($userId);

        // data array
        $data = [
            'nama' => $userData['Nama'], // pass data Nama
        ];

        $data['title']='checkout';
        echo view('checkout',$data); 
    }

    public function checkout()
    {
        $validation = \Config\Services::validation();

        $ModelPresensi = new presensiModel();
       

        //ambil data dari form
        $id_magang = session()->get('user_id');
        $jam_keluar = $this->request->getPost('jamKeluar');
        $kegiatan = $this->request->getPost('Progress');
        $latitude_checkout = $this->request->getPost('latitude_checkout');
        $longitude_checkout = $this->request->getPost('longitude_checkout');
        
        
        // Check if location (latitude and longitude) is provided
        if (empty($latitude_checkout) || empty($longitude_checkout)) {
            return redirect()->back()->with('error', 'Lokasi tidak terdeteksi. Pastikan GPS Anda aktif dan coba lagi.');
        }

        // Membatasi waktu checkout
        $jamKeluarTimestamp = strtotime($jam_keluar);
        $batasAwal = strtotime('16:00');
        $batasAkhir = strtotime('16:30');

        if ($jamKeluarTimestamp < $batasAwal || $jamKeluarTimestamp > $batasAkhir) {
            return redirect()->back()->with('error', 'Checkout hanya dapat dilakukan antara jam 16:00 hingga 16:30.');
        }

        //cari data presensi berdasarkan tanggalnya dan id magang untuk mengupdate chekoutnya
        $tanggal = $this->request->getPost('tanggalKeluar');
        $presensi = $ModelPresensi->where('id_magang', $id_magang)
                                ->where('tanggal',$tanggal)
                                ->first();

        

        //kalau ketemu update datanya
        if($presensi){
            $ModelPresensi->update($presensi['id_presensi'],[
                'jam_keluar'=>$jam_keluar,
                'kegiatan'=>$kegiatan,
                'checkout_latitude' => $latitude_checkout,
                'checkout_longitude' => $longitude_checkout,
            ]);

            return redirect()->to('/success-checkout')->with('success','Checkout berhasil dilakukan');
        }else{
            session()->setFlashdata('error', 'Check-out gagal. Pastikan anda sudah melakukan check-in pada tanggal tersebut.');
            return redirect()->back()->withInput();
        }
        
        $data['title']='checkout';
        echo view('checkout',$data);    
    }
 }
