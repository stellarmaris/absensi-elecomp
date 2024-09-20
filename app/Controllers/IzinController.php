<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;
use DateTime;

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
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $time = $this->request->getPost('time');
        $status = $this->request->getPost('status');
        $kegiatan = $this->request->getPost('kegiatan');


        // Cek apakah semua field diisi
        if (!$startDate || !$endDate || !$time || !$status) {
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
            'start_date' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal mulai wajib diisi.',
                    'valid_date' => 'Format tanggal mulai tidak valid.'
                ]
            ],
            'end_date' => [
                'label' => 'Tanggal Akhir',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal akhir wajib diisi.',
                    'valid_date' => 'Format tanggal akhir tidak valid.'
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
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->withInput()->with('errors', ['foto' => 'File foto gagal diupload.']);
        }

        $newName = $file->getRandomName();
        if (!$file->move('uploads/photos', $newName)) {
            return redirect()->back()->withInput()->with('errors', ['foto' => 'Gagal memindahkan file foto.']);
        }

        $presensiModel = new presensiModel();

        // Buat rentang tanggal dari start_date ke end_date
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);

        // Inisialisasi array untuk menyimpan tanggal yang gagal disimpan
        $failedDates = [];

        while ($startDateTime <= $endDateTime) {
            // Cek apakah hari bukan hari Minggu (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
            if ($startDateTime->format('w') != 0) {
                $data = [
                    'id_magang' => $idMagang,
                    'tanggal' => $startDateTime->format('Y-m-d'),
                    'jam_masuk' => $time,
                    'status' => $status,
                    'foto' => $newName,
                    'verifikasi' => 'Pending',
                    'kegiatan'=> $kegiatan
                ];

                // Simpan data ke database
                if (!$presensiModel->save($data)) {
                    // Jika gagal, simpan tanggalnya untuk ditampilkan ke user
                    $failedDates[] = $startDateTime->format('Y-m-d');
                }
            }
            // Tambah satu hari ke tanggal
            $startDateTime->modify('+1 day');
        }

        if (!empty($failedDates)) {
            // Jika ada tanggal yang gagal disimpan
            $errorMsg = 'Gagal menyimpan data perizinan untuk tanggal: ' . implode(', ', $failedDates);
            return redirect()->back()->withInput()->with('error', $errorMsg);
        }

        // Simpan status izin ke dalam sesi
        session()->setFlashdata('status_izin', $status);

        // Redirect ke halaman sukses
        return redirect()->to('/success-izin')->with('message', 'Perizinan berhasil diupload.');
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
