<?php
require_once './db/conn.php';
require_once './helper/helpers.php';

$query = "
  SELECT
    mobil.*,
    merk_mobil.nama AS merk,
    jenis_mobil.nama AS jenis,
    transmisi.nama AS transmisi,
    warna.nama AS warna,
    warna.kode AS kode_warna,
    cc.nama AS cc,
    agen.nama AS agen
  FROM mobil
  JOIN merk_mobil ON merk_mobil.id = mobil.merk_id
  JOIN jenis_mobil ON jenis_mobil.id = mobil.jenis_id
  JOIN transmisi ON transmisi.id = mobil.transmisi_id
  JOIN warna ON warna.id = mobil.warna_id
  JOIN cc ON cc.id = mobil.cc_id
  JOIN agen ON agen.id = mobil.agen_id
  WHERE mobil.status = 'available'
  ORDER BY mobil.tahun DESC
  LIMIT 6
";
$result = mysqli_query($conn, $query);
$cars = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ikuzo Rental</title>
  
  <link rel="stylesheet" href="<?= asset('plugins/toast/dist/simple-notify.min.css') ?>" type="text/css">
  <script src="<?= asset('plugins/toast/dist/simple-notify.min.js') ?>"></script>

  <!-- 
      - favicon
    -->
  <link rel="shortcut icon" href="./assets/favicon.png">

  <!-- 
      - custom css link
    -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
      - google font link
    -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">

  <style>
    .btn-login {
      background-color: transparent;
      color: var(--carolina-blue);
      border: 1px solid var(--carolina-blue);
    }

    .btn-login:hover {
      background-color: var(--carolina-blue);
      color: white;
      transition: 0.3s;
    }


    @media screen and (min-width: 768px) {
      .hero-text {
        width: 50%;
      }
    }
  </style>
</head>

