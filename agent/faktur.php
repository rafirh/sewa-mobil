<?php
$active = 'faktur';
$title = 'Faktur';

include('partials/header.php');

if (!isset($_GET['id'])) {
  redirectJs('belum-bayar.php');
}

$id = $_GET['id'];

$prev = $_SERVER['HTTP_REFERER'] ?? 'belum-bayar.php';
if (str_contains($prev, 'faktur.php')) {
  $prev = 'belum-bayar.php';
}

$query = "
  SELECT transaksi.*,
    mobil.nama AS nama_mobil,
    mobil.harga AS harga_mobil,
    mobil.kapasitas AS kapasitas_mobil,
    cc.nama AS cc_mobil,
    a.nama AS nama_agen,
    a.alamat AS alamat_agen,
    a.telepon AS telepon_agen,
    ua.email AS email_agen,
    uc.email AS email_penerima,
    uc.no_hp AS telepon_penerima,
    jasa_kirim.harga AS harga_pengiriman
  FROM transaksi
  JOIN mobil ON mobil.id = transaksi.mobil_id
  JOIN agen a ON a.id = mobil.agen_id
  JOIN user ua ON ua.id = a.user_id
  JOIN user uc ON uc.id = transaksi.user_id
  JOIN cc ON cc.id = mobil.cc_id
  JOIN jasa_kirim ON jasa_kirim.id = transaksi.jasa_kirim_id
  WHERE transaksi.id = $id
";

$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

if (!$transaksi || $transaksi['agen_id'] != $_SESSION['user']['agen_id']) {
  setFlashMessage('error', 'Transaksi tidak ditemukan');
  redirectJs('belum-bayar.php');
}
?>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Faktur
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <button type="button" class="btn btn-primary" id="btnPrint">
          <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
            <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
          </svg>
          Cetak Faktur
        </button>
        <a href="<?= $prev ?>" class="btn btn-outline-primary d-none d-sm-inline-block ms-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M5 12l14 0"></path>
            <path d="M5 12l6 6"></path>
            <path d="M5 12l6 -6"></path>
          </svg>
          Kembali
        </a>
        <a href="belum-bayar.php" class="btn btn-outline-primary d-sm-none btn-icon ms-2" aria-label="Kembali">
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

<div class="page-body">
  <div class="container-xl">
    <div class="card card-lg" id="print">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <p class="h3"><?= $transaksi['nama_agen'] ?></p>
            <address>
              <?= $transaksi['email_agen'] ?><br>
              <?= $transaksi['telepon_agen'] ?><br>
              <?= $transaksi['alamat_agen'] ?>
            </address>
          </div>
          <div class="col-6 text-end">
            <p class="h3"><?= $transaksi['nama_penerima'] ?></p>
            <address>
              <?= $transaksi['email_penerima'] ?><br>
              <?= $transaksi['telepon_penerima'] ?><br>
              <?= $transaksi['alamat_penerima'] ?>
            </address>
          </div>
          <div class="col-12 my-5">
            <h1>Faktur <?= $transaksi['kode_transaksi'] ?></h1>
          </div>
        </div>
        <table class="table table-transparent table-responsive">
          <thead>
            <tr>
              <th class="text-center" style="width: 1%"></th>
              <th>Product</th>
              <th class="text-center" style="width: 1%">Hari</th>
              <th class="text-end" style="width: 1%">Harga</th>
              <th class="text-end" style="width: 1%">Total</th>
            </tr>
          </thead>
          <tbody style="white-space: nowrap;">
            <tr>
              <td class="text-center">1</td>
              <td>
                <p class="strong mb-1"><?= $transaksi['nama_mobil'] ?></p>
                <div class="text-secondary"><?= $transaksi['kapasitas_mobil'] ?> Orang, <?= $transaksi['cc_mobil'] ?>cc</div>
              </td>
              <td class="text-center">
                <?= $transaksi['jumlah_hari'] ?>
              </td>
              <td class="text-end"><?= format_rupiah($transaksi['harga_mobil']) ?></td>
              <td class="text-end"><?= format_rupiah($transaksi['harga_mobil'] * $transaksi['jumlah_hari']) ?></td>
            </tr>
            <tr>
              <td colspan="4" class="strong text-end">Subtotal</td>
              <td class="text-end"><?= format_rupiah($transaksi['harga_mobil'] * $transaksi['jumlah_hari']) ?></td>
            </tr>
            <tr>
              <td colspan="4" class="strong text-end">Pengiriman</td>
              <td class="text-end"><?= format_rupiah($transaksi['harga_pengiriman']) ?></td>
            </tr>
            <tr>
              <td colspan="4" class="strong text-end">Diskon</td>
              <td class="text-end">- <?= format_rupiah($transaksi['diskon'] ?? 0) ?></td>
            </tr>
            <tr>
              <td colspan="4" class="font-weight-bold text-uppercase text-end">Total</td>
              <td class="font-weight-bold text-end"><?= format_rupiah($transaksi['total_harga']) ?></td>
            </tr>
          </tbody>
        </table>
        <p class="text-secondary text-center mt-5">Terima kasih telah melakukan transaksi dengan kami. Kami berharap dapat bekerja sama dengan Anda lagi!</p>
      </div>
    </div>
  </div>
</div>

<script>
  addPrintEvent();

  function addPrintEvent() {
    document.getElementById('btnPrint').addEventListener('click', () => {
      const printContents = document.getElementById('print').innerHTML;
      const originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;

      addPrintEvent();
    });
  }
</script>

<?php include('partials/footer.php') ?>