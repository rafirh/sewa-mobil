<?php
$active = 'detail-transaksi';
$title = 'Detail Transaksi';

include('partials/header.php');

$prevPage = $_SERVER['HTTP_REFERER'];
if (str_contains($prevPage, 'detail-transaksi.php')) {
  $prevPage = 'belum-bayar.php';
}

if (!isParamsExist(['id'])) {
  redirect($prevPage);
}

$id = $_GET['id'];


$qeury = "
  SELECT transaksi.*,
    mobil.nama AS nama_mobil,
    mobil.plat_nomor AS plat_nomor_mobil,
    mobil.kapasitas AS kapasitas_mobil,
    mobil.foto AS foto_mobil,
    agen.nama AS nama_agen,
    agen.alamat AS alamat_agen,
    agen.telepon AS telepon_agen,
    agen.no_rekening AS no_rekening_agen,
    agen.bank AS nama_bank_agen,
    agen.atas_nama AS atas_nama_agen,
    metode_pembayaran.nama AS nama_metode_pembayaran,
    status_pembayaran.status_pembayaran AS nama_status_pembayaran,
    status_pengembalian.status_pengembalian AS nama_status_pengembalian,
    jaminan.nama AS nama_jaminan,
    denda.nama AS nama_denda,
    denda.tarif AS tarif_denda
  FROM transaksi
  JOIN mobil ON transaksi.mobil_id = mobil.id
  JOIN agen ON transaksi.agen_id = agen.id
  LEFT JOIN metode_pembayaran ON transaksi.metode_pembayaran_id = metode_pembayaran.id
  JOIN status_pembayaran ON transaksi.status_pembayaran_id = status_pembayaran.id
  JOIN status_pengembalian ON transaksi.status_pengembalian_id = status_pengembalian.id
  JOIN jaminan ON transaksi.jaminan_id = jaminan.id
  LEFT JOIN denda ON transaksi.denda_id = denda.id
  WHERE transaksi.user_id = {$_SESSION['user']['id']} AND transaksi.id = $id
";

$result = mysqli_query($conn, $qeury);
$transaksi = mysqli_fetch_assoc($result);

if (!$transaksi) {
  setFlashMessage('error', 'Transaksi tidak ditemukan');
  redirectJs($prevPage);
}

