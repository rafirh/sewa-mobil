<?php
  require_once('./db/conn.php');
  require_once('./helper/helpers.php');

  redirectIfAuthenticated();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Masuk | Sewa Mobil</title>
  <!-- CSS files -->
  <link href="./assets/plugins/tabler/dist/css/tabler.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="./assets/plugins/toast/dist/simple-notify.min.css" />
  <script src="./assets/plugins/toast/dist/simple-notify.min.js"></script>
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>

<body class="d-flex flex-column">
  <script src="./assets/plugins/tabler/dist/js/demo-theme.min.js?1669759017"></script>
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center">
        <a class="fs-3 navbar-brand navbar-brand-autodark"><img src="./assets/images/logo.png" class="me-2" style="width: 140px;"></a>
      </div>
      <div class="card card-md">
        <div class="card-body">
          <h2 class="text-center mb-4">Sewa Mobil Ikuzo</h2>
          <form action="login.php" method="POST">
            <div class="mb-3">
              <label class="form-label required">Email</label>
              <input type="text" name="email" class="form-control" placeholder="Masukkan email" id="email">
            </div>
            <div class="mb-2">
              <label class="form-label required">
                Kata Sandi
              </label>
              <div class="input-group input-group-flat">
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan kata sandi">
                <span class="input-group-text">
                  <a class="link-secondary" data-bs-toggle="tooltip" id="btnShowPassword" title="Tampilakn kata sandi" onclick="event.preventDefault();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <circle cx="12" cy="12" r="2" />
                      <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                    </svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="mb-2">
              <div class="d-flex">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input" name="remember_me" value="1">
                  <span class="form-check-label">Ingat saya</span>
                </label>
                <a href="#" class="ms-auto">Lupa kata sandi?</a>
              </div>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </div>
          </form>
          <div class="mt-4 text-center">
            Belum punya akun?
            <a href="register.php">
              Daftar disini
            </a>
          </div>
        </div>
      </div>
      <div class="text-center text-muted mt-5">
        © 2023 All rights reserved - 💙 Ikuzo Rental
      </div>
    </div>
  </div>
  <script src="./assets/plugins/tabler/dist/js/tabler.min.js?1669759017" defer></script>
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

    const btnShowPassword = document.querySelector('#btnShowPassword')
    const inputPassword = document.querySelector('#password')

    btnShowPassword.addEventListener('click', function() {
      if (inputPassword.type === 'password') {
        inputPassword.type = 'text'
        btnShowPassword.innerHTML =
          `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M3 3l18 18"></path>
            <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
            <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
          </svg>`;
      } else {
        inputPassword.type = 'password'
        btnShowPassword.innerHTML =
          `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
          </svg>`
      }
    })
  </script>
</body>

</html>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkRequiredFields(['email', 'password'])) {
      $email = htmlspecialchars($_POST['email']);
      $password = htmlspecialchars($_POST['password']);
  
      $query = "SELECT * FROM user WHERE email = '$email'";
      $result = $conn->query($query);
  
      if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
  
        if (password_verify($password, $user['password'])) {
          $_SESSION['user'] = $user;
          if ($user['role'] == 'agent') {
            $query = "SELECT * FROM agen WHERE user_id = " . $user['id'];
            $result = $conn->query($query);
            $_SESSION['user']['agen_id'] = $result->fetch_assoc()['id'];

            redirectJs('./agent/index.php');
          } else {
            redirectJs('./customer/index.php');
          }
        } else {
          echo "<script>toastr('error', 'Gagal', 'Kata sandi yang anda masukkan salah.')</script>";
        }
      } else {
        echo "<script>toastr('error', 'Gagal', 'Email yang anda masukkan tidak ditemukan.')</script>";
      }
    } else {
      echo "<script>toastr('error', 'Gagal', 'Email dan kata sandi tidak boleh kosong.')</script>";
    }
  }

  showToastIfExist();
?>