<?php
include('cek_auth.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <?php include('../config/cssjs-admin.php') ?>
</head>
<body class="bg-warning-subtle">
<div>
    <?php include('navbar.php') ?>
    <div class="container-fluid">
    <h2>Upload Excel</h2>
    <form action="upload-excel-proses.php" method="post" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-sm">
                <label class="form-label">Upload Excel Disini...</label>
                <input type="file" name="excelnya" class="form-control" accept=".xlsx, .xls">
            </div>
            <div class="col-sm align-self-end">
                <input class="btn btn-primary" type="submit" value="Upload">
            </div>
        </div>
    </form>
</div>
</body>
</html>