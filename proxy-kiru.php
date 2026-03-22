<?php
include ("database.php");

$manga_id = $_GET['manga_id'] ?? '';
$page = $_GET['page'] ?? '1';

if (!$manga_id) {
  http_response_code(400);
  echo "Missing manga_id";
  exit;
}

if (!empty($_GET['is_novel']) && $_GET['is_novel'] == '1') {
  $url = $sumber_data."/wp-admin/admin-ajax.php?manga_id={$manga_id}&page={$page}&is_novel=1&action=chapter_list";
} else {
  $url = $sumber_data."/wp-admin/admin-ajax.php?manga_id={$manga_id}&page={$page}&action=chapter_list";
}

$context = stream_context_create([
  'http' => [
    'header' => "User-Agent: Mozilla/5.0\r\n",
    'timeout' => 10
  ]
]);

$resulttt = file_get_contents($url, false, $context);
if (!$resulttt) {
  echo "Error fetching chapters";
  exit;
}

$resulttt = str_replace($sumber_data.'/manga/', $domain.'/play/', $resulttt);
$resulttt = str_replace($sumber_data.'/', $domain.'/', $resulttt);

echo $resulttt;
