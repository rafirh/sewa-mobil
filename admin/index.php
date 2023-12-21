<?php
$active = 'beranda';
$title = 'Beranda';

include('partials/header.php');

$pendapatan_lunas = sumAll($conn, "transaksi", "total_harga", "status_pembayaran_id = 5");
$pendapatan_dp = sumAll($conn, "transaksi", "jumlah_dp", "status_pembayaran_id = 4");
$total_pendapatan = $pendapatan_lunas + $pendapatan_dp;

$pendapatan_lunas_hari_ini = sumAll($conn, "transaksi", "total_harga", "status_pembayaran_id = 5 AND DATE(tanggal_bayar_lunas) = CURDATE()");
$pendapatan_dp_hari_ini = sumAll($conn, "transaksi", "jumlah_dp", "status_pembayaran_id = 4 AND DATE(tanggal_dp) = CURDATE()");
$total_pendapatan_hari_ini = $pendapatan_lunas_hari_ini + $pendapatan_dp_hari_ini;

$jumlah_pelanggan = countAll($conn, 'user', 'role', 'customer');
$jumlah_agen = countAll($conn, 'user', "role = 'agent'");
$jumlah_mobil = countAll($conn, 'mobil');
$jumlah_mobil_tersedia = countAll($conn, "mobil", "status = 'available'");
$jumlah_mobil_disewa = countAll($conn, "mobil", "status = 'unavailable'");
$jumlah_transaksi = countAll($conn, 'transaksi');
$belum_dibayar = countAll($conn, "transaksi", "(status_pembayaran_id = 1 OR status_pembayaran_id = 3)");
$belum_diverifikasi = countAll($conn, "transaksi", "status_pembayaran_id = 2");
$belum_diambil = countAll(
  $conn,
  "transaksi",
  "(status_pembayaran_id = 4 OR status_pembayaran_id = 5) AND transaksi.status_pengembalian_id = 1"
);
$sedang_disewa = countAll(
  $conn,
  "transaksi",
  "(status_pembayaran_id = 4 OR status_pembayaran_id = 5) AND transaksi.status_pengembalian_id = 2"
);
$belum_lunas = countAll(
  $conn,
  "transaksi",
  "status_pembayaran_id = 4 AND transaksi.status_pengembalian_id = 3 AND bukti_bayar_lunas IS NULL"
);
$pelunasan_belum_diverifikasi = countAll(
  $conn,
  "transaksi",
  "status_pembayaran_id = 4 AND transaksi.status_pengembalian_id = 3 AND bukti_bayar_lunas IS NOT NULL"
);
$pesanan_selesai = countAll(
  $conn,
  "transaksi",
  "status_pembayaran_id = 5 AND transaksi.status_pengembalian_id = 3"
);

$query_mobil_terlaris = "
  SELECT 
    mobil.*,
    agen.nama AS nama_agen,
    cc.nama AS nama_cc,
    merk_mobil.nama AS nama_merk_mobil,
    COUNT(transaksi.mobil_id) AS jumlah_transaksi 
  FROM mobil 
  LEFT JOIN agen ON mobil.agen_id = agen.id
  LEFT JOIN cc ON mobil.cc_id = cc.id
  LEFT JOIN merk_mobil ON mobil.merk_id = merk_mobil.id
  LEFT JOIN transaksi ON mobil.id = transaksi.mobil_id 
  WHERE transaksi.status_pembayaran_id = 5 OR transaksi.status_pembayaran_id = 4 OR transaksi.id IS NULL
  GROUP BY mobil.id
  ORDER BY jumlah_transaksi DESC LIMIT 10
";
$result = mysqli_query($conn, $query_mobil_terlaris);
$mobil_terlaris = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query_agen_terbaik = "
  SELECT 
    agen.*,
    COUNT(transaksi.id) AS jumlah_transaksi,
    SUM(IF(transaksi.status_pembayaran_id = 5, transaksi.total_harga, transaksi.jumlah_dp)) AS total_pendapatan
  FROM agen 
  LEFT JOIN transaksi ON agen.id = transaksi.agen_id 
  WHERE transaksi.status_pembayaran_id = 5 OR transaksi.status_pembayaran_id = 4 OR transaksi.id IS NULL
  GROUP BY agen.id
  ORDER BY total_pendapatan DESC LIMIT 10
";
$result = mysqli_query($conn, $query_agen_terbaik);
$agen_terbaik = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
                <span class="bg-lime text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                    <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= format_rupiah($total_pendapatan) ?>
                </div>
                <div class="text-muted">
                  volume pendapatan
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                    <path d="M16 3v4" />
                    <path d="M8 3v4" />
                    <path d="M4 11h16" />
                    <path d="M11 15h1" />
                    <path d="M12 15v3" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= format_rupiah($total_pendapatan_hari_ini) ?>
                </div>
                <div class="text-muted">
                  volume pendapatan hari ini
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_pelanggan ?>
                </div>
                <div class="text-muted">
                  total pelanggan
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
                <span class="bg-indigo text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 21l18 0" />
                    <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                    <path d="M5 21l0 -10.15" />
                    <path d="M19 21l0 -10.15" />
                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $jumlah_agen ?>
                </div>
                <div class="text-muted">
                  total agen
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
                <span class="bg-purple text-white avatar">
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
                  total pesanan
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
      <div class="col-sm-6 col-xl-4 mb-3">
        <div class="card card-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="bg-teal text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                    <path d="M3 9l4 0" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $sedang_disewa ?>
                </div>
                <div class="text-muted">
                  belum diambil
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" />
                    <path d="M12 7v5l3 3" />
                    <path d="M15 19l2 2l4 -4" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $sedang_disewa ?>
                </div>
                <div class="text-muted">
                  sedang disewa
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
                <span class="bg-red text-white avatar">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $belum_lunas ?>
                </div>
                <div class="text-muted">
                  pesanan belum lunas
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 9m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                    <path d="M14 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 9v-2a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v6a2 2 0 0 0 2 2h2" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $pelunasan_belum_diverifikasi ?>
                </div>
                <div class="text-muted">
                  pelunasan belum diverifikasi
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
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                    <path d="M9 15l2 2l4 -4" />
                  </svg>
                </span>
              </div>
              <div class="col">
                <div class="fw-bold">
                  <?= $pesanan_selesai ?>
                </div>
                <div class="text-muted">
                  pesanan selesai
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mobil terlaris <span class="text-muted fs-5">(10 teratas)</span></h3>
          </div>
          <div class="table-responsive text-muted">
            <table class="table card-table table-vcenter" style="white-space: nowrap;">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>CC</th>
                  <th>Total Tersewa</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($mobil_terlaris as $index => $mobil) : ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $mobil['nama'] ?> (<?= $mobil['nama_merk_mobil'] ?>)</td>
                    <td><?= $mobil['nama_cc'] ?> cc</td>
                    <td><?= $mobil['jumlah_transaksi'] ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Agen pendapatan terbanyak <span class="text-muted fs-5">(10 teratas)</span></h3>
          </div>
          <div class="table-responsive text-muted">
            <table class="table card-table table-vcenter" style="white-space: nowrap;">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Jumlah Pesanan</th>
                  <th>Total Pendapatan</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($agen_terbaik as $index => $item) : ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $item['nama'] ?></td>
                    <td><?= $item['jumlah_transaksi'] ?></td>
                    <td><?= format_rupiah($item['total_pendapatan']) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('partials/footer.php') ?>