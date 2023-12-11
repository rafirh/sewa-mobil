<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM cc WHERE id = $id");
  $cc = mysqli_fetch_assoc($result);

  if (!$cc) {
    setFlashMessage('error', 'CC mobil tidak ditemukan');
    redirectJs('cc-mobil.php');
  }

  $query = "DELETE FROM cc WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'CC mobil berhasil dihapus!');
    redirectJs('cc-mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'CC mobil gagal dihapus!');
    redirectJs('cc-mobil.php');
    exit;
  }
}
