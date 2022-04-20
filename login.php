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

if( isset($_SESSION["login"]) ) {
header("Location: index.php");
exit;
}


if(isset($_POST["login"])) {

$username = $_POST["username"];
$password = $_POST["password"];

$hasil = mysqli_query( $conn, "SELECT * FROM user WHERE username='$username' " );

// cek username
if( mysqli_num_rows($hasil) === 1 ) {

    // cek password
    $row = mysqli_fetch_assoc($hasil);
    if(password_verify($password, $row["password"])) {

        // set session
        $_SESSION["login"] = true;

        // cek remember me
        if( isset($_POST["remember"]) ) {
            // buat cookie
            setcookie('lock', $row['id'], time() + 40);
            setcookie('key', hash('sha100', $row['username']), time() + 40);
        }

        header("Location: index.php");
        exit;
    }
}
$error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Log In</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

<div class="container mt-3">

    <!-- Heading -->
    <hr>
    <h2 class="teks">Log In</h2>
    <hr>

    <?php if(isset($error)) : ?>
        <div class="alert alert-danger">
            <strong>Log In Gagal!</strong> Username atau Password Salah.
        </div>
    <?php endif; ?>

    <!-- Form log in -->
    <form action="" method="post">
        <div class="mb-2 mt-2">
            <p>
              <label class ="teks1" for="username">Username:</label>
              <input class="form-control" type="text" name="username" id="username" autocomplete="off">
            </p>
        </div>
        <div class="mb-2 mt-2">
          <label class ="teks1" for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password" autocomplete="off">
        </div>
        <div class="form-check mb-2">
            <label class="form-check-label" for="remember">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"> Remember me
            </label>
        </div>
        <div class="mb-2 mt-2">
            <button class="btn btn-primary" type="submit" name="login">Log In</button>
            <a href="registrasi.php">
                <button type="button" class="btn btn-success">Buat Akun Baru</button>
            </a>
        </div>
  </form>

</div>

</body>
</html>