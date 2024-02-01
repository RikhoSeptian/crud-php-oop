<?php
@ob_start();
session_start();
if(!empty($_SESSION['admin'])){
    require '../koneksi.php';
    $lihat = new view($config);
}else{
    echo "<script>alert('Anda belum login!');window.location='../index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kategori</title>
    <link rel="stylesheet" href="../assets/kasir.css">
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="../assets/img/logo.jpeg" alt="logo" width="150px" style="border-radius: 15px" />
            <h2>Angel Store</h2>
            <ul>
                <li><a href="../kasir.php">Home</a></li>
                <li><a href="../Produk/produk.php">Produk</a></li>
                <li><a href="../Kategori/kategori.php">Kategori</a></li>
                <li><a href="jual.php">Penjualan</a></li>
                <li><a href="laporan.php">Laporan</a></li>
                <li><a href="../Proses/Logout/logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="header">
                <h2 style="color: white">Halaman Penjualan</h2>
            </div>
            <div class="main">


                <?php
                if ($cari == '') {
                } else {
                    $sql = "select barang.*, kategori.id_kategori, kategori.nama_kategori
					from barang inner join kategori on barang.id_kategori = kategori.id_kategori
					where barang.id_barang like '%$cari%' or barang.nama_barang like '%$cari%' or barang.merk like '%$cari%'";
                    $row = $config->prepare($sql);
                    $row->execute();
                    $hasil1 = $row->fetchAll();
                ?>
                    <table class="table table-stripped" width="100%" id="example2">
                        <tr>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                        <?php foreach ($hasil1 as $hasil) { ?>
                            <tr>
                                <td><?php echo $hasil['id_barang']; ?></td>
                                <td><?php echo $hasil['nama_barang']; ?></td>
                                <td><?php echo $hasil['merk']; ?></td>
                                <td><?php echo $hasil['harga_jual']; ?></td>
                                <td>
                                    <a href="fungsi/tambah/tambah.php?jual=jual&id=<?php echo $hasil['id_barang']; ?>&id_kasir=<?php echo $_SESSION['admin']['id_member']; ?>" class="btn btn-success">
                                        <i class="fa fa-shopping-cart"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php
                }
                ?>

                <h1>Penjualan Barang</h1>

                <table class="table table-bordered">
                    <tr>
                        <td><b>Tanggal</b></td>
                        <td><input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" name="tgl"></td>
                    </tr>
                </table>
                <table class="table table-bordered w-100" id="example1">
                    <thead>
                        <tr>
                            <td> No</td>
                            <td> Nama Barang</td>
                            <td style="width:10%;"> Jumlah</td>
                            <td style="width:20%;"> Total</td>
                            <!-- <td> Kasir</td> -->
                            <td> Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_bayar = 0;
                        $no = 1;
                        $hasil_penjualan = $lihat->penjualan(); ?>
                        <?php foreach ($hasil_penjualan  as $isi) { ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['nama_barang']; ?></td>
                                <td>
                                    <!-- aksi ke table penjualan -->
                                    <form method="POST" action="../Proses/Edit/edit.php?jual=jual">
                                        <input type="number" name="jumlah" value="<?php echo $isi['jumlah']; ?>" class="form-control">
                                        <input type="hidden" name="id" value="<?php echo $isi['id_penjualan']; ?>" class="form-control">
                                        <input type="hidden" name="id_barang" value="<?php echo $isi['id_barang']; ?>" class="form-control">
                                </td>
                                <td>Rp.<?php echo number_format($isi['total']); ?>,-</td>
                                <!-- <td><?php echo $isi['nm_member']; ?></td> -->
                                <td>
                                    <button type="submit">Update</button>
                                    </form>
                                    <!-- aksi ke table penjualan -->
                                    <a href="../Proses/Hapus/hapus.php?jual=jual&id=<?php echo $isi['id_penjualan']; ?>&brg=<?php echo $isi['id_barang']; ?>&jml=<?php echo $isi['jumlah']; ?>"><button>X</button>
                                    </a>
                                </td>
                            </tr>
                        <?php $no++;
                            $total_bayar += $isi['total'];
                        } ?>
                    </tbody>
                </table>
                <br />
                <?php $hasil = $lihat->jumlah(); ?>

                <table>
                    <?php
                    // proses bayar dan ke nota
                    if (!empty($_GET['nota'] == 'yes')) {
                        $total = $_POST['total'];
                        $bayar = $_POST['bayar'];
                        if (!empty($bayar)) {
                            $hitung = $bayar - $total;
                            if ($bayar >= $total) {
                                $id_barang = $_POST['id_barang'];
                                $id_member = $_POST['id_member'];
                                $jumlah = $_POST['jumlah'];
                                $total = $_POST['total1'];
                                $tgl_input = $_POST['tgl_input'];
                                $periode = $_POST['periode'];
                                $jumlah_dipilih = count($id_barang);

                                for ($x = 0; $x < $jumlah_dipilih; $x++) {

                                    $d = array($id_barang[$x], $id_member[$x], $jumlah[$x], $total[$x], $tgl_input[$x], $periode[$x]);
                                    $sql = "INSERT INTO nota (id_barang,id_member,jumlah,total,tanggal_input,periode) VALUES(?,?,?,?,?,?)";
                                    $row = $config->prepare($sql);
                                    $row->execute($d);

                                    // ubah stok barang
                                    $sql_barang = "SELECT * FROM barang WHERE id_barang = ?";
                                    $row_barang = $config->prepare($sql_barang);
                                    $row_barang->execute(array($id_barang[$x]));
                                    $hsl = $row_barang->fetch();

                                    $stok = $hsl['stok'];
                                    $idb  = $hsl['id_barang'];

                                    $total_stok = $stok - $jumlah[$x];
                                    // echo $total_stok;
                                    $sql_stok = "UPDATE barang SET stok = ? WHERE id_barang = ?";
                                    $row_stok = $config->prepare($sql_stok);
                                    $row_stok->execute(array($total_stok, $idb));
                                }
                                echo '<script>alert("Belanjaan Berhasil Di Bayar !");</script>';
                            } else {
                                echo '<script>alert("Uang Kurang ! Rp.' . $hitung . '");</script>';
                            }
                        }
                    }
                    ?>
                    <!-- aksi ke table nota -->
                    <form method="POST" action="jual.php?page=jual&nota=yes#kasirnya">
                        <?php foreach ($hasil_penjualan as $isi) {; ?>
                            <input type="hidden" name="id_barang[]" value="<?php echo $isi['id_barang']; ?>">
                            <input type="hidden" name="id_member[]" value="<?php echo $isi['id_member']; ?>">
                            <input type="hidden" name="jumlah[]" value="<?php echo $isi['jumlah']; ?>">
                            <input type="hidden" name="total1[]" value="<?php echo $isi['total']; ?>">
                            <input type="hidden" name="tgl_input[]" value="<?php echo $isi['tanggal_input']; ?>">
                            <input type="hidden" name="periode[]" value="<?php echo date('m-Y'); ?>">
                        <?php $no++;
                        } ?>
                        <tr>
                            <td>Total Semua </td>
                            <td><input type="text" name="total" value="<?php echo $total_bayar; ?>"></td>

                            <td>Bayar </td>
                            <td><input type="text" name="bayar" value="<?php echo $bayar; ?>"></td>
                            <td><button>Bayar</button>
                                <?php if (!empty($_GET['nota'] == 'yes')) { ?>
                                    <td><a class="btn" href="../Proses/Hapus/hapus.php?penjualan=jual"><b>RESET</b></a></td>
                            </td><?php } ?></td>
                        </tr>
                    </form>
                    <!-- aksi ke table nota -->
                    <tr>
                        <td>Kembali</td>
                        <td><input type="text" value="<?php echo $hitung; ?>"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>

</html>