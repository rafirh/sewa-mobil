<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM jenis_mobil WHERE id = $id");
  $cc = mysqli_fetch_assoc($result);

  if (!$cc) {
    setFlashMessage('error', 'Jenis mobil tidak ditemukan');
    redirectJs('jenis-mobil.php');
  }

  $query = "DELETE FROM jenis_mobil WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Jenis mobil berhasil dihapus!');
    redirectJs('jenis-mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'Jenis mobil gagal dihapus!');
    redirectJs('jenis-mobil.php');
    exit;
  }
}
