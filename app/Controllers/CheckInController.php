<?php

namespace App\Controllers;

use App\Models\presensiModel;
use App\Models\UserModel;

class CheckInController extends BaseController
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
        $data['title'] = 'Dashboard';

        return view('checkin_form', $data);
    }
public function store()
{
    // Check if the user is logged in
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $idMagang = session()->get('user_id');

    // Fetch additional user data if needed
    $userModel = new UserModel();
    $userData = $userModel->find($idMagang);

    // Merge session data with additional data (if any)
    $data = array_merge(session()->get(), $userData);

    // Add title data
    $data['title'] = 'Dashboard';

    // Get form data
    $date = $this->request->getPost('date');
    $time = $this->request->getPost('time');
    $latitude = $this->request->getPost('latitude');
    $longitude = $this->request->getPost('longitude');
    $status = $this->request->getPost('status'); // WFO or WFH

    // Pengecekan waktu check-in (misal: antara 07:30 dan 08:15)
    $startTime = "07:30";
    $endTime = "08:15";


    // // Konversi waktu ke format datetime agar bisa dibandingkan
    $checkInTime = strtotime($time);
    $startTimeCheck = strtotime($startTime);
    $endTimeCheck = strtotime($endTime);

    //  // Tambahkan pengecekan waktu check-in
     if ($checkInTime < $startTimeCheck || $checkInTime > $endTimeCheck) {
        return redirect()->back()->with('error', 'Waktu check-in tidak valid. Anda hanya dapat check-in antara pukul 08:00 dan 08:15.');
    }

    // Check if location (latitude and longitude) is provided
    if (empty($latitude) || empty($longitude)) {
        return redirect()->back()->with('error', 'Lokasi tidak terdeteksi. Pastikan GPS Anda aktif dan coba lagi.');
    }

    // Target location coordinates and radius
    $targetLat = -7.9742781;
    $targetLong = 112.665592;
    $radius = 1000; // Radius in meters

    // Function to convert degrees to radians
    function deg2rad($deg)
    {
<<<<<<< HEAD
        return $deg * (M_PI / 180);
    }

    // Function to calculate the distance between two coordinates (Haversine formula)
    function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLong = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLong / 2) * sin($dLong / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    // Initialize verification status
    $verifikasiStatus = 'Pending'; // Default for WFH

    // Handle verification based on status (WFO or WFH)
    if ($status === 'WFO') {
        // Calculate the distance between the current and target locations
        $distance = haversine($latitude, $longitude, $targetLat, $targetLong);

        // Check if the distance is within the specified radius
        if ($distance <= $radius) {
            $verifikasiStatus = 'Sukses'; // Success if within the radius
        }
    }

    $PresensiModel = new PresensiModel();

    // Check if the user has already checked in today
    $existingCheckIn = $PresensiModel->where('id_magang', $idMagang)
        ->where('tanggal', $date)
        ->where('status', 'hadir')
        ->first();

    if ($existingCheckIn) {
        // If the user has already checked in, redirect with an error 
        return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
    }

    // Handle file upload
    $foto = $this->request->getFile('foto');
    if ($foto->isValid() && !$foto->hasMoved()) {
        // Check file size (1 MB = 1,048,576 bytes)
        $maxSize = 1048576; // 1 MB in bytes

        if ($foto->getSize() > $maxSize) {
            return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 1 MB.');
        }

        // Check file extension
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = $foto->getExtension();

        if (in_array($fileExtension, $allowedExtensions)) {
            $newName = $foto->getRandomName(); // Generate random file name
            $foto->move('uploads/photos', $newName);

            // Create the data array with the path to the uploaded photo
            $data = [
                'id_magang' => $idMagang,
                'status' => $status,
                'tanggal' => $date,
                'jam_masuk' => $time,
                'checkIn_latitude' => $latitude,
                'checkin_longitude' => $longitude,
                'verifikasi' => $verifikasiStatus,
                'foto' => $newName // Save the path to the database
            ];

            // Save data to the database
            $PresensiModel->save($data);

            // Check verification status and redirect accordingly
            if ($verifikasiStatus === 'Sukses') {
                return redirect()->to('/success-check-in')->with('success', 'Presensi berhasil disimpan.');
=======
        // Check if the user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $idMagang = session()->get('user_id');
    
        // Fetch additional user data if needed
        $userModel = new UserModel();
        $userData = $userModel->find($idMagang);
    
        // Merge session data with additional data (if any)
        $data = array_merge(session()->get(), $userData);
    
        // Add title data
        $data['title'] = 'Dashboard';
    
        // Get form data
        $date = $this->request->getPost('date');
        $time = $this->request->getPost('time');
        $latitude = $this->request->getPost('latitude');
        $longitude = $this->request->getPost('longitude');
        $status = $this->request->getPost('status'); // WFO or WFH
    
        // Target location coordinates and radius
        $targetLat = -7.9742781;
        $targetLong = 112.665592;
        $radius = 1000; // Radius in meters
    
        // Function to convert degrees to radians
        function deg2rad($deg)
        {
            return $deg * (M_PI / 180);
        }
    
        // Function to calculate distance between two coordinates using the Haversine formula
        function haversine($lat1, $lon1, $lat2, $lon2)
        {
            $earthRadius = 6371000; // Earth radius in meters
    
            $dLat = deg2rad($lat2 - $lat1);
            $dLong = deg2rad($lon2 - $lon1);
    
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLong / 2) * sin($dLong / 2);
    
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    
            $distance = $earthRadius * $c;
    
            return $distance;
        }
    
        // Initialize verification status
        $verifikasiStatus = 'Pending'; // Default for WFH
    
        // Handle verification based on status (WFO or WFH)
        if ($status === 'WFO') {
            // Calculate the distance between the current and target locations
            $distance = haversine($latitude, $longitude, $targetLat, $targetLong);
    
            // Check if the distance is within the specified radius
            if ($distance <= $radius) {
                $verifikasiStatus = 'Sukses'; // Success if within the radius
            }
        }
    
        $PresensiModel = new PresensiModel();
    
        // Check if the user has already checked in today
        $existingCheckIn = $PresensiModel->where('id_magang', $idMagang)
            ->where('tanggal', $date)
            ->where('status', 'hadir')
            ->first();
    
        if ($existingCheckIn) {
            // If the user has already checked in, redirect with an error message
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }
    
        // Handle file upload
        $foto = $this->request->getFile('foto');
        if ($foto->isValid() && !$foto->hasMoved()) {
            // Check file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            $fileExtension = $foto->getExtension();
    
            if (in_array($fileExtension, $allowedExtensions)) {
                $newName = $foto->getRandomName(); // Generate random file name
                $foto->move('uploads/photos', $newName); // Move to the uploads/photos directory
    
                // Create the data array with the path to the uploaded photo
                $data = [
                    'id_magang' => $idMagang,
                    'status' => $status,
                    'tanggal' => $date,
                    'jam_masuk' => $time,
                    'checkIn_latitude' => $latitude,
                    'checkin_longitude' => $longitude,
                    'verifikasi' => $verifikasiStatus, // Use calculated verification status
                    'foto' => $newName // Save the path to the database
                ];
    
                // Save data to the database
                $PresensiModel->save($data);
    
                // Check verification status and redirect accordingly
                if ($verifikasiStatus === 'Sukses') {
                    return redirect()->to('/success-check-in')->with('success', 'Presensi berhasil disimpan.');
                } else {
                    return redirect()->to('/pending-check-in')->with('warning', 'Verifikasi sedang diproses.');
                }
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
            } else {
                // Handle error if the file extension is not allowed
                return redirect()->back()->with('error', 'Format file tidak didukung. Hanya .jpg, .jpeg, dan .png yang diperbolehkan.');
            }
        } else {
            // Handle error if the file extension is not allowed
            return redirect()->back()->with('error', 'Format file tidak didukung. Hanya .jpg, .jpeg, dan .png yang diperbolehkan.');
        }
    } else {
        // Handle error if the file is not valid
        return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 1 MB.');
    }
    
}


    
}
