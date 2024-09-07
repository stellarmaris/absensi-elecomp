<?php

namespace App\Controllers;

use App\Models\presensiModel;

class GrafikController extends BaseController
{
    public function index() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $tahun = date('Y');

        // Inisialisasi Model Presensi
        $ModelPresensi = new presensiModel();

        // Mendapatkan data presensi perbulan
        $builder = $ModelPresensi->builder();
        $builder->select("MONTH(tanggal) as bulan, status, COUNT(*) as jumlah");
        $builder->where("YEAR(tanggal)", $tahun);
        $builder->groupBy("bulan, status");
        $query = $builder->get();

        $results = $query->getResultArray();

        $data = [];
        foreach ($results as $row) {
            $bulan = $row['bulan'];
            $status = $row['status'];
            $jumlah = $row['jumlah'];

            if (!isset($data[$bulan])) {
                $data[$bulan] = [
                    'WFO' => 0,
                    'WFH' => 0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alpha' => 0
                ];
            }
            $data[$bulan][$status] = $jumlah;
        }

        $data['presensi_perbulan'] = $data;
        $data['title'] = 'Grafik Presensi Tahun ' . $tahun;

        return view('grafik', $data);
    }

    public function filter() {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $tahun = $this->request->getGet('tahun');

        // Jika "Pilih Tahun" dipilih (tahun kosong), alihkan ke index
        if (empty($tahun)) {
            return redirect()->to('/GrafikController');
        }

        // Validasi tahun yang dipilih
        $tahun = (int) $tahun;
        if ($tahun < date('Y') - 5 || $tahun > date('Y')) {
            return redirect()->to('/GrafikController');
        }

        // Inisialisasi Model Presensi
        $ModelPresensi = new presensiModel();

        // Mendapatkan data presensi perbulan
        $builder = $ModelPresensi->builder();
        $builder->select("MONTH(tanggal) as bulan, status, COUNT(*) as jumlah");
        $builder->where("YEAR(tanggal)", $tahun);
        $builder->groupBy("bulan, status");
        $query = $builder->get();

        $results = $query->getResultArray();

        $data = [];
        foreach ($results as $row) {
            $bulan = $row['bulan'];
            $status = $row['status'];
            $jumlah = $row['jumlah'];

            if (!isset($data[$bulan])) {
                $data[$bulan] = [
                    'WFO' => 0,
                    'WFH' => 0,
                    'Sakit' => 0,
                    'Izin' => 0,
                    'Alpha' => 0
                ];
            }
            $data[$bulan][$status] = $jumlah;
        }

        $data['presensi_perbulan'] = $data;
        $data['title'] = 'Grafik Presensi Tahun ' . $tahun;

        return view('grafik', $data);
    }
}
