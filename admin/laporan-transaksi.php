<?php
$active = 'laporan-transaksi';
$title = 'Laporan Transaksi';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.plat_nomor AS plat_nomor,
  user.nama AS nama_customer,
  user.no_hp AS telepon_customer,
  agen.nama AS nama_agen,
  agen.telepon AS telepon_agen,
  status_pembayaran.status_pembayaran AS status_pembayaran,
  status_pengembalian.status_pengembalian AS status_pengembalian
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN user ON transaksi.user_id = user.id
  JOIN status_pembayaran ON transaksi.status_pembayaran_id = status_pembayaran.id
  JOIN status_pengembalian ON transaksi.status_pengembalian_id = status_pengembalian.id
  JOIN agen ON transaksi.agen_id = agen.id
  WHERE 1=1
";

if (isParamsExist(['start_date'])) {
  $start_date = htmlspecialchars($_GET['start_date']);
  $query .= " AND transaksi.tanggal_pemesanan >= '{$start_date}'";
}

if (isParamsExist(['end_date'])) {
  $end_date = htmlspecialchars($_GET['end_date']);
  $query .= " AND transaksi.tanggal_pemesanan <= '{$end_date}'";
}

if (isParamsExist(['user_id'])) {
  $user_id = htmlspecialchars($_GET['user_id']);
  $query .= " AND transaksi.user_id = '{$user_id}'";
}

if (isParamsExist(['agen_id'])) {
  $agen_id = htmlspecialchars($_GET['agen_id']);
  $query .= " AND transaksi.agen_id = '{$agen_id}'";
}

if (isParamsExist(['status_pembayaran_id'])) {
  $status_pembayaran_id = htmlspecialchars($_GET['status_pembayaran_id']);
  $query .= " AND transaksi.status_pembayaran_id = '{$status_pembayaran_id}'";
}

if (isParamsExist(['status_pengembalian_id'])) {
  $status_pengembalian_id = htmlspecialchars($_GET['status_pengembalian_id']);
  $query .= " AND transaksi.status_pengembalian_id = '{$status_pengembalian_id}'";
}

$query .= " ORDER BY transaksi.tanggal_pemesanan DESC";

$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_all($result, MYSQLI_ASSOC);

$users = mysqli_query($conn, "SELECT * FROM user WHERE role = 'customer'");
$agens = getAll($conn, 'agen');
$status_pembayaran = getAll($conn, 'status_pembayaran');
$status_pengembalian = getAll($conn, 'status_pengembalian');

$total_pendapatan = 0; 
foreach ($transaksi as $item) {
  $total_pendapatan += $item['total_harga'];
}
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

  .btn-action-delete:hover {
    background-color: #e74c3c;
    color: #ffffff;
    transition: 0.3s;
  }
</style>

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

<div class="page-header d-print-none mt-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h3 class="page-title">
          Laporan Transaksi
        </h3>
      </div>
    </div>
    <div class="row g-2 align-items-center mt-2">
      <div class="col d-flex">
        <a href="#" class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modal-option">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5.5 5h13a1 1 0 0 1 .5 1.5l-5 5.5l0 7l-4 -3l0 -4l-5 -5.5a1 1 0 0 1 .5 -1.5"></path>
          </svg>
          Filter
        </a>
        <?php if (isParamsExist(['start_date', 'end_date', 'pelanggan_id', 'agen_id', 'status_pembayaran_id', 'status_pengembalian_id'])) : ?>
          <a href="laporan-transaksi.php" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-original-title="Clear filter" data-bs-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M4 7h16"></path>
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
              <path d="M10 12l4 4m0 -4l-4 4"></path>
            </svg>
            Hapus filter
          </a>
        <?php endif ?>
      </div>
    </div>
    <div class="row g-2 align-items-center mt-2">
      <div class="col d-flex text-muted">
        <span class="me-3">Total transaksi: <?= count($transaksi) ?></span>
        <span>Total pendapatan: <?= format_rupiah($total_pendapatan) ?></span>
      </div>
    </div>
  </div>
</div>

