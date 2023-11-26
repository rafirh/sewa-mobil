<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');

redirectIfNotAuthenticated();

if (checkAgentExist($_SESSION['user']['id'], $conn)) {
  redirect('index.php');
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Selamat Datang Agen | Rental Mobil Ikuzo</title>
  <!-- CSS files -->
  <link href="<?= asset('plugins/tabler/dist/css/tabler.min.css?1669759017') ?>" rel="stylesheet" />
  <link rel="shortcut icon" href="<?= asset('images/logo.png') ?>" type="image/x-icon">
  <link rel="stylesheet" href="<?= asset('plugins/toast/dist/simple-notify.min.css') ?>" />
  <script src="<?= asset('plugins/toast/dist/simple-notify.min.js') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }

    .btn-edit-avatar {
      position: absolute;
      bottom: -15px;
      left: -15px;
      background-color: #868686;
      box-shadow: 0 0 0 2px #ffffff;
    }

    .avatar-custom-size {
      width: 10rem;
      height: 10rem;
    }

    .btn-delete:hover {
      background-color: #e74c3c;
      color: #ffffff;
      transition: 0.3s;
    }
  </style>

</head>

<body class=" d-flex flex-column">
  <script src="<?= asset('plugins/tabler/dist/js/demo-theme.min.js?1669759017') ?>"></script>
  <div class="page">
    <div class="container container-tight py-4">
      <div class="text-center mb-3">
        <a class="fs-3 navbar-brand navbar-brand-autodark">
          <img src="<?= asset('images/logo.png') ?>" class="me-2" height="80" alt="">
        </a>
      </div>
      <div class="card card-md">
        <div class="card-body text-center py-4">
          <h2>Selamat Datang,</h2>
          <p class="text-muted fst-italic" <?= add_title_tooltip($_SESSION['user']['nama'], 30) ?>>
            <?= mb_strimwidth($_SESSION['user']['nama'], 0, 30, '...') ?>!
          </p>
        </div>
        <form action="lengkapi-data-agen.php" method="post" enctype="multipart/form-data">
          <div class="hr-text hr-text-center hr-text-spaceless mt-2">Lengkapi Data Agen</div>
          <div class="px-4 pt-4">
            <div class="mb-3">
              <label class="form-label required">Nama</label>
              <input type="text" class="form-control" name="nama" placeholder="Masukkan nama agen">
            </div>
            <div class="mb-3">
              <label class="form-label required">Alamat</label>
              <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat agen">
            </div>
            <div class="mb-3">
              <label class="form-label required">Telepon</label>
              <input type="text" class="form-control" name="telepon" placeholder="Masukkan nomor telepon agen">
            </div>
            <div class="mb-3">
              <label class="form-label required">No. Rekening</label>
              <input type="text" class="form-control" name="no_rekening" placeholder="Masukkan nomor rekening agen">
            </div>
            <div class="mb-3">
              <label class="form-label required">Bank</label>
              <input type="text" class="form-control" name="bank" placeholder="Masukkan nama bank rekening">
            </div>
            <div class="mb-3">
              <label class="form-label required">Atas Nama</label>
              <input type="text" class="form-control" name="atas_nama" placeholder="Masukkan nama pemilik rekening">
            </div>
          </div>
          <div class="d-flex justify-content-end px-4 mb-3 mt-2">
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                <path d="M14 4l0 4l-6 0l0 -4"></path>
              </svg>
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="<?= asset('plugins/tabler/dist/js/tabler.min.js?1669759017') ?>" defer></script>
  <script>
    function toastr(status = 'success', title = 'Toast Title', text = 'Toast Text') {
      new Notify({
        status: status,
        title: title,
        text: text,
        effect: 'fade',
        speed: 300,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 3000,
        gap: 20,
        distance: 20,
        type: 3,
        position: 'right top',
      })
    }
  </script>
</body>

</html>

<?php 
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkRequiredFields(['nama', 'alamat', 'telepon', 'no_rekening', 'bank', 'atas_nama'])) {
      $nama = htmlspecialchars($_POST['nama']);
      $alamat = htmlspecialchars($_POST['alamat']);
      $telepon = htmlspecialchars($_POST['telepon']);
      $no_rekening = htmlspecialchars($_POST['no_rekening']);
      $bank = htmlspecialchars($_POST['bank']);
      $atas_nama = htmlspecialchars($_POST['atas_nama']);
      $user_id = $_SESSION['user']['id'];

      $query = "INSERT INTO agen (user_id, nama, alamat, telepon, no_rekening, bank, atas_nama) VALUES ('$user_id', '$nama', '$alamat', '$telepon', '$no_rekening', '$bank', '$atas_nama')";
      $result = $conn->query($query);

      if ($result) {
        $_SESSION['user']['agen_id'] = $conn->insert_id;
        setFlashMessage('success', 'Data agen berhasil disimpan!');
        redirectJs('index.php');
        exit;
      } else {
        setFlashMessage('error', 'Data agen gagal disimpan!');
      }
    } else {
      setFlashMessage('error', 'Semua data harus diisi!');
    }
  }

  showToastIfExist();
?>