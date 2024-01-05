<?php 
    include './koneksi.php';

    if (isset($_POST['submit_update'])) {
        $id_daftar_poli = $_POST['id_daftar_poli'];
        $tgl_periksa = $_POST['tgl_periksa'];
        $catatan = $_POST['catatan'];
        $obat = $_POST['obat'];

        $query_getPeriksa = "SELECT id FROM periksa WHERE id_daftar_poli = ?";
        $stmt_getPeriksa = $mysqli->prepare($query_getPeriksa);
        $stmt_getPeriksa->bind_param('i', $id_daftar_poli);
        $stmt_getPeriksa->execute();
        $stmt_getPeriksa->bind_result($id_periksa);
        $stmt_getPeriksa->fetch();
        $stmt_getPeriksa->close();

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
        $stmt_periksa = $mysqli->prepare("UPDATE periksa SET id_daftar_poli = ?, tgl_periksa = ?, catatan = ?, biaya_periksa = ? WHERE id = ?");
        $total_harga_periksa = $total_harga_obat;
        $stmt_periksa->bind_param('issii', $id_daftar_poli, $tgl_periksa, $catatan, $total_harga_periksa, $id_periksa);
        $stmt_periksa->execute();
        $stmt_periksa->close();

        // Query Data Obat
        if (!empty($obat)) {
            $stmt_delete_obat = $mysqli->prepare("DELETE FROM detail_periksa WHERE id_periksa = ?");
            $stmt_delete_obat->bind_param('i', $id_periksa);
            $stmt_delete_obat->execute();
            $stmt_delete_obat->close();

            $stmt_obat = $mysqli->prepare("INSERT INTO detail_periksa (id_periksa, id_obat) VALUES (?, ?)");
            foreach ($obat as $id_obat) {
                $stmt_obat->bind_param('ii', $id_periksa, $id_obat);
                $stmt_obat->execute();
            }
            $stmt_obat->close();
        }
        
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/polibayu/menuperiksaDokter.php');
        exit();
    }
?>