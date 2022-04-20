<?php
include "database.php";
$que = mysqli_query($db_conn, "SELECT * FROM un_konfigurasi");
$hsl = mysqli_fetch_array($que);
$timestamp = strtotime($hsl['tgl_pengumuman']);
// menghapus tags html (mencegah serangan jso pada halaman index)
$instansi = strip_tags($hsl['instansi']);
$tahun = strip_tags($hsl['tahun']);
$tgl_pengumuman = strip_tags($hsl['tgl_pengumuman']);
//echo $timestamp;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Description" content="Aplikasi Pengecekan Data Mahasiswa UNBARA">
	<title>Info Data Mahasiswa UNBARA</title>
	<link rel="shortcut icon" href="img/favicon.png">
	<!--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">-->
	<link rel="stylesheet" href="css/main.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jasny-bootstrap.min.css" rel="stylesheet">
	
</head>

<body>
        <div class="flex-center position-ref full-height">
		<div class="content">
			<img src="img/unbara.png" alt="Logo PDAM TIRTARAJA" width="100px" height="100px;">
			<div class="title m-b-md">
				Info Data Mahasiswa UNBARA
			</div>
    
    <div class="container">
		<!-- countdown -->
		
		<hr>
		<div id="clock" class="lead"></div>
		
		<div id="xpengumuman">
		<?php
		if(isset($_POST['submit'])){
			//tampilkan hasil queri jika ada
			$npm = stripslashes($_POST['nomor']);
			
			$hasil = mysqli_query($db_conn,"SELECT * FROM datamahasiswa WHERE npm='$npm'");
			if(mysqli_num_rows($hasil) > 0){
				$data = mysqli_fetch_array($hasil);
				
		?>
		    
			<table class="table table-bordered">
				<tr><td>Foto</td><td class="teks"><img src="img/<?= $data['foto']; ?>" class="img-thumbnail" alt="Foto Mahasiswa" width="80"></td>
				<tr><td>NPM</td><td><?= htmlspecialchars($data['npm']); ?></td></tr>
				<tr><td>Nama Mahasiswa</td><td><?= htmlspecialchars($data['nama']); ?></td></tr>
				<tr><td>Jurusan</td><td><?= htmlspecialchars($data['jurusan']); ?></td></tr>
			</table>
						
			<?php
			if( $data['status'] == 1 ){
				echo '<div class="alert alert-success" role="alert"><strong>SELAMAT !</strong> Status Mahasiswa Aktif</div>';
			} else {
				echo '<div class="alert alert-danger" role="alert"><strong>MAAF !</strong> Status Mahasiswa Tidak Aktif!</div>';
			}	
			?>
			
		<?php
			} else {
				echo 'nomor NPM yang anda inputkan tidak ditemukan! periksa kembali nomor NPM anda.';
				//tampilkan pop-up dan kembali tampilkan form
			}
		} else {
			//tampilkan form input nomor npm
		?>
              
        <form method="post">
            <div class="input-group">
                <input type="text" name="nomor" class="form-control" placeholder="Masukkan Nomor NPM" required>
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit" name="submit">Periksa!</button>
                </span>
            </div>
        </form>
		<?php
		}
		?>
		</div>
    </div><!-- /.container -->
	<footer class="footer">
		<div class="container">
			<p class="text-muted">&copy; <?= $tahun; ?> &middot; <?= $instansi; ?></p>
		</div>
	</footer> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/jquery.ripples-min.js"></script>
	<script src="js/ripple.js"></script>
</body>
</html>