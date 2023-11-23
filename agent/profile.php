<?php
require_once('../db/conn.php');
require_once('../helper/helpers.php');
redirectIfNotAuthenticated();

$active = 'profil';
$title = 'Profil';
?>

<?php include('partials/header.php') ?>

<style>
  .btn-edit-avatar {
    position: absolute;
    bottom: -15px;
    left: -15px;
    background-color: #868686;
    box-shadow: 0 0 0 3px #ffffff;
  }

  .avatar-custom-size {
    width: 12rem;
    height: 12rem;
  }

  .btn-delete:hover {
    background-color: #e74c3c;
    color: #ffffff;
    transition: 0.3s;
  }
</style>
<div class="page-header d-print-none mt-3">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h3 class="page-title">
              Profil Saya
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
        <form action="profile.php" method="post" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="row justify-content-center mt-3 ">
                <div class="col-12 text-center">
                  <span id="photoPreview" class="avatar avatar-custom-size rounded position-relative mb-5" style="background-image: url(<?= asset($_SESSION['user']['foto'] ?? 'images/user/default.jpg') ?>)">
                    <label>
                      <button class="btn btn-icon btn-muted rounded-circle btn-edit-avatar" type="button" onclick="document.getElementById('photoInput').click()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                          <path d="M7 9l5 -5l5 5"></path>
                          <path d="M12 4l0 12"></path>
                        </svg>
                      </button>
                    </label>
                    <input type="file" class="form-control" name="foto" id="photoInput" hidden accept=".jpg,.jpeg,.png">
                  </span>
                </div>
                <div class="col-12 mb-3">
                  <div class="datagrid">
                    <div class="datagrid-item">
                      <div class="datagrid-title">Nama Lengkap <span class="text-danger">*</span></div>
                      <input required type="text" class="form-control" placeholder="Nama lengkap" name="nama" value="<?= $_SESSION['user']['nama'] ?>">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="datagrid">
                    <div class="datagrid-item">
                      <div class="datagrid-title">Email <span class="text-danger">*</span></div>
                      <input required type="email" class="form-control" placeholder="Email" name="email" value="<?= $_SESSION['user']['email'] ?>">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="datagrid">
                    <div class="datagrid-item">
                      <div class="datagrid-title">No. Telepon</div>
                      <input required type="text" class="form-control" placeholder="Nomor telepon" name="no_hp" value="<?= $_SESSION['user']['no_hp'] ?>">
                    </div>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <div class="datagrid">
                    <div class="datagrid-item">
                      <div class="datagrid-title">Alamat</div>
                      <input required type="text" class="form-control" placeholder="Nomor telepon" name="alamat" value="<?= $_SESSION['user']['alamat'] ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="d-flex">
                <a href="index.php" type="button" class="btn me-auto">Kembali</a>
                <button type="submit" class="btn btn-primary">
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
  $('#photoInput').change(function() {
    if (this.files && this.files[0]) {
      let reader = new FileReader();
      reader.onload = function(e) {
        $('#photoPreview').css('background-image', 'url(' + e.target.result + ')');
      }
      reader.readAsDataURL(this.files[0]);
    }
  });
</script>

<?php include('partials/footer.php') ?>

<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkRequiredFields(['nama',  'email'])) {
      $name = htmlspecialchars($_POST['nama']);
      $email = htmlspecialchars($_POST['email']);
      $no_hp = htmlspecialchars($_POST['no_hp']) ?? null;
      $alamat = htmlspecialchars($_POST['alamat']) ?? null;
      $foto = null;

      if ($_FILES['foto']['name']) {
        $foto = storeImage($_FILES['foto'], 'user');
      } else {
        $foto = $_SESSION['user']['foto'];
      }

      $id = $_SESSION['user']['id'];
      $query = "UPDATE user SET nama = '$name', email = '$email', no_hp = '$no_hp', alamat = '$alamat' " . ($foto ? ", foto = '$foto'" : '') . " WHERE id = $id";

      if (mysqli_query($conn, $query)) {
        $_SESSION['user'] = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = $id"));
        setFlashMessage('success', 'Berhasil mengubah profil');
        redirectJs('./profile.php');
      } else {
        setFlashMessage('error', 'Gagal mengubah profil');
        redirectJs('./profile.php');
      }
    } else {
      setFlashMessage('error', 'Nama dan email harus diisi');
      redirectJs('./profile.php');
    }
  }

  showToastIfExist();
?>