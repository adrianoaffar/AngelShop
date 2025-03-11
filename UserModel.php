<?php
require_once('conn.php');

class UserModel {
    private $conn;
    
    // Constructor untuk inisialisasi koneksi database
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Fungsi untuk registrasi pengguna baru
    public function registerUser($nama_lengkap, $jenis_kelamin, $alamat, $email, $password, $role) {
        if ($this->isEmailExist($email)) {
            return "Email sudah digunakan!";
        }
    
        // Tidak melakukan hashing, langsung menyimpan password asli
        $stmt = $this->conn->prepare("INSERT INTO `users` (`nama_lengkap`, `jenis_kelamin`, `alamat`, `email`, `password`, `role`, `created_at`) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssss", $nama_lengkap, $jenis_kelamin, $alamat, $email, $password, $role);
        
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return "Registrasi gagal: " . $stmt->error;
        }
    }
    

    // Fungsi untuk login
    public function loginUser($email, $password) {
        $query = "SELECT * FROM `users` WHERE `email` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
    
            // Langsung membandingkan password dari form dengan yang ada di database
            if ($password === $user['password']) {  
                session_regenerate_id(true); 
                
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
                header("Location: index.php");
                exit();
            } else {
                return "Password salah!";
            }
        } else {
            $stmt->close();
            return "Email tidak ditemukan!";
        }
    }
    

    // Fungsi untuk mengecek apakah email sudah terdaftar
    private function isEmailExist($email) {
        $stmt = $this->conn->prepare("SELECT id FROM `users` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        $isExist = $stmt->num_rows > 0;
        $stmt->close();

        return $isExist;
    }

    // Fungsi untuk logout
    public function logoutUser() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
?>
