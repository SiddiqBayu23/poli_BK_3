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
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0C4C93;">
        <div class="container px-5">
            <a class="navbar-brand" href="index.php">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        </div>
    </nav>
    <?php 
        if (isset($_GET['page'])) {
            if ($_GET['page'] === 'loginAdmin') {
                include_once ('./loginAdmin.php');
            } else if ($_GET['page'] === 'loginDokter') {
                include_once ('./loginDokter.php');
            } else if ($_GET['page'] === 'loginPasien') {
                include_once ('./loginPasien.php');
            } else {
                include($_GET['page'] . ".php");
            }
        } else {
    ?>
        <!-- Header-->
        <header class="py-5" style="background-color: #0C4C93;"> <!-- Ubah Color Banner disini -->
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-white mb-2">Sistem Temu Janji <br>Pasien - Dokter</h1>
                        <p class="lead text-white-50 mb-4">Bimbingan Karir 2023 Bidang Web</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Features section-->
    <section class="py-5 border-bottom" id="features">
        <div class="container px-5 my-5">
            <div class="row g-5">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Admin</h2>
                    <p>Apabila Anda adalah seorang Admin, silahkan Login terlebih dahulu untuk mengelola data website!</p>
                    <a class="text-decoration-none" href="index.php?page=loginAdmin">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Dokter</h2>
                    <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk memulai melayani Pasien!</p>
                    <a class="text-decoration-none" href="index.php?page=loginDokter">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-person"></i></div>
                    <h2 class="h4 fw-bolder">Login Sebagai Pasien</h2>
                    <p>Apabila Anda adalah seorang Pasien, silahkan Login terlebih dahulu untuk mulai menggunakan layanan kami!</p>
                    <a class="text-decoration-none" href="index.php?page=loginPasien">
                        Klik Link Berikut
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials section-->
    <section class="py-5 border-bottom">
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <h2 class="fw-bolder">Testimoni Pasien</h2>
                <p class="lead mb-0">Para Pasien yang Setia</p>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <!-- Testimonial 1-->
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0"><i class="bi bi-chat-right-quote-fill text-primary fs-1"></i></div>
                                <div class="ms-4">
                                    <p class="mb-1">Pelayanan di web ini sangat cepat dan mudah. Detail histori tercatat lengkap,
                                        termasuk catatan obat. Harga pelayanan terjangkau, Dokter ramah, pokoke mantab pol!</p>
                                    <div class="small text-muted">- Adi, Semarang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2-->
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0"><i class="bi bi-chat-right-quote-fill text-primary fs-1"></i></div>
                                <div class="ms-4">
                                    <p class="mb-1">Aku tidak pernah merasakan mudahnya berobat sebelum Aku mengenal web ini.
                                        Web yang mudah digunakan dan dokter yang termapil membuat berobat menjadi lebih menyenangkan!</p>
                                    <div class="small text-muted">- Ida, Semarang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="main-footer px-4 py-2">
        <strong>Copyright ©
            <script>
                document.write(new Date().getFullYear())
            </script>
            <a href="https://bengkelkoding.dinus.ac.id/">Bengkel Koding</a>.
        </strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
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