<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $kursus = $_POST["kursus"] ?? '';

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "db_kursus");

    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Cek apakah email sudah terdaftar
    $cek = $koneksi->prepare("SELECT id FROM peserta WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        echo "Email sudah terdaftar, silakan gunakan email lain.";
    } else {
        // Simpan data
        $sql = "INSERT INTO peserta (nama, email, password, kursus) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssss", $nama, $email, $hashed_password, $kursus);

        if ($stmt->execute()) {
            echo "Pendaftaran berhasil!";
        } else {
            echo "Gagal mendaftar: " . $stmt->error;
        }

        $stmt->close();
    }
    $cek->close();
    $koneksi->close();
} else {
    echo "Form belum dikirim.";
}
?>
