<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

function tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $tgl = date('d', strtotime($tanggal));
    $bln = date('n', strtotime($tanggal));
    $thn = date('Y', strtotime($tanggal));
    $jam = date('H:i:s', strtotime($tanggal));
    
    return $tgl . " " . $bulan[$bln] . " " . $thn . " <br> " . $jam;
}

if(empty($_SESSION['user_id']))  
{
	header('location:login.php');
}
else
{
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

                                <?php
                                    // Proses form submit update bukti pembayaran
                                    if (isset($_POST['submit_bukti'])) {
                                        $orderId = $_POST['order_id'];
                                        $bank = $_POST['bank'];
                                        $nomor_rekening = $_POST['nomor_rekening'];
                                        $atas_nama = $_POST['atas_nama'];
                                        
                                        // Proses upload file bukti pembayaran
                                        $uploadDir = 'uploads/bukti_tf/';
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }
                                        $fileName = basename($_FILES['bukti_tf']['name']);
                                        $targetFile = $uploadDir . time() . '_' . $fileName;
                                        $uploadOk = move_uploaded_file($_FILES['bukti_tf']['tmp_name'], $targetFile);

                                        if ($uploadOk) {
                                            // Simpan data ke database
                                            $updateQuery = "UPDATE users_orders SET 
                                                            bank = '".mysqli_real_escape_string($db, "Bank: $bank, No Rek: $nomor_rekening, Atas Nama: $atas_nama")."',
                                                            bukti_tf = '".mysqli_real_escape_string($db, $targetFile)."'
                                                            WHERE o_id = '".intval($orderId)."'";
                                            mysqli_query($db, $updateQuery);
                                            echo "<div class='alert alert-success'>Bukti pembayaran berhasil diupdate.</div>";
                                        } else {
                                            echo "<div class='alert alert-danger'>Gagal mengupload bukti pembayaran.</div>";
                                        }
                                    }
                                ?>

                                <table class="table table-bordered table-hover">
                                    <thead style="background: #404040; color:white;">
                                        <tr>

                                            <th>Tanggal</th>
                                            <th>Barang</th>
                                            <th>Status Pengiriman</th>
                                            <?php
                                                $tfExists = false;
                                                $checkTfQuery = mysqli_query($db, "SELECT 1 FROM users_orders WHERE u_id='".$_SESSION['user_id']."' AND payment_method='TF' LIMIT 1");
                                                if (mysqli_num_rows($checkTfQuery) > 0) {
                                                    $tfExists = true;
                                                    echo "<th>Bukti Pembayaran</th>";
                                                }
                                            ?>
                                            <th>Resi</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php 
				
						$query_res= mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."'");
												if(!mysqli_num_rows($query_res) > 0 )
														{
															echo '<td colspan="6"><center>Kamu Belum Melakukan Pemesanan. </center></td>';
														}
													else
														{			      
										  
										  while($row=mysqli_fetch_array($query_res))
										  {
                                            $items = json_decode($row['items'], true);
						
							?>
                                        <tr>
                                            <td data-column="Date">
                                                <?php echo tanggal_indo($row['date']); ?></td>
                                            <td data-column="Item">
                                                <?php 
                                                if ($items) {
                                                    $no = 1;
                                                    $grandTotal = 0;
                                                    foreach ($items as $item) {
                                                        $subtotal = $item['quantity'] * $item['price'];
                                                        echo $no . '. ' . $item['title'] . '<br>';
                                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;' .$item['quantity'] . ' x Rp ' . number_format($item['price'], 0, ',', '.') . ",-<br>";
                                                        $grandTotal += $subtotal;
                                                        $no++;
                                                    }
                                                    echo '<br>';
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Subtotal : Rp ' . number_format($grandTotal, 0, ',', '.') . ",-</b><br>";
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Ongkir : Rp ' . number_format($row['ongkir'], 0, ',', '.') . ",-</b><br>";
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Total : Rp ' . number_format($row['total'], 0, ',', '.') . ",-</b><br><br>";
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Metode Pembayaran : ' . ($row['payment_method'] == 'TF' ? 'Transfer Bank' : 'COD') . '</b><br>';
                                                } else {
                                                    echo "Data tidak valid";
                                                }                                                
                                                ?>
                                            </td>
                                            <td data-column="status">
                                                <?php 
																			$status=$row['status'];
																			if($status=="Menunggu Pembayaran")
																			{
																			?>
                                                <button type="button" class="btn btn-warning"><span class="fa fa-bars"
                                                        aria-hidden="true"></span> Menunggu Pembayaran</button>
                                                <?php 
																			  }
																			   if($status=="in process")
																			 { ?>
                                                <button type="button" class="btn btn-info"><span
                                                        class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                    Dikemas</button>
                                                <?php
																				}
																			if($status=="on the way")
																				{
																			?>
                                                <button type="button" class="btn btn-success"><span
                                                        class="fa fa-check-circle" aria-hidden="true"></span>
                                                    Dalam Perjalanan</button>
                                                <?php 
																			} 
																			?>
                                                <?php
																			if($status=="rejected")
																				{
																			?>
                                                <button type="button" class="btn btn-danger"> <i
                                                        class="fa fa-close"></i> Nominal Pembayaran Tidak
                                                    Sesuai</button>
                                                <?php 
                                                                            } if($status=="done")
                                                                                {
                                                                            ?>
                                                <button type="button" class="btn btn-success"><span
                                                        class="fa fa-check-circle" aria-hidden="true"></span>
                                                    Selesai</button>
                                                <?php
                                                                            } if($status=="Menunggu Konfirmasi Pembayaran")
                                                                                {
                                                                            ?>
                                                <button type="button" class="btn btn-warning"><span class="fa fa-bars"
                                                        aria-hidden="true"></span>
                                                    Menunggu Konfirmasi Pembayaran</button>
                                                <?php
                                                                            } if($status=="rejected")
                                                                                {
                                                                            ?>
                                                <button type="button" class="btn btn-danger"><span class="fa fa-close"
                                                        aria-hidden="true"></span>
                                                    Dibatalkan</button>
                                                <?php
                                                                            }
                                                                            ?>
                                            </td>
                                            <?php if ($row['payment_method'] == 'TF' && $row['bank'] === null) { ?>
                                            <td>
                                                <form action="update_payment_proses.php" method="POST"
                                                    enctype="multipart/form-data">
                                                    <input type="hidden" name="order_id"
                                                        value="<?php echo $row['o_id']; ?>">
                                                    <div class="form-group">
                                                        <input type="text" name="bank" placeholder="Nama Bank"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="nomor_rekening"
                                                            placeholder="Nomor Rekening" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" name="atas_nama" placeholder="Atas Nama"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="file" name="bukti_tf" accept="image/*"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" name="submit_update"
                                                            class="btn btn-primary btn-sm">Simpan</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <?php } elseif ($row['payment_method'] == 'TF' && $row['bank'] !== null) { ?>
                                            <td>
                                                <span><?php echo $row['bank']; ?></span><br>
                                                <img src="<?php echo $row['bukti_tf']; ?>" alt="" srcset=""
                                                    style="width: 250px; height: 350px;"><br>
                                            </td>
                                            <?php } else { ?> -
                                            <?php } ?>
                                            <td><?php echo$row['resi'] ?> </td>
                                            <td data-column="Action"> <a
                                                    href="delete_orders.php?order_del=<?php echo $row['o_id'];?>"
                                                    onclick="return confirm('Apakah kamu yakin untuk membatalkan pesanan?');"
                                                    class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                        class="fa fa-trash-o" style="font-size:16px"></i></a>
                                            </td>

                                        </tr>


                                        <?php }} ?>




                                    </tbody>
                                </table>



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
</body>

</html>
<?php
}
?>