<?php

$conn = mysqli_connect('localhost', 'root', '', 'db_web2_uas');
if(!$conn){
    echo "Connection Failed";
    die();
}
/*else{
    echo "Connection Success";
}*/

$batas_page = 5;
?>
