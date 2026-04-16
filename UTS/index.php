<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir Coffee Shop</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f9; color: #333; }
        .container { display: flex; height: 100vh; overflow: hidden; }
        
        .katalog-area { flex: 7; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; }
        .judul-section { margin-bottom: 20px; color: #444; }
        
        .katalog-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; flex-grow: 1; align-content: start; }
        
        .kartu-produk {
            background: #fff; padding: 15px; text-align: center;
            border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            cursor: pointer; border: 2px solid transparent; transition: 0.2s;
        }
        .kartu-produk:hover { border-color: #6f4e37; transform: translateY(-2px); }
        .harga { color: #6f4e37; font-weight: bold; margin-top: 5px; margin-bottom: 10px; }
        
        .gambar-produk { width: 100%; height: 120px; object-fit: cover; border-radius: 6px; }
        
        .keranjang-area {
            flex: 3; background: #fff; padding: 20px; border-left: 1px solid #ddd; 
            display: flex; flex-direction: column; box-shadow: -2px 0 10px rgba(0,0,0,0.05);
        }
        .daftar-pesanan { flex-grow: 1; overflow-y: auto; margin-bottom: 20px; }
        .item-pesanan { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .detail-item { flex-grow: 1; }
        .harga-item { font-weight: bold; }
        
        .btn-kurang {
            background: #dc3545; color: white; border: none; border-radius: 4px;
            padding: 2px 8px; cursor: pointer; font-size: 0.9em; margin-left: 8px;
        }
        .btn-kurang:hover { background: #c82333; }
        
        .total-area { border-top: 2px dashed #ccc; padding-top: 20px; }
        .total-harga { font-size: 1.5em; font-weight: bold; margin-bottom: 20px; display: flex; justify-content: space-between; color: #d9534f; }
        .btn-bayar {
            width: 100%; padding: 15px; background: #28a745; color: white;
            border: none; border-radius: 8px; font-size: 1.2em; 
            cursor: pointer; font-weight: bold; transition: 0.2s;
        }
        .btn-bayar:hover { background: #218838; }
        .btn-bayar:disabled { background: #ccc; cursor: not-allowed; }

        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 999; justify-content: center; align-items: center;
        }
        .modal-box {
            background: #fff; width: 450px; border-radius: 10px; padding: 25px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .modal-header { border-bottom: 2px dashed #eee; padding-bottom: 15px; margin-bottom: 15px; text-align: center; }
        .modal-header h3 { margin: 0; color: #333; font-size: 1.5em; }
        .modal-body ul { list-style: none; padding: 0; max-height: 200px; overflow-y: auto; margin-bottom: 15px; }
        .modal-body li { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 1em; color: #555; }
        .modal-total { display: flex; justify-content: space-between; font-weight: bold; font-size: 1.3em; margin-bottom: 20px; color: #d9534f; border-top: 2px dashed #eee; padding-top: 15px;}
        .input-uang { width: 100%; padding: 12px; font-size: 1.2em; border: 2px solid #ccc; border-radius: 6px; margin-bottom: 20px; text-align: right; }
        .input-uang:focus { border-color: #28a745; outline: none; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; }
        .btn-tutup { background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 1em; }
        .btn-tutup:hover { background: #5a6268; }
        .btn-proses { background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-size: 1em; font-weight: bold; }
        .btn-proses:hover { background: #218838; }

        #modal-sukses .modal-header h3 { color: #28a745; font-size: 1.8em; }
        #modal-sukses .modal-header .checkmark { display: block; font-size: 3em; color: #28a745; margin-bottom: 10px; }
        .success-summary { background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #eee; }
        .success-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 1.1em; color: #444; }
        .success-label { color: #666; font-weight: normal; }
        .success-value { font-weight: bold; }
        .success-change { font-size: 1.3em; color: #28a745; margin-top: 10px; border-top: 1px solid #eee; padding-top: 10px;}
        #modal-sukses .modal-footer { justify-content: center; }
        #modal-sukses .btn-proses { background: #007bff; }
        #modal-sukses .btn-proses:hover { background: #0069d9; }

        .area-tombol-riwayat {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px dashed #ddd;
            text-align: right;
        }
        .btn-riwayat {
            background: #17a2b8; color: white; border: none; padding: 15px 25px; 
            border-radius: 8px; cursor: pointer; font-size: 1.1em; font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.2s;
        }
        .btn-riwayat:hover { background: #138496; }
        .table-riwayat { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-riwayat th, .table-riwayat td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .table-riwayat th { background-color: #f4f4f9; color: #333; }
    </style>
</head>
<body>

    <div class="container">
        <div class="katalog-area">
            <h2 class="judul-section">Menu Coffee Shop</h2>
            <div class="katalog-grid">
                
                <?php
                $query = "SELECT * FROM produk";
                $result = mysqli_query($koneksi, $query);

                $daftar_gambar = [
                    'Espresso' => 'espresso.jpg',
                    'Americano (Hot/Ice)' => 'americano.jpg',
                    'Cafe Latte' => 'cafe latte.jpg',
                    'Caffe Latte' => 'cafe latte.jpg',
                    'Cappuccino' => 'cappuccino.jpg',
                    'Caramel Macchiato' => 'caramel macchiato.jpg',
                    'Matcha Latte' => 'matcha latte.jpg',
                    'Croissant Butter' => 'croissant butter.jpg',
                    'Butter Croissant' => 'croissant butter.jpg',
                    'Fudgy Brownie' => 'fudgy brownie.jpg'
                ];

                while ($row = mysqli_fetch_assoc($result)) {
                    $nama_produk = $row['nama_produk'];
                    $file_gambar = isset($daftar_gambar[$nama_produk]) ? $daftar_gambar[$nama_produk] : 'espresso.jpg';
                ?>
                    <div class="kartu-produk" onclick="tambahKeKeranjang('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">
                        <h3><?= $row['nama_produk']; ?></h3>
                        <p class="harga">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                        <img src="img/<?= $file_gambar; ?>" alt="<?= $row['nama_produk']; ?>" class="gambar-produk">
                    </div>
                <?php
                }
                ?>
                
            </div>
            
            <div class="area-tombol-riwayat">
                <button class="btn-riwayat" onclick="bukaModalRiwayat()">📋 Lihat Riwayat Transaksi</button>
            </div>
        </div>

        <div class="keranjang-area">
            <h2 class="judul-section">Keranjang</h2>
            <div class="daftar-pesanan" id="tempat-pesanan">
                <div class="item-pesanan">
                    <span>- Belum ada pesanan -</span>
                </div>
            </div>
            <div class="total-area">
                <div class="total-harga">
                    <span>Total:</span>
                    <span id="angka-total">Rp 0</span>
                </div>
                <button class="btn-bayar" id="tombol-bayar" disabled>Bayar Sekarang</button>
            </div>
        </div>
    </div>

    <div id="modal-pembayaran" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Struk Pembayaran</h3>
            </div>
            <div class="modal-body">
                <ul id="list-struk"></ul>
                <div class="modal-total">
                    <span>Total Harga:</span>
                    <span id="total-struk">Rp 0</span>
                </div>
                <label style="display:block; margin-bottom:8px; font-weight:bold; color:#444;">Nominal Uang Pelanggan (Rp):</label>
                <input type="text" id="input-uang" class="input-uang" placeholder="Contoh: 100.000" oninput="formatRupiah(this)">
            </div>
            <div class="modal-footer">
                <button class="btn-tutup" onclick="tutupModal()">Close</button>
                <button class="btn-proses" onclick="prosesBayar()">Bayar</button>
            </div>
        </div>
    </div>

    <div id="modal-sukses" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <span class="checkmark">✅</span>
                <h3>Transaksi Berhasil!</h3>
            </div>
            <div class="modal-body">
                <p style="text-align:center; margin-bottom: 20px; font-size: 1.1em;">Pembayaran Telah Diterima. Berikut Rinciannya:</p>
                <div class="success-summary">
                    <div class="success-row">
                        <span class="success-label">Total Harga:</span>
                        <span id="sukses-total" class="success-value">Rp 0</span>
                    </div>
                    <div class="success-row">
                        <span class="success-label">Uang Diterima:</span>
                        <span id="sukses-uang" class="success-value">Rp 0</span>
                    </div>
                    <div class="success-row success-change">
                        <span class="success-label">Kembalian:</span>
                        <span id="sukses-kembalian" class="success-value">Rp 0</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-proses" onclick="window.print()">Cetak Struk</button>
                <button class="btn-tutup" onclick="tutupModalSukses()">Tutup & Lanjut</button>
            </div>
        </div>
    </div>

    <div id="modal-riwayat" class="modal-overlay">
        <div class="modal-box" style="width: 800px; max-height: 90vh; display: flex; flex-direction: column;">
            <div class="modal-header">
                <h3>Riwayat Penjualan</h3>
            </div>
            <div class="modal-body" style="overflow-y: auto; flex-grow: 1;">
                <table class="table-riwayat">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Waktu Transaksi</th>
                            <th width="50%">Detail Pesanan</th>
                            <th width="25%">Total Belanja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_riwayat = "SELECT * FROM transaksi ORDER BY tanggal DESC";
                        $res_riwayat = mysqli_query($koneksi, $query_riwayat);
                        $no = 1;

                        if(mysqli_num_rows($res_riwayat) > 0) {
                            while($row_riw = mysqli_fetch_assoc($res_riwayat)) {
                                $tgl = date('d-m-Y H:i', strtotime($row_riw['tanggal']));
                                
                                $detail = !empty($row_riw['detail_pesanan']) ? $row_riw['detail_pesanan'] : '<i>- Detail belum dicatat -</i>';
                                
                                $tot = number_format($row_riw['total_belanja'], 0, ',', '.');
                                
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$tgl}</td>
                                        <td>{$detail}</td>
                                        <td style='font-weight:bold; color:#d9534f;'>Rp {$tot}</td>
                                      </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center; padding:20px;'>Belum ada transaksi.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="margin-top: 20px;">
                <button class="btn-tutup" onclick="tutupModalRiwayat()">Tutup Riwayat</button>
            </div>
        </div>
    </div>

    <script>
        let keranjang = [];
        let totalBelanja = 0;

        function tambahKeKeranjang(namaProduk, hargaProduk) {
            let indexProduk = keranjang.findIndex(item => item.nama === namaProduk);
            if (indexProduk > -1) {
                keranjang[indexProduk].qty += 1;
                keranjang[indexProduk].subtotal = keranjang[indexProduk].qty * hargaProduk;
            } else {
                keranjang.push({ nama: namaProduk, harga: hargaProduk, qty: 1, subtotal: hargaProduk });
            }
            updateTampilanKeranjang();
        }

        function kurangiPesanan(namaProduk) {
            let indexProduk = keranjang.findIndex(item => item.nama === namaProduk);
            if (indexProduk > -1) {
                if (keranjang[indexProduk].qty > 1) {
                    keranjang[indexProduk].qty -= 1;
                    keranjang[indexProduk].subtotal = keranjang[indexProduk].qty * keranjang[indexProduk].harga;
                } else {
                    keranjang.splice(indexProduk, 1);
                }
                updateTampilanKeranjang();
            }
        }

        function updateTampilanKeranjang() {
            let tempatPesanan = document.getElementById('tempat-pesanan');
            let angkaTotal = document.getElementById('angka-total');
            let tombolBayar = document.getElementById('tombol-bayar');
            
            let htmlKeranjang = '';
            totalBelanja = 0;

            if (keranjang.length === 0) {
                htmlKeranjang = '<div class="item-pesanan"><span>- Belum ada pesanan -</span></div>';
                tombolBayar.disabled = true;
            } else {
                tombolBayar.disabled = false;
                keranjang.forEach(item => {
                    totalBelanja += item.subtotal;
                    let formatHarga = item.harga.toLocaleString('id-ID');
                    let formatSubtotal = item.subtotal.toLocaleString('id-ID');

                    htmlKeranjang += `
                        <div class="item-pesanan">
                            <div class="detail-item">
                                <div>${item.nama}</div>
                                <small>${item.qty}x @ Rp ${formatHarga} <button class="btn-kurang" onclick="kurangiPesanan('${item.nama}')">- Kurangi</button></small>
                            </div>
                            <div class="harga-item">Rp ${formatSubtotal}</div>
                        </div>
                    `;
                });
            }
            tempatPesanan.innerHTML = htmlKeranjang;
            angkaTotal.innerText = 'Rp ' + totalBelanja.toLocaleString('id-ID');
        }

        function formatRupiah(input) {
            let angka = input.value.replace(/\D/g, '');
            if (angka !== "") {
                input.value = parseInt(angka, 10).toLocaleString('id-ID');
            } else {
                input.value = "";
            }
        }

        document.getElementById('tombol-bayar').addEventListener('click', function() {
            document.getElementById('modal-pembayaran').style.display = 'flex';
            let listStruk = document.getElementById('list-struk');
            listStruk.innerHTML = ''; 
            keranjang.forEach(item => {
                let formatSubtotal = item.subtotal.toLocaleString('id-ID');
                listStruk.innerHTML += `<li><span>${item.qty}x ${item.nama}</span> <span>Rp ${formatSubtotal}</span></li>`;
            });
            document.getElementById('total-struk').innerText = 'Rp ' + totalBelanja.toLocaleString('id-ID');
            document.getElementById('input-uang').value = '';
            document.getElementById('input-uang').focus(); 
        });

        function tutupModal() {
            document.getElementById('modal-pembayaran').style.display = 'none';
        }

        function prosesBayar() {
            let inputMentah = document.getElementById('input-uang').value;
            
            if (inputMentah === "") {
                alert("Harap masukkan nominal uang!");
                return;
            }

            let uangMasuk = parseInt(inputMentah.replace(/\./g, ''));

            if (isNaN(uangMasuk)) {
                alert("Gagal! Harap masukkan angka yang valid.");
            } else if (uangMasuk < totalBelanja) {
                let kurang = totalBelanja - uangMasuk;
                alert("Uang tidak cukup!\nKurang Rp " + kurang.toLocaleString('id-ID'));
            } else {
                let kembalian = uangMasuk - totalBelanja;
                
                document.getElementById('modal-sukses').style.display = 'flex';
                document.getElementById('sukses-total').innerText = 'Rp ' + totalBelanja.toLocaleString('id-ID');
                document.getElementById('sukses-uang').innerText = 'Rp ' + uangMasuk.toLocaleString('id-ID');
                document.getElementById('sukses-kembalian').innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                
                tutupModal(); 

                let detailPesananStr = "";
                keranjang.forEach(item => {
                    detailPesananStr += `${item.qty}x ${item.nama}, `;
                });
                detailPesananStr = detailPesananStr.slice(0, -2); // Hapus koma terakhir

                let dataKirim = new FormData();
                dataKirim.append('total', totalBelanja);
                dataKirim.append('detail', detailPesananStr); // Kirim rincian ke PHP

                fetch('simpan_transaksi.php', {
                    method: 'POST',
                    body: dataKirim
                }).then(response => response.text())
                  .then(hasil => {
                      console.log("Database: ", hasil); 
                  });
            }
        }

        function tutupModalSukses() {
            document.getElementById('modal-sukses').style.display = 'none';
            // agar data di Riwayat Penjualan langsung ter-update otomatis.
            location.reload();
        }

        function bukaModalRiwayat() {
            document.getElementById('modal-riwayat').style.display = 'flex';
        }
        function tutupModalRiwayat() {
            document.getElementById('modal-riwayat').style.display = 'none';
        }
    </script>

</body>
</html>