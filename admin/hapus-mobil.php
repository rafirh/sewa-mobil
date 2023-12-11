<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM mobil WHERE id = $id");
  $mobil = mysqli_fetch_assoc($result);

  if (!$mobil) {
    setFlashMessage('error', 'Mobil tidak ditemukan');
    redirectJs('mobil.php');
  }

  if ($mobil['foto']) {
    deleteFile($mobil['foto']);
  }

  $query = "DELETE FROM mobil WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Data mobil berhasil dihapus!');
    redirectJs('mobil.php');
    exit;
  } else {
    setFlashMessage('error', 'Data mobil gagal dihapus!');
    redirectJs('mobil.php');
    exit;
  }
}
?>