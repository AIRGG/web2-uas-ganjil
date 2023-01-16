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


function inputan($id='', $name='', $class='', $type='', $value='', $oninput='', $required=''){
    $inputan = '<input ';
    $inputan .= ($id == '')? '' : ' id="'. $id .'" ';
    $inputan .= ($name == '')? '' : ' name="'. $name .'" ';
    $inputan .= ($class == '')? '' : ' class="'. $class .'" ';
    $inputan .= ($type == '')? '' : ' type="'. $type .'" ';
    $inputan .= ($value == '')? '' : ' value="'. $value .'" ';
    $inputan .= ($oninput == '')? '' : ' oninput="'. $oninput .'" ';
    $inputan .= ($required == '')? '' : ' required ';
    $inputan .= ' /> ';
    return $inputan;
}
?>
