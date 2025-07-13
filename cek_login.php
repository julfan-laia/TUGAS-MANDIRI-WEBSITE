<?php
session_start();
include "koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM peserta WHERE email='$email'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if ($data && password_verify($password, $data['password'])) {
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['email'] = $data['email'];
    $_SESSION['kursus'] = $data['kursus'];

    header("Location: kursus.html"); // arahkan ke halaman kursus setelah login
} else {
    echo "<script>alert('Login gagal. Email atau password salah.'); window.location='login.html';</script>";
}
?>
