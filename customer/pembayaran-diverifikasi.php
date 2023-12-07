<?php
$active = 'pembayaran-diverifikasi';
$title = 'Pembayaran Diverifikasi';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.foto AS foto_mobil,
  agen.nama AS nama_agen,
  agen.no_rekening AS no_rekening_agen,
  agen.atas_nama AS atas_nama_agen,
  agen.bank AS bank_agen,
  agen.telepon AS telepon_agen
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN agen ON transaksi.agen_id = agen.id
  WHERE transaksi.user_id = {$_SESSION['user']['id']} AND transaksi.status_pembayaran_id = 2
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
          Pembayaran Sedaang Diverifikasi
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
                  <th>Bukti DP</th>
                  <th>Kode Transaksi</th>
                  <th>Waktu DP</th>
                  <th>Mobil</th>
                  <th>Agen</th>
                  <th>Total Harga</th>
                  <th>DP</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($transaksi as $index => $item) : ?>
                  <tr class="text-muted">
                    <td>
                      <?= $index + 1 ?>
                    </td>
                    <td>
                      <a class="avatar me-2 image-preview cursor-pointer" data-fslightbox="image-<?= $index + 1 ?>" href="<?= asset($item['bukti_dp'] != '' ? $item['bukti_dp'] : 'images/default.png') ?>" style="background-image: url(<?= asset($item['bukti_dp'] != '' ? $item['bukti_dp'] : 'images/default.png') ?>)">
                      </a>
                    </td>
                    <td>
                      <?= $item['kode_transaksi'] ?>
                    </td>
                    <td>
                      <?= date('d F Y H:i', strtotime($item['tanggal_dp'])) ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_mobil'], 24) ?>>
                        <?= mb_strimwidth($item['nama_mobil'], 0, 24, '...') ?>
                      </span>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_agen'], 24) ?>>
                        <?= mb_strimwidth($item['nama_agen'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['telepon_agen'] ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['total_harga']) ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['jumlah_dp']) ?>
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