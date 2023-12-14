<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if (!checkAgentExist($_SESSION['user']['id'], $conn)) {
  redirect('lengkapi-data-agen.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $is_valid = $_POST['is_valid'];

  $result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $id");
  $transaksi = mysqli_fetch_assoc($result);

  if (!$transaksi || $transaksi['agen_id'] != $_SESSION['user']['agen_id']) {
    setFlashMessage('error', 'Transaksi tidak ditemukan');
    redirectJs('verifikasi-pembayaran.php');
  }

  $status_pembayaran_id = $is_valid ? 4 : 3;
  $status_pengiriman_id = 1;

  $query = "UPDATE transaksi SET status_pembayaran_id = $status_pembayaran_id, status_pengiriman_id = $status_pengiriman_id";

  if (!$is_valid) {
    deleteFile($transaksi['bukti_dp']);
    $query .= ", bukti_dp = NULL";
  }

  $query .= " WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Data transaksi berhasil diperbarui!');

    if ($is_valid) {
      redirectJs('menunggu-pengiriman.php');
    } else {
      redirectJs('belum-bayar.php');
    }
    exit;
  } else {
    setFlashMessage('error', 'Data transaksi gagal diperbarui!');
    redirectJs('verifikasi-pembayaran.php');
    exit;
  }
}
?>