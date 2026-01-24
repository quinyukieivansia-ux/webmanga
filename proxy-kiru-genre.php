<?php
// proxy-kiru.php (versi simple)
include ('database.php');


$url = $sumber_data."/wp-admin/admin-ajax.php";

$postdata = http_build_query($_POST);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);
$response = str_replace($sumber_data.'/manga', $domain.'/detail', $response);

$response = preg_replace(
    '#/detail/([^"]*chapter-[^"/]*)/#', 
    '/play/$1/', 
    $response
);

$response = preg_replace(
    '#https?://[^"]*/play/(\?page=\d[^"]*)#',
    '$1',
    $response
);

echo $response;
