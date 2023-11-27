<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');
redirectIfNotAuthenticated();
checkRole('agent');

if (!checkAgentExist($_SESSION['user']['id'], $conn)) {
  redirect('lengkapi-data-agen.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?= $title ?> - Ikuzo Rental</title>
  <link rel="shortcut icon" href="" type="image/x-icon">
  <!-- CSS files -->
  <link href="<?= asset('plugins/tabler/dist/css/tabler.min.css') ?>" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?= asset('plugins/toast/dist/simple-notify.min.css') ?>" type="text/css">
  <script src="<?= asset('plugins/toast/dist/simple-notify.min.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <style>
    @import url('https://rsms.me/inter/inter.css');

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }

    .navbar-nav li.active {
      background-color: rgba(0, 123, 255, 0.15);
      font-weight: 500;
    }

    li.nav-item:hover {
      font-weight: 500;
    }

    .btn-action-delete:hover {
      background-color: #e74c3c;
      color: #ffffff;
      transition: 0.3s;
    }
  </style>
</head>

<body>
  <div class="page">

    <?php include('sidebar.php') ?>

    <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none sticky-top">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
          <div class="d-none d-md-flex me-2">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
              </svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
              </svg>
            </a>
          </div>
          <div class="nav-item dropdown">
            <a class="nav-link d-flex lh-1 text-reset p-0 cursor-pointer" data-bs-toggle="dropdown" aria-label="Open user menu">
              <span class="avatar avatar-sm" style="background-image: url(<?= asset($_SESSION['user']['foto'] ?? 'images/user/default.jpg') ?>)"></span>
              <div class="d-none d-xl-block ps-2" style="min-width: 7rem;">
                <div>
                  <span <?= add_title_tooltip($_SESSION['user']['nama'] ?? '-', 24) ?>>
                    <?= mb_strimwidth($_SESSION['user']['nama'], 0, 24, '...') ?>
                  </span>
                </div>
                <div class="mt-1 small text-muted">
                  <?= ucfirst($_SESSION['user']['role']) ?>
                </div>
              </div>
            </a>
            <div class="text-muted dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="profile.php" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                </svg>
                Profil
              </a>
              <a href="change-password.php" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z"></path>
                  <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0"></path>
                  <path d="M8 11v-4a4 4 0 1 1 8 0v4"></path>
                </svg>
                Ubah Kata Sandi
              </a>
              <a href="../logout.php" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2">
                  </path>
                  <path d="M7 12h14l-3 -3m0 6l3 -3"></path>
                </svg>
                Keluar
              </a>
            </div>
          </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div>
            <span id="datetime"></span>
          </div>
        </div>
      </div>
    </header>

    <div class="page-wrapper">