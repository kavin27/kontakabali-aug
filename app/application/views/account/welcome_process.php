<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div role="main" class="main">
	<div class="login_area tell_us">				
		<div class="container">
			<h1>Welcome</h1>
			<p>Tell us why you are getting divorced.<br>This information will never be shared with your spouse.</p>
			<div class="email_unbranded_out1">
				<span class="chr_txt">Characters left: {{5000-welcome_data.length}}</span>
				<form method="post">
					<textarea name="welcome_data" ng-model="welcome_data" maxlength="5000"></textarea>
					<div class="btn_lt"><input type="submit" name="skip" ng-click="saveWelcome('Skiped')" value="Skip This Step"></div>
					<div class="btn_rt"><input type="submit" name="submit" ng-click="saveWelcome(welcome_data)" value="Submit"></div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="popup" data-popup="popup-1" style="display: block; overflow: scroll; z-index: 99999;"> 
	<div class="popup-inner">
		<div class="popup_sec">
			<h1>Welcome</h1>
			<iframe src="https://player.vimeo.com/video/204249783/" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" width="640" frameborder="0" height="300"></iframe>
			<p>If you are experiencing domestic violence or have concerns about child abduction, you should contact an attorney or your local authorities.  Our service is intended for uncontested divorces wherein both spouses are able to come to a mutual agreement on the terms of their divorce.</p>
			<button type="button" data-popup-close="popup-1">Continue</button>
		</div>
		<a class="popup-close" data-popup-close="popup-1" >x</a>
	</div>
</div>
	<!--popup section ends -->



<script type="text/javascript">
	$(document).ready(function(){
		$(function() {
//----- OPEN
	    $('[data-popup-open]').on('click', function(e)  {
	        var targeted_popup_class = jQuery(this).attr('data-popup-open');
	        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
	 
	        e.preventDefault();
	    });
	 
	    //----- CLOSE
	    $('[data-popup-close]').on('click', function(e)  {
	        var targeted_popup_class = jQuery(this).attr('data-popup-close');
	        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
	 
	        e.preventDefault();
	    });
	});
	});
</script>