<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistem Temu Janji Poliklinik</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/polibayu/dist/css/welcome_styles.css">
    <style>
        /* Custom CSS for hero banner */
        .hero-banner {
            position: relative;
            background-image: url('image/dokter.jpg'); /* Replace 'image/dokter.jpg' with your image file path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 50vh; /* Full height of the viewport */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero-overlay::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust the last value (0.5) to control the overlay darkness */
        }

        .hero-banner h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero-banner p {
            font-size: 1.5rem;
            
        }
    </style>
</head>


<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0C4C93;">
        <div class="container px-5">
            <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pengaduan.php">Pengaduan Pelanggan</a>
        </li>
    </ul>
</div>
        </div>
    </nav>

    <?php
    if (isset($_GET['page'])) {
        if ($_GET['page'] === 'loginAdmin') {
            include_once('./loginAdmin.php');
        } else if ($_GET['page'] === 'loginDokter') {
            include_once('./loginDokter.php');
        } else if ($_GET['page'] === 'loginPasien') {
            include_once('./loginPasien.php');
        } else {
            include($_GET['page'] . ".php");
        }
    } else {
    ?>
        <!-- Hero banner-->
        <header class="hero-banner">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-black mb-2">Sistem Temu Janji <br>Pasien - Dokter</h1>
                        <p class="lead text-black mb-4">Bimbingan Karir 2023 Bidang Web</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About us -->
    <section class="tentangkami py-5">
      <div class="container py-5">
        <div class="row py-5 align-items-center">
          <div class="col-lg-7">
            <h1 class="black">Tentang Kami</h1>
            <p class="py-4" style="font-weight: 300; font-size: 1.3rem;">
            Selamat datang di layanan Sistem Temu Janji Poliklinik! Kami adalah tim profesional yang berkomitmen untuk menyediakan pengalaman layanan kesehatan yang terbaik bagi Anda. Dengan fokus pada inovasi dan kemudahan akses, kami bertujuan untuk memperkuat hubungan antara pasien dan dokter melalui platform kami..
            </p>
          </div>
          <div class="col-lg-5 d-flex justify-content-center">
            <img src="image/dokter2.jpg" alt="">
          </div>
        </div>
      </div>
    </section>


        <!-- Card section-->
<section class="py-5">
    <div class="container px-5">
        <div class="row gx-5">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="display-4 fw-bolder">Selamat Datang di Sistem Temu Janji Poliklinik</h2>
                <p class="lead mb-0">Silakan pilih opsi login yang sesuai dengan peran Anda</p>
            </div>

            <!-- Card 1 - Login Admin -->
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-person h1 text-primary mb-3"></i>
                        <h2 class="h4 fw-bolder">Login Admin</h2>
                        <p>Untuk Admin yang mengurus semua kegiatan di poliklinik ini</p>
                        <a href="index.php?page=loginAdmin" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 - Login Dokter -->
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-person h1 text-primary mb-3"></i>
                        <h2 class="h4 fw-bolder">Login Dokter</h2>
                        <p>Halaman ini khusus untuk dokter yang bekerja dan praktik di poliklinik ini</p>
                        <a href="index.php?page=loginDokter" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 - Login Pasien -->
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-person h1 text-primary mb-3"></i>
                        <h2 class="h4 fw-bolder">Login Pasien</h2>
                        <p>Untuk Pasien yang ingin melakukan pemeriksaan, harap login melalui ini</p>
                        <a href="index.php?page=loginPasien" class="btn btn-primary">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fun fact -->
<section class="container-fluid bg-light">
        <div class="container p-4">
            <h2 class="text-center my-5">FOR YOUR INFORMATION</h2>
            <div class="row align-items-center my-5">
                <div class="col-lg-4 col-md-5 col-sm-8">
                    <img src="image/fyi.jpg" class="rounded-3" alt="" width="350px" height="250px">
                </div>
                <div class="col-sm-8">
                    <h2><strong>Tahukah <span class="text-success">Kamu?</span></strong></h2>
                    <p>Indonesia menghadapi berbagai masalah kesehatan masyarakat, termasuk penyakit menular seperti malaria, demam berdarah, dan tuberkulosis. Selain itu, non-menular seperti diabetes dan penyakit jantung juga menjadi perhatian.</p>
                </div>
            </div>
        </div>
    </section>
    

    <!-- footer -->
    <footer class="bg-dark text-white text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-uppercase mb-4">Kontak Kami</h5>
                <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> Jl. Contoh No. 123, Kota Anda</p>
                <p class="mb-1"><i class="bi bi-envelope-fill"></i> email@example.com</p>
                <p><i class="bi bi-phone-fill"></i> +62 123 456 789</p>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="text-uppercase mb-4">Tautan Cepat</h5>
                <a href="#" class="text-white-50 text-decoration-none">Beranda</a><br>
                <a href="#" class="text-white-50 text-decoration-none">Layanan</a><br>
                <a href="#" class="text-white-50 text-decoration-none">Tentang Kami</a><br>
                <a href="#" class="text-white-50 text-decoration-none">Hubungi Kami</a>
            </div>
            <div class="col-lg-4">
                <h5 class="text-uppercase mb-4">Ikuti Kami</h5>
                <a href="#" class="btn btn-outline-light btn-social mx-1"><i class="bi bi-facebook"></i></a>
                <a href="#" class="btn btn-outline-light btn-social mx-1"><i class="bi bi-twitter"></i></a>
                <a href="#" class="btn btn-outline-light btn-social mx-1"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="btn btn-outline-light btn-social mx-1"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- Copywrite -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        &copy; <script>document.write(new Date().getFullYear())</script> Nama Website. All rights reserved.
    </div>
</footer>
    <?php
    }
    ?>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
