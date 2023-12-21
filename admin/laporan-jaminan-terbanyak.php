<?php
$active = 'laporan-jaminan-terbanyak';
$title = 'Laporan Jaminan Terbanyak';

include('partials/header.php');

$query = "
  SELECT
    jaminan.nama as nama_jaminan,
    COUNT(transaksi.id) AS total_transaksi,
    SUM(transaksi.total_harga) AS total_pendapatan
  FROM transaksi
  RIGHT JOIN jaminan ON jaminan.id = transaksi.jaminan_id
  WHERE transaksi.status_pembayaran_id = 5
";

if (isParamsExist(['start_date'])) {
  $start_date = htmlspecialchars($_GET['start_date']);
  $query .= " AND transaksi.tanggal_pemesanan >= '{$start_date}'";
}

if (isParamsExist(['end_date'])) {
  $end_date = htmlspecialchars($_GET['end_date']);
  $query .= " AND transaksi.tanggal_pemesanan <= '{$end_date}'";
}

$query .= "
  GROUP BY jaminan.id
  ORDER BY total_transaksi DESC, total_pendapatan DESC
";

$result = mysqli_query($conn, $query);
$laporan = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
          Laporan Jaminan Terbanyak
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
        <?php if (isParamsExist(['start_date', 'end_date'])) : ?>
          <a href="laporan-jaminan-terbanyak.php" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-original-title="Clear filter" data-bs-placement="bottom">
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
                  <th>Jaminan</th>
                  <th>Total Pesanan</th>
                  <th>Total Pendapatan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($laporan as $index => $item) : ?>
                  <tr class="text-muted">
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <?= $item['nama_jaminan'] ?>
                    </td>
                    <td>
                      <?= $item['total_transaksi'] ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['total_pendapatan']) ?>
                    </td>
                  </tr>
                <?php endforeach ?>
                <?php if (count($laporan) == 0) : ?>
                  <tr class="text-center">
                    <td colspan="99">
                      <div class="empty bg-transparent" style="height: 500px;">
                        <div class="empty-img"><img src="<?= asset('images\error\undraw_quitting_time_dm8t.svg') ?>" height="128">
                        </div>
                        <p class="empty-title">Laporan tidak ditemukan</p>
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