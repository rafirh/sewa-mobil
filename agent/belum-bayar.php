<?php
$active = 'belum-bayar';
$title = 'Belum Bayar';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.foto AS foto_mobil,
  user.nama AS nama_customer,
  user.no_hp AS telepon_customer,
  user.alamat AS alamat_customer
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN user ON transaksi.user_id = user.id
  WHERE transaksi.agen_id = {$_SESSION['user']['agen_id']} AND (transaksi.status_pembayaran_id = 1 OR transaksi.status_pembayaran_id = 3)
  ORDER BY transaksi.tanggal_pemesanan DESC
";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_all($result, MYSQLI_ASSOC);

$metode_pembayaran = getAll($conn, 'metode_pembayaran');
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
          Pesanan Belum Dibayar
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
                  <th>Foto</th>
                  <th>Kode</th>
                  <th>Mobil</th>
                  <th>Pelanggan</th>
                  <th>Alamat</th>
                  <th>Tanggal Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Total Harga</th>
                  <th>DP</th>
                  <th>Status</th>
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
                      <a class="avatar me-2 image-preview cursor-pointer" data-fslightbox="image-<?= $index + 1 ?>" href="<?= asset($item['foto_mobil'] != '' ? $item['foto_mobil'] : 'images/default.png') ?>" style="background-image: url(<?= asset($item['foto_mobil'] != '' ? $item['foto_mobil'] : 'images/default.png') ?>)">
                      </a>
                    </td>
                    <td>
                      <?= $item['kode_transaksi'] ?>
                    </td>
                    <td>
                      <span <?= add_title_tooltip($item['nama_mobil'], 24) ?>>
                        <?= mb_strimwidth($item['nama_mobil'], 0, 24, '...') ?>
                      </span>
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
                      <?= format_rupiah($item['jumlah_dp']) ?>
                    </td>
                    <td>
                      <?php if ($item['status_pembayaran_id'] == 1) : ?>
                        <span class="badge bg-yellow-lt">Belum dibayar</span>
                      <?php elseif ($item['status_pembayaran_id'] == 3) : ?>
                        <span class="badge bg-danger-lt">Pembayaran Ditolak</span>
                      <?php endif ?>
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
                          <a class="dropdown-item" href="faktur.php?id=<?= $item['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-description me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                              <path d="M9 17h6" />
                              <path d="M9 13h6" />
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

<!-- Modal Delete -->
<div class="modal modal-blur fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <div class="modal-body text-center py-4">
        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M12 9v2m0 4v.01" />
          <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
        </svg>
        <h3>Apakah anda yakin?</h3>
        <div class="text-muted">Pesanan yang dibatalkan tidak dapat dipulihkan.</div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                Batal
              </a></div>
            <div class="col">
              <form method="post" id="formDelete" action="batalkan-pesanan.php">
                <input type="hidden" name="id" value="" id="inputDeleteId">
                <button type="submit" class="btn btn-danger w-100" id="btnDelete">
                  Ya, batalkan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Payment -->
<div class="modal modal-blur fade" id="modalPayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="belum-bayar.php" enctype="multipart/form-data">
        <input type="hidden" name="transaksi_id" id="transaksi_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-label">Jumlah DP</div>
              <div class="form-control-plaintext" id="jumlahDp">Rp 0</div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Rekening</div>
              <div class="form-control-plaintext" id="rekening">...</div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label required">Metode Pembayaran</div>
              <select required class="form-select" name="metode_pembayaran_id" id="metodePembayaran">
                <?php foreach ($metode_pembayaran as $item) : ?>
                  <option value="<?= $item['id'] ?>"><?= $item['nama'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-12 mb-3">
              <div required class="form-label required">Bukti Pembayaran</div>
              <input type="file" class="form-control" name="bukti" id="buktiInput">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= asset('plugins/tabler/dist/libs/fslightbox/index.js') ?>" defer></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<script>
  const modalDelete = document.getElementById('modalDelete');

  modalDelete.addEventListener('show.bs.modal', function(event) {
    const inputDeleteId = document.getElementById('inputDeleteId');
    inputDeleteId.value = event.relatedTarget.dataset.id;
  });

  FilePond.registerPlugin(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
  );

  const fotoInput = FilePond.create(document.querySelector('#buktiInput'), {
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
    labelFileTypeNotAllowed: 'File must be an image',
    storeAsFile: true,
  });

  const modalPayment = document.getElementById('modalPayment');
  const transaksiId = document.getElementById('transaksi_id');
  const jumlahDp = document.getElementById('jumlahDp');
  const rekening = document.getElementById('rekening');

  modalPayment.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.dataset.id;
    const jumlahdp = button.dataset.jumlahdp;
    const rekeningText = button.dataset.rekening;

    transaksiId.value = id;
    jumlahDp.innerHTML = formatRupiah(jumlahdp);
    rekening.innerHTML = rekeningText;
  });

  function formatRupiah(angka) {
    const result = Number(angka).toLocaleString('id-ID', {
      style: 'currency',
      currency: 'IDR'
    });

    return result.replace(',00', '');
  }
</script>

<?php include('partials/footer.php') ?>

<?php
showToastIfExist();
?>