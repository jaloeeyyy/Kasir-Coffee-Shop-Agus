<?php
include 'koneksi.php';

if (isset($_POST['total']) && isset($_POST['detail'])) {
    $total_belanja = $_POST['total'];
    $detail_pesanan = $_POST['detail'];

    $query = "INSERT INTO transaksi (total_belanja, detail_pesanan) VALUES ('$total_belanja', '$detail_pesanan')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "Sukses menyimpan data";
    } else {
        echo "Gagal: " . mysqli_error($koneksi);
    }
}
?>