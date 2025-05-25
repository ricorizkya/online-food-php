<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

if(empty($_SESSION["user_id"])) {
    header('location:login.php');
} else {
    // Mendapatkan total harga
    $item_total = 0;
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += ($item["price"] * $item["quantity"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $selected_bank = $_POST['bank']; // Mengambil bank yang dipilih
    $payment_status = 'Pending'; // Status pembayaran yang sedang diproses
    
    // Menyimpan transaksi di database
    foreach ($_SESSION["cart_item"] as $item) {
        $SQL = "INSERT INTO payment_transactions (u_id, title, quantity, price, payment_method, bank, total_price, payment_status) 
                VALUES ('" . $_SESSION["user_id"] . "', '" . $item["title"] . "', '" . $item["quantity"] . "', '" . $item["price"] . "', 'transfer', '" . $selected_bank . "', '" . $item_total . "', '" . $payment_status . "')";
        mysqli_query($db, $SQL);
    }

    // Mengarahkan ke halaman konfirmasi pembayaran
    header('location: payment_confirmation.php');
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Pembayaran</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet"> 
</head>

<body>
    <div class="container m-t-30">
        <h2>Pembayaran</h2>
        <form action="payment.php" method="post">
            <div class="form-group">
                <label for="bank">Pilih Bank</label>
                <select name="bank" id="bank" class="form-control">
                    <option value="QRIS">QRIS</option>
                    <option value="BNI">BNI</option>
                    <option value="BRI">BRI</option>
                    <option value="BCA">BCA</option>
                </select>
            </div>
            <div class="form-group">
                <label for="total">Total Harga</label>
                <input type="text" name="total" class="form-control" value="$<?php echo $item_total; ?>" readonly />
            </div>
            <button type="submit" name="submit" class="btn btn-success">Proceed to Payment</button>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
