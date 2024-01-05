<?php
if (!isset($_SESSION)) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Add your head section here -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- jQuery and Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      // Event listener for the "View" button
      $('.view-btn').click(function () {
        var pasienId = $(this).data('id');

        // Ajax request to fetch additional details
        $.ajax({
          type: 'POST',
          url: 'get_details.php',
          data: { pasien_id: pasienId },
          success: function (response) {
            // Display the fetched details in the modal body
            $('#viewModalBody').html(response);

            // Show the modal
            $('#viewModal').modal('show');
          }
        });
      });
    });
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>No KTP</th>
                      <th>No Telpon</th>
                      <th>No.RM</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      include './koneksi.php';

                      $query = "SELECT * FROM pasien";
                      $results = $mysqli->query($query);

                      while ($pasienRow = $results->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?= $pasienRow['id'] ?></td>
                        <td><?= $pasienRow['nama'] ?></td>
                        <td><?= $pasienRow['alamat'] ?></td>
                        <td><?= $pasienRow['no_ktp'] ?></td>
                        <td><?= $pasienRow['no_hp'] ?></td>
                        <td><?= $pasienRow['no_rm'] ?></td>
                        <td>
                          <button data-toggle="modal" data-target="#detailModal<?= $pasienRow['id'] ?>" class="btn btn-primary">
                            Riwayat Periksa
                          </button>
                        </td>
                      </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


<?php
    $results->data_seek(0);
    while ($d = $results->fetch_assoc()) {
        $no_detail = 1;
        $pasien_id = $d['id'];
        $details = $mysqli->query("SELECT 
                p.nama AS 'nama_pasien',
                pr.*,
                d.nama AS 'nama_dokter',
                dpo.keluhan AS 'keluhan',
                GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS 'obat'
                FROM periksa pr
                LEFT JOIN daftar_poli dpo ON (pr.id_daftar_poli = dpo.id)
                LEFT JOIN jadwal_periksa jp ON (dpo.id_jadwal = jp.id)
                LEFT JOIN dokter d ON (jp.id_dokter = d.id)
                LEFT JOIN pasien p ON (dpo.id_pasien = p.id)
                LEFT JOIN detail_periksa dp ON (pr.id = dp.id_periksa)
                LEFT JOIN obat o ON (dp.id_obat = o.id)
                WHERE dpo.id_pasien = '$pasien_id'
                GROUP BY pr.id
                ORDER BY pr.tgl_periksa DESC;");
?>
  <!-- Modal for displaying details -->
  <div class="modal fade" id="detailModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Riwayat Periksa Pasien <?= $d['nama'] ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <?php if ($details->num_rows == 0) : ?>
              <p class="my-2 text-danger">Tidak Ditemukan Riwayat Periksa</p>
          <?php else : ?>
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th scope="col">No</th>
                          <th scope="col">Tanggal Periksa</th>
                          <th scope="col">Nama Pasien</th>
                          <th scope="col">Nama Dokter</th>
                          <th scope="col">Keluhan</th>
                          <th scope="col">Catatan</th>
                          <th scope="col">Obat</th>
                          <th scope="col">Total Biaya</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php while ($detail = $details->fetch_assoc()) : ?>
                          <tr>
                              <td><?= $no_detail++; ?></td>
                              <td><?= $detail['tgl_periksa']; ?></td>
                              <td><?= $detail['nama_pasien']; ?></td>
                              <td><?= $detail['nama_dokter']; ?></td>
                              <td><?= $detail['keluhan']; ?></td>
                              <td><?= $detail['catatan']; ?></td>
                              <td><?= $detail['obat']; ?></td>
                              <td><?= $detail['biaya_periksa']; ?></td>
                          </tr>
                      <?php endwhile ?>
                  </tbody>
              </table>
          <?php endif ?>
          </div>
      </div>
    </div>
  </div>
<?php 
    }
?>
</body>

</html>
