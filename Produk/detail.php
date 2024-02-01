<?php
@ob_start();
session_start();
if (!empty($_SESSION['admin'])) {
    require '../koneksi.php';
    $lihat = new view($config);
} else {
    echo "<script>alert('Anda belum login!');window.location='../index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk</title>
    <link rel="stylesheet" href="../assets/kasir.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="../assets/img/logo.jpeg" alt="logo" width="150px" style="border-radius: 15px" />
            <h2>Angel Store</h2>
            <ul>
                <li><a href="../kasir.php">Home</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="../Kategori/kategori.php">Kategori</a></li>
                <li><a href="../Penjualan/jual.php">Penjualan</a></li>
                <li><a href="../Proses/Logout/logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="header">
                <h2 style="color: white">Halaman Produk</h2>
            </div>
            <div class="main">
                <div class="box">
                    <?php
                    $id = $_GET['barang'];
                    $hasil = $lihat->barang_edit($id);
                    ?>
                    <div class="box-button">
                        <button><a style="color: #fff;" href="produk.php">Kembali</a></button>
                    </div>
                </div>

                <h1>Detail Produk</h1>
                <table class="table table-striped">
                    <tr>
                        <td>ID Barang</td>
                        <td><?php echo $hasil['id_barang']; ?></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td><?php echo $hasil['nama_kategori']; ?></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td><?php echo $hasil['nama_barang']; ?></td>
                    </tr>
                    <tr>
                        <td>Merk Barang</td>
                        <td><?php echo $hasil['merk']; ?></td>
                    </tr>
                    <tr>
                        <td>Harga Beli</td>
                        <td><?php echo $hasil['harga_beli']; ?></td>
                    </tr>
                    <tr>
                        <td>Harga Jual</td>
                        <td><?php echo $hasil['harga_jual']; ?></td>
                    </tr>
                    <tr>
                        <td>Satuan Barang</td>
                        <td><?php echo $hasil['satuan_barang']; ?></td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td><?php echo $hasil['stok']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Input</td>
                        <td><?php echo $hasil['tgl_input']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Update</td>
                        <td><?php echo $hasil['tgl_update']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>

</html>