<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$genre = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
include 'database.php';
// echo $actual_link;



$page = explode($domain.'/genres/', $actual_link);
if ($page[1] != '') {
    $page_fix = '/'.$page[1];
}else{
    $page_fix = '';
} ;




// Ambil konten HTML dari situs
$html = file_get_contents($sumber_data.'/genre'.$page_fix);

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
            <h2 style="margin-bottom:0px; padding-bottom: 0px; text-align: center; margin-top:30px;">Genre : <?php echo $genre; ?></h2>
            <?php echo $complete; ?>
        </section>
        
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<script type="text/javascript" src="https://kiryuu02.com/wp-content/themes/mangareader-child/js/script.js?ver=1.0" id="tktm-script-js"></script>
<script type="text/javascript" src="https://kiryuu02.com/wp-content/themes/mangareader/assets/js/filter.js?ver=2.2.0" id="ts-filter-js"></script>
<script type="text/javascript" src="https://kiryuu02.com/wp-content/themes/mangareader/assets/js/search-V2.js?ver=6.8.2" id="ts-search-js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const path = window.location.pathname;
        const match = path.match(/\/genres\/([^\/]+)/);

    if (!match) return; // bukan halaman genre
    loadGenrePage(1); // 🚀 Auto load page 1 saat halaman dibuka
});

    function loadGenrePage(page = 1) {
        const path = window.location.pathname;
        const match = path.match(/\/genres\/([^\/]+)/);
        if (!match) return;

        const genre = match[1];
        const container = document.querySelector("#search-lazyload");
        if (!container) return;

        container.innerHTML = "<div style='width:100%; text-align:center;'>Loading...</div>";

        const formData = new FormData();
        formData.append("action", "advanced_search");
        formData.append("genre", genre);
        formData.append("page", page);

        fetch("<?php echo $domain; ?>/proxy-kiru-genre.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;

        // ♻️ Aktifkan pagination supaya bisa load page berikutnya
            container.querySelectorAll("[data-page]").forEach(btn => {
                btn.addEventListener("click", function () {
                    loadGenrePage(this.dataset.page);
                });
            });
        })
        .catch(err => {
            container.innerHTML = "Error loading data";
            console.error(err);
        });
    }
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const path = window.location.pathname;
    const match = path.match(/\/genres\/([^\/]+)/);
    if (!match) return;

    const genre = match[1];
    const container = document.querySelector("#search-lazyload");
    if (!container) return;

    let typingTimer = null;
    let currentQuery = "";
    let currentOrderBy = "popular"; // default (sesuai label awal kamu)

    function loadGenre(page = 1, query = "", orderby = currentOrderBy) {
        container.innerHTML = "<div style='width:100%; text-align:center;'>Loading...</div>";

        const formData = new FormData();
        formData.append("action", "advanced_search");
        formData.append("genre", genre);
        formData.append("page", page);

        if (query) formData.append("query", query);
        if (orderby) formData.append("orderby", orderby);

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

    // Initial load
    loadGenre();

    // Auto Search
    const searchInput = document.getElementById("search-main-query");
    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            const val = this.value.trim();
            currentQuery = val;

            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                loadGenre(1, currentQuery, currentOrderBy);
            }, 400);
        });
    }

    // Pagination Support
    document.body.addEventListener("click", function(e) {
        const btn = e.target.closest('button[onclick*="addSingularFilter(\'page\'"]');
        if (!btn) return;

        e.preventDefault();

        const onclickText = btn.getAttribute("onclick");
        const matchPage = onclickText.match(/'page'\s*,\s*'(\d+)'/);
        if (!matchPage) return;

        const page = matchPage[1];
        loadGenre(page, currentQuery, currentOrderBy);
    });

    // Override orderByQuery to auto load data
    window.orderByQuery = function(orderby, btn) {
        currentOrderBy = orderby;

        // update text di tombol dropdown
        const nameEl = document.querySelector(".orderby-name");
        if (nameEl) nameEl.textContent = btn.textContent.trim();

        // tutup dropdown setelah pilih
        const selector = document.getElementById("orderby-selector");
        if (selector) selector.setAttribute("data-show", "false");

        // load ulang
        loadGenre(1, currentQuery, currentOrderBy);
    };

});






document.addEventListener("DOMContentLoaded", function () {
    const btns = document.querySelectorAll('button[onclick*="changeShowMode"]');
    if (!btns.length) return;

    // Default: horizontal (bisa kamu ubah)
    let showMode = "horizontal";

    window.changeShowMode = function(mode, btn) {
        showMode = mode;

        // Update UI button selected
        btns.forEach(b => b.dataset.selected = "false");
        btn.dataset.selected = "true";

        // Tambahkan class ke container list
        const container = document.querySelector("#search-lazyload");
        if (!container) return;

        container.dataset.mode = mode;
    };
});





document.addEventListener("DOMContentLoaded", function () {
    const orderBtn = document.querySelector('button[onclick*="addSingularFilter"][onclick*="order"]');
    if (!orderBtn) return;

    const arrowIcon = orderBtn.querySelector("[data-lucide='arrow-down']");
    
    // Default: Latest (DESC)
    let orderType = "desc";

    orderBtn.addEventListener("click", function () {

        // Toggle ASC/DESC
        orderType = orderType === "desc" ? "asc" : "desc";

        // Rotate icon
        arrowIcon.style.transform = orderType === "desc" ? "rotate(0deg)" : "rotate(180deg)";

        // Panggil addSingularFilter tanpa mengubah filter dropdown
        window['addSingularFilter']('order', orderType, this);
    });
});



</script>








<script>
    lucide.createIcons();
</script>







</body>
</html>
