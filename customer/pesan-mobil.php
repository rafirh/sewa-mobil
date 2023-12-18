<?php
$active = 'pesan-mobil';
$title = 'Pesan Mobil';

include('partials/header.php');

$sortables = [
  'total_dipesan' => 'Total Dipesan',
  'nama' => 'Nama',
  'harga' => 'Harga',
  'kapasitas' => 'Kapasitas',
  'tahun' => 'Tahun',
  'status' => 'Status',
  'merk_id' => 'Merk',
  'jenis_id' => 'Jenis',
  'transmisi_id' => 'Transmisi',
  'warna_id' => 'Warna',
  'cc_id' => 'CC',
];

$merk = getAll($conn, 'merk_mobil', 'id', 'ASC');
$jenis = getAll($conn, 'jenis_mobil', 'id', 'ASC');
$transmisi = getAll($conn, 'transmisi', 'id', 'ASC');
$warna = getAll($conn, 'warna', 'id', 'ASC');
$cc = getAll($conn, 'cc', 'id', 'ASC');
$agen = getAll($conn, 'agen', 'id', 'ASC');
$tipe = getAll($conn, 'tipe_mobil', 'id', 'ASC');
$jasa_kirim = getAll($conn, 'jasa_kirim', 'id', 'ASC');

$query = "
  SELECT
    mobil.*,
    merk_mobil.nama AS merk,
    jenis_mobil.nama AS jenis,
    transmisi.nama AS transmisi,
    warna.nama AS warna,
    warna.kode AS kode_warna,
    cc.nama AS cc,
    agen.nama AS agen,
    IFNULL(COUNT(transaksi.id), 0) AS total_dipesan
  FROM mobil
  JOIN merk_mobil ON merk_mobil.id = mobil.merk_id
  JOIN jenis_mobil ON jenis_mobil.id = mobil.jenis_id
  JOIN transmisi ON transmisi.id = mobil.transmisi_id
  JOIN warna ON warna.id = mobil.warna_id
  JOIN cc ON cc.id = mobil.cc_id
  JOIN agen ON agen.id = mobil.agen_id
  LEFT JOIN transaksi ON transaksi.mobil_id = mobil.id
  WHERE status = 'available'
";

if (isParamsExist(['q'])) {
  $q = htmlspecialchars($_GET['q']);
  $query .= " AND (mobil.nama LIKE '%$q%' OR mobil.plat_nomor LIKE '%$q%')";
}

if (isParamsExist(['status'])) {
  $status = htmlspecialchars($_GET['status']);
  $query .= " AND mobil.status = '$status'";
}

if (isParamsExist(['merk_id'])) {
  $merk_id = htmlspecialchars($_GET['merk_id']);
  $query .= " AND mobil.merk_id = $merk_id";
}

if (isParamsExist(['jenis_id'])) {
  $jenis_id = $_GET['jenis_id'];
  $query .= " AND mobil.jenis_id = $jenis_id";
}

if (isParamsExist(['transmisi_id'])) {
  $transmisi_id = htmlspecialchars($_GET['transmisi_id']);
  $query .= " AND mobil.transmisi_id = $transmisi_id";
}

if (isParamsExist(['warna_id'])) {
  $warna_id = htmlspecialchars($_GET['warna_id']);
  $query .= " AND mobil.warna_id = $warna_id";
}

if (isParamsExist(['cc_id'])) {
  $cc_id = htmlspecialchars($_GET['cc_id']);
  $query .= " AND mobil.cc_id = $cc_id";
}

if (isParamsExist(['tipe_id'])) {
  $tipe_id = htmlspecialchars($_GET['tipe_id']);
  $query .= " AND mobil.tipe_id = $tipe_id";
}

if (isParamsExist(['agen_id'])) {
  $agen_id = htmlspecialchars($_GET['agen_id']);
  $query .= " AND mobil.agen_id = $agen_id";
}

$query .= " GROUP BY mobil.id";

if (isParamsExist(['sortby'])) {
  $sortby = htmlspecialchars($_GET['sortby']);
  $order = getValidOrder($_GET['order'] ?? 'ASC');
  $query .= " ORDER BY $sortby $order";
}

