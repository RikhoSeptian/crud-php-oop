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

                <!-- modal -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <h1>Tambah Barang
                            <span class="close">&times;</span>
                        </h1>
                        <form action="../Proses/Tambah/tambah.php?barang=tambah" method="POST">

                            <div>
                                <table class="table table-striped bordered">
                                    <?php
                                    $format = $lihat->barang_id();
                                    ?>
                                    <tr>
                                        <td>ID Barang</td>
                                        <td><input type="text" readonly="readonly" required value="<?php echo $format; ?>" class="form-control" name="id"></td>
                                        <td>Nama Barang</td>
                                        <td><input type="text" placeholder="Nama Barang" required class="form-control" name="nama"></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>
                                            <select name="kategori" class="form-control" required>
                                                <option value="#">Pilih Kategori</option>
                                                <?php $kat = $lihat->kategori();
                                                foreach ($kat as $isi) {     ?>
                                                    <option value="<?php echo $isi['id_kategori']; ?>">
                                                        <?php echo $isi['nama_kategori']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>Satuan Barang</td>
                                        <td>
                                            <select name="satuan" class="form-control" required>
                                                <option value="#">Pilih Satuan</option>
                                                <option value="PCS">PCS</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Merk Barang</td>
                                        <td><input type="text" placeholder="Merk Barang" required class="form-control" name="merk"></td>
                                        <td>Stok</td>
                                        <td><input type="number" required Placeholder="Stok" class="form-control" name="stok"></td>
                                    </tr>
                                    <tr>
                                        <td>Harga Beli</td>
                                        <td><input type="number" placeholder="Harga beli" required class="form-control" name="beli"></td>
                                        <td>Harga Jual</td>
                                        <td><input type="number" placeholder="Harga Jual" required class="form-control" name="jual"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Tanggal Input</td>
                                        <td colspan="2"><input type="text" required readonly="readonly" class="form-control" value="<?php echo  date("j F Y, G:i"); ?>" name="tgl"></td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <button type="submit">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                $sql = " select * from barang where stok <= 10";
                $row = $config->prepare($sql);
                $row->execute();
                $r = $row->rowCount();
                if ($r > 0) {
                    echo "
				<div class='alert alert-warning'>
					<span class='glyphicon glyphicon-info-sign'></span> Ada <span style='color:red'>$r</span> barang yang Stok tersisa sudah kurang dari 3 items. silahkan pesan lagi !!
					<span class='pull-right'><a href='index.php?page=barang&stok=yes'>Cek Barang <i class='fa fa-angle-double-right'></i></a></span>
				</div>
				";
                }
                ?>

                <div class="box">
                    <div class="box-button">
                        <button id="add-button">+Tambah</button>
                        <!-- <button class="hapus"><a href="">+ Tambah Barang</a></button> -->
                        <!-- <button class="transaksi"><a href="">+ Tambah Barang</a></button> -->
                        <input type="text" id="search-box" placeholder="Search...">
                    </div>
                    <h1>Data Barang</h1>
                </div>

                <table id="data-table">
                    <thead>
                        <tr style="background:#DFF0D8;color:#333;">
                            <th>No.</th>
                            <th>ID Barang</th>
                            <th>Gambar</th>
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
                    <tbody id="table-body">
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
                                <td><?php if ($isi['gambar_barang'] == null) { ?>
                                        <a href="edit.php?edit&barang=<?php echo $isi['id_barang']; ?>"><button>Upload</button></a>
                                    <?php } else { ?>
                                        <img style="width: 100px;" src="../assets/gambar/<?php echo $isi['gambar_barang']; ?>" alt="">
                                    <?php } ?>
                                </td>
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
                                <td style="display: flex; justify-content: center;">
                                    <?php if ($isi['stok'] <=  '10') { ?>
                                        <form method="POST" action="../Proses/Edit/edit.php?stok=edit">
                                            <input type="text" name="restok" class="form-control">
                                            <input type="hidden" name="id" value="<?php echo $isi['id_barang']; ?>" class="form-control">
                                            <button class="btn btn-primary btn-sm">
                                                Restok
                                            </button>
                                            <a href="../Proses/Hapus/hapus.php?barang=hapus&id=<?php echo $isi['id_barang']; ?>" onclick="javascript:return confirm('Hapus Data barang ?');">
                                                <button>Hapus</button></a>
                                        </form>
                                    <?php } else { ?>
                                        <a href="detail.php?detail&barang=<?php echo $isi['id_barang']; ?>"><button>Details</button></a>
                                        <a href="edit.php?edit&barang=<?php echo $isi['id_barang']; ?>"><button>Edit</button></a>
                                        <a href="../Proses/Hapus/hapus.php?barang=hapus&id=<?php echo $isi['id_barang']; ?>" onclick="javascript:return confirm('Hapus Data barang ?');"><button>Hapus</button></a>
                                        <!-- <a href="../Proses/Tambah/tambah.php?jual=jual&id=<?php echo $isi['id_barang']; ?>&id_kasir=<?php echo $_SESSION['admin']['id_member']; ?>"><button>Pesan</button></a> -->
                                    <?php } ?>
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

    <script src="../assets/script.js"></script>
</body>

</html>