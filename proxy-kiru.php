<?php
include ("database.php");
// proxy-kiru.php
$manga_id = $_GET['manga_id'];
$page = $_GET['page'] ?? '1';

if (!$manga_id) {
  http_response_code(400);
  echo "Missing manga_id";
  exit;
}
if (!empty($_GET['is_novel']) == '1') {
  $url = $sumber_data."/wp-admin/admin-ajax.php?manga_id={$manga_id}&page={$page}&is_novel=1&action=chapter_list";
}else{
  $url = $sumber_data."/wp-admin/admin-ajax.php?manga_id={$manga_id}&page={$page}&action=chapter_list";
}

$context = stream_context_create([
  'http' => [
    'header' => "User-Agent: Mozilla/5.0\r\n"
  ]
]);

$resulttt = file_get_contents($url, false, $context);
$resulttt = str_replace($sumber_data.'/manga/', $domain.'/play/', $resulttt);
$resulttt = preg_replace(
  '#/detail/([^"]*chapter-[^"/]*)/#', 
  '/play/$1/', 
  $resulttt
);

$resulttt = preg_replace(
  '#https?://[^"]*/play/(\?page=\d[^"]*)#',
  '$1',
  $resulttt
);

echo $resulttt;


