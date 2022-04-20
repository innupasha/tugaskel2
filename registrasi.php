<?php

require 'functions.php';

if(isset($_POST["registrasi"])) {
    
    if(registrasi($_POST) > 0) {
        echo "<script>alert('Registrasi Sukses');</script>";
    } else {
        echo mysqli_error($conn);
    } 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Registrasi</title>
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

<div class="container mt-0">

    <!-- Heading -->
    <hr>
    <h2>Registrasi</h2>
    <hr>

    <!-- Form registrasi -->
    <form action="" method="post">
        <div class="mb-3 mt-3">
            <label class ="teks2" for="username">Username:</label>
            <input class="form-control" type="text" name="username" id="username" autocomplete="off">
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password" autocomplete="off">
        </div>
        <div class="mb-3 mt-3">
            <label class ="teks2" for="password2">Confirm Password:</label>
            <input class="form-control" type="password" name="password2" id="password2" autocomplete="off">
        </div>
        <div class="mb-3 mt-3">
            <button class="btn btn-success" type="submit" name="registrasi">Registrasi</button>
            <a href="index.php">
            <button class="btn btn-primary" type="button">Kembali Log In</button>
            </a>
        </div>

        
  </form>
  <?php include 'footer.php'; ?>
</div>

</body>
</html>