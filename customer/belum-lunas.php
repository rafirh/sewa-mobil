<?php
$active = 'belum-lunas';
$title = 'Pesanan Belum Lunas';

include('partials/header.php');

$query = "
  SELECT transaksi.*,
  mobil.nama AS nama_mobil,
  mobil.plat_nomor AS plat_nomor,
  agen.nama AS nama_agen,
  agen.telepon AS telepon_agen,
  agen.alamat AS alamat_agen, 
  agen.bank AS bank_agen,
  agen.no_rekening AS no_rekening_agen,
  agen.atas_nama AS atas_nama_agen,
  jasa_kirim.nama AS nama_jasa_kirim,
  status_pembayaran.status_pembayaran AS status_pembayaran
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN agen ON transaksi.agen_id = agen.id
  JOIN jasa_kirim ON transaksi.jasa_kirim_id = jasa_kirim.id
  JOIN status_pembayaran ON transaksi.status_pembayaran_id = status_pembayaran.id
  WHERE transaksi.user_id = {$_SESSION['user']['id']} 
    AND transaksi.status_pembayaran_id = 4
    AND transaksi.status_pengiriman_id = 3
    AND transaksi.status_pengembalian_id = 2
    AND transaksi.bukti_bayar_lunas IS NULL
  ORDER BY transaksi.tanggal_pemesanan DESC
";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (checkRequiredFields(['transaksi_id'])) {
    $transaksi_id = htmlspecialchars($_POST['transaksi_id']);

    if (isset($_FILES['bukti']) && !empty($_FILES['bukti']['name'])) {
      $bukti_dp = storeImage($_FILES['bukti'], 'bukti');
    } else {
      setFlashMessage('error', 'Semua data harus diisi!');
      redirectJs('belum-lunas.php');
      exit;
    }

    $query = "SELECT * FROM transaksi WHERE id = $transaksi_id";
    $result = mysqli_query($conn, $query);
    $transaksi = mysqli_fetch_assoc($result);

    if (!$transaksi) {
      setFlashMessage('error', 'Transaksi tidak ditemukan!');
      redirectJs('belum-lunas.php');
      exit;
    }

    $tanggal_bayar_lunas = date('Y-m-d H:i:s');
    $jumlah_bayar_lunas = $transaksi['total_harga'] - $transaksi['jumlah_dp'];

    $query = "UPDATE transaksi SET bukti_bayar_lunas = '$bukti_dp', tanggal_bayar_lunas = '$tanggal_bayar_lunas', jumlah_bayar_lunas = $jumlah_bayar_lunas WHERE id = $transaksi_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
      setFlashMessage('success', 'Bukti pembayaran berhasil dikirim!');
      redirectJs('belum-lunas.php');
      exit;
    } else {
      setFlashMessage('error', 'Bukti pembayaran gagal dikirim!');
      redirectJs('belum-lunas.php');
      exit;
    }
  } else {
    setFlashMessage('error', 'Semua data harus diisi!');
  }
}
?>

<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />

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
          Pesanan Belum Lunas
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
                  <th>Tanggal Sewa</th>
                  <th>Lama Sewa</th>
                  <th>Tanggal Kembali</th>
                  <th>Total DP</th>
                  <th>Total Harga</th>
                  <th>Kekurangan</th>
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
                      <?= date('d M Y', strtotime($item['tanggal_sewa'])) ?>
                    </td>
                    <td>
                      <?= $item['jumlah_hari'] ?> hari
                    </td>
                    <td>
                      <?= date('d M Y', strtotime($item['tanggal_pengembalian'])) ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['jumlah_dp']) ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['total_harga']) ?>
                    </td>
                    <td>
                      <?= format_rupiah($item['total_harga'] - $item['jumlah_dp']) ?>
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
                        <button class="btn btn-icon btn-pill bg-primary-lt me-1" data-bs-toggle="modal" data-bs-target="#modalPayment" data-id="<?= $item['id'] ?>" data-kekurangan="<?= $item['total_harga'] - $item['jumlah_dp'] ?>" data-rekening="<?= $item['bank_agen'] ?> <?= $item['no_rekening_agen'] ?> (<?= $item['atas_nama_agen'] ?>)">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-cashapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" />
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

<!-- Modal Payment -->
<div class="modal modal-blur fade" id="modalPayment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="belum-lunas.php" enctype="multipart/form-data">
        <input type="hidden" name="transaksi_id" id="transaksi_id">
        <div class="modal-body">
          <div class="row">
            <div class="col-12 mb-3">
              <div class="form-label">Kekurangan yang harus dibayar</div>
              <div class="form-control-plaintext" id="kekurangan">Rp 0</div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label">Rekening</div>
              <div class="form-control-plaintext" id="rekening">...</div>
            </div>
            <div class="col-12 mb-3">
              <div class="form-label required">Bukti Pembayaran</div>
              <input required type="file" class="form-control" name="bukti" id="buktiInput">
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
  const kekurangan = document.getElementById('kekurangan');
  const rekening = document.getElementById('rekening');

  modalPayment.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const id = button.dataset.id;
    const jumlahKekurangan = button.dataset.kekurangan;
    const rekeningText = button.dataset.rekening;

    transaksiId.value = id;
    kekurangan.innerHTML = formatRupiah(jumlahKekurangan);
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