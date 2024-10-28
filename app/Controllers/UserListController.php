<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserListController extends BaseController
{
<<<<<<< HEAD
      public function index()
=======
    public function index()
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $ModelUser = new UserModel(); // Ensure this matches your user model
    
        // Get search input
        $search = $this->request->getVar('search');
        $perPage = 10; // Users per page
    
        // If a search query is provided, filter the user data
        if ($search) {
            $data['data_user'] = $ModelUser
                ->where('role', 'user')
                ->like('nama', $search)
                ->orLike('email', $search)
                ->orLike('Jenis_kelamin', $search)
                ->orLike('Nomor_telepon', $search)
                ->orderBy('nama', 'asc')
                ->paginate($perPage, 'presensi');
        } else {
            $data['data_user'] = $ModelUser
                ->where('role', 'user')
                ->orderBy('nama', 'asc')
                ->paginate($perPage, 'presensi');
        }
    
        // Generate pagination links
        $data['pager'] = $ModelUser->pager;
    
        // Pass the search term back to the view for display
        $data['search'] = $search;
        $data['title'] = 'All Users';
        return view('user_list', $data);
    }
    
<<<<<<< HEAD
=======
    private function getTanggalHariIni(): string
    {
        $hari = date('l');
        $tanggal = date('j');
        $bulan = date('F');
        $tahun = date('Y');

        $namaHari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $namaBulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $namaHari[$hari] . ', ' . $tanggal . ' ' . $namaBulan[$bulan] . ' ' . $tahun;
    }
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
    public function detail($id_magang)
    {
        $ModelUser = new UserModel();

        // Dapatkan data user berdasarkan id_magang
        $data['user'] = $ModelUser
            ->where('id_magang', $id_magang)
            ->first();

        if (!$data['user']) {
            return redirect()->to(site_url('dashboardadmin'))->with('error', 'Data pengguna tidak ditemukan.');
        }

        $data['title'] = 'Detail Pengguna';
<<<<<<< HEAD
        return view('detailUser', $data);
=======
        return view('detailuser', $data);
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
    }

    public function edit($id)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            return redirect()->to('/user-list')->with('error', 'User not found');
        }

        // Define the title and pass it to the view
        $data = [
            'title' => 'Edit Profil',
            'user' => $user,
        ];

        return view('useredit', $data);
    }



    public function update($id)
    {

        $userModel = new UserModel();

        $rules = [
            'nama' => [
                'label' => 'Nama lengkap',
                'rules' => 'permit_empty|min_length[3]|max_length[255]',
                'errors' => [
                    'min_length' => '{field} minimal 3 karakter.',
                    'max_length' => '{field} maksimal 255 karakter'
                ]
            ],
            'telepon' => [
                'label' => 'Nomor telepon',
                'rules' => 'permit_empty|min_length[10]|max_length[15]',
                'errors' => [
                    'min_length' => '{field} minimal 10 karakter.',
                    'max_length' => '{field} maksimal 15 karakter'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'permit_empty|min_length[8]|regex_match[/(?=.*[0-9])(?=.*[\W])/]',
                'errors' => [
                    'min_length' => '{field} minimal 8 karakter.',
                    'regex_match' => '{field} harus terdiri dari huruf, angka, dan karakter spesial (@,#,!,?, dll).'
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $dataUser = [
                'Nama' => $this->request->getPost('nama'),
                'Nomor_telepon' => $this->request->getPost('telepon'),
                'alamat' => $this->request->getPost('alamat'),
            ];

            if ($this->request->getPost('password')) {
                $dataUser['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }

            // Debug dataUser
            // dd($dataUser, $id);

            $userModel->update($id, $dataUser);

            return redirect()->to('/user-list');
        }
    }
    public function delete($id_magang)
    {
        // Inisialisasi model UserModel
        $userModel = new UserModel();

        // Periksa apakah pengguna dengan ID tersebut ada
        $user = $userModel->find($id_magang);

        if ($user) {
            // Hapus pengguna berdasarkan ID
            if ($userModel->delete($id_magang)) {
                // Set flashdata untuk pesan sukses
                session()->setFlashdata('success', 'Pengguna berhasil dihapus.');
            } else {
                // Set flashdata untuk pesan error
                session()->setFlashdata('error', 'Pengguna gagal dihapus.');
            }
        } else {
            // Set flashdata untuk pesan error jika pengguna tidak ditemukan
            session()->setFlashdata('error', 'Pengguna tidak ditemukan.');
        }

        // Redirect ke halaman daftar pengguna
        return redirect()->to('/user-list');
    }
}
