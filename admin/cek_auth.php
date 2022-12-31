<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['nama']) || !isset($_SESSION['level'])) {
    session_destroy();
    header("Location: ../");
}

if(isset($_GET['act'])) {
    if($_GET['act'] == 'logout') {
        session_destroy();
        header("Location: ../");
    }
}

include('../config/db.php');
?>