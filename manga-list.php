<?php
include 'database.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 30;

// Ambil semua slug dari sitemap
$all_slugs = [];
for ($i = 1; $i <= 9; $i++) {
    $sitemap_num = $i === 1 ? '' : $i;
    $url = "https://v1.kiryuu.to/manga-sitemap{$sitemap_num}.xml";
    $ctx = stream_context_create(['http' => ['timeout' => 10]]);
    $xml = file_get_contents($url, false, $ctx);
    if (!$xml) continue;
    preg_match_all('#<loc>(https://v1\.kiryuu\.to/manga/([^/]+)/)</loc>#', $xml, $matches);
    foreach ($matches[2] as $slug) {
        $all_slugs[] = $slug;
    }
}

$all_slugs = array_unique($all_slugs);
$total = count($all_slugs);
$total_pages = ceil($total / $per_page);
$offset = ($page - 1) * $per_page;
$page_slugs = array_slice($all_slugs, $offset, $per_page);

header('Content-Type: application/json');
echo json_encode([
    'slugs' => $page_slugs,
    'total' => $total,
    'page' => $page,
    'pages' => $total_pages
]);
