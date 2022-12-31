<?php
// session_start();
// header('Content-type: image/png');
// $gbr = imagecreate(200, 50);
// imagecolorallocate($gbr, 167, 218, 239);
// $grey = imagecolorallocate($gbr, 128, 128, 128);
// $black = imagecolorallocate($gbr, 0,0,0);
// $font = 'calibri.ttf';

// $captcha = '';
// for ($i=0; $i < 5; $i++) { 
//     $nomor = rand(0, 9);
//     $sudut = rand(-25, 25);
//     $captcha .= $nomor;
//     imagettftext($gbr, 20, $sudut, 8+15 * $i, 25, $black, $font, $nomor);
//     imagettftext($gbr, 20, $sudut, 9+15 * $i, 26, $grey, $font, $nomor);
// }
// imagepng($gbr);
// imagedestroy($gbr);
?>

<?php
//mengaktifkan session
session_start();
 
// header("Content-type: image/png");
 
// menentukan session
$_SESSION["Captcha"]="";
 
// membuat gambar dengan menentukan ukuran
$gbr = imagecreate(200, 50);
 
//warna background captcha
imagecolorallocate($gbr, 69, 179, 157);
// echo $dir .'<br>';
$dir= dirname(realpath(__FILE__));
$sep=DIRECTORY_SEPARATOR;   
// echo $sep;
// pengaturan font captcha
$color = imagecolorallocate($gbr, 253, 252, 252);
$font = $dir.$sep."calibri.ttf"; 
$ukuran_font = 20;
$posisi = 32;
// membuat nomor acak dan ditampilkan pada gambar
for($i=0;$i<=5;$i++) {
	// jumlah karakter
	$angka=rand(0, 9);
 
	$_SESSION["Captcha"].=$angka;
 
	$kemiringan= rand(20, 20);
 	
	imagettftext($gbr, $ukuran_font, $kemiringan, 8+15*$i, $posisi, $color, $font, $angka);	
}
print_r($_SESSION);
//untuk membuat gambar 
header ("Content-type: image/PNG");

imagegif($wh); 
imagedestroy($gbr);
?>