<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<<<<<<< HEAD
<!--<link rel="stylesheet" href="/css/profileedit.css">-->
<style>
    .title {
  margin-left: 12px;
}

.custom-font {
  font-family: 'Inter', sans-serif;
}

.custom-btn {
  width: 100%;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 18px;
  font-weight: bold;
  background-color: #130C90;
  border-radius: 10px;
  margin: 0 auto;
  color: white;
  text-decoration: none;
}

.custom-btn:hover {
  background-color: #0C074F;
}

.bold-text {
  font-weight: 900;
}

.card {
  margin-bottom: 15px;
  border-radius: 10px;
  overflow: hidden;
  padding: 20px;
  width: 100%; 
  box-sizing: border-box;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  font-weight: 500;
  font-size: 18px;
  margin-left: 12px;
}

.profile .form-control {
  padding: 15px;
  background-color: #F6F5FB;
  border: 2px solid #130C90;
  border-radius: 10px;
  font-size: 16px;
  font-weight: bold;
  width: 100%;
  margin-left: 0;
  box-sizing: border-box; 
}

.profile .form-control[readonly] {
  border: none;
  box-shadow: none;
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 2%;
  margin-bottom: 20px;
}

.form-group.flex-item {
  width: 48%;
}

.password-field {
  margin-bottom: 20px;
  position: relative;
}

.password-field .toggle-password {
  position: absolute;
  top: 60%;
  left:44%;
  transform: translateY(-50%);
  cursor: pointer;
}


@media (max-width: 768px) {
  .form-group.flex-item {
    width: 100%;
  }

  .profile .form-control {
    width: 100%;
    margin-left: 0;
  }

  .form-label {
    margin-left: 0;
  }

  .title {
    margin-left: 0;
    font-size: 24px;
    text-align: center;
  }

  .custom-btn {
    width: 100%;
    font-size: 16px;
  }

  .card {
    margin-bottom: 20px;
    border-radius: 5px;
    padding: 15px;
    width: 100%;
  }
  
  .password-field .toggle-password {
      position: absolute;
      top: 60%;
      left:93%;
      transform: translateY(-50%);
      cursor: pointer;
    }
  
}

@media (max-width: 480px) {
  .title {
    font-size: 20px;
  }

  .custom-btn {
    height: 35px;
    font-size: 14px;
  }

  .form-label {
    font-size: 16px;
  }

  .profile .form-control {
    font-size: 14px;
    padding: 12px;
  }

  .card {
    padding: 10px;
    width: 100%;
  }
   .password-field .toggle-password {
      position: absolute;
      top: 60%;
      left:90%;
      transform: translateY(-50%);
      cursor: pointer;
    }
}


</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

=======
<link rel="stylesheet" href="/css/profileedit.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<div class="title">
    <h2>Edit Profil</h2>
</div>
<!-- Alert for validation errors -->
<?php if (session()->getFlashdata('validation')): ?>
    <div class="alert alert-danger" role="alert">
        <ul>
            <?php foreach (session()->getFlashdata('validation')->getErrors() as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- kartu profil -->
<div class="card profile custom-font">
    <div class="card-body">
        <form action="<?= base_url('/detail-user/update-user/' . esc($user['id_magang'])) ?>" method="post">

            <div class="form-row">
                <div class="form-group flex-item">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" value="<?= esc($user['Nama']) ?>">
                </div>
                <div class="form-group flex-item">
                    <label for="institusi" class="form-label">Asal Institusi</label>
                    <input type="text" id="institusi" name="institusi" class="form-control" value="<?= esc($user['asal_institusi']) ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group flex-item">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control" value="<?= esc($user['Jenis_kelamin']) ?>" readonly>
                </div>
                <div class="form-group flex-item">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input type="tel" id="telepon" name="telepon" class="form-control" value="<?= esc($user['Nomor_telepon']) ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group flex-item">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" readonly>
                </div>
                <div class="form-group flex-item">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" id="alamat" name="alamat" class="form-control" value="<?= esc($user['alamat']) ?>">
                </div>
            </div>

<<<<<<< HEAD
             <div class="form-group password-field">
=======
            <div class="form-group password-field">
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
                <div class="form-group flex-item">
                    <label for="kata_sandi" class="form-label">Kata Sandi</label>
                    <input type="password" id="kata_sandi" name="password" class="form-control">
                    <i class="fas fa-eye toggle-password"></i>  
                </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary custom-btn">Simpan Perubahan</button>
        </form>
    </div>
<<<<<<< HEAD
=======
   
>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
</div>
<script>
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('kata_sandi');

    togglePassword.addEventListener('click',function(e){
        const type = passwordInput.getAttribute('type') ==='password' ?'text' : 'password';
        passwordInput.setAttribute('type',type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    }); 
</script>
<<<<<<< HEAD
=======

>>>>>>> c00dc2e007764257bf9f4dc4c27ecae3de1427a4
<?= $this->endSection() ?>