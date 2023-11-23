<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');
redirectIfNotAuthenticated();

$active = 'change-password';
$title = 'Ubah Password';
?>

<?php include('partials/header.php') ?>

<div class="page-header d-print-none mt-3">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h3 class="page-title">
              Ubah Kata Sandi
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="change-password.php" method="post" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="form-label">
                    Kata Sandi Saat Ini
                  </label>
                  <div class="input-group input-group-flat">
                    <input required type="password" name="current_password" class="form-control" placeholder="Masukkan kata sandi saat ini">
                    <span class="input-group-text">
                      <a class="link-secondary btn-show-password cursor-pointer text-muted" data-bs-toggle="tooltip" title="Tampilkan kata sandi" onclick="event.preventDefault();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <circle cx="12" cy="12" r="2" />
                          <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                        </svg>
                      </a>
                    </span>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label">
                    Kata Sandi Baru
                  </label>
                  <div class="input-group input-group-flat">
                    <input required type="password" name="new_password" class="form-control" placeholder="Masukkan kata sandi baru">
                    <span class="input-group-text">
                      <a class="link-secondary btn-show-password cursor-pointer text-muted" data-bs-toggle="tooltip" title="Tampilkan kata sandi" onclick="event.preventDefault();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <circle cx="12" cy="12" r="2" />
                          <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                        </svg>
                      </a>
                    </span>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label">
                    Konfirmasi Kata Sandi Baru
                  </label>
                  <div class="input-group input-group-flat">
                    <input required type="password" name="new_password_confirmation" class="form-control" placeholder="Masukkan konfirmasi kata sandi baru">
                    <span class="input-group-text">
                      <a class="link-secondary btn-show-password cursor-pointer text-muted" data-bs-toggle="tooltip" title="Tampilkan kata sandi" onclick="event.preventDefault();">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <circle cx="12" cy="12" r="2" />
                          <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                        </svg>
                      </a>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="index.php" type="button" class="btn me-auto">Kembali</a>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                  Simpan
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('.btn-show-password').on('click', function() {
    var inputPassword = $(this).parent().parent().find('input');
    if (inputPassword.attr('type') === 'password') {
      inputPassword.attr('type', 'text');
      $(this).html(
        `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M3 3l18 18"></path>
                        <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
                        <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
                    </svg>`
      );
    } else {
      inputPassword.attr('type', 'password');
      $(this).html(
        `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                    </svg>`
      );
    }
  })
</script>

<?php include('partials/footer.php') ?>

<?php
showToastIfExist();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (checkRequiredFields(['current_password', 'new_password', 'new_password_confirmation'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $newPasswordConfirmation = $_POST['new_password_confirmation'];

    if ($newPassword != $newPasswordConfirmation) {
      setFlashMessage('error', 'Konfirmasi kata sandi baru tidak cocok');
      redirectJs('./change-password.php');
    }

    $user = $_SESSION['user'];
    $userId = $user['id'];
    $userPassword = $user['password'];

    if (!password_verify($currentPassword, $userPassword)) {
      setFlashMessage('error', 'Kata sandi saat ini tidak cocok');
      redirectJs('./change-password.php');

      exit;
    }

    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

    $query = "UPDATE user SET password = '$newPasswordHash' WHERE id = $userId";

    if ($conn->query($query)) {
      setFlashMessage('success', 'Kata sandi berhasil diubah');
      redirectJs('./change-password.php');
    } else {
      setFlashMessage('error', 'Kata sandi gagal diubah');
      redirectJs('./change-password.php');
    }
  }
}
?>