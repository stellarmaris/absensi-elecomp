<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<title>Lokasi Pengguna</title>
<link rel="stylesheet" href="/css/tampilLokasi.css">

<!--include leaflet css-->
        <link
            rel="stylesheet"
            href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
            integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
            crossorigin=""/>
            <link
                rel="stylesheet"
                href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css"
            />
            <link
                rel="stylesheet"
                href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css"
            />
       
     
<?= $this->endSection() ?>

<?= $this->section('content') ?>

 <!--include javascript-->
 <script
            src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
            integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
            crossorigin="">
        </script>
        <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>



            <div class="info">
                <h1>Lokasi</h1>
                <p>Daftar lokasi check-in dan check-out member<p>
            </div>
            
            
            <div class="col-md-6 ms-auto">
                    <form action="/lokasiSemua" method="get" class="input-group " >
                        <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>">
                        <button type="submit" class="btn" style="background-color: #130C90; color:white">Filter</button>
                    </form>
                        
            </div>
            <div class="col-md-6 mb-3"><h4>Lokasi Masuk</h4></div>
             <div id="map"></div>
            
            <div class="col-md-6 "><h4>Lokasi Keluar</h4></div>
            <div id="map1"></div>
         
            
 

        
       
        <script>

            //map (buat checkin)
            var map = L.map('map').setView([-7.981298, 112.631926], 12);
                      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                   maxZoom: 19,
                                   attribution: '© OpenStreetMap'
                                 }).addTo(map);
           
            var markers = L.markerClusterGroup();
            
            <?php foreach ($presensi as $dataPresensi): ?>
                <?php if($dataPresensi['checkIn_latitude'] !== null && $dataPresensi['checkin_longitude'] !== null ):?>
               var marker= L.marker([<?= $dataPresensi['checkIn_latitude']?>,<?= $dataPresensi['checkin_longitude']?>])
                    .bindPopup("<?=$dataPresensi['Nama'] ?>")
                markers.addLayer(marker);

                <?php endif; ?>
            <?php endforeach ?>
            map.addLayer(markers);

            // Map 1(buat checkout)
                var map1 = L.map('map1').setView([-7.981298, 112.631926], 12); 
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(map1);

            var markers1 =L.markerClusterGroup();

            <?php foreach ($presensi as $dataPresensi): ?>
                <?php if($dataPresensi['checkout_latitude'] !== null && $dataPresensi['checkout_longitude'] !== null): ?>
                   var marker1= L.marker([<?= $dataPresensi['checkout_latitude'] ?>, <?= $dataPresensi['checkout_longitude'] ?>])
                        .bindPopup("<?= $dataPresensi['Nama'] ?>")
                 
                    markers1.addLayer(marker1);
                <?php endif ?>
            <?php endforeach; ?>

            map1.addLayer(markers1);
           
        </script>

<?= $this->endSection() ?>