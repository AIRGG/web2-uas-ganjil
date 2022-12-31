<?php
include('cek_auth.php');

$resp['data'] = '';
$resp['msg'] = '';
$resp['success'] = false;
$resp['error'] = false;
if(isset($_POST['act'])) {
    $act = $_POST['act'];
    $cekcrud = array_search($act, ['add', 'edit', 'delete']);
    if($cekcrud || $cekcrud > -1) {
        $idhide = $_POST['idhide'];
        
        $dosen = $_POST['dosen'];
        $kelas = $_POST['kelas'];
        $ruang = $_POST['ruang'];
        $hari = $_POST['hari'];
        $waktu = $_POST['waktu'];
        $matkul = $_POST['matkul'];
        $jj = $_POST['jj'];
        $ta = $_POST['ta'];
        $sem = $_POST['sem'];

        $sql = "INSERT INTO `tbl_matkul`(`id_matkul`, `id_dosen`, `id_ruang`, `id_kelas`, `hari`, `waktu`, `matkul`, `jj`, `ta`, `sem`) VALUES (NULL,'$dosen','$ruang','$kelas','$hari','$waktu','$matkul','$jj','$ta','$sem')";
        if($act == 'edit') {
            $sql = "UPDATE `tbl_matkul` SET `id_dosen`='$dosen',`id_ruang`='$ruang',`id_kelas`='$kelas',`hari`='$hari',`waktu`='$waktu',`matkul`='$matkul',`jj`='$jj',`ta`='$ta',`sem`='$sem' WHERE id_matkul='$idhide'";
        }
        if($act == 'delete') {
            $sql = "DELETE FROM `tbl_matkul` WHERE id_matkul='$idhide'";
        }
        $query = $conn->query($sql);
        if($query) {
            $resp['msg'] = 'success '.$act;
            $resp['success'] = true;
            echo json_encode($resp);
        }
    }
}
// print_r($_GET);
if(isset($_GET['view'])) {
    // $batas_page = 10;
    $page = isset($_GET['page'])?(int)$_GET['page'] : 1;
    $page_awal = ($page>1) ? ($page * $batas_page) - $batas_page : 0;
    $previous = $page - 1;
    $next = $page + 1;

    $tempdata = $conn->query("SELECT count(*) as total from tbl_matkul a LEFT JOIN tbl_dosen b ON a.id_dosen=b.id_dosen LEFT JOIN tbl_kelas c ON a.id_kelas=c.id_kelas LEFT JOIN tbl_ruang d ON a.id_ruang=d.id_ruang");
    $jumlah_data = $tempdata->fetch_assoc()['total'];
    $total_page = ceil($jumlah_data / $batas_page);
    $result = $conn->query("SELECT * FROM tbl_matkul a LEFT JOIN tbl_dosen b ON a.id_dosen=b.id_dosen LEFT JOIN tbl_kelas c ON a.id_kelas=c.id_kelas LEFT JOIN tbl_ruang d ON a.id_ruang=d.id_ruang LIMIT $page_awal, $batas_page");
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $nomor = $page_awal+1;

    $respdata['nomor'] = $nomor;
    $respdata['jumlah_data'] = $jumlah_data;
    $respdata['total_page'] = $total_page;
    $respdata['data'] = $data;

    $resp['msg'] = 'success';
    $resp['success'] = true;
    $resp['data'] = $respdata;
    echo json_encode($resp);
}
?>