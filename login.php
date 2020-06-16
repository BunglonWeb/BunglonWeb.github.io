<?php
    //cek cookie
    if(isset($_COOKIE['id'])&& isset($_COOKIE['key'])){
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        // ambil username berdasarkan id
        $result= mysqli_query($conn,"SELECT username FROM pengguna WHERE id_pengguna=$id");
        $row=mysqli_fetch_assoc($result);

        //cek cookie
        if($key == hash('sha256',$row['username'])){
            $_SESSION['id_pengguna']=$row['id_pengguna'];
            $_SESSION['username']=$row["username"];
            $_SESSION['foto']=$row["foto"];
            $_SESSION['login-mactoon']= true;
        }
    }

    //cek session
    if(isset($_SESSION["login-mactoon"])){
        echo "<script>document.location.href = 'index.php?p=beranda';</script>";
        exit;
    }

    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($conn,"SELECT * FROM pengguna WHERE username='$username' OR email='$username'");

        if(mysqli_num_rows($result) === 1){
            $row= mysqli_fetch_assoc($result);
            if(password_verify($password,$row["password"])){
                //set session
                $_SESSION['id_pengguna']=$row['id_pengguna'];
                $_SESSION['username']=$row["username"];
                $_SESSION['foto']=$row["foto"];
                $_SESSION['login-mactoon']= true;

                //buat cookie
                setcookie('id',$row['id_pengguna'],time()+86400);
                setcookie('key',hash('sha256',$row['username']),time()+86400);

                echo "<script>document.location.href = 'index.php?p=beranda';</script>";
                exit;
            }
        }
        $error=true;
    }
?>
<div class="container-fluid" style="min-height: 92vh; background-color:#ffffff;">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center" style="margin-top: 6vh;">
            <h4 class="mb-4" style="text-align: center;font-weight: bold;">Log In</h4>
            <?php
                if(isset($error)):?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Login GAGAL!!!</strong> Silahkan Periksa Kembali Username dan Password anda!!.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            <?php endif; ?>

            <form id="form-login" action="" method="post">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required=""/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required=""/>
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="button-login">
                        Log In
                    </button>
                </div>
                <div class="form-group">
                    <a href="" class="login-gmail">G+ Log In with Gmail</a>
                </div>
            </form>
        </div>
    </div>
</div>