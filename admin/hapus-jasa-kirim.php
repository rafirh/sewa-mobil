<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM jasa_kirim WHERE id = $id");
  $jasa_kirim = mysqli_fetch_assoc($result);

  if (!$jasa_kirim) {
    setFlashMessage('error', 'Jasa kirim tidak ditemukan');
    redirectJs('jasa-kirim.php');
  }

  $query = "DELETE FROM jasa_kirim WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Jasa kirim berhasil dihapus!');
    redirectJs('jasa-kirim.php');
    exit;
  } else {
    setFlashMessage('error', 'Merk mobil gagal dihapus!');
    redirectJs('jasa-kirim.php');
    exit;
  }
}
