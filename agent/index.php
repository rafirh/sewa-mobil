<?php
$active = 'beranda';
$title = 'Beranda';

include('partials/header.php');

$jumlah_pelanggan = countAll($conn, 'user', 'role', 'customer');
$jumlah_agen = countAll($conn, 'user', 'role', 'agent');
$jumlah_mobil = countAll($conn, 'mobil', 'agen_id', $_SESSION['user']['agen_id']);
$jumlah_mobil_tersedia = countAll($conn, 'mobil', 'status', 'available', 'agen_id', $_SESSION['user']['agen_id']);
$jumlah_mobil_disewa = countAll($conn, 'mobil', 'status', 'unavailable', 'agen_id', $_SESSION['user']['agen_id']);
$jumlah_transaksi = countAll($conn, 'transaksi', 'agen_id', $_SESSION['user']['agen_id']);
$belum_dibayar = countAll($conn, 'transaksi', 'status_pembayaran_id', 1, 'agen_id', $_SESSION['user']['agen_id']);
$belum_diverifikasi = countAll($conn, 'transaksi', 'status_pembayaran_id', 2, 'agen_id', $_SESSION['user']['agen_id']);
?>

<div class="page-header d-print-none mt-2">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h3 class="page-title">
          Beranda
        </h3>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-purple text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_mobil ?>
                </div>
                <div class="text-muted">
                  total mobil
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-success text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_mobil_tersedia ?>
                </div>
                <div class="text-muted">
                  mobil tersedia
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-pink text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_mobil_disewa ?>
                </div>
                <div class="text-muted">
                  mobil sedang disewa
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-primary text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-sort" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 9l4 -4l4 4m-4 -4v14" />
                    <path d="M21 15l-4 4l-4 -4m4 4v-14" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_transaksi ?>
                </div>
                <div class="text-muted">
                  total transaksi
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-orange text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-credit-card-pay" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 19h-6a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v4.5" />
                    <path d="M3 10h18" />
                    <path d="M16 19h6" />
                    <path d="M19 16l3 3l-3 3" />
                    <path d="M7.005 15h.005" />
                    <path d="M11 15h2" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $belum_dibayar ?>
                </div>
                <div class="text-muted">
                  pesanan belum dibayar
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-teal text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-cashapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M17.1 8.648a.568 .568 0 0 1 -.761 .011a5.682 5.682 0 0 0 -3.659 -1.34c-1.102 0 -2.205 .363 -2.205 1.374c0 1.023 1.182 1.364 2.546 1.875c2.386 .796 4.363 1.796 4.363 4.137c0 2.545 -1.977 4.295 -5.204 4.488l-.295 1.364a.557 .557 0 0 1 -.546 .443h-2.034l-.102 -.011a.568 .568 0 0 1 -.432 -.67l.318 -1.444a7.432 7.432 0 0 1 -3.273 -1.784v-.011a.545 .545 0 0 1 0 -.773l1.137 -1.102c.214 -.2 .547 -.2 .761 0a5.495 5.495 0 0 0 3.852 1.5c1.478 0 2.466 -.625 2.466 -1.614c0 -.989 -1 -1.25 -2.886 -1.954c-2 -.716 -3.898 -1.728 -3.898 -4.091c0 -2.75 2.284 -4.091 4.989 -4.216l.284 -1.398a.545 .545 0 0 1 .545 -.432h2.023l.114 .012a.544 .544 0 0 1 .42 .647l-.307 1.557a8.528 8.528 0 0 1 2.818 1.58l.023 .022c.216 .228 .216 .569 0 .773l-1.057 1.057z" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $belum_diverifikasi ?>
                </div>
                <div class="text-muted">
                  pembayaran belum diverifikasi
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('partials/footer.php') ?>