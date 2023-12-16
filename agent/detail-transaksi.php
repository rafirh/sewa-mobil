<?php
$active = 'detail-transaksi';
$title = 'Detail Transaksi';

include('partials/header.php');

if (!isParamsExist(['id'])) {
  redirect('menunggu-pengiriman.php');
}

$id = $_GET['id'];

$qeury = "
  SELECT
    mobil.*,
    merk_mobil.nama AS merk,
    jenis_mobil.nama AS jenis,
    transmisi.nama AS transmisi,
    warna.nama AS warna,
    warna.kode AS kode_warna,
    cc.nama AS cc,
    agen.nama AS agen,
    tipe_mobil.nama AS tipe
  FROM mobil
  JOIN merk_mobil ON merk_mobil.id = mobil.merk_id
  JOIN jenis_mobil ON jenis_mobil.id = mobil.jenis_id
  JOIN transmisi ON transmisi.id = mobil.transmisi_id
  JOIN warna ON warna.id = mobil.warna_id
  JOIN cc ON cc.id = mobil.cc_id
  JOIN agen ON agen.id = mobil.agen_id
  JOIN tipe_mobil ON tipe_mobil.id = mobil.tipe_id
  WHERE mobil.id = $id
";

$result = mysqli_query($conn, $qeury);
$car = mysqli_fetch_assoc($result);

if (!$car) {
  redirect('mobil.php');
}

if ($car['agen_id'] != $_SESSION['user']['agen_id']) {
  redirect('mobil.php');
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center justify-content-center">
      <div class="col-12 col-lg-8 col-md-10">
        <div class="row">
          <div class="col">
            <h2 class="page-title">
              Detail Mobil
            </h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list d-flex">
              <a href="mobil.php" class="btn btn-outline-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M5 12l14 0"></path>
                  <path d="M5 12l6 6"></path>
                  <path d="M5 12l6 -6"></path>
                </svg>
                Kembali
              </a>
              <a href="mobil.php" class="btn btn-outline-primary d-sm-none btn-icon" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M5 12l14 0"></path>
                  <path d="M5 12l6 6"></path>
                  <path d="M5 12l6 -6"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= $car['nama'] ?></h3>
            <div class="card-actions">
              <a class="btn btn-outline-primary w-100" href="ubah-mobil.php?id=<?= $car['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none">
                  </path>
                  <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                  </path>
                  <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                  </path>
                  <path d="M16 5l3 3"></path>
                </svg>
                Ubah
              </a>
            </div>
          </div>
          <div class="px-sm-5 py-3 py-sm-4 w-75 mx-auto">
            <a data-fslightbox="gallery<?= $index ?>" href="<?= asset($car['foto'] != '' ? $car['foto'] : 'images/default.png') ?>">
              <div class="img-responsive card-img-top" style="background-image: url(<?= asset($car['foto'] != '' ? $car['foto'] : 'images/default.png') ?>)">
              </div>
            </a>
          </div>
          <div class="card-body px-4">
            <div class="row">
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Nama Agen</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21l18 0" />
                        <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                        <path d="M5 21l0 -10.15" />
                        <path d="M19 21l0 -10.15" />
                        <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                      </svg>
                      <?= $car['agen'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Harga</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= format_rupiah($car['harga']) ?> / hari
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Kapasitas</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                      </svg>
                      <?= $car['kapasitas'] ?> orang
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Plat Nomor</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['plat_nomor'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Merk</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <span class="badge badge-outline text-indigo fs-6"><?= $car['merk'] ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">CC Mesin</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['cc'] ?> cc
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Transmisi</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['transmisi'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Jenis</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['jenis'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Warna</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <span class="badge me-1" style="background-color: <?= $car['kode_warna'] ?>;"></span>
                      <?= $car['warna'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Tahun Produksi</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['tahun'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Tipe</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $car['tipe'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Status</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <span class="badge badge-outline text-<?= $car['status'] == 'available' ? 'green' : 'pink' ?>">
                        <?= $car['status'] == 'available' ? 'Tersedia' : 'Tidak Tersedia' ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>

<?php include('partials/footer.php') ?>