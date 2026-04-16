<?php


$host = "sql309.infinityfree.com";
$user = "if0_41585317";
$pass = "xFHfQcZF5dRaLd";
$db   = "if0_41585317_minipos";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>