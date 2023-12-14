<?php 
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
  $user = mysqli_fetch_assoc($result);

  if (!$user) {
    setFlashMessage('error', 'Pengguna tidak ditemukan');
    redirectJs('pengguna.php');
  }

  if ($user['foto']) {
    deleteFile($user['foto']);
  }

  $query = "DELETE FROM user WHERE id = $id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    setFlashMessage('success', 'Data pengguna berhasil dihapus!');
    redirectJs('pengguna.php');
    exit;
  } else {
    setFlashMessage('error', 'Data pengguna gagal dihapus!');
    redirectJs('pengguna.php');
    exit;
  }
}
?>