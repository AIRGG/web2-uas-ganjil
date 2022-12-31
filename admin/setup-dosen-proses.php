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
        $nip = $_POST['nip'];
        $nama_dosen = $_POST['nama_dosen'];
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        $sql = "INSERT INTO `tbl_dosen`(`id_dosen`, `nip`, `nama_dosen`, `email`, `nohp`, `alamat`) VALUES (NULL,'$nip','$nama_dosen','$email','$no_hp','$alamat')";
        if($act == 'edit') {
            $sql = "UPDATE `tbl_dosen` SET `nip`='$nip',`nama_dosen`='$nama_dosen',`email`='$email',`nohp`='$no_hp',`alamat`='$alamat' WHERE id_dosen='$idhide'";
        }
        if($act == 'delete') {
            $sql = "DELETE FROM `tbl_dosen` WHERE id_dosen='$idhide'";
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

    $tempdata = $conn->query("select count(*) as total from tbl_dosen");
    $jumlah_data = $tempdata->fetch_assoc()['total'];
    $total_page = ceil($jumlah_data / $batas_page);
    $result = $conn->query("select * from tbl_dosen limit $page_awal, $batas_page");
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