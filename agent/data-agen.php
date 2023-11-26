<?php
$active = 'data-agen';
$title = 'Data Agen';

include('partials/header.php');

$query = "SELECT * FROM agen WHERE user_id = " . $_SESSION['user']['id'];
$result = $conn->query($query);
$agen = $result->fetch_assoc();
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Data Agen
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
        <form action="data-agen.php" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Nama</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan nama agen" name="nama" value="<?= $agen['nama'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Alamat</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan alamat agen" name="alamat" value="<?= $agen['alamat'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Telepon</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan nomor telepon agen" name="telepon" value="<?= $agen['telepon'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">No. Rekening</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan nomor rekening agen" name="no_rekening" value="<?= $agen['no_rekening'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Bank</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan nama bank rekening" name="bank" value="<?= $agen['bank'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Atas Nama</label>
                <div class="col">
                  <input type="text" class="form-control" placeholder="Masukkan nama pemilik rekening" name="atas_nama" value="<?= $agen['atas_nama'] ?>">
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
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
    if (checkRequiredFields(['nama', 'alamat', 'telepon', 'no_rekening', 'bank', 'atas_nama'])) {
      $nama = htmlspecialchars($_POST['nama']);
      $alamat = htmlspecialchars($_POST['alamat']);
      $telepon = htmlspecialchars($_POST['telepon']);
      $no_rekening = htmlspecialchars($_POST['no_rekening']);
      $bank = htmlspecialchars($_POST['bank']);
      $atas_nama = htmlspecialchars($_POST['atas_nama']);
      $user_id = $_SESSION['user']['id'];
      
      $query = "UPDATE agen SET nama = '$nama', alamat = '$alamat', telepon = '$telepon', no_rekening = '$no_rekening', bank = '$bank', atas_nama = '$atas_nama' WHERE user_id = $user_id";
      $result = $conn->query($query);

      if ($result) {
        setFlashMessage('success', 'Data agen berhasil diperbarui!');
        redirectJs('data-agen.php');
        exit;
      } else {
        setFlashMessage('error', 'Data agen gagal diperbarui!');
        redirectJs('data-agen.php');
        exit;
      }
    } else {
      setFlashMessage('error', 'Semua data harus diisi!');
    }
  }

  showToastIfExist();
?>
