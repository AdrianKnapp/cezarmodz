<link rel="stylesheet" href="assets/css/loader.css">

<div class="loader-wrapper">
  <div class="loader">Loading...</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
  $(window).on("load",function(){
      $(".loader-wrapper").fadeOut("slow");
  });
</script>