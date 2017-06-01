<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en" ng-app="project">
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	
		<title>It's Over Easy</title>	
		<meta name="keywords" content="HTML5 Template" />
		<meta name="description" content="Porto - Responsive HTML5 Template">
		<meta name="author" content="okler.net">
		<!-- Favicon -->
		<link rel="shortcut icon" href="../static/img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="../static/img/apple-touch-icon.png">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- Web Fonts  -->
	 	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css"> 
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="../static/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../static/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="../static/css/jquery-ui.min.css">
		
		<link rel="stylesheet" href="../static/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="../static/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<!-- <link rel="stylesheet" href="static/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="static/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="static/vendor/magnific-popup/magnific-popup.min.css"> -->
		<!-- Theme CSS -->
		<link rel="stylesheet" href="../static/css/theme.css">
		<!-- <link rel="stylesheet" href="static/css/theme-elements.css">
		<link rel="stylesheet" href="static/css/theme-blog.css">
		<link rel="stylesheet" href="static/css/theme-shop.css"> -->
		<link rel="stylesheet" href="../static/css/v-accordion.css">
		<link rel="stylesheet" href="../static/css/toaster.css">
		<link rel="stylesheet" href="../static/css/select2.css">
		<link rel="stylesheet" href="../static/css/select.css">
		<link rel="stylesheet" href="../static/css/jquery.mCustomScrollbar.min.css">
		<link rel="stylesheet" href="../static/css/angular-material.min.css">
		<link rel="stylesheet" href="../static/js/scroll/ng-scrollbar.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
		<!-- Current Page CSS -->
		<!-- <link rel="stylesheet" href="static/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="static/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="static/vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="static/vendor/circle-flip-slideshow/css/component.css"> -->
		<link rel="stylesheet" type="text/css" href="../static/js/fullcalendar/dist/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="../static/css/date-picker/angular-datepicker.css">
		<!-- Skin CSS -->
		<!-- <link rel="stylesheet" href="static/css/skins/default.css">
		<link rel="stylesheet" href="static/css/style.css"> -->
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../static/css/custom.css">
		<!-- Head Libs -->
		<!-- <script src="static/vendor/modernizr/modernizr.min.js"></script> -->
		<script src="//www.google.com/recaptcha/api.js?render=explicit&onload=vcRecaptchaApiLoaded" async defer></script>
		<script>
		var BASE_URL = "<?php echo base_url(); ?>";
		</script>
	</head>
	<body ng-controller="authCtrl">
		<div class="body">
			<header id="header" ng-controller="authCtrl" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}' style="min-height: 68px;" >
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="/">
										<img alt="Porto" width="auto" src="../static/img/logo.png">
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
													<!--<li ng-repeat="menua in menu" class="dropdown {{ ::menua.class}}">
														<a href="#">{{ ::menua.title}}</a>
													</li> -->
													<li class="dropdown"><a href="/">Home</a></li>
													<li ng-if="authenticated" class="dropdown"><a href="#!/dashboard">Dashboard</a></li>
													<!-- <li class="dropdown"><a href="#!/priceComparison">Our Process</a></li> -->
													<li class="dropdown"><a href="">Our Process</a></li>
													<li class="dropdown"><a href="#">Help</a></li>
													<li ng-if="authenticated" class="dropdown green">
														<!-- <a href="" ng-click="doLogout()">SAVE & LOG OUT</a> -->
														<a href="home/logout">SAVE & LOG OUT</a>
													</li>		
													<li ng-if="!authenticated" class="dropdown ble"><a href="/app">Sign In</a></li>		
													<li ng-if="authenticated" class=" avatar_icon">
														<a data-toggle="dropdown" data-close-others="true" ng-init="loadProfile()">
															<img ng-src="{{'../static/img/icons/avatar/'+profilePic+'.png'}}" height="42px" width="42px">
														</a>
														<ul class="dropdown-menu pull-right">
															<h1>Choose Your Avatar</h1>
						                                    <li>
						                                        <a ng-click="changeProfile(1)">
						                                        	<img src="../static/img/icons/avatar/1.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(2)">
						                                        	<img src="../static/img/icons/avatar/2.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(3)">
						                                        	<img src="../static/img/icons/avatar/3.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(4)">
						                                        	<img src="../static/img/icons/avatar/4.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(5)">
						                                        	<img src="../static/img/icons/avatar/5.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(6)">
						                                        	<img src="../static/img/icons/avatar/6.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(7)">
						                                        	<img src="../static/img/icons/avatar/7.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(8)">
						                                        	<img src="../static/img/icons/avatar/8.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(9)">
						                                        	<img src="../static/img/icons/avatar/9.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(10)">
						                                        	<img src="../static/img/icons/avatar/10.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(11)">
						                                        	<img src="../static/img/icons/avatar/11.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(12)">
						                                        	<img src="../static/img/icons/avatar/12.png">
						                                        </a>
						                                    </li>
						                                    <!--<li class="logOut"><a href="" ng-click="doLogout()">Log out</a></li>-->
						                                </ul>
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
			<div >
				<md-content>
    <md-tabs md-dynamic-height="" md-align-tabs="bottom" md-selected="welcomeStep">
      <md-tab label="How The Process Works">
        <md-content class="md-padding">
          <div class="container">
			<div class="col-md-4">
				<div class="step_img_sec"><img src="../static/img/nl/step1.png" alt="step"></div>
				<h6>STEP 1</h6>
				<p>The first step in filing for divorce is to submit an initial divorce petition to the state of California. Since you are the person requesting the divorce, you will be called <b>“the Petitioner”</b>.</p>
			</div>
			<div class="col-md-4">
				<div class="step_img_sec"><img src="../static/img/nl/step2.png" alt="step"></div>
				<h6>STEP 2</h6>
				<p>After the court receives the petition, your spouse, called <b>“the Respondent”,</b> is required to respond to your request. Next, you both will have 6 months from the date the petition is filed to reach agreement on the financials terms of your divorce, regarding spousal support and child support. </p>					
			</div>

			<div class="col-md-4">
				<div class="step_img_sec"><img src="../static/img/nl/step3.png" alt="step"></div>
				<h6>STEP 3</h6>
				<p>Finally, the last stage of your divorce requires you and your spouse to reach agreement on all terms,determine the final outcome on any outstanding issues. The final divorce judgement is issued once all terms including child custody and the division of community property. If you cannot reach agreement the court will are decided. </p>		
			</div>
			<div class="col-md-12 step_last_para">
				<p>This process will assist you in generating the required legal forms necessary to obtain a divorce.</p>
			</div>
		</div>
        </md-content>
      </md-tab>
      <md-tab label="Price Comparison">
        <md-content class="md-padding">
          <div class="container">
			<div class="col-md-4">
				<div class="price_area">
					<div class="pack_sec">
						<h4>Trial</h4>
						<button type="button" class="sign_btn">Sign Up</button>
						<ul>
							<li>
								Articles, updates and news
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>
								Full access to all forms 
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>
								Forms for both spouses
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>
								Co-parenting resources 
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>
								Community property allocation tools 
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>
								Spousal support tools
								<div class="tooltip ">
									<i class="fa fa-info" aria-hidden="true"></i>
									<span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
										curabitur tellus molestie
										nec, eu nulla nullam, sit
										pulvinar etiam amet.
									</span>
								</div>
							</li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>								<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
						</ul>
						<h5>Free</h5>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="price_area">
					<div class="pack_sec">
						<h4>Member</h4>
						<button type="button" class="sign_btn">Sign Up</button>
						<ul>
							<li>Free 45 minute phone consultation with It’s Over Easy<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Articles, updates and news<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Full access to all forms <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Forms for both spouses <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Co-parenting resources <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Community property allocation tools <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Temporary separation agreement <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Divorce Judgement Upon Agreement of both Spouses <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Pro tips <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Split payments <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Free delivery of forms to court  <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
							<li>&nbsp;<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i></div></li>
						</ul>
						<h5>&#x24;750 <span>(does not include filing fees)</span></h5>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="price_area">
					<div class="pack_sec">
						<h4>Premium</h4>
						<button type="button" class="sign_btn">Sign Up</button>
						<ul>
							<li>Free 90 minute phone consultation with It’s Over Easy <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Articles, updates and news <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Full access to all forms <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Forms for both spouses <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Co-parenting resources <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Community property allocation tools<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Temporary separation agreement<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Divorce Judgement Upon Agreement of both Spouses<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Pro tips<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Split payments<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Submit forms to court<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Form Accuracy Review<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Free delivery of forms to court<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
							<li>Includes filing fees <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
							curabitur tellus molestie
							nec, eu nulla nullam, sit
							pulvinar etiam amet.</span></div></li>
						</ul>
						<h5>&#x24;3,200</h5>
					</div>
				</div>
			</div>
		</div>
        </md-content>
      </md-tab>
      <md-tab label="Promo Video">
        <md-content class="">
			<div class="video_sec_aArea">
				<iframe src="https://player.vimeo.com/video/183514621" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			</div>
			<!-- <div class="slider-container rev_slider_wrapper" style="z-index: 99;">
     <div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"delay": 9000, "gridwidth": 1200, "gridheight": 690, "disableProgressBar": "on"}'>
      <ul>
       -->
       <!--THIRD SLIDER STARTS -->
       
      <!--  <li data-index="rs-23" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="" class="tp-revslider-slidesli rs-pause-timer-always active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 20; visibility: inherit; opacity: 1; background-color: rgba(255, 255, 255, 0);"> -->
  <!-- MAIN IMAGE -->
  <!-- <div class="slotholder" style="position: absolute; top: 0px; left: 0px; z-index: 0; width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"> --><!--Runtime Modification - Img tag is Still Available for SEO Goals in Source - <img src="http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png" style="background-color:#707070" alt="" title="Home" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg defaultimg" data-no-retina="">--><!-- <div class="tp-bgimg defaultimg" style="background-color: rgb(112, 112, 112); background-repeat: no-repeat; background-image: url(&quot;http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png&quot;); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit; z-index: 20;" src="http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png"></div></div> -->
  <!-- LAYERS -->

  <!-- LAYER NR. 1 -->
  <!-- <div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 0px; top: 0px; z-index: 5;"><div class="tp-loop-wrap" style="position:absolute;"><div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;"><div class="tp-caption   tp-resizeme tp-videolayer HasListener coverscreenvideo rs-apiready" id="slide-23-layer-1" data-x="0" data-y="0" data-transform_idle="o:1;" data-transform_in="opacity:0;s:300;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="500" data-responsive_offset="on" data-vimeoid="84" data-videoattributes="title=0&amp;byline=0&amp;portrait=0&amp;api=1" data-videowidth="100%" data-videoheight="100%" data-videoloop="none" data-forcecover="1" data-aspectratio="16:9" data-autoplay="on" data-videoposter="http://yourdemo.live/reid-insurance/wp-content/uploads/2016/12/135.jpg" data-noposteronmobile="off" data-volume="100" style="z-index: 5; visibility: inherit; width: 1349px; height: 492px; transition: none 0s ease 0s ; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px;"> <div class="tp-videoposter noSwipe" style="cursor: pointer; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 3; background-image: url(&quot;http://yourdemo.live/reid-insurance/wp-content/uploads/2016/12/135.jpg&quot;); background-size: cover; background-position: center center; transition: none 0s ease 0s ; line-height: 18px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; visibility: hidden; opacity: 0; transform: matrix(1, 0, 0, 1, 0, 0);"></div><iframe style="position: absolute; left: 0px; top: -27.1151%; width: 100%; height: 154.23%; display: block; visibility: inherit; opacity: 1;" src="https://player.vimeo.com/video/183514621?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0&amp;api=1&amp;player_id=iframe43328&amp;api=1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" class="resizelistener" id="iframe43328" width="100%" height="100%"></iframe></div></div></div></div>
 </li> -->
       <!--THIRD SLIDER ENDS -->
      <!--  
      </ul>
     </div>
    </div> -->
        </md-content>
      </md-tab>
    </md-tabs>
  </md-content>
