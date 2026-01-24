<?php 
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';
$genre = explode($domain, $actual_link);
// echo $genre[1];
$genree = str_replace('/', '', $genre[1]);

$context = stream_context_create([
    'http' => [
        'header' => 
        "User-Agent: Mozilla/5.0\r\n" .
        "Accept: text/html\r\n" .
        "Referer: ".$sumber_data."/\r\n"
    ]
]);

$html = file_get_contents($sumber_data."".$genre[1], false, $context);



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
$result = str_replace('<script data-cfasync="false" async type="text/javascript" src="//cq.synochaauca.com/r6yAy4NZbETqFs/57707"></script>', '', $result);
$result = str_replace($sumber_data.'/project/?the', $domain.'/project/?the', $result);
$result = str_replace($sumber_data.'/latest/?the', $domain.'/latest/?the', $result);
$result = str_replace($sumber_data.'/novel/?the', $domain.'/novel/?the', $result);
$result = str_replace($sumber_data.'/manhua/?the', $domain.'/novel/?the', $result);
$result = preg_replace(
    '#/play/((?![^"]*chapter-)[^"/]*)/#',
    '/detail/$1/',
    $result
);

$result = preg_replace(
    '#https?://[^"]*/play/(\?page=\d[^"]*)#',
    '$1',
    $result
);


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

</body>

<script type="text/javascript">
    window.open = (url)=>console.log("open called with",url);
</script>
<script>
    lucide.createIcons();
</script>
