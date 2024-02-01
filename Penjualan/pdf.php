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

require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$bulan_tes = array(
    '01' => "Januari",
    '02' => "Februari",
    '03' => "Maret",
    '04' => "April",
    '05' => "Mei",
    '06' => "Juni",
    '07' => "Juli",
    '08' => "Agustus",
    '09' => "September",
    '10' => "Oktober",
    '11' => "November",
    '12' => "Desember"
);

$html .= '<div class="modal-view">
<h3 style="text-align:center;">';
if (!empty(htmlentities($_GET['cari']))) {
    $html .= 'Data Laporan Penjualan ' . $bulan_tes[htmlentities($_GET['bln'])] . '     ' . htmlentities($_GET['thn']);
} elseif (!empty(htmlentities($_GET['hari']))) {
    $html .= 'Data Laporan Penjualan ' . htmlentities($_GET['tgl']);
} else {
    $html .= 'Data Laporan Penjualan ' . $bulan_tes[date('m')] . ' ' . date('Y');
}
$html .= '</h3>';
$html .= '<table border="1" width="100%" cellpadding="3" cellspacing="4">
            <thead>
                <tr bgcolor="yellow">
                    <th> No</th>
                    <th> ID Barang</th>
                    <th> Nama Barang</th>
                    <th style="width:10%;"> Jumlah</th>
                    <th style="width:10%;"> Modal</th>
                    <th style="width:10%;"> Total</th>
                    <th> Tanggal Input</th>
                </tr>
            </thead>
            <tbody>';
$no = 1;
if (!empty(htmlentities($_GET['cari']))) {
    $periode = htmlentities($_GET['bln']) . '-' . htmlentities($_GET['thn']);
    $no = 1;
    $jumlah = 0;
    $bayar = 0;
    $hasil = $lihat->periode_jual($periode);
} elseif (!empty(htmlentities($_GET['hari']))) {
    $hari = htmlentities($_GET['tgl']);
    $no = 1;
    $jumlah = 0;
    $bayar = 0;
    $hasil = $lihat->hari_jual($hari);
} else {
    $hasil = $lihat->jual();
}
$bayar = 0;
$jumlah = 0;
$modal = 0;
foreach ($hasil as $isi) {
    $bayar += $isi['total'];
    $modal += $isi['harga_beli'] * $isi['jumlah'];
    $jumlah += $isi['jumlah'];
    $html .= '<tr>
            <td>' . $no . '</td>
            <td>' . $isi['id_barang'] . '</td>
            <td>' . $isi['nama_barang'] . '</td>
            <td>' . $isi['jumlah'] . ' </td>
            <td>Rp.' . number_format($isi['harga_beli'] * $isi['jumlah']) . ',-</td>
            <td>Rp.' . number_format($isi['total']) . ',-</td>
            <td>' . $isi['tanggal_input'] . '</td>
        </tr>';
    $no++;
}
$html .= '<tr>
            <td>-</td>
            <td>-</td>
            <td><b>Total Terjual</b></td>
            <td><b>' . $jumlah . '</b></td>
            <td><b>Rp.' . number_format($modal) . ',-</b></td>
            <td><b>Rp.' . number_format($bayar) . ',-</b></td>
            <td><b>
                Rp.' . number_format($bayar - $modal) . ',-</b></td>
        </tr>
    </tbody>
</table>
</div>';
$dompdf->loadHtml($html);
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream("data-laporan-" . date('Y-m-d'));