if ($transaksi['user_id'] != $_SESSION['user']['id']) {
  redirectJs($prevPage);
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
              Detail Transaksi
            </h2>
          </div>
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list d-flex">
              <a href="<?= $prevPage ?>" class="btn btn-outline-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M5 12l14 0"></path>
                  <path d="M5 12l6 6"></path>
                  <path d="M5 12l6 -6"></path>
                </svg>
                Kembali
              </a>
              <a href="<?= $prevPage ?>" class="btn btn-outline-primary d-sm-none btn-icon" aria-label="Kembali">
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
            <h3 class="card-title"><?= $transaksi['kode_transaksi'] ?></h3>
          </div>
          <div class="px-sm-5 py-3 py-sm-4 w-75 mx-auto">
            <a data-fslightbox="gallery<?= $index ?>" href="<?= asset($transaksi['foto_mobil'] != '' ? $transaksi['foto_mobil'] : 'images/default.png') ?>">
              <div class="img-responsive card-img-top" style="background-image: url(<?= asset($transaksi['foto_mobil'] != '' ? $transaksi['foto_mobil'] : 'images/default.png') ?>)">
              </div>
            </a>
          </div>
          <div class="card-body px-4">
            <div class="row">
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Nama Mobil</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['nama_mobil'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Kapasitas</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['kapasitas_mobil'] ?> orang
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Plat Nomor</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['plat_nomor_mobil'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Nama Pelanggan</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['nama_penerima'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Alamat Pelanggan</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['alamat_penerima'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Telepon Pelanggan</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['no_hp_penerima'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Nama Agen</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['nama_agen'] ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Rekening Agen</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['no_rekening_agen'] ?> <br>
                      (<?= $transaksi['nama_bank_agen'] ?> a.n. <?= $transaksi['atas_nama_agen'] ?>)
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Waktu Pesan</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= date('d M Y H:i', strtotime($transaksi['tanggal_pemesanan'])) ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Tanggal Sewa</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= date('d M Y', strtotime($transaksi['tanggal_sewa'])) ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Lama Sewa</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['jumlah_hari'] ?> hari
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Waktu Pengembalian</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['tanggal_pengembalian'] ? date('d M Y H:i', strtotime($transaksi['tanggal_pengembalian'])) : '-' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Total Biaya</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= format_rupiah($transaksi['total_harga']) ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Jumlah DP</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= format_rupiah($transaksi['jumlah_dp']) ?> (<?= $transaksi['persentase_dp'] ?>%)
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Metode Pembayaran</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['nama_metode_pembayaran'] ?? '-' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Waktu DP</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['tanggal_dp'] ? date('d M Y H:i', strtotime($transaksi['tanggal_dp'])) : '-' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Bukti DP</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?php if ($transaksi['bukti_dp']): ?>
                        <a data-fslightbox="bukti-dp" href="<?= asset($transaksi['bukti_dp']) ?>">
                          Lihat bukti
                        </a>
                      <?php else: ?>
                        -
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Jumlah Bayar Lunas</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['jumlah_bayar_lunas'] ? format_rupiah($transaksi['jumlah_bayar_lunas']) : '-' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Waktu Bayar Lunas</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['tanggal_bayar_lunas'] ? date('d M Y H:i', strtotime($transaksi['tanggal_bayar_lunas'])) : '-' ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Bukti Bayar Lunas</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?php if ($transaksi['bukti_bayar_lunas']): ?>
                        <a data-fslightbox="bukti-lunas" href="<?= asset($transaksi['bukti_bayar_lunas']) ?>">
                          Lihat bukti
                        </a>
                      <?php else: ?>
                        -
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Status Mobil</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                        <?php if ($transaksi['status_pengembalian_id'] == 1): ?>
                          <span class="badge badge-outline text-primary">
                            <?= $transaksi['nama_status_pengembalian'] ?>
                          </span>
                        <?php elseif ($transaksi['status_pengembalian_id'] == 2): ?>
                          <span class="badge badge-outline text-orange">
                            <?= $transaksi['nama_status_pengembalian'] ?>
                          </span>
                        <?php elseif ($transaksi['status_pengembalian_id'] == 3): ?>
                          <span class="badge badge-outline text-success">
                            <?= $transaksi['nama_status_pengembalian'] ?>
                          </span>
                        <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Status Pembayaran</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?php if ($transaksi['status_pembayaran_id'] == 1): ?>
                        <span class="badge badge-outline text-yellow">
                          <?= $transaksi['nama_status_pembayaran'] ?>
                        </span>
                      <?php elseif ($transaksi['status_pembayaran_id'] == 2): ?>
                        <span class="badge badge-outline text-orange">
                          <?= $transaksi['nama_status_pembayaran'] ?>
                        </span>
                      <?php elseif ($transaksi['status_pembayaran_id'] == 3): ?>
                        <span class="badge badge-outline text-danger">
                          <?= $transaksi['nama_status_pembayaran'] ?>
                        </span>
                      <?php elseif ($transaksi['status_pembayaran_id'] == 4 && $transaksi['bukti_bayar_lunas'] != null): ?>
                        <span class="badge badge-outline text-orange">
                          Pelunasan Sedang Diverifikasi
                        </span>
                      <?php elseif ($transaksi['status_pembayaran_id'] == 4): ?>
                        <span class="badge badge-outline text-primary">
                          <?= $transaksi['nama_status_pembayaran'] ?>
                        </span>
                      <?php elseif ($transaksi['status_pembayaran_id'] == 5): ?>
                        <span class="badge badge-outline text-success">
                          <?= $transaksi['nama_status_pembayaran'] ?>
                        </span>
                      <?php endif ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-6">
                <div class="mb-3">
                  <label class="form-label">Jaminan</label>
                  <div class="form-control-plaintext">
                    <div class="text-muted mb-1">
                      <?= $transaksi['nama_jaminan'] ?>
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