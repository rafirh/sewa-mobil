<?php

session_start();

function redirect($url)
{
  header("Location: $url");
}

function redirectJs($url)
{
  echo "<script>window.location.href = '$url'</script>";
}

function redirectIfAuthenticated()
{
  if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'administrator') {
      redirect('./admin/index.php');
    } else if ($_SESSION['user']['role'] == 'agent') {
      redirect('./agent/index.php');
    } else {
      redirect('./customer/index.php');
    }
  }
}

function redirectIfNotAuthenticated($url = null)
{
  if (!isset($_SESSION['user'])) {
    redirect($url ?? '../login.php');
  }
}

function destroySession($key = null)
{
  if ($key) {
    unset($_SESSION[$key]);
  } else {
    session_destroy();
  }
}

function logout()
{
  session_start();
  session_destroy();
  redirect('./login.php');
}

function setFlashMessage($key, $value)
{
  $_SESSION['flash_message'][$key] = $value;
}

function getFlashMessage($key)
{
  if (isset($_SESSION['flash_message'][$key])) {
    $value = $_SESSION['flash_message'][$key];
    unset($_SESSION['flash_message'][$key]);
    return $value;
  }

  return null;
}

function showToastIfExist()
{
  $success = getFlashMessage('success');
  $error = getFlashMessage('error');

  if ($success) {
    echo "<script>toastr('success', 'Berhasil', '$success')</script>";
  }

  if ($error) {
    echo "<script>toastr('error', 'Gagal', '$error')</script>";
  }
}

function asset($path)
{
  $request_uri = $_SERVER['REQUEST_URI'];
  $array = explode('/', $request_uri);
  $app_url = $array[0] . '/' . $array[1];

  return $app_url . '/assets/' . $path;
}

function add_title_tooltip($string, $limit = 20)
{
  if (strlen($string) > $limit) {
    echo 'data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="' . $string . '"';
  }
  echo '';
}

function storeImage($file, $folder) {
  $path = "../assets/images/$folder/";
  $filename = $file['name'];
  $tmp = $file['tmp_name'];
  $ext = explode('.', $filename);
  $ext = strtolower(end($ext));
  $new_filename = uniqid() . ".$ext";
  $new_path = $path . $new_filename;

  if (!file_exists($path)) {
    mkdir($path);
  }

  move_uploaded_file($tmp, $new_path);

  return "images/$folder/$new_filename";
}

function deleteFile($path) {
  if (file_exists("../assets/$path")) {
    unlink("../assets/$path");
  }
}

function checkRequiredFields($fields)
{
  foreach ($fields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
      return false;
    }
  }

  return true;
}

function format_rupiah($angka)
{
  $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}

function isParamsExist($params)
{
    foreach ($params as $param) {
      if (isset($_GET[$param]) && !empty($_GET[$param])) {
        return true;
      }
    }
}

function checkAgentExist($userId, $conn)
{
  $query = "SELECT * FROM agen WHERE user_id = $userId";
  $result = mysqli_query($conn, $query);
  return mysqli_num_rows($result) > 0;
}

function getAll($conn, $table, $orderBy = 'id', $orderType = 'ASC')
{
  $query = "SELECT * FROM $table";
  if ($orderBy) {
    $query .= " ORDER BY $orderBy $orderType";
  }
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getValidOrder($order) {
  if (strtolower($order) == 'desc') {
    return 'DESC';
  }

  return 'ASC';
}

function checkRole($role, $loginPath = null) {
  if (!isset($_SESSION['user'])) {
    redirect($loginPath ?? '../login.php');
  }

  if ($_SESSION['user']['role'] == $role) {
    return;
  }

  if ($_SESSION['user']['role'] == 'administrator') {
    redirect('../admin/index.php');
  } else if ($_SESSION['user']['role'] == 'agent') {
    redirect('../agent/index.php');
  } else {
    redirect('../customer/index.php');
  }
}