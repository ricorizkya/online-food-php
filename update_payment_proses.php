<?php
session_start();
include("connection/connect.php");

if (isset($_POST['submit_update'])) {
    $order_id = $_POST['order_id'];
    $bank = mysqli_real_escape_string($db, $_POST['bank']);
    $nomor_rekening = mysqli_real_escape_string($db, $_POST['nomor_rekening']);
    $atas_nama = mysqli_real_escape_string($db, $_POST['atas_nama']);

    if (isset($_FILES['bukti_tf']) && $_FILES['bukti_tf']['error'] == 0) {
        $file_tmp = $_FILES['bukti_tf']['tmp_name'];
        $file_name = basename($_FILES['bukti_tf']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            $new_file_name = "bukti_tf_" . $order_id . "_" . time() . "." . $file_ext;
            $upload_dir = "uploads/bukti_tf/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                $bank_data = $bank . " - " . $nomor_rekening . " - " . $atas_nama;

                $sql_update = "UPDATE users_orders SET status = 'Menunggu Konfirmasi Pembayaran', bank = '$bank_data', bukti_tf = '$upload_path' WHERE o_id = '$order_id'";

                if (mysqli_query($db, $sql_update)) {
                    $_SESSION['success_msg'] = "Data bukti pembayaran berhasil disimpan.";
                } else {
                    $_SESSION['error_msg'] = "Gagal menyimpan data ke database.";
                }
            } else {
                $_SESSION['error_msg'] = "Gagal mengupload bukti pembayaran.";
            }
        } else {
            $_SESSION['error_msg'] = "Format file tidak didukung. Hanya jpg, jpeg, png, gif yang diperbolehkan.";
        }
    } else {
        $_SESSION['error_msg'] = "File bukti pembayaran tidak diupload.";
    }

    header("Location: your_orders.php");
    exit;
}
?>