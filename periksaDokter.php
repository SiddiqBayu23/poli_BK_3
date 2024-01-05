<?php
// Start or resume the session
if (!isset($_SESSION)) {
    session_start();
}

// Include the database connection file
include_once("koneksi.php");

/// Query to fetch data from pasien and daftar_poli tables with status_periksa
$pasienQuery = "SELECT pasien.id, pasien.nama, daftar_poli.id AS id_daftar_poli, daftar_poli.keluhan, daftar_poli.status_periksa
                FROM daftar_poli 
                INNER JOIN pasien ON pasien.id = daftar_poli.id_pasien";


// Prepare and execute the query
$stmt = $mysqli->prepare($pasienQuery);

if ($stmt === false) {
    die("Error in preparing statement");
}

$stmt->execute();

// Get the result and fetch data
$pasienResult = $stmt->get_result();
$pasienData = $pasienResult->fetch_all(MYSQLI_ASSOC);

$stmt->close();

// Query to fetch data from periksa, detail_periksa, and obat tables
$detailQuery = "SELECT periksa.id AS id_periksa, periksa.tgl_periksa, periksa.catatan, obat.nama_obat, obat.kemasan, obat.harga
                FROM periksa 
                LEFT JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa
                LEFT JOIN obat ON detail_periksa.id_obat = obat.id";

// Prepare and execute the query
$detailStmt = $mysqli->prepare($detailQuery);

if ($detailStmt === false) {
    die("Error in preparing statement");
}

$detailStmt->execute();

// Get the result and fetch data
$detailResult = $detailStmt->get_result();
$detailData = $detailResult->fetch_all(MYSQLI_ASSOC);

$detailStmt->close();

//// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $id_pasien = $_POST['periksa_id_pasien'];
    $status_periksa = $_POST['periksa_status'];

    // Update the daftar_poli table
    $updateQuery = "UPDATE daftar_poli SET status_periksa = ? WHERE id_pasien = ?";
    $updateStmt = $mysqli->prepare($updateQuery);

    if ($updateStmt === false) {
        die("Error in preparing update statement: " . $mysqli->error);
    }

    // Tipe data "s" untuk string, "i" untuk integer
    $updateStmt->bind_param("si", $status_periksa, $id_pasien);

    if ($updateStmt->execute() === false) {
        die("Error in executing update statement: " . $updateStmt->error);
    } else {
        // Logging: Tulis ke file log atau outputkan ke console
        file_put_contents('update_log.txt', "Update successful for id_pasien: $id_pasien\n", FILE_APPEND);
    }

    $updateStmt->close();

    // Query to fetch all data from the periksa table
    $allPeriksaQuery = "SELECT * FROM periksa";

    // Prepare and execute the query
    $allPeriksaStmt = $mysqli->prepare($allPeriksaQuery);

    if ($allPeriksaStmt === false) {
        die("Error in preparing statement");
    }

    $allPeriksaStmt->execute();

    // Get the result and fetch data
    $allPeriksaResult = $allPeriksaStmt->get_result();
    $allPeriksaData = $allPeriksaResult->fetch_all(MYSQLI_ASSOC);

    $allPeriksaStmt->close();
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Pasien</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

    <style>
        .aksi-btn {
            margin-right: 5px;
        }

        table {
            width: 100%;
        }
    </style>
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
                                            <th>Keluhan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pasienData as $pasienRow) {
                                            echo "<tr>";
                                            echo "<td>" . $pasienRow['id'] . "</td>";
                                            echo "<td>" . $pasienRow['nama'] . "</td>";
                                            echo "<td>" . $pasienRow['keluhan'] . "</td>";
                                            echo "<td>";

                                            // Check if the 'status_periksa' key exists in the $pasienRow array
                                            if (array_key_exists('status_periksa', $pasienRow)) {
                                                // Check the status and display the appropriate button
                                                if ($pasienRow['status_periksa'] == 1) {
                                                    // Status is 1, hide "Periksa" button and show "Edit" button
                                                    echo "<button class='btn btn-primary edit-btn' data-toggle='modal' data-target='#editModal' data-id='" . $pasienRow['id'] . "' data-poli='" .$pasienRow['id_daftar_poli'] . "'>Edit</button>";
                                                } else {
                                                    // Status is 0, hide "Edit" button and show "Periksa" button
                                                    echo "<button class='btn btn-success periksa-btn' data-toggle='modal' data-target='#periksaModal' data-id='" . $pasienRow['id'] . "' data-poli='" .$pasienRow['id_daftar_poli'] . "'>Periksa</button>";
                                                }
                                            } else {
                                                // Handle the case where 'status_periksa' key is not present in the array
                                                echo "Status not available";
                                            }

                                            echo "</td>";
                                            echo "</tr>";
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

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <!-- Periksa Modal -->
    <div class="modal fade" id="periksaModal" tabindex="-1" role="dialog" aria-labelledby="periksaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="periksaModalLabel">Form Periksa Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="create_periksa.php">
                        <input type="hidden" name="id_pasien" id="periksa_id_pasien">
                        <input type="hidden" name="id_daftar_poli" id="id_daftar_poli">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_tanggal_periksa">Tanggal Periksa</label>
                                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_obat">Obat</label>
                            <select name="obat[]" id="obat" class="form-control" multiple>
                                    <?php
                                        $query_obat = "SELECT * FROM obat";
                                        $db_obat = mysqli_query($mysqli, $query_obat);

                                        while ($obat = mysqli_fetch_assoc($db_obat)) {
                                    ?>
                                    <option value="<?= $obat['id'] ?>"><?= $obat['nama_obat'] ?> - <?= $obat['harga'] ?></option>
                                    <?php
                                        }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submit_periksa">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- ... (existing code) ... -->

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Form Update Periksa Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form method="POST" action="update_periksa.php">
                        <input type="hidden" name="id_pasien" id="edit_id_pasien">
                        <input type="hidden" name="id_daftar_poli" id="edit_id_daftar_poli">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_nama">Nama</label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_tanggal_periksa">Tanggal Periksa</label>
                                    <input type="datetime-local" class="form-control" id="tgl_periksa" name="tgl_periksa" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_obat">Obat</label>
                            <select name="obat[]" id="obat" class="form-control" multiple>
                                    <?php
                                        $query_obat = "SELECT * FROM obat";
                                        $db_obat = mysqli_query($mysqli, $query_obat);

                                        while ($obat = mysqli_fetch_assoc($db_obat)) {
                                    ?>
                                    <option value="<?= $obat['id'] ?>"><?= $obat['nama_obat'] ?> - <?= $obat['harga'] ?></option>
                                    <?php
                                        }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="submit_update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk menangani data pada modal -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tangkap klik pada tombol "Periksa"
            $('.btn-success').click(function() {
                // Ambil nilai ID pasien dari atribut data-id tombol
                var id_pasien = $(this).data('id');

                // Set nilai ID pasien ke elemen input periksa_id_pasien pada modal
                $('#periksa_id_pasien').val(id_pasien);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Tangkap klik pada tombol "Edit"
            $('.edit-btn').click(function() {
                var id_pasien = $(this).data('id');
                var selectedPasien = <?php echo json_encode($pasienData); ?>;
                var pasien = selectedPasien.find(pasien => pasien.id === id_pasien);
                
                $('#edit_id_pasien').val(id_pasien);
                $('#edit_id_daftar_poli').val(pasien.id_daftar_poli);
                $('#edit_nama').val(pasien.nama);
            });

            $('.periksa-btn').click(function () {
                var id_pasien = $(this).data('id');
                var selectedPasien = <?php echo json_encode($pasienData); ?>;
                var pasien = selectedPasien.find(pasien => pasien.id === id_pasien);

                $('#periksa_id_pasien').val(id_pasien);
                $('#id_daftar_poli').val(pasien.id_daftar_poli);
                $('#nama').val(pasien.nama);
            });
        });
    </script>

</body>

</html>