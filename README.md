# ☕ MiniPOS Coffee Shop

Sistem Informasi Kasir (Point of Sales) sederhana berbasis Web yang dibuat untuk memenuhi Tugas UTS. Aplikasi ini dirancang agar kasir dapat mencatat pesanan, menghitung total belanja, memproses kembalian secara otomatis, dan merekam riwayat transaksi ke dalam database.

## 🚀 Fitur Utama
- **Katalog Menu Interaktif:** Menambahkan pesanan ke keranjang belanja hanya dengan satu klik.
- **Auto-Format Rupiah:** Kolom input uang otomatis menambahkan titik ribuan agar kasir tidak salah input nominal.
- **Kalkulasi Cerdas:** Peringatan uang kurang dan kalkulasi uang kembalian secara otomatis.
- **Riwayat Transaksi:** Menampilkan detail pesanan (nama kopi & jumlah) langsung di dalam aplikasi.
- **Database Integration:** Semua transaksi sukses terekam langsung ke MySQL.

## 💻 Teknologi yang Digunakan
* **Frontend:** HTML, CSS, Vanilla JavaScript
* **Backend:** PHP Native
* **Database:** MySQL

## 🛠️ Cara Install & Menjalankan di Localhost (XAMPP)
1. Download atau *clone* repository ini.
2. Pindahkan folder project ke dalam `C:\xampp\htdocs\`.
3. Buka **phpMyAdmin**, buat database baru bernama `minipos_db`.
4. Import file `minipos_db.sql` yang ada di repository ini ke dalam database tersebut.
5. Buka browser dan ketik: `localhost/nama_folder_project_kamu`.
