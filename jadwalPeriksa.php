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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header">
                <button data-toggle="modal" data-target="#formModal" class="btn btn-primary">
                    Riwayat Periksa
                </button>
                </div>
              <div class="card-body">
              <?php 
                    if (isset($_SESSION)) {
                        if (isset($_SESSION['error'])) {
                            echo '
                                <p class="text-danger">
                                    ' . $_SESSION['error'] . '
                                </p>
                            ';
                            unset($_SESSION['error']);
                        } else if (isset($_SESSION['success'])) {
                            echo '
                                <p class="text-success">
                                    ' . $_SESSION['success'] . '
                                </p>
                            ';
                            unset($_SESSION['success']);
                        }
                    }
                ?>
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Dokter</th>
                      <th>Hari</th>
                      <th>Jam Mulai</th>
                      <th>Jam Selesai</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        include './koneksi.php';

                        $no = 1;
                        $query = "SELECT
                        jadwal_periksa.*,
                        dokter.nama AS nama_dokter
                        FROM jadwal_periksa
                        INNER JOIN dokter ON dokter.id = jadwal_periksa.id_dokter";
                        $db = mysqli_query($mysqli, $query);

                        while ($result = mysqli_fetch_assoc($db)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $result['nama_dokter'] ?></td>
                            <td><?= $result['hari'] ?></td>
                            <td><?= $result['jam_mulai'] ?></td>
                            <td><?= $result['jam_selesai'] ?></td>
                            <td><?= $result['aktif'] == 'Y' ? 'Aktif' : 'Tidak Aktif' ?></td>
                            <td>
                            <button data-toggle="modal" data-target="#editModal<?= $result['id'] ?>" class="btn btn-warning">
                                Edit Jadwal Periksa
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
         
<!-- Create Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Form Tambah Jadwal Periksa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST">
                <div class="row gy-4">
                    <input type="hidden" value="<?= $_SESSION['id_dokter'] ?>" name="id_dokter">
                    <div class="form-group col-12 col-lg-6">
                        <label class="form-label">Dokter</label>
                        <input type="text" class="form-control" readonly value="<?= $_SESSION['nama'] ?>">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-control" required>
                            <option value="">-Pilih Hari-</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai" required>
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jam_selesai" required>
                    </div>
                    <div class="col-12 form-group">
                        <button class="btn btn-success btn-sm" type="submit" name="submitJadwal">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>


<!-- Update Modal -->
<?php 
    include './koneksi.php';
    $db->data_seek(0);

    while ($data = $db->fetch_assoc()) {
        $jadwal_id = $data['id'];
        $query = "SELECT
        jadwal_periksa.*,
        dokter.nama AS nama_dokter
        FROM jadwal_periksa
        INNER JOIN dokter ON dokter.id = jadwal_periksa.id_dokter
        WHERE jadwal_periksa.id = ?";
        $stmt_detail = $mysqli->prepare($query);
        $stmt_detail->bind_param('i', $jadwal_id);
        $stmt_detail->execute();
        $stmt_detail->close();
?>
<div class="modal fade" id="editModal<?= $jadwal_id ?>" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">Form Update Jadwal Periksa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST">
                <div class="row gy-4">
                    <input type="hidden" value="<?= $_SESSION['id_dokter'] ?>" name="id_dokter">
                    <input type="hidden" value="<?= $data['id'] ?>" name="id_jadwal">
                    <div class="form-group col-12 col-lg-6">
                        <label class="form-label">Dokter</label>
                        <input type="text" class="form-control" readonly value="<?= $_SESSION['nama'] ?>">
                    </div>
                    <div class="form-group col-12 col-lg-6">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-control" required>
                            <option value="">-Pilih Hari-</option>
                            <option value="Senin" <?= $data['hari'] === 'Senin' ? 'selected' : '' ?>>Senin</option>
                            <option value="Selasa" <?= $data['hari'] === 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                            <option value="Rabu" <?= $data['hari'] === 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                            <option value="Kamis" <?= $data['hari'] === 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                            <option value="Jumat" <?= $data['hari'] === 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai" required value="<?= $data['jam_mulai'] ?>">
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jam_selesai" required value="<?= $data['jam_selesai'] ?>">
                    </div>
                    <div class="form-group col-12">
                        <label class="form-label">Status Jadwal</label>
                        <select name="aktif" class="form-control" required>
                            <option value="">-Pilih Status Jadwal-</option>
                            <option value="Y" <?= $data['aktif'] === 'Y' ? 'selected' : '' ?>>Aktif</option>
                            <option value="N" <?= $data['aktif'] === 'N' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <button class="btn btn-success btn-sm" type="submit" name="updateJadwal">
                            <i class="fas fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<?php 
    }
?>





<?php
    include './koneksi.php';

    if (isset($_POST['submitJadwal'])) {
        $id_dokter = $_POST['id_dokter'];
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        $query = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?)";
        $stmt_jadwal = $mysqli->prepare($query);
        $stmt_jadwal->bind_param('isss', $id_dokter, $hari, $jam_mulai, $jam_selesai);
        $stmt_jadwal->execute();
        $stmt_jadwal->close();

        header("Location: http://{$_SERVER['HTTP_HOST']}/polibayu/menujadwalperiksa.php");
        exit;

    }

    if (isset($_POST['updateJadwal'])) {
        $id_jadwal = $_POST['id_jadwal'];
        $id_dokter = $_POST['id_dokter'];
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        $aktif = $_POST['aktif'];

        if ($aktif == 'Y') {
            $query_active = "SELECT * FROM jadwal_periksa WHERE aktif = 'Y'";
            $result_active = mysqli_query($mysqli, $query_active);
    
            if (mysqli_num_rows($result_active) > 0) {
                $_SESSION['error'] = 'Gagal mengaktifkan jadwal! Masih ada jadwal aktif.';
            } else {
                $query = "UPDATE jadwal_periksa SET id_dokter = ?, hari = ?, jam_mulai = ?, jam_selesai = ?, aktif = ? WHERE id = ?";
                $stmt_update = $mysqli->prepare($query);
                $stmt_update->bind_param('issssi', $id_dokter, $hari, $jam_mulai, $jam_selesai, $aktif, $id_jadwal);
                $stmt_update->execute();
                $stmt_update->close();
                $_SESSION['success'] = 'Berhasil update jadwal!';
                header("Location: http://{$_SERVER['HTTP_HOST']}/polibayu/menujadwalperiksa.php");
                exit;
            }
        } else {
            $query = "UPDATE jadwal_periksa SET id_dokter = ?, hari = ?, jam_mulai = ?, jam_selesai = ?, aktif = ? WHERE id = ?";
            $stmt_update = $mysqli->prepare($query);
            $stmt_update->bind_param('issssi', $id_dokter, $hari, $jam_mulai, $jam_selesai, $aktif, $id_jadwal);
            $stmt_update->execute();
            $stmt_update->close();
            $_SESSION['success'] = 'Berhasil update jadwal!';
            header("Location: http://{$_SERVER['HTTP_HOST']}/polibayu/menujadwalperiksa.php");
            exit;
        }
    }
?>
</body>

</html>
