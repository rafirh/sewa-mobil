<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $id");
  $transaksi = mysqli_fetch_assoc($result);

  if (!$transaksi || $transaksi['agen_id'] != $_SESSION['user']['agen_id']) {
    setFlashMessage('error', 'Transaksi tidak ditemukan');
    redirectJs('belum-bayar.php');
  }

  $query = "DELETE FROM transaksi WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Pesanan berhasil dibatalkan!');
    redirectJs('belum-bayar.php');
    exit;
  } else {
    setFlashMessage('error', 'Pesanan gagal dibatalkan!');
    redirectJs('belum-bayar.php');
    exit;
  }
}
?>