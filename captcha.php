<?php
// phpinfo();
// $testGD = get_extension_funcs("gd"); // Grab function list 
// if (!$testGD){ echo "GD not even installed."; exit; }
// echo"<pre>".print_r($testGD,true)."</pre>";
    session_start();
    function acakCaptcha() {
        $kode = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    
        $pass = array(); 

        $panjangkode = strlen($kode) - 2; 
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $panjangkode);
            $pass[] = $kode[$n];
        }
    
        return implode($pass); 
    }
    
    //hasil kode acak disimpan di $code
    $code = acakCaptcha();
    // die($code);
    //kode acak disimpan di dalam session agar data dapat dipassing ke halaman lain
    $_SESSION["captcha"] = $code;

    //membuat background
    $gbr = imagecreatetruecolor(173, 50);
    $bgc = imagecolorallocate($gbr, 181, 52, 113);
    //membuat text warna 
    $fc = imagecolorallocate($gbr, 223, 230, 233);
    imagefill($gbr, 0, 0, $bgc);
    imagestring($gbr, 10, 65, 15,  $code, $fc);

    //membuat gambar
    header ("Content-type: image/PNG");
    imagepng($gbr);
    imagedestroy($gbr);
?>