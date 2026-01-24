<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';
// echo $actual_link;



$judul = explode($domain.'/detail/', $actual_link);

if ($judul[1] != "") {
  $judul_fix = $judul[1];
  $link_html = $sumber_data.'/manga/'.$judul[1];


}elseif ($judul_episodes[1] != "") {
  $judul_fix = $judul_episodes[1];
  $link_html = $sumber_data.'/episodes/'.$judul_episodes[1];
}else{
 $judul = explode('play', $actual_link);
 $judul_fix = $judul[1];
 $link_html = $sumber_data.''.$judul[1].'/play';
}



// Ambil konten HTML dari situs
$html = file_get_contents($link_html);

// Buat DOM dan muat HTML-nya
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Hindari warning HTML tidak valid
$dom->loadHTML($html);
libxml_clear_errors();

// Ambil elemen <body>
$body = $dom->getElementsByTagName('body')->item(0);

// Ambil HTML dalam <body>
$result = $dom->saveHTML($body);



$judul_fix = explode('/', $judul[1]);
$judul_fix = explode('?', $judul_fix[0]);
// echo $sumber_data.'/'.$judul_fix[0];
$result = str_replace($sumber_data.'/'.$judul_fix[0], $domain.'/play/'.$judul_fix[0], $result);
$result = str_replace($sumber_data.'/manga', $domain.'/detail', $result);
$result = str_replace($sumber_data.'/tag', $domain.'/tag', $result);
$result = str_replace($sumber_data.'/nonton-film', $domain.'/play/nonton-film', $result);
$result = str_replace($sumber_data.'/genre', $domain.'/genres', $result);
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
$result = str_replace('//cq.synochaauca.com/r6yAy4NZbETqFs/57707', '', $result);
$result = preg_replace(
  '#/detail/([^"]*chapter-[^"/]*)/#', 
  '/play/$1/', 
  $result
);

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

  <div class="container detail">
    <section class="col-md-12">
      <?php echo $complete; ?>
    </section>

  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


  <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/static/js/htmx.min.js?ver=1.5.0" id="ts-tabs-js"></script>
  <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/static/js/_hyperscript.min.js?ver=1.5.0"></script>
  <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/static/js/solid.min.js?ver=1.5.0" id="ts-history_script-js"></script>
  <script type="module" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/assets/global-BeojbsWw.js?ver=1.5.0" id="kiru-module-global-js"></script>

  <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/static/js/brands.min.js?ver=1.5.0"></script>
  <script type="text/javascript" src="<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/assets/manga-DJoj72L2.js?ver=1.5.0" id="kiru-module-manga-js"></script>



  <script type="speculationrules"> {"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/*"},{"not":{"href_matches":["\/wp-*.php","\/wp-admin\/*","\/wp-content\/uploads\/*","\/wp-content\/*","\/wp-content\/plugins\/*","\/wp-content\/themes\/kiryuu\/*","\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]} </script>
  <script id="kiru-htmx-js-after"> var kiru = kiru || { ajaxUrl: '<?php echo $sumber_data; ?>/wp-admin/admin-ajax.php', emojiUrl: '<?php echo $sumber_data; ?>/wp-content/themes/kiryuu/static/data.json', prefersReducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches, isTouch: 'ontouchstart' in window || navigator.maxTouchPoints > 0, commentCooldown: Number('60'), }; </script>

  <script>
document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll('[role="tab"]');
  const panels = document.querySelectorAll('[role="tabpanel"]');
  const kiruLoaded = { chapters: false, novelChapters: false }; // ✅ per tab

  tabs.forEach(tab => {
    tab.addEventListener("click", function (e) {
      e.preventDefault();

      const key = this.getAttribute("data-key");

      // 🔄 Nonaktifkan semua tab & sembunyikan semua panel
      tabs.forEach(t => {
        t.setAttribute("aria-selected", "false");
        t.dataset.selected = "false";
      });
      panels.forEach(p => {
        p.setAttribute("data-focus", "false");
        p.classList.add("hidden");
      });

      // ✅ Aktifkan tab yang diklik
      this.setAttribute("aria-selected", "true");
      this.dataset.selected = "true";

      const activePanel = document.querySelector(`#tabpanel-${key}`);
      if (activePanel) {
        activePanel.setAttribute("data-focus", "true");
        activePanel.classList.remove("hidden");
      }

      // ⚙️ Jalankan fetch sesuai tab (cek per tab)
      if ((key === "chapters" || key === "novelChapters") && !kiruLoaded[key]) {
        kiruLoaded[key] = true;

        const match = document.documentElement.innerHTML.match(/manga_id=(\d+)/);
        const mangaID = match ? match[1] : null;
        if (!mangaID) return console.error("❌ manga_id tidak ditemukan.");

        // Tentukan URL berdasarkan tab
        let url = "";
        if (key === "novelChapters") {
          url = `<?php echo $domain; ?>/proxy-kiru.php?manga_id=${mangaID}&page=1&is_novel=1&action=chapter_list`;
        } else {
          url = `<?php echo $domain; ?>/proxy-kiru.php?manga_id=${mangaID}`;
        }

        // 🔄 Fetch data
        fetch(url)
          .then(res => res.text())
          .then(html => {
            const target = key === "novelChapters"
              ? document.querySelector("#novel-chapter-list")
              : document.querySelector("#chapter-list");

            if (target) {
              target.innerHTML = html;
              console.log(`✅ ${key} berhasil dimuat dari:`, url);
            } else {
              console.warn(`⚠️ Elemen target untuk ${key} tidak ditemukan.`);
            }
          })
          .catch(err => console.error(`❌ Gagal memuat ${key}:`, err));
      }
    });
  });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-more-less]').forEach(button => {
    button.addEventListener('click', () => {
      const wrapper = button.parentElement;
      const descs = wrapper.querySelectorAll('[itemprop="description"]');
      const label = button.querySelector('[data-name]');
      const icon  = button.querySelector('svg');

      // pastikan ada 2 description
      if (descs.length !== 2) return;

      const first  = descs[0];
      const second = descs[1];

      const firstShow = first.getAttribute('data-show') === 'true';

      if (firstShow) {
        // === SHOW MORE ===
        first.setAttribute('data-show', 'false');
        second.setAttribute('data-show', 'true');

        label.textContent = 'Show less';
        icon.classList.add('rotate-180');
      } else {
        // === SHOW LESS ===
        first.setAttribute('data-show', 'true');
        second.setAttribute('data-show', 'false');

        label.textContent = 'Show more';
        icon.classList.remove('rotate-180');
      }
    });
  });
});
</script>







  <script>
    lucide.createIcons();
  </script>




</body>
</html>
