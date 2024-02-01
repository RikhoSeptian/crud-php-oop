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
                    <h1>Edit Barang</h1>
                </div>

                <table>
                    <form action="../Proses/Edit/edit.php?barang=edit" method="POST">
                        <tr>
                            <td>ID Barang</td>
                            <td><input type="text" readonly="readonly" value="<?php echo $hasil['id_barang']; ?>" name="id"></td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>
                                <select name="kategori" style="width: 100%;">
                                    <option value="<?php echo $hasil['id_kategori']; ?>"><?php echo $hasil['nama_kategori']; ?></option>
                                    <option value="#">Pilih Kategori</option>
                                    <?php $kat = $lihat->kategori();
                                    foreach ($kat as $isi) {     ?>
                                        <option value="<?php echo $isi['id_kategori']; ?>"><?php echo $isi['nama_kategori']; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Barang</td>
                            <td><input type="text" value="<?php echo $hasil['nama_barang']; ?>" name="nama"></td>
                        </tr>
                        <tr>
                            <td>Merk Barang</td>
                            <td><input type="text" value="<?php echo $hasil['merk']; ?>" name="merk"></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td><input type="number" value="<?php echo $hasil['harga_beli']; ?>" name="beli"></td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td><input type="number" value="<?php echo $hasil['harga_jual']; ?>" name="jual"></td>
                        </tr>
                        <tr>
                            <td>Satuan Barang</td>
                            <td>
                                <select name="satuan" style="width: 100%;">
                                    <option value="<?php echo $hasil['satuan_barang']; ?>"><?php echo $hasil['satuan_barang']; ?>
                                    </option>
                                    <option value="#">Pilih Satuan</option>
                                    <option value="PCS">PCS</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td><input type="number" class="form-control" value="<?php echo $hasil['stok']; ?>" name="stok"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Update</td>
                            <td><input type="text" readonly="readonly" class="form-control" value="<?php echo  date("j F Y, G:i"); ?>" name="tgl"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button>Simpan</button></td>
                        </tr>
                    </form>
                    <tr>
                        <td>Gambar</td>
                        <td style="display: flex; flex-direction: column;">
                            <img style="width: 100px; margin-right: 10px;" src="../assets/gambar/<?php echo $hasil['gambar_barang']; ?>" alt="#" />
                            <form method="POST" action="../Proses/Edit/edit.php?gambar_barang=barang" enctype="multipart/form-data">
                                <input type="file" accept="image/*" name="foto">
                                <input type="hidden" value="<?php echo $hasil['gambar_barang']; ?>" name="foto2">
                                <input type="hidden" name="id" value="<?php echo $hasil['id_barang']; ?>">
                                <button type="submit" value="Tambah">Ganti Foto</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>

</html>