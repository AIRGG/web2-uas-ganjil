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
        $kode_kelas = $_POST['kode_kelas'];
        $nama_kelas = $_POST['nama_kelas'];

        $sql = "INSERT INTO `tbl_kelas`(`id_kelas`, `kode_kelas`, `nama_kelas`) VALUES (NULL,'$kode_kelas','$nama_kelas')";
        if($act == 'edit') {
            $sql = "UPDATE `tbl_kelas` SET `kode_kelas`='$kode_kelas',`nama_kelas`='$nama_kelas' WHERE id_kelas='$idhide'";
        }
        if($act == 'delete') {
            $sql = "DELETE FROM `tbl_kelas` WHERE id_kelas='$idhide'";
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

    $tempdata = $conn->query("select count(*) as total from tbl_kelas");
    $jumlah_data = $tempdata->fetch_assoc()['total'];
    $total_page = ceil($jumlah_data / $batas_page);
    $result = $conn->query("select * from tbl_kelas limit $page_awal, $batas_page");
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