$result = $conn->query($query);
$cars = $result->fetch_all(MYSQLI_ASSOC);

$order_id = $_GET['order_id'] ?? null;
?>

<style>
  .image-preview:hover {
    opacity: 0.8;
    transition: 0.3s;
    cursor: pointer;
  }

  .image-preview {
    background-color: transparent;
  }

  .car-detail:hover {
    background-color: #f5f5f5;
    transition: 0.3s;
    cursor: pointer;
  }
</style>

<div class="page-header d-print-none mt-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h3 class="page-title">
          Pesan Mobil
        </h3>
      </div>
    </div>
    <div class="row g-2 align-items-center">
      <div class="col col-sm-8 col-md-6 col-xl-4 mt-3 d-flex">
        <div class="input-group me-2">
          <input type="text" class="form-control" placeholder="Cari ..." id="inputSearch" value="<?= $_GET['q'] ?? '' ?>">
          <button class="btn btn-icon" type="button" id="btnSearch">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
              <path d="M21 21l-6 -6"></path>
            </svg>
          </button>
        </div>
        <a href="#" class="btn btn-outline-primary btn-icon" data-bs-toggle="modal" data-bs-target="#modal-option">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
          </svg>
        </a>
      </div>
      <?php if (isParamsExist(['q', 'sortby', 'order', 'status', 'merk_id', 'jenis_id', 'transmisi_id', 'warna_id', 'cc_id', 'tipe_id', 'agen_id'])) : ?>
        <div class="col-auto mt-3">
          <a href="pesan-mobil.php" class="btn btn-outline-danger btn-icon" data-bs-toggle="tooltip" data-bs-original-title="Clear filter" data-bs-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M4 7h16"></path>
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
              <path d="M10 12l4 4m0 -4l-4 4"></path>
            </svg>
          </a>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards" style="overflow-y: auto;">
      <?php foreach ($cars as $index => $car) : ?>
        <div class="col-sm-4 col-md-4 col-xl-3">
          <div class="card">
            <a data-fslightbox="gallery<?= $index ?>" href="<?= asset($car['foto'] != '' ? $car['foto'] : 'images/default.png') ?>">
              <div class="img-responsive card-img-top" style="background-image: url(<?= asset($car['foto'] != '' ? $car['foto'] : 'images/default.png') ?>)">
              </div>
            </a>
            <a class="text-reset text-decoration-none" href="detail-mobil.php?id=<?= $car['id'] ?>">
              <div class="card-body p-3 car-detail">
                <span class="badge badge-outline text-indigo fs-6"><?= $car['merk'] ?></span>
                <h3 class="m-0 mb-1 mt-1">
                  <?= $car['nama'] ?> <span class="text-muted fs-5">(<?= $car['cc'] ?> cc)</span>
                </h3>
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
                <div class="text-muted mb-1">
                  <?= format_rupiah($car['harga']) ?> / hari
                </div>
                <div class="text-muted mb-3">
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
                <div class="text-muted mb-1">
                  <?= $car['total_dipesan'] ?> kali dipesan
                </div>
              </div>
            </a>
            <div class="card-footer" style="padding: 0.5rem 1rem;">
              <a href="#" class="btn btn-outline-primary w-100" data-bs-toggle="modal" 
                data-bs-target="#modal-order" data-id="<?= $car['id'] ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                  <path d="M17 17h-11v-14h-2" />
                  <path d="M6 5l14 1l-1 7h-13" />
                </svg>
                Pesan
              </a>
            </div>
          </div>
        </div>
      <?php endforeach ?>

      <?php if (count($cars) == 0) : ?>
        <div class="empty d-flex flex-column justify-content-center align-items-center" style="min-height: 30rem;">
          <div class="empty-img"><img src="<?= asset('images\error\undraw_quitting_time_dm8t.svg') ?>" height="128"></div>
          <p class="empty-title">Mobil tidak ditemukan</p>
          <p class="empty-subtitle text-muted">
            Sesuaikan kata kunci pencarian atau filter yang digunakan.
          </p>
          <div class="empty-action">
            <a href="pesan-mobil.php" class="btn btn-outline-danger">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                </path>
                <path d="M4 7l16 0m-10 4l0 6m4 -6l0 6m-9 -10l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12m-10 0v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3">
                </path>
              </svg>
              Bersihkan filter pencarian
            </a>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</div>

