<?php
$active = 'cc-mobil';
$title = 'Tambah CC Mobil';

include('partials/header.php');
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Tambah CC Mobil
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
        <form action="tambah-cc-mobil.php" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Jumlah CC</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan cc mobil" name="nama">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <a href="cc-mobil.php" type="button" class="btn me-auto">Kembali</a>
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
      
      $query = "INSERT INTO cc (nama) VALUES ('$nama')";
      $result = mysqli_query($conn, $query);

      if ($result) {
        setFlashMessage('success', 'CC mobil berhasil disimpan!');
        redirectJs('cc-mobil.php');
        exit;
      } else {
        setFlashMessage('error', 'CC mobil gagal disimpan!');
        redirectJs('tambah-cc-mobil.php');
        exit;
      }
    } else {
      setFlashMessage('error', 'Semua data harus diisi!');
    }
  }
?>
