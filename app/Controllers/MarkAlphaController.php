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
}