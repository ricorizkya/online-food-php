<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

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

// Konversi data PHP ke JSON untuk digunakan di JavaScript
$provincesJson = json_encode(PROVINCES);

if(empty($_SESSION['user_id']))  
{
	header('location:login.php');
}
else
{

    $user_id = $_SESSION['user_id'];
    $query = mysqli_query($db, "SELECT * FROM users WHERE u_id = '$user_id'");
    $user = mysqli_fetch_assoc($query);

    if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];

    // Ambil dan escape semua input
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $province = mysqli_real_escape_string($db, $_POST['province']);
    $city = mysqli_real_escape_string($db, $_POST['city']);

    console.log($username);
    console.log($cpassword);

    // Validasi input
    if (empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($address) || empty($province) || empty($city)) {
        echo "<script>alert('Semua kolom kecuali password harus diisi!');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid!');</script>";
    } elseif (strlen($phone) < 10) {
        echo "<script>alert('Nomor telepon tidak valid!');</script>";
    } elseif (!empty($password) && strlen($password) < 6) {
        echo "<script>alert('Password minimal 6 karakter!');</script>";
    } elseif (!empty($password) && $password !== $cpassword) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } else {
        // Cek email dan username apakah sudah digunakan user lain
        $check_username = mysqli_query($db, "SELECT id FROM users WHERE username = '$username' AND id != '$user_id'");
        $check_email = mysqli_query($db, "SELECT id FROM users WHERE email = '$email' AND id != '$user_id'");

        if (mysqli_num_rows($check_username) > 0) {
            echo "<script>alert('Username sudah digunakan oleh user lain!');</script>";
        } elseif (mysqli_num_rows($check_email) > 0) {
            echo "<script>alert('Email sudah digunakan oleh user lain!');</script>";
        } else {
            // Update query
            $query = "UPDATE users SET 
                        username = '$username',
                        f_name = '$firstname',
                        l_name = '$lastname',
                        email = '$email',
                        phone = '$phone',
                        address = '$address',
                        province = '$province',
                        city = '$city'";

            // Tambahkan update password jika diisi
            if (!empty($password)) {
                $hashedPassword = md5($password);
                $query .= ", password = '$hashedPassword'";
            }

            $query .= " WHERE u_id = '$user_id'";

            if (mysqli_query($db, $query)) {
                echo "<script>alert('Data berhasil diperbarui!'); window.location.href='profile.php';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengupdate data!');</script>";
            }
        }
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
    <title>Pesanan Saya</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">
    .indent-small {
        margin-left: 5px;
    }

    .form-group.internal {
        margin-bottom: 0;
    }

    .dialog-panel {
        margin: 10px;
    }

    .datepicker-dropdown {
        z-index: 200 !important;
    }

    .panel-body {
        background: #e5e5e5;
        /* Old browsers */
        background: -moz-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
        /* FF3.6+ */
        background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #e5e5e5), color-stop(100%, #ffffff));
        /* Chrome,Safari4+ */
        background: -webkit-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
        /* Chrome10+,Safari5.1+ */
        background: -o-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
        /* Opera 12+ */
        background: -ms-radial-gradient(center, ellipse cover, #e5e5e5 0%, #ffffff 100%);
        /* IE10+ */
        background: radial-gradient(ellipse at center, #e5e5e5 0%, #ffffff 100%);
        /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e5e5e5', endColorstr='#ffffff', GradientType=1);
        font: 600 15px "Open Sans", Arial, sans-serif;
    }

    label.control-label {
        font-weight: 600;
        color: #777;
    }

    /* 
table { 
	width: 750px; 
	border-collapse: collapse; 
	margin: auto;
	
	}

/* Zebra striping */
    /* tr:nth-of-type(odd) { 
	background: #eee; 
	}

th { 
	background: #404040; 
	color: white; 
	font-weight: bold; 
	
	}

td, th { 
	padding: 10px; 
	border: 1px solid #ccc; 
	text-align: left; 
	font-size: 14px;
	
	} */
    */ @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {

        /* table { 
	  	width: 100%; 
	}

	
	table, thead, tbody, th, td, tr { 
		display: block; 
	} */


        /* thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	tr { border: 1px solid #ccc; } */

        /* td { 
		
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
	}

	td:before { 
		
		position: absolute;
	
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
		
		content: attr(data-column);

		color: #000;
		font-weight: bold;
	} */

    }
    </style>

</head>

<body>


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



        <!-- <div class="inner-page-hero bg-image" data-image-src="images/img/BG.jpg">
                <div class="container"> </div>
        
            </div> -->
        <div class="result-show">
            <div class="container">
                <div class="row">


                </div>
            </div>
        </div>

        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                    </div>
                    <div class="col-xs-12">
                        <div class="bg-gray">
                            <div class="row">
                                <h2>Data Diri</h2>
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="example-text-input">User-Name</label>
                                            <input class="form-control" type="text" name="username"
                                                id="example-text-input"
                                                value="<?= htmlspecialchars($user['username']) ?>" readonly>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="example-text-input">Nama Pertama</label>
                                            <input class="form-control" type="text" name="firstname"
                                                id="example-text-input"
                                                value="<?= htmlspecialchars($user['f_name']) ?>">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="example-text-input-2">Nama Terakhir</label>
                                            <input class="form-control" type="text" name="lastname"
                                                id="example-text-input-2"
                                                value="<?= htmlspecialchars($user['l_name']) ?>">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Email </label>
                                            <input type="text" class="form-control" name="email" id="exampleInputEmail1"
                                                value="<?= htmlspecialchars($user['email']) ?>">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="example-tel-input-3">Nomer Handphone</label>
                                            <input class="form-control" type="text" name="phone"
                                                id="example-tel-input-3"
                                                value="<?= htmlspecialchars($user['phone']) ?>">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                id="exampleInputPassword1">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword2">Confirm password</label>
                                            <input type="password" class="form-control" name="cpassword"
                                                id="exampleInputPassword2">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="provinceSelect" class="form-label">Provinsi</label>
                                            <select class="form-control" id="provinceSelect" name="province">
                                                <option value="" disabled>-- Pilih Provinsi --</option>
                                                <?php foreach (PROVINCES as $province => $cities): ?>
                                                <option value="<?= htmlspecialchars($province) ?>"
                                                    <?= ($user['province'] === $province) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($province) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label for="citySelect" class="form-label">Kota</label>
                                            <select class="form-control" id="citySelect" name="city">
                                                <option value="" disabled>-- Pilih Kota --</option>
                                                <?php
                if (isset(PROVINCES[$user['province']])) {
                    foreach (PROVINCES[$user['province']] as $city) {
                        echo '<option value="' . htmlspecialchars($city) . '"';
                        if ($user['city'] === $city) echo ' selected';
                        echo '>' . htmlspecialchars($city) . '</option>';
                    }
                }
                ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="exampleTextarea">Alamat Lengkap</label>
                                            <textarea class="form-control" id="exampleTextarea" name="address"
                                                rows="3"><?= htmlspecialchars($user['address']) ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <p><input type="submit" value="Update" name="submit" class="btn theme-btn">
                                            </p>
                                        </div>
                                    </div>
                                </form>




                            </div>

                        </div>



                    </div>



                </div>
            </div>
    </div>
    </section>


    <footer class="footer">
        <div class="row bottom-footer">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 payment-options color-gray">
                        <h5>Payment Options</h5>
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
                        <h5>Informations</h5>
                        <a href="https://www.instagram.com/minamakmurid/"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.instagram.com/minamakmurid/"><i class="fa-brands fa-instagram"></i></a>
                        <!-- <p>https://www.instagram.com/minamakmurid/.</p>
								   <a href="https://www.instagram.com/minamakmurid/" target="_blank"> -->
                    </div>
                </div>
            </div>
        </div>

        </div>
    </footer>

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
    const provinces = <?= $provincesJson ?>;
    const provinceSelect = document.getElementById('provinceSelect');
    const citySelect = document.getElementById('citySelect');

    // Ambil data dari PHP (data user dari database)
    const selectedProvinceFromDB = "<?= isset($user['province']) ? addslashes($user['province']) : '' ?>";
    const selectedCityFromDB = "<?= isset($user['city']) ? addslashes($user['city']) : '' ?>";

    function updateCityOptions(province, selectedCity = '') {
        citySelect.innerHTML = '<option value="" disabled>-- Pilih Kota --</option>';

        if (province && provinces[province]) {
            citySelect.disabled = false;

            provinces[province].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;

                if (city === selectedCity) {
                    option.selected = true;
                }

                citySelect.appendChild(option);
            });
        } else {
            citySelect.disabled = true;
        }
    }

    // Saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        if (selectedProvinceFromDB) {
            updateCityOptions(selectedProvinceFromDB, selectedCityFromDB);
        }
    });

    // Ketika user memilih provinsi baru
    provinceSelect.addEventListener('change', function() {
        updateCityOptions(this.value);
    });
    </script>

</body>

</html>
<?php
}
?>