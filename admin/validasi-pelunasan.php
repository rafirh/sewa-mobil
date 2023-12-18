<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $is_valid = $_POST['is_valid'];

  $result = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $id");
  $transaksi = mysqli_fetch_assoc($result);

  if (!$transaksi) {
    setFlashMessage('error', 'Transaksi tidak ditemukan');
    redirectJs('verifikasi-pelunasan.php');
  }

  $status_pembayaran_id = $is_valid ? 5 : 4;

  $query = "UPDATE transaksi SET status_pembayaran_id = $status_pembayaran_id";

  if (!$is_valid) {
    deleteFile($transaksi['bukti_bayar_lunas']);
    $query .= ", bukti_bayar_lunas = NULL, jumlah_bayar_lunas = NULL, tanggal_bayar_lunas = NULL";
  }

  $query .= " WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Data transaksi berhasil diperbarui!');
    redirectJs('verifikasi-pelunasan.php');
    exit;
  } else {
    setFlashMessage('error', 'Data transaksi gagal diperbarui!');
    redirectJs('verifikasi-pelunasan.php');
    exit;
  }
}
?>