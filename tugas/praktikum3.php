<?php
class Produk {
    // Tambahkan deklarasi properti agar tidak error di PHP 8.2+
    public $nama;
    public $harga;

    public static $jumlahProduk = 0;

    public function tambahProduk() {
        self::$jumlahProduk++;
    }

}

class Transaksi {

    final public function prosesTransaksi() {
        echo "Transaksi diproses";
    }

}

// 1 & 2. Membuat 5 produk dengan nama dan harga
$p1 = new Produk();
$p1->nama = "Laptop Gaming";
$p1->harga = 15000000;
$p1->tambahProduk();

$p2 = new Produk();
$p2->nama = "Mouse Wireless";
$p2->harga = 350000;
$p2->tambahProduk();

$p3 = new Produk();
$p3->nama = "Keyboard Mechanical";
$p3->harga = 1200000;
$p3->tambahProduk();

$p4 = new Produk();
$p4->nama = "Monitor 144Hz";
$p4->harga = 2500000;
$p4->tambahProduk();

$p5 = new Produk();
$p5->nama = "Headset 7.1";
$p5->harga = 850000;
$p5->tambahProduk();

// 3. Tampilkan total produk
echo "### Ringkasan Inventaris ###<br>";
echo "Total Produk: " . Produk::$jumlahProduk;
echo "<br><hr><br>";

// 4. Simulasikan transaksi untuk ke-5 produk
$transaksi = new Transaksi();

echo "1. " . $p1->nama . " | Rp" . number_format($p1->harga, 0, ',', '.') . " | ";
$transaksi->prosesTransaksi();
echo "<br>";

echo "2. " . $p2->nama . " | Rp" . number_format($p2->harga, 0, ',', '.') . " | ";
$transaksi->prosesTransaksi();
echo "<br>";

echo "3. " . $p3->nama . " | Rp" . number_format($p3->harga, 0, ',', '.') . " | ";
$transaksi->prosesTransaksi();
echo "<br>";

echo "4. " . $p4->nama . " | Rp" . number_format($p4->harga, 0, ',', '.') . " | ";
$transaksi->prosesTransaksi();
echo "<br>";

echo "5. " . $p5->nama . " | Rp" . number_format($p5->harga, 0, ',', '.') . " | ";
$transaksi->prosesTransaksi();

?>