<header class="header-manga p-3 bg-dark text-white">
  <div class="container">
    <div class="d-flex menu-resp flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="<?php echo $domain; ?>" class="logo-resp d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
        <img class="bi me-2" height="50" role="img" aria-label="Bootstrap" src="<?php echo $domain; ?>/img/<?php echo $logo; ?>">
      </a>

      <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="<?php echo $domain; ?>" class="nav-link px-2 text-white">HOME</a></li>
        <li><a href="<?php echo $domain; ?>/manga-list" class="nav-link px-2 text-white">POPULER</a></li>
        <li><a href="<?php echo $domain; ?>/manga-list/ongoing" class="nav-link px-2 text-white">ONGOING</a></li>
        <li><a href="<?php echo $domain; ?>/manga-list/on-hiatus" class="nav-link px-2 text-white">ON-HIATUS</a></li>
        <li><a href="<?php echo $domain; ?>/manga-list/completed" class="nav-link px-2 text-white">COMPLETED</a></li>

        <!-- <li><a href="<?php echo $domain; ?>/detail/list-mode" class="nav-link px-2 text-white">LIST MODE</a></li>       -->
      </ul>

      <form id="search-form" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
        <div class="input-group mb-3">
          <input type="search" class="form-control search-input" style="margin:0px;" id="search-input" placeholder="Search..." aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</header>


<script>
  document.getElementById("search-form").addEventListener("submit", function(e) {
    e.preventDefault();

    const keyword = document.getElementById("search-input").value.trim();

    if (!keyword) return;

    // replace spasi jadi dash/hyphen supaya rapi di URL
    const slug = keyword.replace(/\s+/g, "-");

    // redirect ke format /search/keyword
    window.location.href = "<?= $domain; ?>/search/" + slug;
  });
</script>




<!-- ADS   ADS   ADS   ADS  ADS   ADS   ADS   ADS -->
<!-- ADS   ADS   ADS   ADS  ADS   ADS   ADS   ADS -->




<!-- BANNER ATAS / DI BAWAH HEADER -->
<div class="container adsban-manga" style="margin-bottom:20px;">
  <div class="row">
    <div class="col-md-6">

      <!-- BANNER KIRI : PASTE DI BAWAH INI -->
      

      <!-- END BANNER KIRI -->

    </div>
    <div class="col-md-6">

      <!-- BANNER KANAN : PASTE DI BAWAH INI -->
      


      <!-- END BANNER KANAN -->

    </div>
  </div>
</div>
<!-- END BANNER ATAS / DI BAWAH HEADE -->






<!-- BANNER POPUP : PASTE DI BAWAH INI -->
<div id="floatPopup" class="ads-popup-fixed">

  <!-- IKLAN POPUP : PASTE DI BAWAH INI -->


  <!-- END IKLAN POPUP -->

</div>
<!-- END BANNER POPUP -->





<!-- BANNER BAWAH FIXED -->
<div class="ads-fixed-bottom">

  <!-- IKLAN BANNER BAWAH : PASTE DI BAWAH INI -->
  

  <!-- END IKLAN BANNER BAWAH -->

</div>
<!-- END BANNER BAWAH FIXED -->
