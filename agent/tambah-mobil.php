<?php
$active = 'mobil';
$title = 'Tambah Mobil';

include('partials/header.php');

$merk = getAll($conn, 'merk_mobil', 'id', 'ASC');
$jenis = getAll($conn, 'jenis_mobil', 'id', 'ASC');
$transmisi = getAll($conn, 'transmisi', 'id', 'ASC');
$warna = getAll($conn, 'warna', 'id', 'ASC');
$cc = getAll($conn, 'cc', 'id', 'ASC');
?>

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-md-10">
        <h2 class="page-title">
          Tambah Mobil
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
        <form action="tambah-mobil.php" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Merk</label>
                <div class="col">
                  <select required class="form-select" name="merk_id">
                    <option value="" selected disabled>Pilih merk mobil</option>
                    <?php foreach ($merk as $item) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Jenis</label>
                <div class="col">
                  <select required class="form-select" name="jenis_id">
                    <option value="" selected disabled>Pilih jenis mobil</option>
                    <?php foreach ($jenis as $item) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Transmisi</label>
                <div class="col">
                  <select required class="form-select" name="transmisi_id">
                    <option value="" selected disabled>Pilih transmisi mobil</option>
                    <?php foreach ($transmisi as $item) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Warna</label>
                <div class="col">
                  <select required class="form-select" name="warna_id">
                    <option value="" selected disabled>Pilih warna mobil</option>
                    <?php foreach ($warna as $item) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">CC</label>
                <div class="col">
                  <select required class="form-select" name="cc_id">
                    <option value="" selected disabled>Pilih cc mobil</option>
                    <?php foreach ($cc as $item) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Nama</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan nama mobil" name="nama">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Plat Nomor</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan plat nomor mobil" name="plat_nomor">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Tahun</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan tahun mobil" name="tahun">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Harga Sewa</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan harga sewa mobil" name="harga">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Kapasitas</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan kapasitas mobil" name="kapasitas">
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
              <a href="mobil.php" type="button" class="btn me-auto">Kembali</a>
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
</script>

<?php include('partials/footer.php') ?>

<?php 
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (checkRequiredFields(['merk_id', 'jenis_id', 'transmisi_id', 'warna_id', 'cc_id', 'nama', 'plat_nomor', 'tahun', 'harga', 'kapasitas'])) {
      $merk_id = htmlspecialchars($_POST['merk_id']);
      $jenis_id = htmlspecialchars($_POST['jenis_id']);
      $transmisi_id = htmlspecialchars($_POST['transmisi_id']);
      $warna_id = htmlspecialchars($_POST['warna_id']);
      $cc_id = htmlspecialchars($_POST['cc_id']);
      $nama = htmlspecialchars($_POST['nama']);
      $plat_nomor = htmlspecialchars($_POST['plat_nomor']);
      $tahun = htmlspecialchars($_POST['tahun']);
      $harga = htmlspecialchars($_POST['harga']);
      $kapasitas = htmlspecialchars($_POST['kapasitas']);
      $agen_id = $_SESSION['user']['agen_id'];

      if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
        $foto = storeImage($_FILES['foto'], 'mobil');
      } else {
        $foto = null;
      }

      
      $query = "INSERT INTO mobil (merk_id, jenis_id, transmisi_id, warna_id, cc_id, nama, plat_nomor, tahun, harga, kapasitas, agen_id, foto) VALUES ('$merk_id', '$jenis_id', '$transmisi_id', '$warna_id', '$cc_id', '$nama', '$plat_nomor', '$tahun', '$harga', '$kapasitas', '$agen_id', '$foto')";
      $result = mysqli_query($conn, $query);

      if ($result) {
        setFlashMessage('success', 'Data mobil berhasil disimpan!');
        redirectJs('mobil.php');
        exit;
      } else {
        setFlashMessage('error', 'Data mobil gagal disimpan!');
        redirectJs('tambah-mobil.php');
        exit;
      }
    } else {
      setFlashMessage('error', 'Semua data harus diisi!');
    }
  }

  showToastIfExist();
?>
