<?php

session_start();

function redirect($url) {
  header("Location: $url");
}

function redirectJs($url) {
  echo "<script>window.location.href = '$url'</script>";
}

function redirectIfAuthenticated() {
  if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'administrator') {
      redirect('./admin/index.php');
    } else {
      redirect('./customer/index.php');
    }
  }
}

function redirectIfNotAuthenticated($url = null) {
  if (!isset($_SESSION['user'])) {
    redirect($url ?? '../login.php');
  }
}

function destroySession($key = null) {
  if ($key) {
    unset($_SESSION[$key]);
  } else {
    session_destroy();
  }
}

function logout() {
  session_start();
  session_destroy();
  redirect('./login.php');
}

function setFlashMessage($key, $value) {
  $_SESSION['flash_message'][$key] = $value;
}

function getFlashMessage($key) {
  if (isset($_SESSION['flash_message'][$key])) {
    $value = $_SESSION['flash_message'][$key];
    unset($_SESSION['flash_message'][$key]);
    return $value;
  }

  return null;
}

function showToastIfExist() {
  $success = getFlashMessage('success');
  $error = getFlashMessage('error');

  if ($success) {
    echo "<script>toastr('success', 'Berhasil', '$success')</script>";
  }

  if ($error) {
    echo "<script>toastr('error', 'Gagal', '$error')</script>";
  }
}