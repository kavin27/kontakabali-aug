<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$email = $_REQUEST['email'];
$key = $_REQUEST['key'];
$fields = array(
	'email' => $email, 
	'key' => $key
	);

$ch = curl_init();
    
foreach ( $fields as $key => $value) {
 $fields2[] = $key . '=' . $value;
}
$fields2 = implode ('&', $fields2);
curl_setopt($ch, CURLOPT_URL, base_url() . "api/auth/activate");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$server_output = curl_exec ($ch);
$result = json_decode($server_output);
curl_close ($ch);
if($result->status == 'SUCCESS'){
	redirect(base_url()."#/login");
}
else{
	?>
	<!DOCTYPE html>
<html>
	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	

		<title>It's Over Easy</title>	

		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>static/img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="<?php echo base_url(); ?>static/img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/theme.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/theme-elements.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/theme-blog.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/vendor/circle-flip-slideshow/css/component.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>static/css/custom.css">

		<!-- Head Libs -->
		<script src="<?php echo base_url(); ?>static/vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>
	<div class="body welcome_process">
			<header id="header" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}'>
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="<?php echo base_url(); ?>#/">
										<img alt="IOE" width="auto" height="auto" src="<?php echo base_url(); ?>static/img/logo.png">
									</a>
								</div>
							</div>
							<div class="header-column">
								<div class="header-row">
									<div class="header-nav">
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main">
											<i class="fa fa-bars"></i>
										</button>
										<!--<ul class="header-social-icons social-icons hidden-xs">
											<li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a></li>
											<li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a></li>
											<li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
										</ul>-->
										<div class="header-nav-main header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
											<nav>
												<ul class="nav nav-pills" id="mainNav">
													<li class="dropdown"><a href="<?php echo base_url(); ?>">Home</a></li>
													<li class="dropdown"><a href="<?php echo base_url(); ?>#/dashboard">Dashboard</a></li>
													<li class="dropdown"><a href="#">Our Process</a></li>
													<li class="dropdown"><a href="#">Help</a></li>		
													<li>
														<a href="#">
															<img src="<?php echo base_url(); ?>static/img/nl/egg_green.png" alt="egg_green">							
														</a>
													</li>
														
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
<h1 style='position: absolute; top: 50%; left: 50%; margin-left: -150px;'>" <?php echo $result->message; ?>"</h1>;
</div>
<!-- Vendor -->
		<script src="<?php echo base_url(); ?>static/vendor/jquery/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/common/common.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="<?php echo base_url(); ?>static/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="<?php echo base_url(); ?>static/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="<?php echo base_url(); ?>static/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
		<script src="<?php echo base_url(); ?>static/js/views/view.home.js"></script>
		
		<!-- Theme Custom -->
		<script src="<?php echo base_url(); ?>static/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="<?php echo base_url(); ?>static/js/theme.init.js"></script>

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

	</body>
</html>

	<?php 
}


exit;
?>

