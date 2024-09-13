<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;

class IzinController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');

        // Fetch additional user data if needed
        $userModel = new UserModel();
        $userData = $userModel->find($userId);

        // Merge session data with additional data (if any)
        $data = array_merge(session()->get(), $userData);

        // Add title data
        $data['title'] = 'Form Perizinan';

        return view('izin_form', $data);
    }

    public function store()
    {
        $idMagang = session()->get('user_id');
        $date = $this->request->getPost('date');
        $time = $this->request->getPost('time');
        $status = $this->request->getPost('status');
        $kegiatan = $this->request->getPost('kegiatan');


        // Cek apakah semua field diisi
        if (!$date || !$time || !$status) {
            return redirect()->back()->withInput()->with('error', 'Semua field harus diisi.');
        }

        // Definisikan aturan validasi
        $validationRules = [
            'foto' => [
                'label' => 'Foto Bukti',
                'rules' => 'uploaded[foto]|max_size[foto,1024]|ext_in[foto,png,jpg,jpeg]',
                'errors' => [
                    'uploaded' => 'File foto wajib diupload.',
                    'max_size' => 'Ukuran file foto tidak boleh lebih dari 1MB.',
                    'ext_in' => 'Ekstensi file foto harus berupa: png, jpg, atau jpeg.',
                ]
            ],
            'date' => [
                'label' => 'Tanggal Perizinan',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal perizinan wajib diisi.',
                    'valid_date' => 'Format tanggal perizinan tidak valid.'
                ]
            ],
            'time' => [
                'label' => 'Waktu Perizinan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Waktu perizinan wajib diisi.',
                ]
            ],
            'status' => [
                'label' => 'Status Perizinan',
                'rules' => 'required|in_list[sakit,izin]',
                'errors' => [
                    'required' => 'Status perizinan wajib diisi.',
                    'in_list' => 'Status perizinan tidak valid.'
                ]
            ],
        ];

        // Lakukan validasi
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Proses upload file
        $file = $this->request->getFile('foto');

        // Cek apakah file valid dan tidak ada error
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->withInput()->with('errors', ['foto' => 'File foto gagal diupload.']);
        }

        // Generate nama file baru
        $newName = $file->getRandomName();

        // Pindahkan file ke direktori tujuan
        if (!$file->move('uploads/photos', $newName)) {
            return redirect()->back()->withInput()->with('errors', ['foto' => 'Gagal memindahkan file foto.']);
        }

        // Simpan data ke database
        $presensiModel = new presensiModel();

        $data = [
            'id_magang' => $idMagang,
            'tanggal' => $date,
            'jam_masuk' => $time,
            'status' => $status,
            'foto' => $newName,
            'verifikasi' => 'Pending',
            'kegiatan'=> $kegiatan
        ];

        // Try to save the data
        if ($presensiModel->save($data)) {
            // Simpan status izin ke dalam sesi
            session()->setFlashdata('status_izin', $status);

            // Redirect ke halaman sukses
            return redirect()->to('/success-izin')->with('message', 'Perizinan berhasil diupload.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data perizinan.');
        }
    }

    public function success()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data['title'] = 'Perizinan Sukses';
        $data['message'] = session()->getFlashdata('message') ?? 'Perizinan berhasil diupload.';

        return view('success_izin', $data);
    }
}
