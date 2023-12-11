<?php
$active = 'transmisi-mobil';
$title = 'Tambah Transmisi Mobil';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirectJs('transmisi-mobil.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM transmisi WHERE id = $id");
$transmisi = mysqli_fetch_assoc($result);

if (!$transmisi) {
  redirectJs('transmisi-mobil.php');
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Ubah Transmisi Mobil
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
        <form method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Nama</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan nama transmisi mobil" name="nama" value="<?= $transmisi['nama'] ?>">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="transmisi-mobil.php" type="button" class="btn me-auto">Kembali</a>
              <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('partials/footer.php') ?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (checkRequiredFields(['nama'])) {
    $nama = htmlspecialchars($_POST['nama']);
    
    $query = "UPDATE transmisi SET nama = '$nama' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Transmisi mobil berhasil diubah!');
      redirectJs('transmisi-mobil.php');
      exit;
    } else {
      setFlashMessage('error', 'Transmisi mobil gagal diubah!');
      redirectJs("ubah-transmisi-mobil.php?id=$id");
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>
