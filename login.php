<?php
session_start(); // Pastikan session dimulai di awal
require_once('UserModel.php');

$userModel = new UserModel();
$error = "";

// Cek jika ada pesan sukses logout
$logoutMessage = $_SESSION['logout_success'] ?? "";
unset($_SESSION['logout_success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        $result = $userModel->loginUser($email, $password); // Tidak menggunakan password_verify()

        if ($result === true) {
            session_regenerate_id(true); // Mencegah session fixation
            $_SESSION['email'] = $email; // Simpan sesi pengguna
            header("Location: index.php");
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    
    <link rel="stylesheet" href="css/login.css">

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<section>
    <div class="box">
        <div class="form">
            <img src="img/belanja.png" class="user" alt="User Image">
            <h2>Login</h2>

            <!-- Menampilkan pesan logout jika ada -->
            <?php if (!empty($logoutMessage)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($logoutMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Menampilkan error jika ada -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" onsubmit="return validateForm()">
                <div class="inputBx">
                    <input type="text" name="email" placeholder="Username" id="email" required autofocus>
                    <img src="images/user.png" alt="User Icon">
                </div>
                <div class="inputBx">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <img src="images/lock.png" alt="Lock Icon">
                </div>

                <label class="remember">
                    <input type="checkbox"> Remember Me
                </label>

                <div class="text-center">
                    <button id="submit" class="btn btn-info w-100 btn-lg" type="submit">Login</button>
                </div>

                <div class="text-center">
                    <p>Anda Belum Punya Akun? <a href="register.php" class="fw-bolder">Daftar</a></p>
                    <span><a href="#">Forgot Password</a></span>
                </div>
            </form>

        </div>
    </div>
</section>

<script>
function validateForm() {
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    if (username === "" || password === "") {
        alert("Username dan password harus diisi!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
