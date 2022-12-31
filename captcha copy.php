<?php 
    // session_start();

    // // generate random number and store in session
    // $randomnr = rand(1000, 9999);
    // $_SESSION['randomnr2'] = md5($randomnr);
    // //generate image
    // $im = imagecreatetruecolor(100, 38);
    // //colors:
    // $white = imagecolorallocate($im, 255, 255, 255);
    // $grey = imagecolorallocate($im, 128, 128, 128);
    // $black = imagecolorallocate($im, 0, 0, 0);
    // imagefilledrectangle($im, 0, 0, 200, 35, $black);

    // // -------------      your fontname    -------------
    // //  example font http://www.webpagepublicity.com/free-fonts/a/Anklepants.ttf
    // $dir= dirname(realpath(__FILE__));
    // $sep=DIRECTORY_SEPARATOR;   
    // $font = $dir.$sep.'calibri.ttf';

    // //draw text:
    // imagettftext($im, 35, 0, 22, 24, $grey, $font, $randomnr);

    // imagettftext($im, 35, 0, 15, 26, $white, $font, $randomnr);

    // // prevent client side  caching
    // // header("Expires: Wed, 1 Jan 2015 00:00:00 GMT");
    // // header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    // // header("Cache-Control: no-store, no-cache, must-revаlidate");
    // // header("Cache-Control: post-check=0, pre-check=0", false);
    // // header("Pragma: no-cache");

    // //send image to browser
    // header ("Content-type: image/PNG");
    // imagegif($im);
    // imagedestroy($im);
    ?>
<?php
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

    //kode acak disimpan di dalam session agar data dapat dipassing ke halaman lain
    $_SESSION["code"] = $code;
    

    //membuat background
    $wh = imagecreatetruecolor(173, 50);
    
    $bgc = imagecolorallocate($wh, 22, 86, 165);
    
    //membuat text warna 
    $fc = imagecolorallocate($wh, 223, 230, 233);
    imagefill($wh, 0, 0, $bgc);
    
    imagestring($wh, 10, 50, 15,  $code, $fc);


    //membuat gambar
    header ("Content-type: image/PNG");

    imagegif($wh);

    imagedestroy($wh);
?>