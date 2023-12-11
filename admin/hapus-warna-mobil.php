<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM warna WHERE id = $id");
  $merk = mysqli_fetch_assoc($result);

  if (!$merk) {
    setFlashMessage('error', 'Merk mobil tidak ditemukan');
    redirectJs('warna-mobil.php');
  }

  $query = "DELETE FROM warna WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Merk mobil berhasil dihapus!');
    redirectJs('warna-mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'Merk mobil gagal dihapus!');
    redirectJs('warna-mobil.php');
    exit;
  }
}
