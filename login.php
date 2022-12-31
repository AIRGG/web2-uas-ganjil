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
</head>

<body>
    <h1>Login Form</h1>
    <form action="" method="post">
        <label>Username</label><br>
        <input type="text" name="username"><br><br>
        <label>Password</label><br>
        <input type="password" name="password"><br><br>
        <img src="captcha.php"><br>
        <input type="text" name="captcha" placeholder="input captcha..."><br><br>
        <input type="submit" name="btn-login" value="Login">
        <a href="index.php">Kembali</a>
    </form>
</body>

</html>