<body>

  <!-- 
      - #HEADER
    -->

  <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="#" class="logo" style="text-decoration: none; color: black; font-weight: bold; font-size: 20px;">
        Ikuzo Rental
      </a>

      <nav class="navbar" data-navbar>
        <ul class="navbar-list">

          <li>
            <a href="#home" class="navbar-link" data-nav-link>Beranda</a>
          </li>

          <li>
            <a href="#featured-car" class="navbar-link" data-nav-link>Mobil</a>
          </li>

        </ul>
      </nav>

      <div class="header-actions">
        <a href="./login.php" class="btn btn-login">
          <?php if (isset($_SESSION['user'])) : ?>
            <span>Dashboard</span>
          <?php else : ?>
            <span>Masuk</span>
          <?php endif; ?>
        </a>
        <a href="./register.php" class="btn" aria-labelledby="aria-label-txt">
          <span>Daftar</span>
        </a>
      </div>

    </div>
  </header>





  <main>
    <article>

      <!-- 
          - #HERO
        -->

      <section class="section hero" id="home">
        <div class="container">

          <div class="hero-content">
            <h2 class="h1 hero-title" style="font-weight: 900;">
              Platform sewa mobil mudah dan cepat
            </h2>

            <p class="hero-text">
              Ikuzo Rental adalah platform penyedia layanan sewa mobil yang menyediakan berbagai macam mobil dengan harga yang terjangkau.
            </p>
          </div>

          <div class="hero-banner"></div>
        </div>
      </section>





      <!-- 
          - #FEATURED CAR
        -->

      <section class="section featured-car" id="featured-car">
        <div class="container">

          <div class="title-wrapper">
            <h2 class="h2 section-title">Mobil terbaru</h2>
          </div>

          <ul class="featured-car-list">
            <?php foreach ($cars as $car) : ?>
              <li>
                <div class="featured-car-card">

                  <figure class="card-banner">
                    <img src="<?= asset($car['foto'] != '' ? $car['foto'] : 'images/default.png') ?>" alt="mobil" loading="lazy" width="440" height="300" class="w-100">
                  </figure>

                  <div class="card-content">

                    <div class="card-title-wrapper">
                      <h3 class="h3 card-title">
                        <?= $car['nama'] ?>
                      </h3>

                      <data class="year" value="<?= $car['tahun'] ?>">
                        <?= $car['tahun'] ?>
                      </data>
                    </div>

                    <ul class="card-list">

                      <li class="card-list-item">
                        <ion-icon name="people-outline"></ion-icon>

                        <span class="card-item-text"><?= $car['kapasitas'] ?> Orang</span>
                      </li>

                      <li class="card-list-item">
                        <ion-icon name="flash-outline"></ion-icon>

                        <span class="card-item-text"><?= $car['cc'] ?>cc</span>
                      </li>

                      <li class="card-list-item">
                        <ion-icon name="storefront-outline"></ion-icon>

                        <span class="card-item-text"><?= mb_strimwidth($car['agen'], 0, 16, '...') ?></span>
                      </li>

                      <li class="card-list-item">
                        <ion-icon name="hardware-chip-outline"></ion-icon>

                        <span class="card-item-text"><?= $car['transmisi'] ?></span>
                      </li>

                    </ul>

                    <div class="card-price-wrapper">

                      <p class="card-price">
                        <strong><?= format_rupiah($car['harga']) ?></strong> / hari
                      </p>

                      <a href="./customer/pesan-mobil.php?order_id=<?= $car['id'] ?>" class="btn" data-bs-toggle="modal">Pesan</a>

                    </div>

                  </div>

                </div>
              </li>
            <?php endforeach; ?>
          </ul>

        </div>
      </section>





      <!-- 
          - #GET START
        -->

      <section class="section get-start">
        <div class="container">

          <h2 class="h2 section-title">Mulai dengan 4 langkah mudah</h2>

          <ul class="get-start-list">

            <li>
              <div class="get-start-card">

                <div class="card-icon icon-1">
                  <ion-icon name="person-add-outline"></ion-icon>
                </div>

                <h3 class="card-title">Buat akun</h3>

                <p class="card-text">
                  Jika belum memiliki akun, silahkan daftar terlebih dahulu dengan mengklik tombaol daftar dibawah ini.
                </p>

                <a href="./register.php" class="card-link">Daftar</a>

              </div>
            </li>

            <li>
              <div class="get-start-card">

                <div class="card-icon icon-2">
                  <ion-icon name="car-outline"></ion-icon>
                </div>

                <h3 class="card-title">Pilih mobil</h3>

                <p class="card-text">
                  Pilihlah mobil yang sesuai dengan kebutuhan dan gaya hidup Anda untuk memastikan pengalaman berkendara yang memuaskan.
                </p>

              </div>
            </li>

            <li>
              <div class="get-start-card">

                <div class="card-icon icon-3">
                  <ion-icon name="person-outline"></ion-icon>
                </div>

                <h3 class="card-title">Pilih agen</h3>

                <p class="card-text">
                  Anda dapat memilih agen yang Anda inginkan untuk mengantarkan mobil yang Anda sewa ke tempat rumah Anda.
                </p>

              </div>
            </li>

            <li>
              <div class="get-start-card">

                <div class="card-icon icon-4">
                  <ion-icon name="card-outline"></ion-icon>
                </div>

                <h3 class="card-title">Pembayaran</h3>

                <p class="card-text">
                  Lakukan pembayaran dengan metode pembayaran yang Anda inginkan, dan tunggu mobil yang Anda sewa sampai di rumah Anda.
                </p>

              </div>
            </li>

          </ul>

        </div>
      </section>

    </article>
  </main>





  <!-- 
      - #FOOTER
    -->

  <footer class="footer">
    <div class="container">

      <div class="footer-top">

        <div class="footer-brand">
          <a href="#" class="logo">
            <img src="./assets/images/logo.png" alt="logo" style="width: 50%;">
          </a>

          <p class="footer-text">
            Search for cheap rental cars in New York. With a diverse fleet of 19,000 vehicles, Waydex offers its
            consumers an
            attractive and fun selection.
          </p>
        </div>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Company</p>
          </li>

          <li>
            <a href="#" class="footer-link">About us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Pricing plans</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contacts</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Support</p>
          </li>

          <li>
            <a href="#" class="footer-link">Help center</a>
          </li>

          <li>
            <a href="#" class="footer-link">Ask a question</a>
          </li>

          <li>
            <a href="#" class="footer-link">Privacy policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms & conditions</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <p class="footer-list-title">Neighborhoods in New York</p>
          </li>

          <li>
            <a href="#" class="footer-link">Manhattan</a>
          </li>

          <li>
            <a href="#" class="footer-link">Central New York City</a>
          </li>

          <li>
            <a href="#" class="footer-link">Upper East Side</a>
          </li>

          <li>
            <a href="#" class="footer-link">Queens</a>
          </li>

          <li>
            <a href="#" class="footer-link">Theater District</a>
          </li>

          <li>
            <a href="#" class="footer-link">Midtown</a>
          </li>

          <li>
            <a href="#" class="footer-link">SoHo</a>
          </li>

          <li>
            <a href="#" class="footer-link">Chelsea</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <ul class="social-list">

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-skype"></ion-icon>
            </a>
          </li>

          <li>
            <a href="#" class="social-link">
              <ion-icon name="mail-outline"></ion-icon>
            </a>
          </li>

        </ul>

        <p class="copyright">
          &copy; 2023 <a href="#">Ikuzo Rental</a>. All Rights Reserved
        </p>

      </div>

    </div>
  </footer>

  <!-- 
      - custom js link
    -->
  <script src="./assets/js/script.js"></script>

  <!-- 
      - ionicon link
    -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>