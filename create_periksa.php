<?php 
    include './koneksi.php';

    if (isset($_POST['submit_periksa'])) {
        $id_daftar_poli = $_POST['id_daftar_poli'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        $obat = $_POST['obat'];

        // Hitung Total Harga Obat
        $total_harga_obat = 0;
        if (!empty($obat)) {
            $stmt_obat_harga = $mysqli->prepare("SELECT harga FROM obat WHERE id = ?");
            foreach ($obat as $id_obat) {
                $stmt_obat_harga->bind_param('i', $id_obat);
                $stmt_obat_harga->execute();
                $result = $stmt_obat_harga->get_result();
                $harga_obat = $result->fetch_assoc()['harga'];
                $total_harga_obat += $harga_obat;
            }
            $stmt_obat_harga->close();
        }

        // Query Data Periksa
        $total_harga = $total_harga_obat;
        $stmt_periksa = $mysqli->prepare("INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES (?, ?, ?, ?)");
        $stmt_periksa->bind_param('issi', $id_daftar_poli, $tgl_periksa, $catatan, $total_harga);
        $stmt_periksa->execute();
        $stmt_periksa->close();

        $id_periksa = $mysqli->insert_id;

        // Query Data Obat
        if (!empty($obat)) {
            $stmt_obat = $mysqli->prepare("INSERT INTO detail_periksa (id_periksa, id_obat) VALUES (?, ?)");
            foreach ($obat as $id_obat) {
                $stmt_obat->bind_param('ii', $id_periksa, $id_obat);
                $stmt_obat->execute();
            }
            $stmt_obat->close();
        }

        // Query Data Daftar Poli
        $stmt_daftar_poli = $mysqli->prepare("UPDATE daftar_poli SET status_periksa = true WHERE id = ?");
        $stmt_daftar_poli->bind_param('i', $id_daftar_poli);
        $stmt_daftar_poli->execute();
        $stmt_daftar_poli->close();

        header('Location: http://'.$_SERVER['HTTP_HOST'].'/polibayu/menuperiksaDokter.php');
        exit();
    }
?>