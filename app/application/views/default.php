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
		<link rel="shortcut icon" href="static/img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="static/img/apple-touch-icon.png">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- Web Fonts  -->
	 	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css"> 
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="static/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="static/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="static/css/jquery-ui.min.css">
		
		<link rel="stylesheet" href="static/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="static/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<!-- <link rel="stylesheet" href="static/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="static/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="static/vendor/magnific-popup/magnific-popup.min.css"> -->
		<!-- Theme CSS -->
		<link rel="stylesheet" href="static/css/theme.css">
		<!-- <link rel="stylesheet" href="static/css/theme-elements.css">
		<link rel="stylesheet" href="static/css/theme-blog.css">
		<link rel="stylesheet" href="static/css/theme-shop.css"> -->
		<link rel="stylesheet" href="static/css/v-accordion.css">
		<link rel="stylesheet" href="static/css/toaster.css">
		<link rel="stylesheet" href="static/css/select2.css">
		<link rel="stylesheet" href="static/css/select.css">
		<link rel="stylesheet" href="static/css/jquery.mCustomScrollbar.min.css">
		<link rel="stylesheet" href="static/css/angular-material.min.css">
		<link rel="stylesheet" href="static/js/scroll/ng-scrollbar.css">
		<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
		<!-- Current Page CSS -->
		<!-- <link rel="stylesheet" href="static/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="static/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="static/vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="static/vendor/circle-flip-slideshow/css/component.css"> -->
		<link rel="stylesheet" type="text/css" href="static/js/fullcalendar/dist/fullcalendar.css">
		<link rel="stylesheet" type="text/css" href="static/css/date-picker/angular-datepicker.css">
		<!-- Skin CSS -->
		<!-- <link rel="stylesheet" href="static/css/skins/default.css">
		<link rel="stylesheet" href="static/css/style.css"> -->
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="static/css/custom.css">
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
										<img alt="Porto" width="auto" src="static/img/logo.png">
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
													<li class="dropdown"><a href="home/ourProcess">Our Process</a></li>
													<li class="dropdown"><a href="#">Help</a></li>
													<li ng-if="authenticated" class="dropdown green">
														<!-- <a href="" ng-click="doLogout()">SAVE & LOG OUT</a> -->
														<a href="home/logout">SAVE & LOG OUT</a>
													</li>		
													<li ng-if="!authenticated" class="dropdown ble"><a href="/app">Sign In</a></li>		
													<li ng-if="authenticated" class=" avatar_icon">
														<a data-toggle="dropdown" data-close-others="true" ng-init="loadProfile()">
															<img ng-src="{{'static/img/icons/avatar/'+profilePic+'.png'}}" height="42px" width="42px">
														</a>
														<ul class="dropdown-menu pull-right">
															<h1>Choose Your Avatar</h1>
						                                    <li>
						                                        <a ng-click="changeProfile(1)">
						                                        	<img src="static/img/icons/avatar/1.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(2)">
						                                        	<img src="static/img/icons/avatar/2.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(3)">
						                                        	<img src="static/img/icons/avatar/3.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(4)">
						                                        	<img src="static/img/icons/avatar/4.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(5)">
						                                        	<img src="static/img/icons/avatar/5.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(6)">
						                                        	<img src="static/img/icons/avatar/6.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(7)">
						                                        	<img src="static/img/icons/avatar/7.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(8)">
						                                        	<img src="static/img/icons/avatar/8.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(9)">
						                                        	<img src="static/img/icons/avatar/9.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(10)">
						                                        	<img src="static/img/icons/avatar/10.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(11)">
						                                        	<img src="static/img/icons/avatar/11.png">
						                                        </a>
						                                    </li>
						                                    <li>
						                                        <a ng-click="changeProfile(12)">
						                                        	<img src="static/img/icons/avatar/12.png">
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
				<!--<div ng-view></div> -->
				<route-loading-indicator></route-loading-indicator>
				<div data-ng-view="" id="ng-view" class="slide-animation"></div>

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
	<script src="static/js/jquery.min.js"></script>
	<script src="static/js/jquery-ui.min.js"></script>
	<script src="static/js/select2.js"></script>
	<script src="static/js/angular.js"></script>
	<script src="static/js/angular-resource.min.js"></script>
	<script src="static/js/angular-route.min.js"></script>
  	<script src="static/js/angular-animate.min.js" ></script>
  	<script src="static/js/v-accordion.js" ></script>
  	<script src="static/js/angular-ui-select2/select2.js" ></script>
  	<script src="static/js/angular-recaptcha.js" ></script>
  	<script src="static/js/angular-animate.js" ></script>
  	<script src="static/js/angular-aria.js" ></script>
  	<script src="static/js/angular-material.js" ></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  	<script src="static/js/ngMask.min.js" ></script>
	<script src="static/js/toaster.js"></script>
	<script src="static/js/bootstrap.min.js"></script>
	<script src="static/js/angular-file-upload.js"></script>
	<script src="static/js/ng-file-upload.js"></script>
	<script src="static/js/moment/moment.js"></script>
	<script src="static/js/fullcalendar/dist/fullcalendar.js"></script>
	<script src="static/js/angular-moment.min.js"></script>
	<!-- <script src="static/js/scroll/ng-scrollbar.js"></script> -->
	<script src="static/js/angular-drag-and-drop-lists.js"></script>
	<script src="static/js/contextMenu.js"></script>
	<script src="static/js/calendar.js"></script>
	<script src="static/js/date-picker/angular-datepicker.js"></script>
	<script src="static/js/ui-bootstrap-tpls.js"></script>	
	<script src="static/js/png-time-input.js"></script>	
	<script src="static/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="static/js/scrollbars.min.js"></script>
	<script src="static/js/date.js"></script>
	<script src="static/js/app.js"></script>
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