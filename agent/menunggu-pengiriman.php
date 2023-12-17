<?php
$active = 'menunggu-pengiriman';
$title = 'Menunggu Pengiriman';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.plat_nomor AS plat_nomor,
  user.nama AS nama_customer,
  user.no_hp AS telepon_customer,
  user.alamat AS alamat_customer, 
  jasa_kirim.nama AS nama_jasa_kirim
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN user ON transaksi.user_id = user.id
  JOIN jasa_kirim ON transaksi.jasa_kirim_id = jasa_kirim.id
  WHERE transaksi.agen_id = {$_SESSION['user']['agen_id']} AND transaksi.status_pembayaran_id = 4
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
          Menunggu Pengiriman
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
                  <th>Pelanggan</th>
                  <th>Alamat</th>
                  <th>Tanggal Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Jasa Kirim</th>
                  <th>Total Harga</th>
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
                      <span <?= add_title_tooltip($item['nama_customer'], 24) ?>>
                        <?= mb_strimwidth($item['nama_customer'], 0, 24, '...') ?>
                      </span>
                      <br>
                      <?= $item['telepon_customer'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['alamat_customer'], 35) ?>>
                        <?= mb_strimwidth($item['alamat_customer'], 0, 35, '...') ?>
                      </span>
                    </td>
                    <td>
                      <?= date('d F Y', strtotime($item['tanggal_sewa'])) ?>
                    </td>
                    <td>
                      <?= $item['jumlah_hari'] ?> hari
                    </td>
                    <td>
                      <?= format_rupiah($item['total_harga']) ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_jasa_kirim'], 24) ?>>
                        <?= mb_strimwidth($item['nama_jasa_kirim'], 0, 24, '...') ?>
                      </span>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <button class="btn btn-icon btn-pill bg-primary-lt me-1" data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDeliverr">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                            <path d="M3 9l4 0" />
                          </svg>
                        </button>
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

<!-- Modal Deliver -->
<div class="modal modal-blur fade" id="modalDeliver" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-primary"></div>
      <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-primary icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M12 9v2m0 4v.01" />
          <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
        </svg>
        <h3>Apakah anda yakin ingin mengkonfirmasi pembayaran ini?</h3>
        <div class="text-muted">Pembayaran yang dikonfirmasi tidak dapat dibatalkan.</div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                Batal
              </a></div>
            <div class="col">
              <form method="post" id="formAccept" action="validasi-pembayaran.php">
                <input type="hidden" name="id" value="" id="inputAcceptId">
                <input type="hidden" name="is_valid" value="1">
                <button type="submit" class="btn btn-primary w-100">
                  Ya, konfirmasi
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>

<script>
  const modalDeliver = document.getElementById('modalDeliver');
  modalDeliver.addEventListener('show.bs.modal', function(event) {
    const inputAcceptId = document.getElementById('inputAcceptId');
    inputAcceptId.value = event.relatedTarget.dataset.id;
  });
</script>

<?php include('partials/footer.php') ?>

<?php
showToastIfExist();
?>