<!-- Modal Option -->
<div class="modal modal-blur fade" id="modal-option" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Pencarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="GET" id="formOption">
        <input type="hidden" name="q" id="q">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-label">Agen</div>
              <select class="form-select" name="agen_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($agen as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['agen_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Merk</div>
              <select class="form-select" name="merk_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($merk as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['merk_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Jenis</div>
              <select class="form-select" name="jenis_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($jenis as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['jenis_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Transmisi</div>
              <select class="form-select" name="transmisi_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($transmisi as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['transmisi_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Warna</div>
              <select class="form-select" name="warna_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($warna as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['warna_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">CC</div>
              <select class="form-select" name="cc_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($cc as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['cc_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Tipe</div>
              <select class="form-select" name="tipe_id">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($tipe as $item) : ?>
                  <option value="<?= $item['id'] ?>" <?= ($_GET['tipe_id'] ?? '') == $item['id'] ? 'selected' : '' ?>>
                    <?= $item['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-label">Urutkan Berdasarkan</div>
              <select class="form-select" name="sortby">
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($sortables as $key => $value) : ?>
                  <option value="<?= $key ?>" <?= ($_GET['sortby'] ?? '') == $key ? 'selected' : '' ?>>
                    <?= $value ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          <div class="col-md-6 mb-3">
            <div class="form-label">Urutan</div>
            <div class="form-selectgroup">
              <label class="form-selectgroup-item">
                <input type="radio" name="order" value="asc" class="form-selectgroup-input" <?= ($_GET['order'] ?? '') == 'asc' ? 'checked' : '' ?>>
                <span class="form-selectgroup-label">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-ascending-letters me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 10v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4"></path>
                    <path d="M19 21h-4l4 -7h-4"></path>
                    <path d="M4 15l3 3l3 -3"></path>
                    <path d="M7 6v12"></path>
                  </svg>
                  Ascending
                </span>
              </label>
              <label class="form-selectgroup-item">
                <input type="radio" name="order" value="desc" class="form-selectgroup-input" <?= ($_GET['order'] ?? '') == 'desc' ? 'checked' : '' ?>>
                <span class="form-selectgroup-label">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sort-descending-letters me-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 21v-5c0 -1.38 .62 -2 2 -2s2 .62 2 2v5m0 -3h-4"></path>
                    <path d="M19 10h-4l4 -7h-4"></path>
                    <path d="M4 15l3 3l3 -3"></path>
                    <path d="M7 6v12"></path>
                  </svg>
                  Descending
                </span>
              </label>
            </div>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btnFormOption">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Order -->
<div class="modal modal-blur fade" id="modal-order" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Pemesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="formOrder">
        <input type="hidden" name="mobil_id" id="mobil_id">
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Nama Penerima</div>
              <input type="text" class="form-control" name="nama_penerima" required value="<?= $_SESSION['user']['nama'] ?? '' ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">No. Hp Penerima</div>
              <input type="text" class="form-control" name="alamat_penerima" required value="<?= $_SESSION['user']['alamat'] ?? '' ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Alamat Penerima</div>
              <input type="text" class="form-control" name="no_hp_penerima" required value="<?= $_SESSION['user']['no_hp'] ?? '' ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Tanggal Sewa</div>
              <input type="date" class="form-control" name="tanggal_sewa" required min="<?= date('Y-m-d') ?>">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Lama Sewa</div>
              <div class="input-group input-group-flat">
                <input type="number" class="form-control" name="jumlah_hari" required placeholder="Masukkan lama sewa">
                <span class="input-group-text">
                  Hari
                </span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Jasa Kirim</div>
              <select class="form-select" name="jasa_kirim_id" required>
                <option value="" disabled selected>Pilih</option>
                <?php foreach ($jasa_kirim as $item) : ?>
                  <option value="<?= $item['id'] ?>">
                    <?= $item['nama'] ?> (<?= format_rupiah($item['harga']) ?>)
                  </option>
                <?php endforeach ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <div class="form-label">Jumlah DP</div>
              <select class="form-select" name="jumlah_dp" required>
                <option value="" disabled selected>Pilih</option>
                <option value="25">25%</option>
                <option value="50">50%</option>
                <option value="75">75%</option>
                <option value="100">100%</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Pesan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>

<script>
  const formOption = document.getElementById('formOption');
  const btnFormOption = document.getElementById('btnFormOption');

  const inputSearch = document.getElementById('inputSearch');
  const btnSearch = document.getElementById('btnSearch');
  const q = document.getElementById('q');

  btnFormOption.addEventListener('click', submitFormOption);
  btnSearch.addEventListener('click', submitFormOption);
  inputSearch.addEventListener('keyup', function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      btnSearch.click();
    }
  });

  function submitFormOption() {
    q.value = inputSearch.value;
    formOption.submit();
  }

  const modalOrder = document.getElementById('modal-order');
  const mobil_id = document.getElementById('mobil_id');

  modalOrder.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    let id;

    const urlParams = new URLSearchParams(window.location.search);
    const order_id = urlParams.get('order_id');

    if (order_id) {
      id = order_id;
    } else {
      id = button.getAttribute('data-id');
    }

    mobil_id.value = id;
  });

  <?php if ($order_id): ?>
    $(document).ready(function() {
      mobil_id.value = <?= $order_id ?>;
      $('#modal-order').modal('show');
    })

    $('#modal-order').on('hidden.bs.modal', function() {
      window.history.replaceState({}, document.title, "pesan-mobil.php");
    })
  <?php endif ?>
