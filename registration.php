<!DOCTYPE html>
<html lang="en">
<?php

session_start(); 
error_reporting(0); 
include("connection/connect.php"); 
// Data constant provinsi dan kota
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

if(isset($_POST['submit'] )) 
{
     if(empty($_POST['firstname']) || 
   	    empty($_POST['lastname'])|| 
         empty($_POST['email']) ||  
         empty($_POST['phone'])||
         empty($_POST['password'])||
         empty($_POST['cpassword']) ||
         empty($_POST['cpassword']) ||
        empty($_POST['address']) ||
        empty($_POST['province']) ||
        empty($_POST['city']))
		{
			$message = "All fields must be Required!";
		}
	else
	{
	
	$check_username= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
	$check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");
		

	
	if($_POST['password'] != $_POST['cpassword']){  
       	
          echo "<script>alert('Password not match');</script>"; 
    }
	elseif(strlen($_POST['password']) < 6)  
	{
      echo "<script>alert('Password Must be >=6');</script>"; 
	}
	elseif(strlen($_POST['phone']) < 10)  
	{
      echo "<script>alert('Invalid phone number!');</script>"; 
	}

    elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
    {
          echo "<script>alert('Invalid email address please type a valid email!');</script>"; 
    }
	elseif(mysqli_num_rows($check_username) > 0) 
     {
       echo "<script>alert('Username Already exists!');</script>"; 
     }
	elseif(mysqli_num_rows($check_email) > 0) 
     {
       echo "<script>alert('Email Already exists!');</script>"; 
     }
	else{

      $username = mysqli_real_escape_string($db, $_POST['username']);
            $firstname = mysqli_real_escape_string($db, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($db, $_POST['lastname']);
            $email = mysqli_real_escape_string($db, $_POST['email']);
            $phone = mysqli_real_escape_string($db, $_POST['phone']);
            $password = md5($_POST['password']);
            $address = mysqli_real_escape_string($db, $_POST['address']);
            $province = mysqli_real_escape_string($db, $_POST['province']);
            $city = mysqli_real_escape_string($db, $_POST['city']);

            $mql = "INSERT INTO users(username, f_name, l_name, email, phone, password, address, province, city)
                    VALUES('$username', '$firstname', '$lastname', '$email', '$phone', '$password', '$address', '$province', '$city')";

            mysqli_query($db, $mql);
	
		 header("refresh:0.1;url=login.php");
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
    <title>Pendaftaran</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div style=" background-image: url('images/img/pimg.jpg');">
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

            <div class="container">
                <ul>


                </ul>
            </div>

            <section class="contact-page inner-page">
                <div class="container ">
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-body">

                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label for="example-text-input">User-Name</label>
                                                <input class="form-control" type="text" name="username"
                                                    id="example-text-input">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="example-text-input">Nama Pertama</label>
                                                <input class="form-control" type="text" name="firstname"
                                                    id="example-text-input">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="example-text-input-2">Nama Terakhir</label>
                                                <input class="form-control" type="text" name="lastname"
                                                    id="example-text-input-2">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="exampleInputEmail1">Email </label>
                                                <input type="text" class="form-control" name="email"
                                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="example-tel-input-3">Nomer Handphone</label>
                                                <input class="form-control" type="text" name="phone"
                                                    id="example-tel-input-3">
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
                                                <select class="form-control" id="provinceSelect"
                                                    aria-label="Pilih Provinsi" name="province">
                                                    <option value="" selected disabled>-- Pilih Provinsi --</option>
                                                    <?php foreach (PROVINCES as $province => $cities): ?>
                                                    <option value="<?= htmlspecialchars($province) ?>">
                                                        <?= htmlspecialchars($province) ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <!-- <div class="mb-3"> -->
                                                <label for="citySelect" class="form-label">Kota</label>
                                                <select class="form-control" id="citySelect" aria-label="Pilih Kota"
                                                    name="city" disabled>
                                                    <option value="" selected disabled>-- Pilih Kota --</option>
                                                </select>
                                                <!-- </div> -->
                                                <!-- <label for="exampleTextarea">Alamat Lengkap</label>
                                                <textarea class="form-control" id="exampleTextarea" name="address"
                                                    rows="3"></textarea> -->
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="exampleTextarea">Alamat Lengkap</label>
                                                <textarea class="form-control" id="exampleTextarea" name="address"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-4">
                                                <p><input type="submit" value="Register" name="submit"
                                                        class="btn theme-btn"></p>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <footer class="footer">
                <div class="container">

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
                                    <h5>Addition informations</h5>
                                    <p>Join thousands of other restaurants who benefit from having partnered with us.
                                    </p>
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
        // Data provinsi dan kota dari PHP
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