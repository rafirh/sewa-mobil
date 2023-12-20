<?php
$active = 'sedang-disewa';
$title = 'Sedang Disewa';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.plat_nomor AS plat_nomor,
  agen.nama AS nama_agen,
  agen.telepon AS telepon_agen,
  agen.alamat AS alamat_agen,
  status_pembayaran.status_pembayaran AS status_pembayaran
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN agen ON transaksi.agen_id = agen.id
  JOIN status_pembayaran ON transaksi.status_pembayaran_id = status_pembayaran.id
  WHERE transaksi.user_id = {$_SESSION['user']['id']} 
    AND (transaksi.status_pembayaran_id = 4 OR transaksi.status_pembayaran_id = 5)
    AND transaksi.status_pengembalian_id = 2
  ORDER BY transaksi.tanggal_pemesanan DESC
";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
          Pesanan Sedang Disewa
        </h3>
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
                  <th>Kode Transaksi</th>
                  <th>Mobil</th>
                  <th>Agen</th>
                  <th>Alamat</th>
                  <th>Tanggal Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Tenggat Pengembalian</th>
                  <th>Total Harga</th>
                  <th>Status Pembayaran</th>
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
                      <span <?= add_title_tooltip($item['nama_agen'], 24) ?>>
                        <?= mb_strimwidth($item['nama_agen'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['telepon_agen'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['alamat_agen'], 35) ?>>
                        <?= mb_strimwidth($item['alamat_agen'], 0, 35, '...') ?>
                      </span>
                    </td>
                    <td>
                      <?= date('d M Y', strtotime($item['tanggal_sewa'])) ?>
                    </td>
                    <td>
                      <?= $item['jumlah_hari'] ?> hari
                    </td>
                    <td>
                      <?= date('d M Y', strtotime($item['tanggal_sewa'] . ' + ' . $item['jumlah_hari'] . ' days')) ?>
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
                        <p class="empty-title">Anda belum memiliki pesanan</p>
                        <p class="empty-subtitle text-muted">
                          Anda belum memiliki pesanan, silahkan pesan mobil terlebih dahulu.
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

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>

<?php include('partials/footer.php') ?>

<?php
showToastIfExist();
?>