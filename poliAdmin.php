<!-- poliAdmin.php -->
<?php
// Include the database connection file
include_once("koneksi.php");

// Ensure the database connection is successful
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Query to retrieve data from the 'poli' table
$query = "SELECT * FROM poli";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poli</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Poli</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Poli</th>
                    <th>Nama Poli</th>
                    <th>Keterangan</th> <!-- Corrected typo here -->
                    <!-- Add additional columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id_poli'] . "</td>";
                    echo "<td>" . $row['nama_poli'] . "</td>";
                    echo "<td>" . $row['keterangan'] . "</td>";
                    // Add additional columns as needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
