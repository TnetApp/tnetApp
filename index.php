<?php require 'header.php'; ?>
<div class="preload">
	<div class="logo">
		<img src="images/logo.png" class="logo-icon">
			</div>
			<div class="loader-frame" id="preloader_spinner">
			<div class="loader1" id="loader1"></div>
		<div class="loader2" id="loader2"></div>
	</div><br>
<p class="text-success text-center text-bold loading">Loading ...</p>
</div>
<script type="text/javascript">
	//Preloader and Spinner 
(function(){
		var preload = document.getElementById('preload');
		var loading = 0;
		var id = setInterval(frame, 64);
		function frame() {
			if (loading == 100) {
				clearInterval(id);
				window.open("login.php", "_self");
			}else{
				loading = loading +1;
				if (loading == 90) {
					preload.style.animation = "fadeout 1s ease";
				}
			}
		}
	})();
</script>