<div class='tab-nav'>
	<span class='next' ng-click ="nextStep()"></span>
	<span class='prev' ng-click ="previousStep()"></span>
</div>	

<div class="btn_sec_are">
	<div class="container">
		<div class="btn12_sec">
			<button type="button">Have a question for an attorney?</button>  
			<a href="/app/"><button type="button">Continue</button> </a>
		</div>
	</div>
</div>


		    </div>
		</div>
<script type="text/ng-template" id="custom-datepicker.html">
	<div class="enhanced-datepicker">
	    <div class="proxied-field-wrap">
	        <input type="text" ui-date-format="mm/dd/yy" ng-model="ngModel" ui-date="dateOptions"/>
	    </div>
	</div>
</script>
	<toaster-container toaster-options="{'time-out': 3000}" style="left: 50%; margin-left: -150px; "></toaster-container>
	<script src="../static/js/jquery.min.js"></script>
	<script src="../static/js/jquery-ui.min.js"></script>
	<script src="../static/js/select2.js"></script>
	<script src="../static/js/angular.js"></script>
	<script src="../static/js/angular-resource.min.js"></script>
	<script src="../static/js/angular-route.min.js"></script>
  	<script src="../static/js/angular-animate.min.js" ></script>
  	<script src="../static/js/v-accordion.js" ></script>
  	<script src="../static/js/angular-ui-select2/select2.js" ></script>
  	<script src="../static/js/angular-recaptcha.js" ></script>
  	<script src="../static/js/angular-animate.js" ></script>
  	<script src="../static/js/angular-aria.js" ></script>
  	<script src="../static/js/angular-material.js" ></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  	<script src="../static/js/ngMask.min.js" ></script>
	<script src="../static/js/toaster.js"></script>
	<script src="../static/js/bootstrap.min.js"></script>
	<script src="../static/js/angular-file-upload.js"></script>
	<script src="../static/js/ng-file-upload.js"></script>
	<script src="../static/js/moment/moment.js"></script>
	<script src="../static/js/fullcalendar/dist/fullcalendar.js"></script>
	<script src="../static/js/angular-moment.min.js"></script>
	<!-- <script src="static/js/scroll/ng-scrollbar.js"></script> -->
	<script src="../static/js/angular-drag-and-drop-lists.js"></script>
	<script src="../static/js/contextMenu.js"></script>
	<script src="../static/js/calendar.js"></script>
	<script src="../static/js/date-picker/angular-datepicker.js"></script>
	<script src="../static/js/ui-bootstrap-tpls.js"></script>	
	<script src="../static/js/png-time-input.js"></script>	
	<script src="../static/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="../static/js/scrollbars.min.js"></script>
	<script src="../static/js/date.js"></script>
	<script src="../static/js/app.js"></script>
	<script type="text/javascript">
    var APP_ID = "wck7ioip";
	window.intercomSettings = {
    	app_id: APP_ID
  	};
	(function(){
		var w=window;
		var ic=w.Intercom;
		if(typeof ic==="function"){
			ic('reattach_activator');
			ic('update',intercomSettings);
		}else{
			var d=document;
			var i=function(){
				i.c(arguments)};
				i.q=[];
				i.c=function(args){
					i.q.push(args)
				};
				w.Intercom=i;
				function l(){
					var s=d.createElement('script');
					s.type='text/javascript';
					s.async=true;
					s.src='https://widget.intercom.io/widget/' + APP_ID;
					var x=d.getElementsByTagName('script')[0];
					x.parentNode.insertBefore(s,x);
				}
				if(w.attachEvent){
					w.attachEvent('onload',l);
				}else{
					w.addEventListener('load',l,false);
				}
			}
		})()
  </script>
	<style type="text/css">
		#intercom-container .intercom-launcher-frame{
			bottom: 75px !important;
			right: 35px !important;
		}
		#intercom-container .intercom-app-launcher-enabled .intercom-messenger-frame{
			bottom: 145px !important;
		}
	</style>
	
	</body>
</html>
