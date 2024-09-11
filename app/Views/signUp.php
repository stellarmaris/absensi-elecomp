<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

        .alert {
            padding: 15px 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Success Alert */
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        /* Danger Alert */
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        /* Warning Alert */
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .container {
            max-width: 500px;
            background-color: white;
            /* margin-top: 20px;
           margin-bottom: 20px; */
            border-radius: 10px;
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.25);
            font-family: "Poppins", sans-serif
        }

        .container h2 {
            font-size: 25px;
        }

        .container p {
            font-size: 13px;
        }

        .form-control {
            border-radius: 10px;
            background-color: rgba(19, 12, 144, 0.04);
            font-size: 13px;
        }

        .form-label,
        .form-check-label,
        .form-check-input {
            font-size: 14px;
        }

        body {
            background-image: url('/images/Sign In 1.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 20px;
        }

        .input-group-append {
            cursor: pointer;
        }

        .input-group-append .btn {
            padding: 0.5rem;
            border-radius: 0 10px 10px 0;
            border-color: #ddd;
            background-color: rgba(19, 12, 144, 0.04);
        }

        .input-group-append .btn:hover {
            color: #130C90
        }

        .password-wrapper{
            position: relative;
        }
        .password-wrapper input{
            padding-right: 30px;
        }
        .password-wrapper .toggle-password{
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }



    </style>


</head>

<body>

    <?php
    if (isset($validation)): ?>
        <div class="alert alert-danger">
            <?= $validation->listErrors() ?>
        </div>
    <?php elseif (isset($eror)) : ?>
        <div class="alert alert-danger">
            <?= $eror ?>
        </div>
    <?php endif; ?>

    <div class="container p-4 border">
        <form action="/signUp" method="POST">
            <?= csrf_field() ?>
            <div class="mb-4" style="text-align: center;">
                <h2>Pendaftaran Absensi</h2>
                <p>Haiii, masukkan detail informasi dirimu.</p>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap:</label>
                <input type="text" class="form-control" name="Nama" value="<?= set_value('Nama') ?>" placeholder="Cth: Ronaldowati" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Asal Institusi:</label>
                <input type="text" class="form-control" name="asal_institusi" value="<?= set_value('asal_institusi') ?>" placeholder="Cth: Universitas Brawijaya" required>
            </div>
            <div class="row g-1">
                <label class="form-label">Jenis Kelamin:</label>
                <div class=" mb-2 form-check col">
                    <input type="radio" class="form-check-input" id="laki-laki" name="Jenis_kelamin" value="laki-laki" <?= set_radio('Jenis_kelamin', 'laki-laki') ?>>
                    <label class="form-check-label" for="laki-laki">Laki-Laki</label>
                </div>
                <div class="form-check col">
                    <input type="radio" class="form-check-input" id="perempuan" name="Jenis_kelamin" value="Perempuan" <?= set_radio('Jenis_kelamin', 'Perempuan') ?>>
                    <label class="form-check-label">Perempuan</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon:</label>
                <input type="text" class="form-control" name="Nomor_telepon" placeholder="Cth: 082272112772" value="<?= set_value('Nomor_telepon') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Cth: Ronaldowati21@gmail.com" value="<?= set_value('email') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                    <div class=" password-wrapper" >
                        <input type="password" class="form-control" name="password" id="password" placeholder="Setidaknya 8 karakter disertai angka dan spesial karakter" value="<?= set_value('password')?>" required>
                        <i class="fas fa-eye toggle-password"></i>
                    </div>
                
            </div>
            <div class="mb-5">
                <label class="form-label">Alamat</label>
                <input type="Alamat" class="form-control" name="alamat" placeholder="Cth: Jl. Danau Amora No.C5 E8, Sawojajar" value="<?= set_value('alamat') ?>" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn mb-2" style="background-color: #130C90; color:white;"><strong>Daftar</strong></button>
            </div>
            <p style="text-align: center;">Sudah punya akun? <a href="/login" style="color:#130C90"><strong>Masuk</strong></a></a></p>

        </form>
    </div>
</body>

<script>
const togglePassword = document.querySelector('.toggle-password');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click',function(e){
    const type = passwordInput.getAttribute('type') ==='password' ?'text' : 'password';
    passwordInput.setAttribute('type',type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});
</script>
</html>



