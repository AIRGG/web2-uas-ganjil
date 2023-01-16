<?php
include('config/db.php');

$resp['data'] = '';
$resp['msg'] = '';
$resp['success'] = false;
$resp['error'] = false;
// print_r($resp);
// die();
// print_r($_GET);
if(isset($_GET['view'])) {
    // -- FILTERING -- \\
    $fil_hari = isset($_GET['hari']) ? $_GET['hari'] : '';
    $fil_dosen = isset($_GET['dosen']) ? $_GET['dosen'] : '';
    $fil_ruang = isset($_GET['ruang']) ? $_GET['ruang'] : '';
    $fil_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

    // $batas_page = 10;
    $page = isset($_GET['page'])?(int)$_GET['page'] : 1;
    $page_awal = ($page>1) ? ($page * $batas_page) - $batas_page : 0;
    $previous = $page - 1;
    $next = $page + 1;

    $sql_count_row = "SELECT count(*) as total from tbl_matkul a 
    LEFT JOIN tbl_dosen b ON a.id_dosen=b.id_dosen 
    LEFT JOIN tbl_kelas c ON a.id_kelas=c.id_kelas 
    LEFT JOIN tbl_ruang d ON a.id_ruang=d.id_ruang WHERE 1=1 ";

    $sql_data = "SELECT * FROM tbl_matkul a 
    LEFT JOIN tbl_dosen b ON a.id_dosen=b.id_dosen 
    LEFT JOIN tbl_kelas c ON a.id_kelas=c.id_kelas 
    LEFT JOIN tbl_ruang d ON a.id_ruang=d.id_ruang WHERE 1=1 ";

    // DO FILTER SQL
    if(strlen($fil_hari) > 0) {
        $sql_count_row .= "  AND hari LIKE '%$fil_hari%'  ";
        $sql_data .= "  AND hari LIKE '%$fil_hari%'  ";
    }
    if(strlen($fil_dosen) > 0) {
        $sql_count_row .= "  AND b.nama_dosen LIKE '%$fil_dosen%'  ";
        $sql_data .= "  AND b.nama_dosen LIKE '%$fil_dosen%'  ";
    }
    if(strlen($fil_ruang) > 0) {
        $sql_count_row .= "  AND d.nama_ruang LIKE '%$fil_ruang%' ";
        $sql_data .= "  AND d.nama_ruang LIKE '%$fil_ruang%' ";
    }
    if(strlen($fil_kelas) > 0) {
        $sql_count_row .= "  AND c.nama_kelas LIKE '%$fil_kelas%' ";
        $sql_data .= "  AND c.nama_kelas LIKE '%$fil_kelas%' ";
    }
    $sql_data .= " LIMIT $page_awal, $batas_page ";
    // die($sql_data);

    $tempdata = $conn->query($sql_count_row);

    $jumlah_data = $tempdata->fetch_assoc()['total'];
    $total_page = ceil($jumlah_data / $batas_page);
    $result = $conn->query($sql_data);
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