<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Tanggal Transaksi</th>
                  <th>Kode Transaksi</th>
                  <th>Mobil</th>
                  <th>Pelanggan</th>
                  <th>Agen</th>
                  <th>Tanggal Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Total Harga</th>
                  <th>Status Pembayaran</th>
                  <th>Status Mobil</th>
                  <th class="text-center">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($transaksi as $index => $item) : ?>
                  <tr class="text-muted">
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <?= date('d M Y H:i', strtotime($item['tanggal_pemesanan'])) ?>
                    </td>
                    <td>
                      <?= $item['kode_transaksi'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_mobil'], 24) ?>>
                        <?= mb_strimwidth($item['nama_mobil'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['plat_nomor'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_customer'], 24) ?>>
                        <?= mb_strimwidth($item['nama_customer'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['telepon_customer'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_agen'], 24) ?>>
                        <?= mb_strimwidth($item['nama_agen'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['telepon_agen'] ?>
                    </td>
                    <td>
                      <?= date('d M Y', strtotime($item['tanggal_sewa'])) ?>
                    </td>
                    <td>
                      <?= $item['jumlah_hari'] ?> hari
                    </td>
                    <td>
                      <?= format_rupiah($item['total_harga']) ?>
                    </td>
                    <td>
                      <?php if ($item['status_pembayaran_id'] == 1) : ?>
                        <span class="badge badge-outline text-yellow">
                          <?= $item['status_pembayaran'] ?>
                        </span>
                      <?php elseif ($item['status_pembayaran_id'] == 2) : ?>
                        <span class="badge badge-outline text-teal">
                          <?= $item['status_pembayaran'] ?>
                        </span>
                      <?php elseif ($item['status_pembayaran_id'] == 3) : ?>
                        <span class="badge badge-outline text-danger">
                          <?= $item['status_pembayaran'] ?>
                        </span>
                      <?php elseif ($item['status_pembayaran_id'] == 4) : ?>
                        <span class="badge badge-outline text-primary">
                          <?= $item['status_pembayaran'] ?>
                        </span>
                      <?php elseif ($item['status_pembayaran_id'] == 5) : ?>
                        <span class="badge badge-outline text-success">
                          <?= $item['status_pembayaran'] ?>
                        </span>
                      <?php endif ?>
                    </td>
                    <td>
                    <?php if ($item['status_pengembalian_id'] == 1): ?>
                      <span class="badge badge-outline text-primary">
                        <?= $item['status_pengembalian'] ?>
                      </span>
                    <?php elseif ($item['status_pengembalian_id'] == 2): ?>
                      <span class="badge badge-outline text-orange">
                        <?= $item['status_pengembalian'] ?>
                      </span>
                    <?php elseif ($item['status_pengembalian_id'] == 3): ?>
                      <span class="badge badge-outline text-success">
                        <?= $item['status_pengembalian'] ?>
                      </span>
                    <?php endif ?>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-icon btn-pill bg-muted-lt" data-bs-toggle="dropdown" aria-expanded="false" title="Lainnya">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-dots-vertical" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <circle cx="12" cy="12" r="1">
                            </circle>
                            <circle cx="12" cy="19" r="1">
                            </circle>
                            <circle cx="12" cy="5" r="1">
                            </circle>
                          </svg>
                        </button>
                        <div class="text-muted dropdown-menu dropdown-menu-end">
                          <a class="dropdown-item" href="detail-transaksi.php?id=<?= $item['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                              <path d="M9 17h6" />
                              <path d="M9 13h6" />
                            </svg>
                            Detail
                          </a>
                          <a class="dropdown-item" href="faktur.php?id=<?= $item['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-receipt me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2m4 -14h6m-6 4h6m-2 4h2" />
                            </svg>
                            Faktur
                          </a>
                          <a class="dropdown-item" href="nota.php?id=<?= $item['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                              <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                              <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Print Nota
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
                <?php if (count($transaksi) == 0) : ?>
                  <tr class="text-center">
                    <td colspan="99">
                      <div class="empty bg-transparent" style="height: 500px;">
                        <div class="empty-img"><img src="<?= asset('images\error\undraw_quitting_time_dm8t.svg') ?>" height="128">
                        </div>
                        <p class="empty-title">Transaksi tidak ditemukan</p>
                        <p class="empty-subtitle text-muted">
                          Sesuaikan kata pencarian atau filter yang anda pilih.
                        </p>
                      </div>
                    </td>
                  </tr>
                <?php endif ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Option -->
<div class="modal modal-blur fade" id="modal-option" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Filter Pencarian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="GET" id="formOption">
        <input type="hidden" name="q" id="q">
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-label">Tanggal Mulai</div>
              <input type="date" class="form-control" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>">
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Tanggal Selesai</div>
              <input type="date" class="form-control" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>">
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Pelanggan</div>
              <select class="form-select" name="user_id">
                <option value="">Semua</option>
                <?php foreach ($users as $user) : ?>
                  <option value="<?= $user['id'] ?>" <?= isset($_GET['user_id']) && $_GET['user_id'] == $user['id'] ? 'selected' : '' ?>>
                    <?= $user['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Agen</div>
              <select class="form-select" name="agen_id">
                <option value="">Semua</option>
                <?php foreach ($agens as $agen) : ?>
                  <option value="<?= $agen['id'] ?>" <?= isset($_GET['agen_id']) && $_GET['agen_id'] == $agen['id'] ? 'selected' : '' ?>>
                    <?= $agen['nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Status Pembayaran</div>
              <select class="form-select" name="status_pembayaran_id">
                <option value="">Semua</option>
                <?php foreach ($status_pembayaran as $status) : ?>
                  <option value="<?= $status['id'] ?>" <?= isset($_GET['status_pembayaran_id']) && $_GET['status_pembayaran_id'] == $status['id'] ? 'selected' : '' ?>>
                    <?= $status['status_pembayaran'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Status Pengembalian</div>
              <select class="form-select" name="status_pengembalian_id">
                <option value="">Semua</option>
                <?php foreach ($status_pengembalian as $status) : ?>
                  <option value="<?= $status['id'] ?>" <?= isset($_GET['status_pengembalian_id']) && $_GET['status_pengembalian_id'] == $status['id'] ? 'selected' : '' ?>>
                    <?= $status['status_pengembalian'] ?>
                  </option>
                <?php endforeach ?>
              </select>
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

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>
<script>
  const formOption = document.getElementById('formOption');
  const btnFormOption = document.getElementById('btnFormOption');

  btnFormOption.addEventListener('click', submitFormOption);

  function submitFormOption() {
    formOption.submit();
  }
</script>

<?php include('partials/footer.php') ?>

<?php
showToastIfExist();
?>