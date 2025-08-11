<?php


include("connection/connect.php");

$storeCity = "Semarang";
$storeProvince = "Jawa Tengah";
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

$userProvince = $_POST['province'] ?? '';
$userCity = $_POST['city'] ?? '';

$shippingFee = 60000; // default fallback

if ($userCity === $storeCity) {
    $shippingFee = 10000;
} elseif ($userProvince === $storeProvince) {
    $shippingFee = 20000;
} elseif (
    isset($provinceToIsland[$userProvince]) &&
    isset($provinceToIsland[$storeProvince]) &&
    $provinceToIsland[$userProvince] === "Jawa" &&
    $provinceToIsland[$storeProvince] === "Jawa"
) {
    $shippingFee = 25000;
} elseif ($provinceToIsland[$userProvince] === 'Sumatera') {
    $shippingFee = 30000;
} elseif ($provinceToIsland[$userProvince] === 'Kalimantan') {
    $shippingFee = 35000;
} elseif ($provinceToIsland[$userProvince] === 'Sulawesi') {
    $shippingFee = 40000;
} elseif ($provinceToIsland[$userProvince] === 'MalukuPapua') {
    $shippingFee = 50000;
}

echo json_encode(['shippingFee' => $shippingFee]);
exit;