<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM tipe_mobil WHERE id = $id");
  $merk = mysqli_fetch_assoc($result);

  if (!$merk) {
    setFlashMessage('error', 'Tipe mobil tidak ditemukan');
    redirectJs('tipe-mobil.php');
  }

  $query = "DELETE FROM tipe_mobil WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Tipe mobil berhasil dihapus!');
    redirectJs('tipe-mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'Tipe mobil gagal dihapus!');
    redirectJs('tipe-mobil.php');
    exit;
  }
}
