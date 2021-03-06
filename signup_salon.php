<?php
include "../koneksi.php";
function submit($data){
    global $conn;
    $nama_salon = mysqli_real_escape_string($conn,$data["nama_salon"]);
    $nohp_salon = mysqli_real_escape_string($conn,$data["nohp_salon"]);
    $alamat = mysqli_real_escape_string($conn,$data["alamat"]);
    $email = mysqli_real_escape_string($conn,$data["email"]);
    $slot = mysqli_real_escape_string($conn,$data["slot"]);
    $status = mysqli_real_escape_string($conn,$data["status"]);

    $username = mysqli_real_escape_string($conn,$data["username"]);
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $confirm_password= mysqli_real_escape_string($conn,$data["confirm_password"]);


    //cek username sudah ada atau belum
    $result = mysqli_query($conn,"SELECT username FROM daftar_salon WHERE username='$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>alert('Username sudah terdaftar!');</script>";
        return false;
    }

    $cek_email = mysqli_query($conn, "SELECT email FROM daftar_salon WHERE email='$email'");
    if(mysqli_fetch_assoc($cek_email)){
        echo "<script> alert('Email sudah digunakan !');</script>";
        return false;
    }
    if($password!==$confirm_password){
        echo "<script>alert('Password tidak sesuai dengan konfirmasi !');</script>";
        return false;
    }
    //enkripsi password
    $password = password_hash($password,PASSWORD_DEFAULT);

    //tambah user baru ke databse
    mysqli_query($conn,"INSERT INTO daftar_salon VALUES('','$nama_salon','$nohp_salon','$alamat','$email','$slot','$status','$username','$password')");
    return mysqli_affected_rows($conn);
}

//cek tombol sign up menjalan fungsi sign up
if(isset($_POST["submit"])){
    if(submit($_POST)>0){
        echo "<script>alert('Selamat Akun Anda Telah Terdaftar, Silahkan Login Untuk Menggunakan Bunglon!!');
                document.location.href='../index.php';
            </script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form by Colorlib</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: #ff9798">

    <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="signup-img">
                    <img src="images/signup-img.jpg" alt="">
                </div>
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form">
                        <h2>salon registration form</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama_salon">Nama Salon :</label>
                                <input type="text" name="nama_salon" id="nama_salon" required/>
                            </div>
                            <div class="form-group">
                                <label for="nohp_salon">Nomor Handphone :</label>
                                <input type="text" name="nohp_salon" id="nohp_salon" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat :</label>
                            <input type="text" name="alamat" id="alamat">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" required/>
                        </div>
                        <div class="form-group">
                            <label for="slot">Slot :</label>
                            <input type="text" name="slot" id="slot">
                        </div>
                        <div class="form-group">
                            <label for="status">Status :</label>
                            <input type="text" name="status" id="status">
                        </div>
                        <div class="form-group">
                            <label for="username">Username :</label>
                            <input type="username" name="username" id="username" />
                        </div>

                        <div class="form-group">
                            <label for="password">password</label>
                            <input type="password" name="password" id="password" required/>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm_password</label>
                            <input type="password" name="confirm_password" id="confirm_password" required/>
                        </div>
                        <div class="form-submit">
                            <input type="submit" value="Sign Up Customer" class="submit" onclick="location.href='signup.php';" />
                            <input type="submit" value="Reset All" class="submit" name="reset" id="reset" />
                            <input type="submit" value="Submit Form" class="submit" name="submit" id="submit" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>