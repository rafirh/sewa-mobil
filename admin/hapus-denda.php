<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM denda WHERE id = $id");
  $denda = mysqli_fetch_assoc($result);

  if (!$denda) {
    setFlashMessage('error', 'Denda tidak ditemukan');
    redirectJs('jasa-kirim.php');
  }

  $query = "DELETE FROM denda WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Denda berhasil dihapus!');
    redirectJs('jasa-kirim.php');
    exit;
  } else {
    setFlashMessage('error', 'Denda gagal dihapus!');
    redirectJs('jasa-kirim.php');
    exit;
  }
}
