<?php 
$genre = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// -------------------------
// KONFIGURASI
// -------------------------
$url = $actual_link;
$custom_meta_title = "BACA MANGA TERLENGKAP";
$custom_meta_description = "MangaIndo tempat baca manga online gratis dan terlengkap";
$custom_meta_image = "$domain/img/logo-manga.png";
$custom_favicon = "$domain/img/logo-manga.png";
$nama_website = "MangaIndo";




if ($custom_meta_description != '') {
	$sl_des = "-";
}else{
	$sl_des = "";
}

if ($custom_meta_title != '') {
	$sl_tit = "-";
}else{
	$sl_tit = "";
}


// -------------------------
// CEK KONDISI URL
// -------------------------
if (strpos($url, '/play/') !== false) {
	preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $result, $match);
	$manga_title = trim($match[1] ?? '');
	$meta_title = "Baca Manga $manga_title – $nama_website $sl_tit $custom_meta_title";
    // ambil gambar
	if (preg_match('/<div[^>]*class=["\'][^"\']*w-\[100px\][^"\']*["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\']/is', $result, $match)) {
		$meta_image = $match[1];
	}else {
		$meta_image = $custom_meta_image;
	}
} elseif (strpos($url, '/r/') !== false) {
	preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $result, $match);
	$manga_title = trim($match[1] ?? '');
	$meta_title = "Baca Manga $manga_title – $nama_website $sl_tit $custom_meta_title";
    // ambil gambar
	if (preg_match('/<div[^>]*class=["\'][^"\']*w-\[100px\][^"\']*["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\']/is', $result, $match)) {
		$meta_image = $match[1];
	}else {
		$meta_image = $custom_meta_image;
	}
} elseif (strpos($url, '/detail/') !== false) {
	preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $html, $match);
	$manga_title = trim($match[1] ?? '');
	$meta_title = "Baca Manga $manga_title – $nama_website $sl_tit $custom_meta_title";
	if (preg_match('/<div[^>]+class=["\'][^"\']*relative contents[^"\']*["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\']/is', $result, $match)) {
		$meta_image = $match[1];
	} else {
		$meta_image = $custom_meta_image;
	}
} elseif (strpos($url, '/genres/') !== false) {
	$meta_title = html_entity_decode("Manga Genre $genre - $nama_website $sl_tit $custom_meta_title");
	$meta_title = str_replace($nama_website_sumber_data, $nama_website, $meta_title);
	$meta_image = $custom_meta_image;
} elseif (strpos($url, 'search/') !== false) {
	$meta_title = html_entity_decode("Search : $genre - $nama_website $sl_tit $custom_meta_title");
	$meta_title = str_replace($nama_website_sumber_data, $nama_website, $meta_title);
	$meta_image = $custom_meta_image;
} elseif (strpos($url, 'manga-list/') !== false) {
	$meta_title = html_entity_decode("Manga $genre - $nama_website $sl_tit $custom_meta_title");
	$meta_title = str_replace($nama_website_sumber_data, $nama_website, $meta_title);
	$meta_image = $custom_meta_image;
} elseif (strpos($url, 'manga-list') !== false AND strpos($genre, 'manga-list') !== false) {
	$meta_title = html_entity_decode("Manga Populer - $nama_website $sl_tit $custom_meta_title");
	$meta_title = str_replace($nama_website_sumber_data, $nama_website, $meta_title);
	$meta_image = $custom_meta_image;
} else {
    // fallback jika bukan play/detail
	$meta_image = $custom_meta_image;
	$meta_title = "$nama_website $sl_tit $custom_meta_title";
}

// deskripsi meta
$meta_deskripsi = "$custom_meta_description $sl_des $meta_title";
?>

