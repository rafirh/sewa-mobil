<?php
$active = 'warna-mobil';
$title = 'Tambah Warna Mobil';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirectJs('warna-mobil.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM warna WHERE id = $id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
  redirectJs('warna-mobil.php');
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Ubah Warna Mobil
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
                  <input required type="text" class="form-control" placeholder="Masukkan nama warna mobil" name="nama" value="<?= $mobil['nama'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Warna</label>
                <div class="col-2">
                  <input required type="color" class="form-control" placeholder="Masukkan warna mobil" name="kode" value="<?= $mobil['kode'] ?>">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="warna-mobil.php" type="button" class="btn me-auto">Kembali</a>
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
    $kode = htmlspecialchars($_POST['kode']);
    
    $query = "UPDATE warna SET nama = '$nama', kode = '$kode' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Warna mobil berhasil diubah!');
      redirectJs('warna-mobil.php');
      exit;
    } else {
      setFlashMessage('error', 'Warna mobil gagal diubah!');
      redirectJs("ubah-warna-mobil.php?id=$id");
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>
