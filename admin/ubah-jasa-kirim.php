<?php
$active = 'jasa-kirim';
$title = 'Ubah Jasa Kirim';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirectJs('jasa-kirim.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM jasa_kirim WHERE id = $id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
  redirectJs('jasa-kirim.php');
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Ubah Jasa Kirim
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
                <label class="col-md-4 col-12 col-form-label required">Harga</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan harga jasa kirim" name="harga" value="<?= $mobil['harga'] ?>">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="jasa-kirim.php" type="button" class="btn me-auto">Kembali</a>
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
    $harga = htmlspecialchars($_POST['harga']);
    
    $query = "UPDATE jasa_kirim SET nama = '$nama', harga = '$harga' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Jasa kirim berhasil diubah!');
      redirectJs('jasa-kirim.php');
      exit;
    } else {
      setFlashMessage('error', 'Jasa kirim gagal diubah!');
      redirectJs("ubah-jasa-kirim.php?id=$id");
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>
