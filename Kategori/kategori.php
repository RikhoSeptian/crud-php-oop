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
                <li><a href="kategori.php">Kategori</a></li>
                <li><a href="../Penjualan/jual.php">Penjualan</a></li>
                <li><a href="../Proses/Logout/logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <div class="header">
                <h2 style="color: white">Data Kategori</h2>
            </div>
            <div class="main">


                <?php
                if (!empty($_GET['uid'])) {
                    $sql = "SELECT * FROM kategori WHERE id_kategori = ?";
                    $row = $config->prepare($sql);
                    $row->execute(array($_GET['uid']));
                    $edit = $row->fetch();
                ?>
                    <form method="POST" action="../Proses/Edit/edit.php?kategori=edit">
                        <table>
                            <tr>
                                <td style="width:25pc;"><input type="text" class="form-control" value="<?= $edit['nama_kategori']; ?>" required name="kategori" placeholder="Masukan Kategori Barang Baru">
                                    <input type="hidden" name="id" value="<?= $edit['id_kategori']; ?>">
                                </td>
                                <td style="padding-left:10px;"><button>Ubah Data</button></td>
                                <td style="padding-left:10px;"><a href="kategori.php"><button>Batal</button></a></td>
                            </tr>
                        </table>
                    </form>
                <?php } else { ?>
                    <form method="POST" action="../Proses/Tambah/tambah.php?kategori=tambah">
                        <table>
                            <tr>
                                <td style="width:25pc;"><input type="text" class="form-control" required name="kategori" placeholder="Masukan Kategori Barang Baru"></td>
                                <td style="padding-left:10px;"><button id="tombol-simpan" class="btn btn-primary"><i class="fa fa-plus"></i>
                                        Insert Data</button></td>
                            </tr>
                        </table>
                    </form>
                <?php } ?>


                <h1>Data Kategori</h1>
                <table>
                    <thead>
                        <th>No.</th>
                        <th>Kategori</th>
                        <th>Tanggal Input</th>
                        <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hasil = $lihat->kategori();
                        $no = 1;
                        foreach ($hasil as $isi) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $isi['nama_kategori']; ?></td>
                                <td><?php echo $isi['tgl_input']; ?></td>
                                <td style="display: flex; justify-content: center;">
                                    <a href="kategori.php?page=kategori&uid=<?php echo $isi['id_kategori']; ?>"><button>Edit</button></a>
                                    <a href="../Proses/Hapus/hapus.php?kategori=hapus&id=<?php echo $isi['id_kategori']; ?>" onclick="javascript:return confirm('Hapus Data Kategori ?');"><button class="btn btn-danger">Hapus</button></a>
                                </td>
                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>

</html>