<?php

//main connection file for both admin & front end
$servername = "db"; //server
$username = "phpuser"; //username
$password = ""; //password
$dbname = "onlinefoodphp";  //database

// Create connection
$db = mysqli_init();

// Opsional: Jika perlu menonaktifkan verifikasi SSL
// mysqli_options($db, MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false);

// Lakukan koneksi
if (!mysqli_real_connect($db, $servername, $username, $password, $dbname)) {
    die("Connection failed: " . mysqli_connect_error());
}

?>