<?php 
// error_reporting(E_ERROR | E_PARSE);
include 'sumber-data.php';

// $domain = $_SERVER['HTTP_HOST'];


// BOLEH DIGANTI SESUAI INTRUKSI
$logo = "logo-manga.png"; // Simpan gambar logo di folder "img", copy file name disini.
$favicon = "favicon-manga.png"; // Simpan gambar logo di folder "img", copy file name disini.
$nama_website = "BACA MANGA TERLENGKAP"; // Judul Website / Nama Website

// $domain = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
// echo $domain;
$domain = "https://mangaserver.playall.me"; // Ganti dengan domain Anda yang akan digunakan




// IKLAN BANNER KIRI
// ("") Kutip Ke-1 diisi link halaman tujuan jika pakai link, kosongkan jika tidak pakai link
// ("") Kutip Ke-2 diisi nama/judul gambar, simpan gambar di folder *img*

// Jika mau tambah banner lebih dari dua bisa tambahkan scrept ini << array("","banner-800x200px.jpg"), >> dibawah array
$banner_iklan_kiri = array(
	array("","banner-800x90px.jpg"), 
	array("","banner-800x200px.jpg"),
);




// IKLAN BANNER KANAN
// ("") Kutip Ke-1 diisi link halaman tujuan jika pakai link, kosongkan jika tidak pakai link
// ("") Kutip Ke-2 diisi nama/judul gambar, simpan gambar di folder *img*

// Jika mau tambah banner lebih dari dua bisa tambahkan scrept ini << array("","banner-800x200px.jpg"), >> dibawah array
$banner_iklan_kanan = array(
	array("","banner-800x90px.jpg"), 
	array("","banner-800x200px.jpg"),
);

// STYLE WEBSITE
$warna_background = "linear-gradient(142.56deg, #322C7A 21.68%, #30ABBD 80.35%)"; // ganti dengan kode warna yang di inginkan
$warna_text = "white"; // ganti dengan kode warna yang di inginkan


?>