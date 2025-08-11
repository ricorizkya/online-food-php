<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
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
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Semua Pesanan</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>

<body class="fix-header fix-sidebar">

    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper">

        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="dashboard.php">

                        <span><img src="images/icn.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">

                    <ul class="navbar-nav mr-auto mt-md-0">




                    </ul>

                    <ul class="navbar-nav my-lg-0">



                        <li class="nav-item dropdown">

                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>

                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all
                                                notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/user-icn.png"
                                    alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="left-sidebar">

            <div class="scroll-sidebar">

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a></li>
                        <li class="nav-label">Log</li>
                        <li> <a href="all_users.php"> <span><i
                                        class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i
                                    class="fa fa-archive f-s-20 color-warning"></i><span
                                    class="hide-menu">Toko</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_restaurant.php">Semua Toko</a></li>
                                <li><a href="add_category.php">Tambah Kategori</a></li>
                                <li><a href="add_restaurant.php">Tambah Toko</a></li>

                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery"
                                    aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="all_menu.php">Semua Menu</a></li>
                                <li><a href="add_menu.php">Tambahkan Menu</a></li>


                            </ul>
                        </li>
                        <li> <a href="all_orders.php"><i class="fa fa-shopping-cart"
                                    aria-hidden="true"></i><span>Pesanan</span></a></li>

                    </ul>
                </nav>

            </div>

        </div>

        <div class="page-wrapper">



            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">


                        <div class="col-lg-12">
                            <div class="card card-outline-primary">
                                <div class="card-header">
                                    <h4 class="m-b-0 text-white">Semua Pesanan</h4>
                                </div>

                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>User</th>
                                                <th>Barang</th>
                                                <th>Total</th>
                                                <th>Status Pesanan</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
												$sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ";
												$query=mysqli_query($db,$sql);
												
													if(!mysqli_num_rows($query) > 0 )
														{
															echo '<td colspan="8"><center>No Orders</center></td>';
														}
													else
														{				
																	while($rows=mysqli_fetch_array($query))
																		{
																																							
																				?>
                                            <?php
												
                                                $items = json_decode($rows['items'], true);
                                                         

                                                echo ' <tr>
																					           <td>'.tanggal_indo($rows['date']).'</td>
																								<td>'.$rows['f_name'].' '.$rows['l_name'].'</td>' ?>
                                            <td>
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
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Ongkir : Rp ' . number_format($rows['ongkir'], 0, ',', '.') . ",-</b><br>";
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Total : Rp ' . number_format($rows['total'], 0, ',', '.') . ",-</b><br><br>";
                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<b>Metode Pembayaran : ' . ($rows['payment_method'] == 'TF' ? 'Transfer Bank' : 'COD') . '</b><br>';
                                                } else {
                                                    echo "Data tidak valid";
                                                } 
                                                ?>
                                            </td>
                                            <?php echo 
																								'<td>Rp '.number_format($rows['total'], 0, ',', '.').'</td>'
																								
																								?>

                                            <td data-column="status">
                                                <?php 
																			$status=$rows['status'];
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
                                            <td>
                                                <a href="delete_orders.php?order_del=<?php echo $rows['o_id'];?>"
                                                    onclick="return confirm('Apa kamu Yakin?');"
                                                    class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i
                                                        class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                <?php
																								echo '<a href="view_order.php?user_upd='.$rows['o_id'].'" " class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="fa fa-edit"></i></a>
																									</td>
																									</tr>';
																					 
																						
																						
																		}	
														}
												
											
											?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>


    <footer class="footer"> © 2024 - UD Mina Makmur</footer>

    </div>

    </div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/sidebarmenu.js"></script>
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

</body>

</html>