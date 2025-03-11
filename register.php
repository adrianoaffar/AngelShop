<?php
require_once('UserModel.php');
$userModel = new UserModel();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? trim($_POST['jenis_kelamin']) : '';
    $alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : 'user';

    if (empty($nama_lengkap) || empty($jenis_kelamin) || empty($alamat) || empty($email) || empty($password)) {
        echo "Semua field harus diisi!";
    } else {
        $result = $userModel->registerUser($nama_lengkap, $jenis_kelamin, $alamat, $email, $password, $role);
        echo $result === true ? "Registrasi berhasil!" : $result;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<section>
    <div class="container">
        <div class="row my-5 text-center">
            <div class="col-12">
                <p class="fw-bolder display-1 text-white mb-0">Register! <i class="fa fa-user"></i></p>
                <p class="text-white">Masukkan data dengan benar!</p>
            </div>

            <div class="col-6 mx-auto">
                <div class="card text-center">
                    <div class="card-body">
                        <form action="register.php" method="post" class="p-4">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <textarea name="alamat" class="form-control" placeholder="Masukkan alamat lengkap" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <?php if (!empty($error)) : ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <div class="text-center">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>

                            <div class="text-center mt-3">
                                <p>Sudah punya akun? <a href="login.php" class="fw-bold">Login!</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

</body>
</html>
