<?php
namespace App\Models;
use CodeIgniter\Model;

class presensiModel extends Model{
    protected $table = 'presensi';
    protected $primaryKey = 'id_presensi';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'id_magang',
        'status',
        'verifikasi',
        'tanggal',
        'jam_masuk',
        'jam_piket',
        'jam_keluar',
        'foto',
        'foto_piket',
        'kegiatan',
        'kegiatan_piket',
        'checkIn_latitude',
        'checkin_longitude', 
        'checkout_latitude', 
        'checkout_longitude',
        'verifikasi',
    ];


}