<?php 
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';

$judul = explode($domain.'/play/', $actual_link);
$judul = explode('/', $judul[1]);
$judul = $judul[0];

$url_back = str_replace('/play/', '/detail/', $actual_link);
$url_back = preg_replace('#chapter-[^/]+/?$#', '', $url_back);


$url = str_replace($domain.'/play/', $sumber_data.'/manga/', $actual_link);

$context = stream_context_create([
    'http' => [
        'header' => 
        "User-Agent: Mozilla/5.0\r\n" .
        "Accept: text/html\r\n" .
        "Referer: ".$sumber_data."/\r\n"
    ]
]);

$html = file_get_contents($url, false, $context);



    // Buat DOM dan muat HTML-nya
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Hindari warning HTML tidak valid
$dom->loadHTML($html);
libxml_clear_errors();

// Ambil elemen <body>
$body = $dom->getElementsByTagName('body')->item(0);

// Ambil HTML dalam <body>
$result = $dom->saveHTML($body);



// $result = str_replace($sumber_data.'/manga/'.$judul_fix, $domain.'/manga/', $result);
$result = str_replace($sumber_data.'/manga/', $domain.'/play/', $result);
$result = str_replace('//cq.synochaauca.com/r6yAy4NZbETqFs/57707', '', $result);

$result = str_replace('play/'.$judul.'/"', 'detail/'.$judul.'/"', $result);
$result = str_replace('play/'.$judul.'/`"', 'detail/'.$judul.'/`"', $result);



$result = str_replace($nama_website_sumber_data, $nama_website, $result);
$complete = $result;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</style>
</head>
<body>
    <?php include 'header.php'; ?>


   <?php echo $complete; ?>

   <a href="<?php echo $url_back; ?>#chapterlist" class="btn btn-primary" style="width: 100%; margin-top:0px; padding: 10px; font-weight: bold; display:block; position: fixed; bottom: 0px;">PILIH CHAPTER LAINNYA</a>
</body>

<script type="text/javascript">
    window.open = (url)=>console.log("open called with",url);
</script>
<script>
    lucide.createIcons();
</script>
