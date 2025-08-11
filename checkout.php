<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();


function function_alert() { 
      

    echo "<script>alert('Terima Kasih. Pesananmu sedang diproses !');</script>"; 
    echo "<script>window.location.replace('your_orders.php');</script>"; 
} 

if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else{
    define('PROVINCES', [
    'Nanggroe Aceh Darussalam' => ['Banda Aceh', 'Langsa', 'Lhokseumawe', 'Sabang', 'Subulussalam'],
    'Sumatera Utara' => ['Medan', 'Pematangsiantar', 'Sibolga', 'Tanjungbalai', 'Binjai', 'Padangsidempuan'],
    'Sumatera Selatan' => ['Palembang', 'Pagaralam', 'Lubuklinggau'],
    'Sumatera Barat' => ['Padang', 'Bukittinggi', 'Padangpanjang', 'Pariaman', 'Sawahlunto', 'Solok'],
    'Riau' => ['Pekanbaru', 'Dumai'],
    'Jambi' => ['Jambi', 'Sungai Penuh'],
    'Bengkulu' => ['Bengkulu', 'Curup', 'Lubuklinggau'],
    'Lampung' => ['Bandar Lampung', 'Metro'],
    'DKI Jakarta' => ['Jakarta'],
    'Banten' => ['Serang', 'Cilegon', 'Tangerang', 'Bekasi'],
    'Jawa Barat' => ['Bandung', 'Bekasi', 'Bogor', 'Cimahi', 'Cirebon', 'Depok', 'Sukabumi'],
    'Jawa Tengah' => ['Semarang', 'Pekalongan', 'Salatiga'],
    'DI Yogyakarta' => ['Yogyakarta'],
    'Jawa Timur' => ['Surabaya', 'Malang', 'Madiun', 'Mojokerto', 'Jombang'],
    'Bali' => ['Denpasar'],
    'Nusa Tenggara Barat' => ['Mataram'],
    'Nusa Tenggara Timur' => ['Kupang'],
    'Kalimantan Utara' => ['Tanjung Selor'],
    'Kalimantan Timur' => ['Samarinda'],
    'Kalimantan Selatan' => ['Banjarmasin'],
    'Kalimantan Tengah' => ['Palangka Raya'],
    'Kalimantan Barat' => ['Pontianak'],
    'Sulawesi Utara' => ['Manado'],
    'Sulawesi Tengah' => ['Palu'],
    'Sulawesi Selatan' => ['Makassar'],
    'Sulawesi Tenggara' => ['Kendari'],
    'Sulawesi Barat' => ['Mamuju'],
    'Maluku' => ['Ambon'],
    'Maluku Utara' => ['Sofifi'],
    'Papua' => ['Jayapura'],
    'Papua Barat' => ['Manokwari'],
    'Gorontalo' => ['Gorontalo'],
    'Kepulauan Riau' => ['Tanjung Pinang'],
    'Papua Selatan' => ['Merauke'],
    'Papua Tengah' => ['Nabire'],
    'Papua Pegunungan' => ['Jayawijaya'],
]);

$provincesJson = json_encode(PROVINCES);

    $provinceToIsland = [
    // Jawa
    'DKI Jakarta' => 'Jawa', 'Banten' => 'Jawa', 'Jawa Barat' => 'Jawa', 'Jawa Tengah' => 'Jawa', 'DI Yogyakarta' => 'Jawa', 'Jawa Timur' => 'Jawa',
    
    // Sumatera
    'Nanggroe Aceh Darussalam' => 'Sumatera', 'Sumatera Utara' => 'Sumatera', 'Sumatera Selatan' => 'Sumatera', 'Sumatera Barat' => 'Sumatera', 'Riau' => 'Sumatera', 'Jambi' => 'Sumatera', 'Bengkulu' => 'Sumatera', 'Lampung' => 'Sumatera', 'Kepulauan Riau' => 'Sumatera',
    
    // Kalimantan
    'Kalimantan Barat' => 'Kalimantan', 'Kalimantan Tengah' => 'Kalimantan', 'Kalimantan Selatan' => 'Kalimantan', 'Kalimantan Timur' => 'Kalimantan', 'Kalimantan Utara' => 'Kalimantan',
    
    // Sulawesi dan sekitarnya
    'Sulawesi Utara' => 'Sulawesi', 'Sulawesi Tengah' => 'Sulawesi', 'Sulawesi Selatan' => 'Sulawesi', 'Sulawesi Tenggara' => 'Sulawesi', 'Sulawesi Barat' => 'Sulawesi', 'Gorontalo' => 'Sulawesi', 'Bali' => 'Sulawesi', 'Nusa Tenggara Barat' => 'Sulawesi', 'Nusa Tenggara Timur' => 'Sulawesi',
    
    // Maluku dan Papua
    'Maluku' => 'MalukuPapua', 'Maluku Utara' => 'MalukuPapua', 'Papua' => 'MalukuPapua', 'Papua Barat' => 'MalukuPapua', 'Papua Tengah' => 'MalukuPapua', 'Papua Pegunungan' => 'MalukuPapua', 'Papua Selatan' => 'MalukuPapua',
];

$user_id = $_SESSION["user_id"];
$userQuery = mysqli_query($db, "SELECT province, city FROM users WHERE u_id = '$user_id'");
$userData = mysqli_fetch_assoc($userQuery);

$userProvince = $userData['province'];
$userCity = $userData['city'];

// Toko berada di Semarang, provinsi Jawa Tengah
$storeCity = "Semarang";
$storeProvince = "Jawa Tengah";
$storeIsland = $provinceToIsland[$storeProvince];
$userIsland = $provinceToIsland[$userProvince];

$shippingFee = 0;

if ($userCity === $storeCity) {
    $shippingFee = 10000;
} elseif ($userProvince === $storeProvince) {
    $shippingFee = 20000;
} elseif ($userIsland === 'Jawa' && $storeIsland === 'Jawa') {
    $shippingFee = 25000;
} elseif ($userIsland === 'Sumatera') {
    $shippingFee = 30000;
} elseif ($userIsland === 'Kalimantan') {
    $shippingFee = 35000;
} elseif ($userIsland === 'Sulawesi') {
    $shippingFee = 40000;
} elseif ($userIsland === 'MalukuPapua') {
    $shippingFee = 50000;
} else {
    $shippingFee = 60000; // fallback
}

$queryUser = mysqli_query($db, "SELECT * FROM users WHERE u_id = '$user_id'");
$userData = mysqli_fetch_assoc($queryUser);

$item_total = 0;
$cart_items = [];

if (!empty($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $cart_items[] = $item;
        $item_total += ($item["price"] * $item["quantity"]);
    }
} else {
    $cart_items = [];
}

$address_option = $_POST['alamat_pengiriman'];
$payment = $_POST['mod'];

if ($address_option === 'default') {
    $nama_penerima = $userData['f_name'] . ' ' . $userData['l_name'];
    $nomer_penerima = $userData['phone'];
    $alamat_pengiriman = $userData['address'];
} elseif ($address_option === 'custom') {
    $nama_penerima = mysqli_real_escape_string($db, $_POST['custom_name']);
    $nomer_penerima = mysqli_real_escape_string($db, $_POST['custom_phone']);
    $alamat_pengiriman = mysqli_real_escape_string($db, $_POST['custom_address']);
} else {
    $alamat_pengiriman = '';
}

if ($payment === 'COD') {
    $status = 'Dikemas';
}elseif ($payment === 'TF') {
    $status = 'Menunggu Pembayaran';
}else {
    $status = '';
}

if (isset($_POST['submit'])) {
    $cart_items = [];  // Reset array
    $item_total = 0;   // Reset total harga

    foreach ($_SESSION["cart_item"] as $item) {
        $cart_items[] = [
            'id' => $item["d_id"],
            'title' => $item["title"],
            'quantity' => (int)$item["quantity"],
            'price' => (int)$item["price"]
        ];
        $item_total += ($item["price"] * $item["quantity"]);
    }

    $items_json = mysqli_real_escape_string($db, json_encode($cart_items, JSON_UNESCAPED_UNICODE));
    $payment_method = mysqli_real_escape_string($db, $_POST['mod']);
    $total_all = $item_total + $shippingFee;

    $SQL = "
        INSERT INTO users_orders 
        (u_id, items, ongkir, total, status, name_shipping, phone_shipping, shipping_address, payment_method, bank, bukti_tf) 
        VALUES 
        ('{$_SESSION["user_id"]}', '$items_json', '$shippingFee', '$total_all', '$status', '$nama_penerima', '$nomer_penerima', '$alamat_pengiriman', '$payment_method', '', '')
    ";

    if (mysqli_query($db, $SQL)) {
        unset($_SESSION["cart_item"]);
        $success = "Terima Kasih, Pesanan Anda Sedang Dikemas!";
        function_alert();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($db);
    }
}

?>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>Pesan Sekarang</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <div class="site-wrapper">
        <header id="header" class="header-scroll top-header headrom">
            <nav class="navbar navbar-dark">
                <div class="container">
                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse"
                        data-target="#mainNavbarCollapse">&#9776;</button>
                    <a class="navbar-brand" href="index.php"> <img class="img-rounded" src="images/icn.jpg" alt=""> </a>
                    <div class="collapse navbar-toggleable-md  float-lg-right" id="mainNavbarCollapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item"> <a class="nav-link active" href="index.php">Home <span
                                        class="sr-only">(current)</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Toko <span
                                        class="sr-only"></span></a> </li>

                            <?php
						if(empty($_SESSION["user_id"]))
							{
								echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a> </li>
							  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a> </li>';
							}
						else
							{
									
									
										echo  '<li class="nav-item"><a href="your_orders.php" class="nav-link active">Pesanan Saya</a> </li>';
                              echo  '<li class="nav-item"><a href="profile.php" class="nav-link active">Profil</a> </li>';
									echo  '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a> </li>';
							}

						?>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="page-wrapper">
            <div class="top-links">
                <!-- <div class="container">
                    <ul class="row links">
                      
                        <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="restaurants.php">Pilih Toko</a></li>
                        <li class="col-xs-12 col-sm-4 link-item "><span>2</span><a href="#">Pilih Menu</a></li>
                        <li class="col-xs-12 col-sm-4 link-item active" ><span>3</span><a href="checkout.php">Pesan dan Bayar</a></li>
                    </ul>
                </div> -->
            </div>

            <div class="container">

                <span style="color:green;">
                    <?php echo $success; ?>
                </span>

            </div>




            <div class="container m-t-30">
                <form action="" method="post">
                    <div class="widget clearfix">

                        <div class="widget-body">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="cart-totals margin-b-20">
                                        <div class="user-details mb-4">
                                            <h4>Data Diri Pemesan</h4>
                                            <table class="table">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td><?= htmlspecialchars($userData['f_name']); ?>
                                                        <?= htmlspecialchars($userData['l_name']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td><?= htmlspecialchars($userData['email']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>No Telepon</th>
                                                    <td><?= htmlspecialchars($userData['phone']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <td><?= htmlspecialchars($userData['address']); ?></td>
                                                </tr>
                                            </table>

                                            <!-- Pilih alamat -->
                                            <div class="form-check mt-3">
                                                <label>
                                                    <input type="radio" name="alamat_pengiriman" value="default" checked
                                                        onclick="toggleCustomAddress(false)">
                                                    Gunakan alamat saya
                                                </label>
                                                <br>
                                                <label>
                                                    <input type="radio" name="alamat_pengiriman" value="custom"
                                                        onclick="toggleCustomAddress(true)">
                                                    Kirim ke alamat lain
                                                </label>
                                            </div>

                                            <!-- Alamat baru -->
                                            <div id="custom-address-form" style="display: none; margin-top: 20px;">
                                                <h5>Alamat Pengiriman Baru</h5>

                                                <div class="form-group col-md-12">
                                                    <label>Nama Lengkap</label>
                                                    <input type="text" name="custom_name" class="form-control">
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label>Email</label>
                                                        <input type="email" name="custom_email" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>No Telepon</label>
                                                        <input type="text" name="custom_phone" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="provinceSelect" class="form-label">Provinsi</label>
                                                        <select class="form-control" id="provinceSelect"
                                                            aria-label="Pilih Provinsi" name="province">
                                                            <option value="" selected disabled>-- Pilih Provinsi --
                                                            </option>
                                                            <?php foreach (PROVINCES as $province => $cities): ?>
                                                            <option value="<?= htmlspecialchars($province) ?>">
                                                                <?= htmlspecialchars($province) ?>
                                                            </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="citySelect" class="form-label">Kota</label>
                                                        <select class="form-control" id="citySelect"
                                                            aria-label="Pilih Kota" name="city" disabled>
                                                            <option value="" selected disabled>-- Pilih Kota --</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label>Alamat</label>
                                                    <textarea name="custom_address" class="form-control"
                                                        rows="3"></textarea>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="ordered-items mb-4">
                                            <h4>Item yang Dipesan</h4>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Judul</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($cart_items)): ?>
                                                    <?php foreach ($cart_items as $item): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item["title"]); ?></td>
                                                        <td><?= htmlspecialchars($item["quantity"]); ?></td>
                                                        <td>Rp. <?= number_format($item["price"]); ?></td>
                                                        <td>Rp.
                                                            <?= number_format($item["price"] * $item["quantity"]); ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <tr>
                                                        <td colspan="4">Tidak ada item dalam keranjang.</td>
                                                    </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="cart-totals-title">
                                            <h4>Ringkasan Keranjang</h4>
                                        </div>
                                        <div class="cart-totals-fields">

                                            <table class="table">
                                                <tbody>



                                                    <tr>
                                                        <td>Subtotal Keranjang</td>
                                                        <td> <?php echo "Rp. ".$item_total; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Biaya Pengiriman</td>

                                                        <td id="shipping-fee">
                                                            <?php echo "Rp. " . number_format($shippingFee); ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td class="text-color"><strong>Total</strong></td>
                                                        <td class="text-color"><strong id="total-fee">
                                                                <?php echo "Rp. " . number_format($item_total + $shippingFee); ?>
                                                            </strong></td>

                                                    </tr>
                                                </tbody>




                                            </table>
                                        </div>
                                    </div>
                                    <div class="payment-option">
                                        <ul class=" list-unstyled">
                                            <li>
                                                <label class="custom-control custom-radio  m-b-20">
                                                    <input name="mod" id="radioStacked1" checked value="COD"
                                                        type="radio" class="custom-control-input"> <span
                                                        class="custom-control-indicator"></span> <span
                                                        class="custom-control-description">Cash on Delivery</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="custom-control custom-radio  m-b-10">
                                                    <input name="mod" type="radio" value="TF"
                                                        class="custom-control-input"> <span
                                                        class="custom-control-indicator"></span> <span
                                                        class="custom-control-description">Transfer </span>
                                                </label>
                                            </li>
                                        </ul>
                                        <p class="text-xs-center"> <input type="submit"
                                                onclick="return confirm('Apakah kamu ingin melanjutkan pemesanan ?');"
                                                name="submit" class="btn btn-success btn-block" value="Pesan Sekarang">
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <footer class="footer">
                <div class="row bottom-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 payment-options color-gray">
                                <h5>Opsi Pembayaran</h5>
                                <ul>
                                    <li>
                                        <a href="#"> <img src="images/paypal.png" alt="Paypal"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/mastercard.png" alt="Mastercard"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/maestro.png" alt="Maestro"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/stripe.png" alt="Stripe"> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <img src="images/bitcoin.png" alt="Bitcoin"> </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-4 address color-gray">
                                <h5>Alamat</h5>
                                <p>Jl. Purwosari IV No. 17 Tambakrejo, Semarang, Indonesia 50174</p>
                                <h5>Phone: 08122842048</a></h5>
                            </div>
                            <div class="col-xs-12 col-sm-5 additional-info color-gray">
                                <h5>Addition informations</h5>
                                <p>Join thousands of other restaurants who benefit from having partnered with us.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </footer>
    </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script>
    function toggleCustomAddress(useCustom) {
        const customForm = document.getElementById('custom-address-form');
        customForm.style.display = useCustom ? 'block' : 'none';
        if (useCustom) {
            document.getElementById('provinceSelect').disabled = false;
            document.getElementById('citySelect').disabled = false;
        }
        updateShippingFee(useCustom);
    }

    function updateShippingFee(useCustom) {
        let province = '';
        let city = '';

        if (useCustom) {
            province = document.getElementById('provinceSelect').value;
            city = document.getElementById('citySelect').value;
        } else {
            // Ambil dari PHP langsung (server-side rendered)
            province = "<?= addslashes($userProvince) ?>";
            city = "<?= addslashes($userCity) ?>";
        }

        if (!province || !city) return;

        const formData = new FormData();
        formData.append('province', province);
        formData.append('city', city);

        fetch('calculate_shipping.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                const fee = data.shippingFee || 0;
                document.querySelector('#shipping-fee').textContent = "Rp. " + fee.toLocaleString();
                const subtotal = <?= $item_total ?>;
                const total = subtotal + fee;
                document.querySelector('#total-fee').textContent = "Rp. " + total.toLocaleString();
            });
    }

    // Event listener saat user memilih provinsi/kota baru
    document.getElementById('provinceSelect').addEventListener('change', () => updateShippingFee(true));
    document.getElementById('citySelect').addEventListener('change', () => updateShippingFee(true));
    </script>

    <script>
    function toggleCustomAddress(show) {
        const form = document.getElementById('custom-address-form');
        form.style.display = show ? 'block' : 'none';
    }

    const provinces = <?= $provincesJson ?>;

    const provinceSelect = document.getElementById('provinceSelect');
    const citySelect = document.getElementById('citySelect');

    provinceSelect.addEventListener('change', function() {
        const selectedProvince = this.value;

        // Kosongkan dropdown kota
        citySelect.innerHTML = '<option value="" selected disabled>-- Pilih Kota --</option>';

        if (selectedProvince && provinces[selectedProvince]) {
            // Aktifkan dropdown kota
            citySelect.disabled = false;

            // Tambahkan opsi kota sesuai provinsi yang dipilih
            provinces[selectedProvince].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        } else {
            // Jika tidak ada provinsi dipilih, disable dropdown kota
            citySelect.disabled = true;
        }
    });
    </script>

</body>

</html>

<?php
}
?>