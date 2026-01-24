<?php include 'database.php';
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if (isset($_GET['orderby'])) {
    $link_update = str_replace($domain, $sumber_data, $actual_link);
}elseif (isset($_GET['page'])) {
    $link_update = str_replace($domain, $sumber_data, $actual_link);
}else{
    $link_update = $sumber_data;
}
// echo $link_update;
// Ambil konten HTML dari situs
$html = file_get_contents($link_update);

// Buat DOM dan muat HTML-nya
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Hindari warning HTML tidak valid
$dom->loadHTML($html);
libxml_clear_errors();

// Ambil elemen <body>
$body = $dom->getElementsByTagName('body')->item(0);

// Ambil HTML dalam <body>
$complete = $dom->saveHTML($body);


$complete = str_replace('class="bs"', 'class="bs col-md-2"', $complete);
$complete = str_replace('class="popconslide"', 'class="popconslide row"', $complete);
$complete = str_replace('class="listupd"', 'class="listupd row"', $complete);
$complete = str_replace($sumber_data.'/manga/', $domain.'/detail/', $complete);
$complete = str_replace($sumber_data.'/category', $domain.'/category', $complete);
$complete = str_replace($nama_website_sumber_data, $nama_website, $complete);
$complete = str_replace($nama_website_sumber_data5, "BOX OFFICE ".$nama_website, $complete);
$complete = str_replace($nama_website_sumber_data2, $nama_website, $complete);
$complete = str_replace($nama_website_sumber_data4, $nama_website, $complete);
$complete = str_replace($sumber_data, $domain."/play", $complete);
$complete = str_replace($domain."/play/wp-", $sumber_data."/wp-", $complete);
$complete = str_replace("/play/project", "/project", $complete);
$complete = str_replace("/play/latest", "/latest", $complete);
$complete = str_replace("/play/novel", "/novel", $complete);
$complete = str_replace("/play/page/", "/page/", $complete);
$complete = str_replace("/play/genres/", "/genres/", $complete);



$complete = preg_replace(
    '#/detail/([^"]*chapter-[^"/]*)/#', 
    '/play/$1/', 
    $complete
);

$complete = preg_replace(
    '#https?://[^"]*/play/(\?page=\d[^"]*)#',
    '$1',
    $complete
);




preg_match_all('/<h2(.*)class(.*)=(.*)"jdlflm">(.*)<\/h2>/U', $complete, $result_judul_complete);
$judul_complete = array_pop($result_judul_complete);
$total_complete = count($judul_complete);
// $content_genres = file_get_contents($sumber_data.'/genre-list');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- Font Awesome 5 CDN -->
    
</head>
<body>
    <section class="col-md-12 movie-home">
     <?php include 'header.php'; ?>
     <div class="container home">
        <?php echo $complete; ?>
    </section>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script type="text/javascript">
var swiper = new Swiper(".hero-slider .swiper", {
  slidesPerView: 1, // default mobile
  spaceBetween: 15,
  centeredSlides: false,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false
  },
  breakpoints: {
    640: { 
      slidesPerView: 2 
    },
    1024: { 
      slidesPerView: 3 
    }
  }
});
</script>

<script>
lucide.createIcons();
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // ambil semua tombol tab
    const tabButtons = document.querySelectorAll(".tab-button");
    // ambil semua konten ul
    const tabContents = document.querySelectorAll("[data-trending-chart]");

    tabButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const period = btn.getAttribute("data-period");

            // reset semua button
            tabButtons.forEach(b => b.setAttribute("data-active", "false"));
            // aktifkan button yg diklik
            btn.setAttribute("data-active", "true");

            // reset semua konten
            tabContents.forEach(content =>
                content.setAttribute("data-active", "false")
            );

            // tampilkan konten sesuai tab
            const activeContent = document.querySelector(`[data-trending-chart="${period}"]`);
            if (activeContent) activeContent.setAttribute("data-active", "true");
        });
    });
});
</script>
</body>
</html>