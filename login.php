<?php
session_start();
include('config/db.php');

if (isset($_POST['btn-login'])) {
    // if(isset($_SESSION['captcha'])) {
    //     $_SESSION['captcha']
    // }
    
    // cek dulu captcha nya
    if($_SESSION['captcha'] != $_POST['captcha']) {
        echo "<script>alert('Captcha Salah. Silahkan coba lagi!')</script>";
    }else {

        // kalo captcha valid, cek login
        $username = $_POST['username'];
        $password = md5($_POST['password']);
    
        $sql = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['level'] = $row['level'];
            // die($row['level']);
            if($row['level'] == 'admin') {
                header("Location: admin/index.php");
            }else {
                header("Location: index.php");
            }
        } else {
            echo "<script>alert('Username atau Password Anda salah. Silahkan coba lagi!')</script>";
        }
        
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>

<body class="bg-danger-subtle text-center"> 
<div class="container-fluid">
    <h1>Login Form</h1>
    <hr>
    <form action="" method="post">
        <label>Username</label><br>
        <input type="text" name="username"><br><br>
        <label>Password</label><br>
        <input type="password" name="password"><br><br>
        <img src="captcha.php"><br><br>
        <input type="text" name="captcha" placeholder="input captcha..."><br><br>
        <input type="submit" name="btn-login" class="btn btn-success" value="Login">
        <a href="index.php" class="btn btn-primary">Kembali</a>
    </form>
</div>
</body>

</html>