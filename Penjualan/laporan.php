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
                    <table>
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
                                    <a href="../Proses/Tambah/tambah.php?jual=jual&id=<?php echo $hasil['id_barang']; ?>&id_kasir=<?php echo $_SESSION['admin']['id_member']; ?>"></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php
                }
                ?>

                    <h1>Laporan Penjualan</h1>

                    <form method="post" action="laporan.php?page=laporan&cari=ok">
                        <table>
                            <tr>
                                <th>
                                    Pilih Bulan
                                </th>
                                <th>
                                    Pilih Tahun
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="bln">
                                        <option selected="selected">Bulan</option>
                                        <?php
                                        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                        $jlh_bln = count($bulan);
                                        $bln1 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
                                        $no = 1;
                                        for ($c = 0; $c < $jlh_bln; $c += 1) {
                                            echo "<option value='$bln1[$c]'> $bulan[$c] </option>";
                                            $no++;
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <?php
                                    $now = date('Y');
                                    echo "<select name='thn' class='form-control'>";
                                    echo '
								<option selected="selected">Tahun</option>';
                                    for ($a = 2017; $a <= $now; $a++) {
                                        echo "<option value='$a'>$a</option>";
                                    }
                                    echo "</select>";
                                    ?>
                                </td>
                                <td style="display: flex; justify-content: center;">
                                    <input type="hidden" name="periode" value="ya">
                                    <button> Cari
                                    </button>
                                    <a class="btn" href="laporan.php?page=laporan"> Refresh</a>

                                    <?php if (!empty($_GET['cari'])) { ?>
                                        <a class="btn" href="excel.php?cari=yes&bln=<?= $_POST['bln']; ?>&thn=<?= $_POST['thn']; ?>">Excel</a>
                                        <a class="btn" href="pdf.php?cari=yes&bln=<?= $_POST['bln']; ?>&thn=<?= $_POST['thn']; ?>">PDF</a>
                                    <?php } else { ?>
                                        <a class="btn" href="excel.php">Excel</a>
                                        <a class="btn" href="pdf.php">PDF</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <form method="post" action="laporan.php?page=laporan&hari=cek">
                        <table>
                            <tr>
                                <th>
                                    Pilih Hari
                                </th>
                                <th>
                                    Aksi
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="date" value="<?= date('Y-m-d'); ?>" name="hari">
                                </td>
                                <td style="display: flex; justify-content: center; height: 60px; padding-right: 20px;">
                                    <input type="hidden" name="periode" value="ya">
                                    <button>Cari</button>
                                    <a class="btn" href="laporan.php?page=laporan">Refresh</a>

                                    <?php if (!empty($_GET['hari'])) { ?>
                                        <a class="btn" href="excel.php?hari=cek&tgl=<?= $_POST['hari']; ?>">Excel</a>
                                        <a class="btn" href="pdf.php?hari=cek&tgl=<?= $_POST['hari']; ?>">PDF</a>
                                    <?php } else { ?>
                                        <a class="btn" href="excel.php">Excel</a>
                                        <a class="btn" href="pdf.php">PDF</a>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </form>


                    <table>
                        <thead>
                            <tr style="background:#DFF0D8;color:#333;">
                                <th> No</th>
                                <th> ID Barang</th>
                                <th> Nama Barang</th>
                                <th style="width:10%;"> Jumlah</th>
                                <th style="width:10%;"> Modal</th>
                                <th style="width:10%;"> Total</th>
								<th> Kasir</th>
                                <th> Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (!empty($_GET['cari'])) {
                                $periode = $_POST['bln'] . '-' . $_POST['thn'];
                                $no = 1;
                                $jumlah = 0;
                                $bayar = 0;
                                $hasil = $lihat->periode_jual($periode);
                            } elseif (!empty($_GET['hari'])) {
                                $hari = $_POST['hari'];
                                $no = 1;
                                $jumlah = 0;
                                $bayar = 0;
                                $hasil = $lihat->hari_jual($hari);
                            } else {
                                $hasil = $lihat->jual();
                            }
                            ?>
                            <?php
                            $bayar = 0;
                            $jumlah = 0;
                            $modal = 0;
                            foreach ($hasil as $isi) {
                                $bayar += $isi['total'];
                                $modal += $isi['harga_beli'] * $isi['jumlah'];
                                $jumlah += $isi['jumlah'];
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $isi['id_barang']; ?></td>
                                    <td><?php echo $isi['nama_barang']; ?></td>
                                    <td><?php echo $isi['jumlah']; ?> </td>
                                    <td>Rp.<?php echo number_format($isi['harga_beli'] * $isi['jumlah']); ?>,-</td>
                                    <td>Rp.<?php echo number_format($isi['total']); ?>,-</td>
								<td><?php echo $isi['nm_member'];?></td>

                                    <td><?php echo $isi['tanggal_input']; ?></td>
                                </tr>
                            <?php $no++;
                            } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total Terjual</td>
                                <th><?php echo $jumlah; ?></td>
                                <th>Rp.<?php echo number_format($modal); ?>,-</th>
                                <th>Rp.<?php echo number_format($bayar); ?>,-</th>
								<th style="background:#0bb365;color:#fff;">Keuntungan</th>

                                <th style="background:#0bb365;color:#fff;">
                                    Rp.<?php echo number_format($bayar - $modal); ?>,-</th>
                            </tr>
                        </tfoot>
                    </table>
            </div>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>

</html>