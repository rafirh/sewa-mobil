<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM transmisi WHERE id = $id");
  $merk = mysqli_fetch_assoc($result);

  if (!$merk) {
    setFlashMessage('error', 'Transmisi mobil tidak ditemukan');
    redirectJs('transmisi-mobil.php');
  }

  $query = "DELETE FROM transmisi WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Transmisi mobil berhasil dihapus!');
    redirectJs('transmisi-mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'Transmisi mobil gagal dihapus!');
    redirectJs('transmisi-mobil.php');
    exit;
  }
}
