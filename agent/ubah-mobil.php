<?php
$active = 'mobil';
$title = 'Ubah Mobil';

include('partials/header.php');

$merk = getAll($conn, 'merk_mobil', 'id', 'ASC');
$jenis = getAll($conn, 'jenis_mobil', 'id', 'ASC');
$transmisi = getAll($conn, 'transmisi', 'id', 'ASC');
$warna = getAll($conn, 'warna', 'id', 'ASC');
$cc = getAll($conn, 'cc', 'id', 'ASC');
$tipe = getAll($conn, 'tipe_mobil', 'id', 'ASC');

if (!isParamsExist(['id'])) {
  redirect('mobil.php');
}

$id = htmlspecialchars($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM mobil WHERE id = $id");
$mobil = mysqli_fetch_assoc($result);

if (!$mobil) {
  redirect('mobil.php');
}

if ($mobil['agen_id'] != $_SESSION['user']['agen_id']) {
  redirect('mobil.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (checkRequiredFields(['merk_id', 'jenis_id', 'transmisi_id', 'warna_id', 'nama', 'plat_nomor', 'tahun', 'harga', 'kapasitas', 'cc_id'])) {
    $merk_id = htmlspecialchars($_POST['merk_id']);
    $jenis_id = htmlspecialchars($_POST['jenis_id']);
    $transmisi_id = htmlspecialchars($_POST['transmisi_id']);
    $warna_id = htmlspecialchars($_POST['warna_id']);
    $cc_id = htmlspecialchars($_POST['cc_id']);
    $tipe_id = htmlspecialchars($_POST['tipe_id']);
    $nama = htmlspecialchars($_POST['nama']);
    $plat_nomor = htmlspecialchars($_POST['plat_nomor']);
    $tahun = htmlspecialchars($_POST['tahun']);
    $harga = htmlspecialchars($_POST['harga']);
    $kapasitas = htmlspecialchars($_POST['kapasitas']);

    deleteFile($mobil['foto']);
    if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
      $foto = storeImage($_FILES['foto'], 'mobil');
    } else {
      $foto = null;
    }
    
    $query = "UPDATE mobil SET merk_id = '$merk_id', jenis_id = '$jenis_id', transmisi_id = '$transmisi_id', warna_id = '$warna_id', cc_id = '$cc_id', tipe_id = '$tipe_id', nama = '$nama', plat_nomor = '$plat_nomor', tahun = '$tahun', harga = '$harga', kapasitas = '$kapasitas', foto = '$foto' WHERE id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Data mobil berhasil diubah!');
      redirectJs('mobil.php');
      exit;
    } else {
      setFlashMessage('error', 'Data mobil gagal diubah!');
      redirectJs('tambah-mobil.php');
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
          Ubah Mobil
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
        <form action="ubah-mobil.php?id=<?= $mobil['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Merk</label>
                <div class="col">
                  <select required class="form-select" name="merk_id">
                    <option value="" selected disabled>Pilih merk mobil</option>
                    <?php foreach ($merk as $item) : ?>
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['merk_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
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
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['jenis_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
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
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['transmisi_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
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
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['warna_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
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
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['cc_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Tipe</label>
                <div class="col">
                  <select required class="form-select" name="tipe_id">
                    <option value="" selected disabled>Pilih tipe mobil</option>
                    <?php foreach ($tipe as $item) : ?>
                      <option value="<?= $item['id'] ?>" <?= $item['id'] == $mobil['tipe_id'] ? 'selected' : '' ?>>
                        <?= $item['nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Nama</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan nama mobil" name="nama" value="<?= $mobil['nama'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Plat Nomor</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan plat nomor mobil" name="plat_nomor" value="<?= $mobil['plat_nomor'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Tahun</label>
                <div class="col">
                  <input required type="text" class="form-control" placeholder="Masukkan tahun mobil" name="tahun" value="<?= $mobil['tahun'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Harga Sewa</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan harga sewa mobil" name="harga" value="<?= $mobil['harga'] ?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-md-4 col-12 col-form-label required">Kapasitas</label>
                <div class="col">
                  <input required type="number" class="form-control" placeholder="Masukkan kapasitas mobil" name="kapasitas" value="<?= $mobil['kapasitas'] ?>">
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
    acceptedFileTypes: ['image/jpg', 'image/jpeg', 'image/png'],
    labelFileTypeNotAllowed: 'File must be an image',
    storeAsFile: true,
  });

  <?php if ($mobil['foto'] != '' && $mobil['foto'] != null) : ?>
    fotoInput.addFile('<?= asset($mobil['foto']) ?>');
  <?php endif ?>
</script>

<?php include('partials/footer.php') ?>

<?php 
  showToastIfExist();
?>
