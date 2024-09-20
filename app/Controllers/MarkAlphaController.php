<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;

class MarkAlphaController extends BaseController
{
    public function markAlpha()
    {
        // Load models
        $presensiModel = new PresensiModel();
        $magangModel = new UserModel();

        // Get current date and time
        $today = date('Y-m-d');
        $currentTime = date('H:i:s');

        // Get all users with role 'User' who haven't submitted attendance for today
        $allUsers = $magangModel->where('role', 'User')->findAll(); // Filter by role

        foreach ($allUsers as $user) {
            $attendance = $presensiModel
                ->where('id_magang', $user['id_magang'])
                ->where('tanggal', $today)
                ->first();

            // If no attendance exists for this user, create a new row with status 'Alpha'
            if (!$attendance) {
                $presensiModel->insert([
                    'id_magang' => $user['id_magang'],
                    'status' => 'Alpha',
                    'tanggal' => $today,
                    'jam_masuk' => $currentTime,
                    'verifikasi' => 'Sukses'
                ]);
            }
        }

        return redirect()->back()->with('message', 'Attendance marked for absent users with role User.');
    }
    public function updateStatusAlpha($id_presensi)
    {
        // Memanggil model presensi
        $presensiModel = new PresensiModel();

        // Mengambil keterangan dari query parameter
        $keterangan = $this->request->getGet('keterangan');

        // Update status menjadi 'alpha'
        $data = [
            'status' => 'alpha',
            'kegiatan' => $keterangan // Menyimpan keterangan ke kolom kegiatan
        ];

        // Proses update berdasarkan id_presensi
        $presensiModel->update($id_presensi, $data);

        // Mengatur pesan sukses
        session()->setFlashdata('success', 'Status berhasil diperbarui menjadi Alpha dengan keterangan: ' . $keterangan);

        // Redirect ke halaman sebelumnya atau halaman rekapitulasi absen
        return redirect()->to(site_url('RekapitulasiAbsen'));
    }
}
