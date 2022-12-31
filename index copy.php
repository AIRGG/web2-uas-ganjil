<?php
session_start();
include('css.php');
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .flex {
            display: flex;
        }

        .flex>div {
            margin-right: 10px
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Jadwal Matkul</h1>
        <hr>
        <form action="" method="get">
            <!-- <div class="row">
            <div class="col">
                <caption>Filter By:</caption>
            </div>
        </div> -->
            <div class="row g-3">
                <div class="col-sm">
                    <label class="form-label">Hari</label>
                    <input type="text" name="hari" value="<?= isset($_GET["hari"]) ? $_GET["hari"] : ''  ?>" class="form-control">
                </div>
                <div class="col-sm">
                    <label class="form-label">Dosen</label>
                    <input type="text" name="dosen" value="<?= isset($_GET["dosen"]) ? $_GET["dosen"] : ''  ?>" class="form-control">
                </div>
                <div class="col-sm">
                    <label class="form-label">Ruang</label>
                    <input type="text" name="kelas" value="<?= isset($_GET["kelas"]) ? $_GET["kelas"] : ''  ?>" class="form-control">
                </div>
                <div class="col-sm align-self-end">
                    <input class="btn btn-primary" type="submit" value="Filter">
                    <input type="hidden" name="key" value="tamu">
                    <a class="btn btn-link" href="/web2-uts?key=tamu">Refresh</a>
                    <a class="btn btn-danger" href="/web2-uts">Homepage</a>
                </div>
            </div>
        </form>
        <table class="table table-striped table-hover table-sm table-bordered">
            <thead class="table-dark">
                
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</body>

</html>