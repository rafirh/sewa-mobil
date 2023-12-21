<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');
redirectIfNotAuthenticated();
checkRole('administrator');

$prevPage = $_SERVER['HTTP_REFERER'] ?? 'verifikasi-pelunasan.php';
if (str_contains($prevPage, 'detail-transaksi.php')) {
  $prevPage = 'verifikasi-pelunasan.php';
}

if (!isParamsExist(['id'])) {
  redirect($prevPage);
}

$id = $_GET['id'];

$qeury = "
  SELECT transaksi.*,
    mobil.nama AS nama_mobil,
    mobil.harga AS harga_mobil,
    merk_mobil.nama AS merk_mobil,
    agen.nama AS nama_agen,
    agen.alamat AS alamat_agen,
    agen.telepon AS telepon_agen,
    user.nama AS nama_customer,
    user.no_hp AS telepon_customer,
    metode_pembayaran.nama AS nama_metode_pembayaran,
    status_pembayaran.status_pembayaran AS nama_status_pembayaran,
    denda.nama AS nama_denda,
    denda.tarif AS tarif_denda
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN merk_mobil ON mobil.merk_id = merk_mobil.id
  JOIN agen ON transaksi.agen_id = agen.id
  JOIN user ON transaksi.user_id = user.id
  LEFT JOIN metode_pembayaran ON transaksi.metode_pembayaran_id = metode_pembayaran.id
  JOIN status_pembayaran ON transaksi.status_pembayaran_id = status_pembayaran.id
  LEFT JOIN denda ON transaksi.denda_id = denda.id
  WHERE transaksi.id = $id AND transaksi.agen_id = {$_SESSION['user']['agen_id']}
";

$result = mysqli_query($conn, $qeury);

if (!$result) {
  redirect($prevPage);
}

$transaksi = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Print Nota</title>
  <style>
    @import url('http://fonts.cdnfonts.com/css/vcr-osd-mono');

    body {
      font-family: 'VCR OSD Mono';
      color: #000;
      text-align: center;
      display: flex;
      justify-content: center;
      font-size: 14px;
      padding-top: 50px;
    }

    .bill {
      width: 60vh;
      box-shadow: 0 0 3px #aaa;
      padding: 10px 10px;
      box-sizing: border-box;
    }

    .flex {
      display: flex;
    }

    .justify-between {
      justify-content: space-between;
    }

    .table {
      border-collapse: collapse;
      width: 100%;
    }

    .table .header {
      border-top: 2px dashed #000;
      border-bottom: 2px dashed #000;
    }

    .table {
      text-align: left;
    }

    .table .total td:first-of-type {
      border-top: none;
      border-bottom: none;
    }

    .table .total td {
      border-top: 2px dashed #000;
      /* border-bottom: 2px dashed #000; */
    }

    .table .net-amount td:first-of-type {
      border-top: none;
    }

    .table .net-amount {
      border-bottom: 2px dashed #000;
    }

    @media print {

      .hidden-print,
      .hidden-print * {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <div class="bill">
    <div class="brand">
      Rental <?= $transaksi['nama_agen'] ?>
    </div>
    <div class="address">
      <?= mb_strimwidth($transaksi['alamat_agen'], 0, 50, '...') ?>
      <br> No. Tel <?= $transaksi['telepon_agen'] ?>
    </div>
    <div class="shop-details">

    </div>
    <div class="bill-details" style="margin: 10px 0 10px 0">
      <div class="flex justify-between">
        <div>Penyewa: <?= mb_strimwidth($transaksi['nama_customer'], 0, 20, '...') ?></div>
      </div>
      <div class="flex justify-between">
        <div>No. Tel: <?= $transaksi['telepon_customer'] ?></div>
      </div>
      <div class="flex justify-between">
        <div>Tanggal: <?= date('d-m-Y', strtotime($transaksi['tanggal_bayar_lunas'] ?? $transaksi['tanggal_dp'])) ?></div>
      </div>
      <div class="flex justify-between">
        <div>Metode Pembayaran: <?= $transaksi['nama_metode_pembayaran'] ?></div>
      </div>
    </div>
    <table class="table">
      <tr class="header">
        <th>
          Mobil
        </th>
        <th>
          Harga
        </th>
        <th>
          Hari
        </th>
        <th>
          Subtotal
        </th>
      </tr>
      <tr>
        <td><?= $transaksi['nama_mobil'] ?> (<?= $transaksi['merk_mobil'] ?>)</td>
        <td><?= format_rupiah($transaksi['harga_mobil']) ?></td>
        <td><?= $transaksi['jumlah_hari'] ?></td>
        <td><?= format_rupiah($transaksi['harga_mobil'] * $transaksi['jumlah_hari']) ?></td>
      </tr>
      <tr class="total">
        <td></td>
        <td colspan="2">Diskon</td>
        <td>- Rp 0</td>
      </tr>
      <tr>
        <td></td>
        <td>Total</td>
        <td></td>
        <td><?= format_rupiah($transaksi['total_harga']) ?></td>
      </tr>
      <tr class="total">
        <td></td>
        <td>Deposit</td>
        <td></td>
        <td><?= format_rupiah($transaksi['jumlah_dp']) ?></td>
      </tr>
      <tr>
        <td></td>
        <td>Kekurangan</td>
        <td></td>
        <td><?= format_rupiah($transaksi['total_harga'] - $transaksi['jumlah_dp']) ?></td>
      </tr>
      <tr>
        <td></td>
        <td>Pelunasan</td>
        <td></td>
        <td><?= format_rupiah($transaksi['jumlah_bayar_lunas']) ?></td>
      </tr>
      <tr class="net-amount total">
        <td></td>
        <td>Status</td>
        <td></td>
        <td><?= $transaksi['nama_status_pembayaran'] ?></td>
      </tr>
    </table>
    <div style="margin-top: 6px">
      Terima telah menyewa mobil kami
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      window.print();
      setTimeout(() => {
        window.location.href = '<?= $prevPage ?>';
      }, 1000);
    })
  </script>
</body>

</html>