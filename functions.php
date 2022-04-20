<?php

// koneksi database
$conn = mysqli_connect("localhost", "root", "", "belajarphp");

// menampilkan query
function query($query) {

    global $conn;

    $hasil = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($hasil) ) {
        $rows[] = $row;
    }
    return $rows;
}

// function upload
function upload() {

    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $namaTMP = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    // cek apakah tidak ada foto yang diupload
    if($error === 4) {
        echo "<script>alert('Upload Foto Terlebih Dahulu!');</script>";
        return false;
    }

    //cek apakah yang diupload adalah foto
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    if(!in_array($ekstensiFoto, $ekstensiValid)) {
        echo "<script>alert('Hanya Bisa Mengupload File Berekstensi [jpg, jpeg, png, jfif, dan webp]');</script>";
        return false;
    }

    //cek jika ukuran foto terlalu besar
    if($ukuranFile > 10485760) {
        echo "<script>alert('Ukuran Foto Terlalu Besar!');</script>";
        return false;
    }

    //generate nama baru untuk foto & upload
    $namaBaruFile = uniqid();
    $namaBaruFile .= '.';
    $namaBaruFile .= $ekstensiFoto;

    move_uploaded_file($namaTMP, 'img/' . $namaBaruFile);
    return $namaBaruFile;
}

// function tambah
function tambah($data) {

    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $npm = htmlspecialchars($data["npm"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    $status = htmlspecialchars($data["status"]);

    //upload foto
    $foto = upload();
    if(!$foto) {
        return false;
    }

    $query = "INSERT INTO datamahasiswa VALUES ('', '$nama', '$npm', '$jurusan', '$email', '$foto', 'status')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// function hapus
function hapus($id) {
    
    global $conn;

    mysqli_query($conn, "DELETE FROM datamahasiswa WHERE id=$id");
    return mysqli_affected_rows($conn);
}

// function ubah
function ubah($data) {

    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $npm = htmlspecialchars($data["npm"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $email = htmlspecialchars($data["email"]);
    $fotoLama = $data["fotolama"];
    $status = htmlspecialchars($data["status"]);

    // cek apakah user mengganti foto baru atau tidak
    if($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
    }

    $query = "UPDATE datamahasiswa SET nama='$nama', npm='$npm', jurusan='$jurusan', email='$email', foto='$foto', status='$status' WHERE id=$id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// function cari
function cari($keyword) {
    $query = "SELECT * FROM datamahasiswa WHERE nama LIKE '%$keyword%' OR npm LIKE '%$keyword%' OR jurusan LIKE '%$keyword%' OR email LIKE '%$keyword%' OR status LIKE '%$keyword%'";
    return query($query);
}

// function registrasi
function registrasi($data) {

    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    // cek username sudah ada atau belum
    $hasil = mysqli_query($conn, "SELECT username FROM user WHERE username='$username'");
    if(mysqli_fetch_assoc($hasil)) {
        echo "<script>alert('Username Sudah Digunakan');</script>";
        return false;
    }

    // cek konfirmasi password
    if($password !== $password2) {
        echo "<script>alert('Password Tidak Cocok');</script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

?>