<?php

session_start();

if(!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

$mahasiswa2 = query("SELECT * FROM datamahasiswa WHERE id=$id")[0];

if(isset($_POST["edit"])) {

    if(ubah($_POST) > 0) {
        echo "<script>alert('Data Berhasil Diubah'); document.location.href='index2.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Diubah!'); document.location.href='index2.php';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Ubah Data Mahasiswa</title>
    <style>
        .teks{
            text-align: center;
            font-family: cambria;
        }
    </style>
    <style>
        .teks2{
            font-family: cambria;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<div class="container mt-3">

    <!-- Heading -->
    <hr>
    <h2>Ubah Data Mahasiswa</h2>
    <hr>

    <!-- Form tambah data -->
    <form action="" method="post" enctype="multipart/form-data">
    <input class="form-control" type="hidden" name="id" value="<?= $mahasiswa2['id']; ?>">
    <input class="form-control" type="hidden" name="fotolama" value="<?= $mahasiswa2['foto']; ?>">
        <div class="mb-3 mt-3">
            <label class ="teks2" for="foto">Foto:</label><br>
            <img src="img/<?= $mahasiswa2['foto']; ?>" class="rounded-circle" alt="Cinque Terre" width="100" height="100"><br><br>
            <input class="form-control" type="file" name="foto" id="foto">
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="nama">Nama:</label>
            <input class="form-control" type="text" name="nama" id="nama" value="<?= $mahasiswa2['nama']; ?>" required>
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="npm">NPM:</label>
            <input class="form-control" type="text" name="npm" id="npm" value="<?= $mahasiswa2['npm']; ?>" required>
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="jurusan">Jurusan:</label>
            <input class="form-control" type="text" name="jurusan" id="jurusan" value="<?= $mahasiswa2['jurusan']; ?>" required>
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="email">E-mail:</label>
            <input class="form-control" type="text" name="email" id="email" value="<?= $mahasiswa2['email']; ?>" required>
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="status">Status: 0 (NOL) Jika Tidak Aktif , 1 (SATU) Jika Aktif</label>
            <input class="form-control" type="text" name="status" id="status" value="<?= $mahasiswa2['status']; ?>" required>
        </div>
        <div class="mb-3 mt-3">
            <button class="btn btn-success" type="submit" name="edit">Ubah <span class="glyphicon glyphicon-ok"></span></button>
            <a href="index2.php">
                <button class="btn btn-danger" type="button">Batal <span class="glyphicon glyphicon-remove"></span></button>
            </a>
        </div>
  </form>
  <?php include 'footer.php'; ?>
</div>

</body>
</html>