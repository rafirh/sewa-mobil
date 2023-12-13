<?php
$active = 'denda';
$title = 'Ubah Denda';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirectJs('denda.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM denda WHERE id = $id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
  redirectJs('denda.php');
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Ubah Denda
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
                  <input required type="text" class="form-control" placeholder="Masukkan nama merk mobil" name="nama" value="<?= $mobil['nama'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Tarif</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan tarif Denda" name="tarif" value="<?= $mobil['tarif'] ?>">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="denda.php" type="button" class="btn me-auto">Kembali</a>
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
  if (checkRequiredFields(['nama', 'tarif'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $tarif = htmlspecialchars($_POST['tarif']);
    
    $query = "UPDATE denda SET nama = '$nama', tarif = '$tarif' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Denda berhasil diubah!');
      redirectJs('denda.php');
      exit;
    } else {
      setFlashMessage('error', 'Denda gagal diubah!');
      redirectJs("ubah-denda.php?id=$id");
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>
