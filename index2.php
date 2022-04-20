<?php

session_start();

if(!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require 'functions.php';

// Menambahkan pagination & konfigurasi pagination
$dataPerHalaman = 2;
$jumlahData = count( query("SELECT * FROM datamahasiswa") );
$halaman = ceil($jumlahData / $dataPerHalaman);
if( isset($_GET["halaman"]) ) {
    $halamanAktif = $_GET["halaman"];
} else {
    $halamanAktif = 1;
}

$awalData = ($dataPerHalaman * $halamanAktif) - $dataPerHalaman;

$jumlahLink = 1;
if( $halamanAktif > $jumlahLink ) {
    $startNum = $halamanAktif - $jumlahLink;
} else {
    $startNum = 1;
}

if( $halamanAktif < ($halaman - $jumlahLink) ) {
    $endNum = $halamanAktif + $jumlahLink;
} else {
    $endNum = $halaman;
}
// End pagination

$mahasiswa = query("SELECT * FROM datamahasiswa LIMIT $awalData, $dataPerHalaman");

// Ketika tombol cari di klik maka akan menampilkan hasil data yang dicari
if ( isset($_POST["cari"]) ) {   
    $mahasiswa = cari( $_POST["keyword"] );
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Administrator</title>
    <style>
        .nav-teks{
            letter-spacing: 5px;
            color: green;
            font-weight: bold;
            padding: 10px;
        }

        .teks{
            font-size: 18px;
            text-align: center;
            font-family: cambria;
        }
    </style>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container" style="margin-left:105px;">
            <a class="navbar-brand" href="index.php">
                <img class="rounded-pill" alt="Logo" style="width:40px;" src="img/unbara.png" style="font-family: cambria;"> Universitas Baturaja
                <span class="nav-teks"></span>
            </a>
        </div>
        <!-- Log out -->
        <div style="margin-right:120px;">
            <a href="logout.php" class="button">
                <button class="btn btn-danger" style="font-family: cambria;">Logout </button>
            </a>
        </div>
    </nav>

    <!-- Heading -->
    <hr>
    <h1 class="container">Data Mahasiswa Kelas B.2.1</h1>
    <hr>

    <!-- Fitur cari -->
    <div class="container">
        <form class="d-flex" action="" method="post">
            <input class="form-control me-1 input-sm" style="width: 280px;" type="text" name="keyword" placeholder="Masukkan bae.." autocomplete="off">
            <button class="btn btn-info" type="submit" name="cari"><i class="fa fa-search"></i></button>
        </form>
    </div>

    <!-- Tombol -->
    <div class="container mt-3">
        <!-- Tambah -->
        <a href="tambah.php">
            <button class="btn btn-success btn-sm">
                Tambah Mahasiswa  
                <i class="fa fa-plus"></i>
            </button>
        </a>
    </div>
    <!-- Tombol Export-->
    <div class="container mt-3">
        <!-- Tambah -->
        <a href="export.php">
            <button class="btn btn-success btn-sm">
                Export data  
                <i class="fa fa-plus"></i>
            </button>
        </a>
    </div>
    
    <!-- Tabel -->
    
    <div class="container mt-2">
        <table class="table table-bordered" >
        <style>
            {
  border: 5px solid black;
            }
            </style>
            <thead>
                <tr>
                    <th class="teks">No.</th>
                    <th class="teks">Foto</th>
                    <th class="teks">Nama Mahasiswa</th>
                    <th class="teks">NPM</th>
                    <th class="teks">Jurusan</th>
                    <th class="teks">E-mail</th>
                    <th class="teks">Status</th>
                    <th class="teks" colspan="2">Aksi</th>
                </tr>
            </thead>
            
            <?php $a = $awalData + 1; ?>
            <?php foreach( $mahasiswa as $mhs ) : ?>
                <tbody>
                    <tr>
                        <td class="teks"><?= $a; ?></td>
                        <td class="teks"><img src="img/<?= $mhs["foto"]; ?>" class="img-thumbnail" alt="Cinque Terre" width="80"></td>
                        <td class="teks"><?= $mhs["nama"]; ?></td>
                        <td class="teks"><?= $mhs["npm"]; ?></td>
                        <td class="teks"><?= $mhs["jurusan"]; ?></td>
                        <td class="teks"><?= $mhs["email"]; ?></td>
                        <td class="teks"><?= $mhs["status"]; ?></td>
                        <td class="teks">
                            <a href="ubah.php?id=<?= $mhs["id"]; ?>"><i class="fa fa-edit fa-lg" style="color: #009933;"></i></a>
                        </td>
                        <td class="teks">
                            <a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Apakah Anda Yakin?');"><i class="fa fa-trash-o fa-lg" style="color: #cc0000;"></i></a>
                        </td>
                    </tr>
                </tbody>
            <?php $a++; ?>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- navigasi -->
    <div class="container mt-3">
        <ul class="pagination justify-content-center pagination-sm">
            <?php if ($halamanAktif > 1) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">Previous</a></li>
            <?php endif; ?>

            <?php for ($i = $startNum; $i <= $endNum; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>" style="color:black; background-color:red; font-weight:bold;"><?= $i; ?></a></li>
                <?php else : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
                <?php endif; ?>
            <?php endfor;  ?>

            <?php if ($halamanAktif < $halaman) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </div>
    <footer align="center">
    <?php include 'footer.php'; ?>
        </footer>
    </body>

    <!--<script type="text/javascript">
    function validasi() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;       
        if (username != "" && password!="") {
            return true;
        }else{
            alert('Username dan Password harus di isi !');
            return false;
        }
    }
    </script>-->
</html>>