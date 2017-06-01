<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../../static/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../static/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../../static/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="../../static/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="../../static/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="../../static/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="../../static/vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="../../static/css/theme.css">
		<link rel="stylesheet" href="../../static/css/theme-elements.css">
		<link rel="stylesheet" href="../../static/css/theme-blog.css">
		<link rel="stylesheet" href="../../static/css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="../../static/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="../../static/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="../../static/vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="../../static/vendor/circle-flip-slideshow/css/component.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="../../static/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../../static/css/custom.css">

		<!-- Head Libs -->
		<script src="../../static/vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body>

		<div class="body">
			<header id="header" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}'>
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="index.html">
										<img alt="IOE" width="auto" height="auto" src="../../static/img/logo.png">
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
													<li class="dropdown"><a href="index.html">Home</a></li>
													<li class="dropdown"><a href="index.html">Dashboard</a></li>
													<li class="dropdown"><a href="index.html">Our Process</a></li>
													<li class="dropdown"><a href="index.html">Help</a></li>		
													<li class="dropdown"><img src="../../static/img/nl/login_cir.png" alt="login_cir"></li>									
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

			<div role="main" class="main">
				<div class="login_area">				
				<div class="container">
					<?php 
					if(isset($status)){
						?>
						<p><?php echo $message; ?></p>
						<?php
					}
					else{
					?>
						<h1>Reset Your Password</h1>
						<p>Enter your new password</p>
						<div class="col-md-12 login_form">	
							<form name="form_1" method="post" action="<?php echo base_url(); ?>api/auth/confirmChangePassword">
								<input type="hidden" name="email" value="<?php echo $email; ?>">
								<input type="hidden" name="key" value="<?php echo $key; ?>">
								<input class="input_field user_name1" name="password" placeholder="Password" type="password">
								<input class="input_field" name="rpassword" placeholder="Re-enter Password" type="password">
								<input class="ioe_btn new" name="continue" value="Reset" type="submit">
							</form>
						</div>
					<?php 
					}	
					?>
					</div>
				</div>

			</div>

		</div>

		<!-- Vendor -->
		<script src="../../static/vendor/jquery/jquery.min.js"></script>
		<script src="../../static/vendor/jquery.appear/jquery.appear.min.js"></script>
		<script src="../../static/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="../../static/vendor/jquery-cookie/jquery-cookie.min.js"></script>
		<script src="../../static/vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="../../static/vendor/common/common.min.js"></script>
		<script src="../../static/vendor/jquery.validation/jquery.validation.min.js"></script>
		<script src="../../static/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
		<script src="../../static/vendor/jquery.gmap/jquery.gmap.min.js"></script>
		<script src="../../static/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
		<script src="../../static/vendor/isotope/jquery.isotope.min.js"></script>
		<script src="../../static/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="../../static/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
		<script src="../../static/vendor/vide/vide.min.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="../../static/js/theme.js"></script>
		
		<!-- Current Page Vendor and Views -->
		<script src="../../static/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
		<script src="../../static/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="../../static/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
		<script src="../../static/js/views/view.home.js"></script>
		
		<!-- Theme Custom -->
		<script src="../../static/js/custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="../../static/js/theme.init.js"></script>

	</body>
</html>
