<?php

session_start();

require 'functions.php';

// cek cookie
if( isset($_COOKIE["lock"]) && isset($_COOKIE["key"]) ) {
    $lock = $_COOKIE['lock'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $hasil = mysqli_query($conn, "SELECT username FROM user WHERE id=$id");
    $row = mysqli_fetch_assoc($hasil);

    // cek cookie dan username 
    if($key === hash('sha100', $row['username'])) {
        $_SESSION['login'] = true;
    }
}




if(isset($_POST["login"])) {

$username = $_POST["username"];
$password = $_POST["password"];

$hasil = mysqli_query( $conn, "SELECT * FROM user WHERE username='$username' " );

// cek username
if( mysqli_num_rows($hasil) === 1 ) {

    // cek password
    $row = mysqli_fetch_assoc($hasil) ;
    if(password_verify($password, $row["password"])) {

        // set session
        $_SESSION["login"] = true;

        // cek remember me
        if( isset($_POST["remember"]) ) {
            // buat cookie
            setcookie('lock', $row['id'], time() + 40);
            setcookie('key', hash('sha100', $row['username']), time() + 40);
        }

        header("Location: index2.php");
        exit;
    }
}
$error = true;
}

?>

<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144808195-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-144808195-1');
	</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>body{background-image:url("img/bg.jpg");}
	@media screen and (max-width: 600px) {
h4{font-size:85%;}
}
	</style>
	<link rel="icon" 
      type="image/png" 
      href="favicon.png">
    </head>
    <body>
    <div align="center">
    <img src="img/unbara.png" width="10%" style="margin-top:5%" \>
            <div align="center" style="width:750px;margin-top:5%;">
                <form name="login_form" method="post" class="well well-lg" action="" style="-webkit-box-shadow: 0px 0px 20px #ff00000;">
                    <i class="fa fa-windows fa-4x"></i>
                    <div class="container">
					<div style="color:white">
                    <h4>DATABASE MAHASISWA</h4>
                    <br>
                    <?php if(isset($error)) : ?>
        <div class="alert alert-danger">
            <strong>Log In Gagal!</strong> Username atau Password Salah.
        </div>
    <?php endif; ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="" aria-hidden="true"></i></span>
                        <input require name="username" id="username" class="form-control" type="text" placeholder="username" autocomplete="off" />
                    </div>
                    <br/>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="" aria-hidden="true"></i></span>
                        <input require name="password" id="password" class="form-control" type="password" placeholder="password" autocomplete="off" />
                    </div>
                    <br />

            <div class="mb-1 mt-1">
            <button class="btn btn-primary" type="submit" name="login">Login</button>
            <a href="registrasi.php">
                <button type="button" class="btn btn-success">Buat Akun Baru</button>
            </a>
            </div>
                </form>
            </div>
        </div>
        <br>

        <footer align="center">
        <div class="container">
					<div style="color:white">Created By </div><a href="#" title="Universitas Baturaja"><i class="fa fa-copyright" aria-hidden="true">Kelas B.2.1 INFORMATIKA Universitas Baturaja</i></a>
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

</html>