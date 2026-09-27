<?php
$host = "127.0.0.1";
$user = "root";
$pass = "UdenISecSV12@S"; 
$db   = "db_sederhana";        

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
