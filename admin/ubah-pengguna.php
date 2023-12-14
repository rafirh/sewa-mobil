<?php
$active = 'pengguna';
$title = 'Ubah Pengguna';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirectJs('pengguna.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
$pengguna = mysqli_fetch_assoc($result);

if (!$pengguna) {
  redirectJs('pengguna.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (checkRequiredFields(['nama'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $role = htmlspecialchars($_POST['role']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    
    deleteFile($pengguna['foto']);
    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
      $foto = storeImage($_FILES['foto'], 'user');
    } else {
      $foto = null;
    }

    $query = "UPDATE user SET nama = '$nama', email = '$email', role = '$role', alamat = '$alamat', no_hp = '$no_hp', foto = '$foto'";

    if (isset($_POST['password']) && !empty($_POST['password'])) {
      $password = htmlspecialchars($_POST['password']);
      $password = password_hash($password, PASSWORD_DEFAULT);
      $query .= ", password = '$password'";
    }

    $query .= " WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Pengguna berhasil disimpan!');
      redirectJs('pengguna.php');
      exit;
    } else {
      setFlashMessage('error', 'Pengguna gagal disimpan!');
      redirectJs('tambah-pengguna.php');
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Ubah Pengguna
        </h2>
      </div>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards justify-content-center">
      <div class="col-md-10">
        <form action="ubah-pengguna.php?id=<?= $pengguna['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Role</label>
                <div class="col">
                  <select required class="form-select" name="role">
                    <option selected disabled>Pilih role</option>
                    <option value="administrator" <?= $pengguna['role'] == 'administrator' ? 'selected' : '' ?>>Administrator</option>
                    <option value="agent" <?= $pengguna['role'] == 'agent' ? 'selected' : '' ?>>Agen</option>
                    <option value="customer" <?= $pengguna['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Nama Lengkap</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan nama pengguna" name="nama" value="<?= $pengguna['nama'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Email</label>
                <div class="col">
                  <input required type="email" class="form-control" placeholder="Masukkan email pengguna" name="email" value="<?= $pengguna['email'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label">Kata Sandi Baru <span class="fs-5 text-muted">(Opsional)</span></label>
                <div class="col">
                  <div class="input-group input-group-flat">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan konfirmasi kata sandi baru">
                    <span class="input-group-text">
                      <a class="link-secondary" data-bs-toggle="tooltip" id="btnShowPassword" title="Tampilkan kata sandi" onclick="event.preventDefault();">
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
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Alamat</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan alamat pengguna" name="alamat" value="<?= $pengguna['alamat'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">No. HP</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan nomor hp pengguna" name="no_hp" value="<?= $pengguna['no_hp'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label">Foto</label>
                <div class="col">
                  <input id="fotoInput" type="file" class="form-control" name="foto" accept="image/png, image/jpeg, image/jpg">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="pengguna.php" type="button" class="btn me-auto">Kembali</a>
              <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<script>
  FilePond.registerPlugin(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
  );

  const fotoInput = FilePond.create(document.querySelector('#fotoInput'), {
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
    labelFileTypeNotAllowed: 'File must be an image',
    storeAsFile: true,
  });

  <?php if ($pengguna['foto']) : ?>
    fotoInput.addFile('<?= asset($pengguna['foto']) ?>')
  <?php endif; ?>

  const btnShowPassword = document.querySelector('#btnShowPassword')
  const inputPassword = document.querySelector('#password')

  addEventShowPassword(btnShowPassword, inputPassword)

  function addEventShowPassword(btn, input) {
    btn.addEventListener('click', function() {
      if (input.type === 'password') {
        input.type = 'text'
        btn.innerHTML =
          `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M3 3l18 18"></path>
            <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"></path>
            <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"></path>
          </svg>`;
      } else {
        input.type = 'password'
        btn.innerHTML =
          `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
          </svg>`
      }
    })
  }
</script>

<?php include('partials/footer.php') ?>
