<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$genre = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
include 'database.php';
// echo $actual_link;


$page = explode($domain.'/search/', $actual_link);
if ($page[1] != '') {
    $page_fix = '/'.$page[1];
}else{
    $page_fix = '';
} ;


// Ambil konten HTML dari situs
$html = file_get_contents($sumber_data.'/advanced-search');

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
            <h2 style="margin-bottom:0px; padding-bottom: 0px; text-align: center; margin-top:30px;">Search : <?php echo $genre; ?></h2>
            <?php echo $complete; ?>
        </section>
        
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader-child/js/script.js?ver=1.0" id="tktm-script-js"></script>
    <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader/assets/js/filter.js?ver=2.2.0" id="ts-filter-js"></script>
    <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/mangareader/assets/js/search-V2.js?ver=6.8.2" id="ts-search-js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const path = window.location.pathname;
            const match = path.match(/\/search\/([^\/]+)/);
            if (!match) return;

    const initialSlug = match[1]; // ambil keywords slug dari URL (one-piece)
    const initialQuery = initialSlug.replace(/-/g, " "); // ubah jadi "one piece"
    const container = document.querySelector("#search-lazyload");
    const searchInput = document.getElementById("search-main-query");

    if (!container) return;

    // isi input dengan nilai dari URL jika ada
    if (searchInput) searchInput.value = initialQuery;

    // State
    let typingTimer = null;
    let currentQuery = initialQuery;      // dipakai untuk request (dapat berubah saat user ketik)
    let currentOrderBy = "popular";      // default dropdown
    let currentOrderType = "desc";       // asc/desc toggle button
    let currentViewMode = "horizontal";  // list/grid

    // Utility: slugify (lowercase + dash)
    function toSlug(text) {
        return String(text).trim().toLowerCase().replace(/\s+/g, "-");
    }

    // Main loader: gunakan `query` kalau diberikan, kalau tidak fallback ke initialQuery
    function loadGenre(page = 1, query = "", orderby = currentOrderBy) {
        container.innerHTML = "<div style='width:100%; text-align:center;'>Loading...</div>";

        const formData = new FormData();
        formData.append("action", "advanced_search");
        // pakai query jika ada, kalau tidak pakai initialQuery
        const searchTermToSend = (query && query.trim() !== "") ? query.trim() : initialQuery;
        formData.append("search_term", searchTermToSend);
        formData.append("page", page);

        if (query) formData.append("query", query);
        if (orderby) formData.append("orderby", orderby);
        formData.append("order", currentOrderType); // asc/desc

        fetch("<?= $domain; ?>/proxy-kiru-genre.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(html => {
            container.innerHTML = html;

            // rebind pagination buttons inside returned html (if they use data-page)
            container.querySelectorAll("[data-page]").forEach(btn => {
                btn.addEventListener("click", function () {
                    const p = this.dataset.page;
                    if (p) loadGenre(p, currentQuery, currentOrderBy);
                });
            });
        })
        .catch(err => {
            container.innerHTML = "Error loading data";
            console.error(err);
        });
    }

    // ------------ INITIAL AUTO LOAD ------------
    // load page 1 memakai initialQuery (so One Piece langsung tampil)
    loadGenre(1, currentQuery, currentOrderBy);

    // ------------ SEARCH INPUT: keyup debounce & Enter behavior ------------
    if (searchInput) {
        // Debounced live search (typing)
        searchInput.addEventListener("keyup", function (e) {
            const val = this.value.trim();
            currentQuery = val;

            // If user pressed Enter, we redirect to /search/slug
            if (e.key === "Enter") {
                e.preventDefault();
                if (!val) return;
                const slug = toSlug(val);
                // Redirect to /search/slug (this reloads page and initial load will use slug)
                window.location.href = "<?= $domain; ?>/search/" + slug;
                return;
            }

            // Otherwise debounce live search
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                loadGenre(1, currentQuery, currentOrderBy);
            }, 400);
        });
    }

    // ------------ Pagination click (buttons that use addSingularFilter('page',...)) ------------
    document.body.addEventListener("click", function(e) {
        const btn = e.target.closest('button[onclick*="addSingularFilter(\'page\'"]');
        if (!btn) return;

        e.preventDefault();
        const onclickText = btn.getAttribute("onclick") || "";
        const matchPage = onclickText.match(/'page'\s*,\s*'(\d+)'/);
        if (!matchPage) return;

        const page = matchPage[1];
        loadGenre(page, currentQuery, currentOrderBy);
    });

    // ------------ Dropdown Order (Popular, Rating, Updated, etc) ------------
    // This function will be called by your existing onclick="window['orderByQuery']('popular', this)"
    window.orderByQuery = function(orderby, btn) {
        currentOrderBy = orderby;

        // update label dropdown (optional, keep it as your dropdown text)
        const nameEl = document.querySelector(".orderby-name");
        if (nameEl) nameEl.textContent = btn.textContent.trim();

        // close dropdown if needed
        const selector = document.getElementById("orderby-selector");
        if (selector) selector.setAttribute("data-show", "false");

        loadGenre(1, currentQuery, currentOrderBy);
    };

    // ------------ ASC / DESC Order Toggle Button (arrow) ------------
    const orderBtn = document.querySelector('button[onclick*="addSingularFilter"][onclick*="order"]');
    if (orderBtn) {
        const arrowIcon = orderBtn.querySelector("[data-lucide='arrow-down']");
        orderBtn.addEventListener("click", function (ev) {
            // toggle order type
            currentOrderType = currentOrderType === "desc" ? "asc" : "desc";
            // rotate icon for visual cue
            if (arrowIcon) arrowIcon.style.transform = currentOrderType === "desc" ? "rotate(0deg)" : "rotate(180deg)";
            // call load (do not change dropdown selection)
            loadGenre(1, currentQuery, currentOrderBy);
        });
    }

    // ------------ View Mode (horizontal / vertical) ------------
    const viewBtns = document.querySelectorAll('button[onclick*="changeShowMode"]');
    if (viewBtns.length) {
        window.changeShowMode = function(mode, btn) {
            currentViewMode = mode;
            viewBtns.forEach(b => b.dataset.selected = "false");
            btn.dataset.selected = "true";
            container.dataset.mode = mode; // apply mode to container; style via CSS
        };
    }

});
</script>

<script>
    lucide.createIcons();
</script>

</body>
</html>
