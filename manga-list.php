<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$genre = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
include 'database.php';
// echo $actual_link;

$param = '';
if ($genre != "") {
    $param = "?the_status=".$genre;
}

// echo $param;
// Ambil konten HTML dari situs
$html = file_get_contents($sumber_data.'/advanced-search/'.$param);

// Buat DOM dan muat HTML-nya
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Hindari warning HTML tidak valid
$dom->loadHTML($html);
libxml_clear_errors();

// Ambil elemen <body>
$body = $dom->getElementsByTagName('body')->item(0);

// Ambil HTML dalam <body>
$result = $dom->saveHTML($body);


$result = str_replace($sumber_data.'/project/page', $domain.'/project/page', $result);
$result = str_replace($sumber_data.'/manga/', $domain.'/detail/', $result);
$result = str_replace($sumber_data.'/genres', $domain.'/genres', $result);
$result = str_replace($sumber_data.'/tvshows-release-year', $domain.'/tvshows-release-year', $result);
$result = str_replace($sumber_data.'/tvshows-cast', $domain.'/tvshows-cast', $result);
$result = str_replace($sumber_data.'/tvshows-genre', $domain.'/tvshows-genre', $result);
$result = str_replace($sumber_data.'/tvshows-networks', $domain.'/tvshows-networks', $result);
$result = str_replace($sumber_data.'/size', $domain.'/size', $result);
$result = str_replace($sumber_data.'/release-year', $domain.'/release-year', $result);
$result = str_replace($sumber_data.'/quality', $domain.'/quality', $result);
$result = str_replace($sumber_data.'/negara', $domain.'/negara', $result);
$result = str_replace($sumber_data.'/star', $domain.'/star', $result);
$result = str_replace($sumber_data.'/director', $domain.'/director', $result);
$result = str_replace($sumber_data.'/category', $domain.'/category', $result);
$result = str_replace($sumber_data.'/movies', $domain.'/movies', $result);
$result = str_replace($sumber_data.'/tvshows-creator', $domain.'/tvshows-creator', $result);
$result = str_replace($sumber_data.'/tvshows/', $domain.'/play-tvshows/', $result);
$result = str_replace('"'.$sumber_data.'"', '"'.$domain.'"', $result);


$result = str_replace($nama_website_sumber_data, $nama_website, $result);

$complete = $result;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</head>
<body>


    <?php include 'header.php'; ?>

    <div class="container home" style="margin-bottom: 50px;">
        <section class="col-md-12">
            <h2 style="margin-bottom:0px; padding-bottom: 0px; text-align: center; margin-top:30px;"><?php echo $genre; ?></h2>
            <?php echo $complete; ?>
        </section>
        
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader-child/js/script.js?ver=1.0" id="tktm-script-js"></script>
<script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader/assets/js/filter.js?ver=2.2.0" id="ts-filter-js"></script>
<script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader/assets/js/search-V2.js?ver=6.8.2" id="ts-search-js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const path = window.location.pathname;

    if (!path.includes("/manga-list")) return;

    const container = document.querySelector("#search-lazyload");
    if (!container) return;

    let typingTimer = null;
    let currentQuery = "";
    let currentOrderBy = "popular";
    let currentStatus = [];

    // Ambil status dari URL
    const pathParts = path.split("/").filter(Boolean);
    const lastSegment = pathParts[pathParts.length - 1].toLowerCase();

    const validStatus = ["ongoing", "completed", "on-hiatus", "dropped"];

    if (validStatus.includes(lastSegment)) {
        currentStatus = [lastSegment];
    }

    function loadAnimeList(page = 1, query = currentQuery, orderby = currentOrderBy, statusArr = currentStatus) {
        container.innerHTML = "<div style='width:100%; text-align:center;'>Loading...</div>";

        const formData = new FormData();
        formData.append("action", "advanced_search");
        formData.append("page", page);
        formData.append("orderby", orderby);

        if (query) formData.append("query", query);

        // status JSON array
        if (Array.isArray(statusArr) && statusArr.length > 0) {
            formData.append("status", JSON.stringify(statusArr));
        }

        fetch("<?= $domain; ?>/proxy-kiru-genre.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;
        })
        .catch(err => {
            container.innerHTML = "Error loading data";
            console.error(err);
        });
    }

    // Load pertama
    loadAnimeList();

    // Live search
    const searchInput = document.getElementById("search-main-query");
    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            currentQuery = this.value.trim();

            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                loadAnimeList(1);
            }, 400);
        });
    }

    // ✅ FIX PAGINATION
    window.addSingularFilter = function(type, value, btn) {
        if (type === "page") {
            loadAnimeList(Number(value));
        }
    };

    // OrderBy change
    window.orderByQuery = function(orderby, btn) {
        currentOrderBy = orderby;

        const nameEl = document.querySelector(".orderby-name");
        if (nameEl) nameEl.textContent = btn.textContent.trim();

        const selector = document.getElementById("orderby-selector");
        if (selector) selector.setAttribute("data-show", "false");

        loadAnimeList(1);
    };

});
</script>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const btns = document.querySelectorAll('button[onclick*="changeShowMode"]');
    if (!btns.length) return;

    // Default: vertical
    let showMode = "vertical";

    // Set tampilan default ke vertical saat load page
    setTimeout(() => {
        const firstBtn = btns[0]; // tombol vertical
        firstBtn.dataset.selected = "true";
        btns[1].dataset.selected = "false";
        const container = document.querySelector("#search-lazyload");
        if (container) container.dataset.mode = "vertical";
    }, 50);

    window.changeShowMode = function(mode, btn) {
        showMode = mode;

        // Reset selected semua tombol
        btns.forEach(b => b.dataset.selected = "false");

        // Set tombol aktif
        btn.dataset.selected = "true";

        // Update container list
        const container = document.querySelector("#search-lazyload");
        if (!container) return;

        container.dataset.mode = mode;
    };
});

</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