</script>

<?php include('partials/footer.php') ?>

<?php 
  showToastIfExist();

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mobii_id = $_POST['mobil_id'];
    $nama_penerima = $_POST['nama_penerima'];
    $alamat_penerima = $_POST['alamat_penerima'];
    $no_hp_penerima = $_POST['no_hp_penerima'];
    $tanggal_sewa = $_POST['tanggal_sewa'];
    $jumlah_hari = $_POST['jumlah_hari'];
    $jasa_kirim_id = $_POST['jasa_kirim_id'];
    $persentase_dp = $_POST['jumlah_dp'];

    $mobil = getById($conn, 'mobil', $mobii_id);
    $jasa_kirim = getById($conn, 'jasa_kirim', $jasa_kirim_id);

    $total_harga = $mobil['harga'] * $jumlah_hari + $jasa_kirim['harga'];
    $jumlah_dp = $total_harga * $persentase_dp / 100;
    $status_pembayaran_id = 1;
    $status_pengiriman_id = 1;
    $status_pengembalian_id = 1;
    $jasa_kirim_id = $jasa_kirim['id'];
    $user_id = $_SESSION['user']['id'];
    $agen_id = $mobil['agen_id'];
    $mobil_id = $mobil['id'];
    $tanggal_pemesanan = date('Y-m-d H:i:s');
    $kode_transaksi = "TRX" . date('mdHis') . rand(100, 999);

    $query = "
      INSERT INTO transaksi (
        mobil_id,
        user_id,
        agen_id,
        status_pembayaran_id,
        status_pengiriman_id,
        status_pengembalian_id,
        jasa_kirim_id,
        nama_penerima,
        alamat_penerima,
        no_hp_penerima,
        tanggal_sewa,
        tanggal_pemesanan,
        jumlah_hari,
        total_harga,
        persentase_dp,
        jumlah_dp,
        kode_transaksi
      ) VALUES (
        $mobil_id,
        $user_id,
        $agen_id,
        $status_pembayaran_id,
        $status_pengiriman_id,
        $status_pengembalian_id,
        $jasa_kirim_id,
        '$nama_penerima',
        '$alamat_penerima',
        '$no_hp_penerima',
        '$tanggal_sewa',
        '$tanggal_pemesanan',
        $jumlah_hari,
        $total_harga,
        $persentase_dp,
        $jumlah_dp,
        '$kode_transaksi'
      )
    ";

    $result = $conn->query($query);

    if ($result) {
      setFlashMessage('success', 'Berhasil melakukan pemesanan');
      redirectJs('belum-bayar.php');
    } else {
      setFlashMessage('error', 'Gagal melakukan pemesanan');
      redirectJs('belum-bayar.php');
    }
  }
?>
