<?php
@ob_start();
session_start();
if(!empty($_SESSION['admin'])){
    require 'koneksi.php';
    $lihat = new view($config);
}else{
    echo "<script>alert('Anda belum login!');window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aplikasi</title>
    <link rel="stylesheet" href="assets/kasir.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="assets/img/logo.jpeg" alt="logo" width="150px" style="border-radius: 15px" />
            <h2>Angel Store</h2>
            <ul>
                <li><a href="kasir.php">Home</a></li>
                <li><a href="Produk/produk.php">Produk</a></li>
                <li><a href="Kategori/kategori.php">Kategori</a></li>
                <li><a href="Penjualan/jual.php">Penjualan</a></li>
                <li><a href="Proses/Logout/logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="header">
                <h2 style="color: white">Data Produk Yang di jual</h2>
            </div>
            <div class="main">
                <table>
                    <thead>
                        <tr style="background:#DFF0D8;color:#333;">
                            <th>No.</th>
                            <th>ID Barang</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalBeli = 0;
                        $totalJual = 0;
                        $totalStok = 0;
                        if ($_GET['stok'] == 'yes') {
                            $hasil = $lihat->barang_stok();
                        } else {
                            $hasil = $lihat->barang();
                        }
                        $no = 1;
                        foreach ($hasil as $isi) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['id_barang']; ?></td>
                                <td><?php echo $isi['nama_kategori']; ?></td>
                                <td><?php echo $isi['nama_barang']; ?></td>
                                <td><?php echo $isi['merk']; ?></td>
                                <td>
                                    <?php if ($isi['stok'] == '0') { ?>
                                        <button class="btn btn-danger"> Habis</button>
                                    <?php } else { ?>
                                        <?php echo $isi['stok']; ?>
                                    <?php } ?>
                                </td>
                                <td>Rp.<?php echo number_format($isi['harga_beli']); ?>,-</td>
                                <td>Rp.<?php echo number_format($isi['harga_jual']); ?>,-</td>
                                <td> <?php echo $isi['satuan_barang']; ?></td>
                                <td><a style="padding: 5px;background-color: #333; text-decoration: none; color: #ddd; border-radius: 5px;" href="Proses/Tambah/tambah.php?jual=jual&id=<?php echo $isi['id_barang']; ?>&id_kasir=<?php echo $_SESSION['admin']['id_member']; ?>" class="beli">Pesan</a></td>
                            </tr>
                        <?php
                            $no++;
                            $totalBeli += $isi['harga_beli'] * $isi['stok'];
                            $totalJual += $isi['harga_jual'] * $isi['stok'];
                            $totalStok += $isi['stok'];
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total </td>
                            <th><?php echo $totalStok; ?></td>
                            <th>Rp.<?php echo number_format($totalBeli); ?>,-</td>
                            <th>Rp.<?php echo number_format($totalJual); ?>,-</td>
                            <th colspan="2" style="background:#ddd"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- <script src="assets/script.js"></script> -->
</body>

</html>