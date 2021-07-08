<link rel="stylesheet" href="assets/css/loader.css">
<div class="loader-wrapper">
  <span class="loader"><span class="loader-inner"></span></span>
</div>
<script src="assets/js/jquery.js"></script>
<script>
  $(window).on("load",function(){
      $(".loader-wrapper").fadeOut("slow");
  });
</script>