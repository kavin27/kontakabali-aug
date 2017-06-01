<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">	
		<title>It's Over Easy</title>	
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
		<link rel="stylesheet" href="static/css/theme.css">
		<link rel="stylesheet" href="static/css/custom.css">
		<style type="text/css">
			#error p {
				font-size: 16px;
				margin: 0;
				padding: 0;
				color: red;
			}
		</style>
		<script src="//www.google.com/recaptcha/api.js?render=explicit&onload=vcRecaptchaApiLoaded" async defer></script>
		
	</head>
	<body ng-controller="authCtrl">
		<div class="body">
			<header id="header" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}' style="min-height: 68px;" >
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
													<li class="dropdown"><a href="/">Home</a></li>
													<!-- <li class="dropdown"><a href="#!/priceComparison">Our Process</a></li> -->
													<li class="dropdown"><a href="home/ourProcess">Our Process</a></li>
													<li class="dropdown"><a href="#">Help</a></li>
													<li class="dropdown ble"><a href="/app">Sign In</a></li>		
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
						<h1>Log in</h1>
						<p>Welcome back! Please enter your<br>username and password to sign in.</p>
						<div class="col-md-12 login_form">
							<form id="loginForm">
								<div id="user">
									<input class="input_field user_name1" id="email" name="email" placeholder="Email Address" type="text" autocomplete="off" >
								</div>
								<div id="pwd">
									<input class="input_field" id="password" name="password" placeholder="Password" type="password" autocomplete="off">
								</div>
								<div id="error">
									
								</div>
								<div id="sub_btn">
									<input class="ioe_btn new" name="continue" value="Log In" type="submit">
								</div>
							</form>	
						</form>
						<p><a href="<?php echo base_url(); ?>#!/forgot_password">Forgot Password?</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
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
		<script src="static/js/jquery.min.js"></script>
		<script type="text/javascript">
			(function(){
				var loginForm = document.getElementById('loginForm');
				var loginInputs = loginForm.getElementsByTagName('input');
				var username = document.getElementById('email');
				username.addEventListener('keypress', function(){
					if(this.value != ''){
						this.classList.remove('error');
					}
				});
				var password = document.getElementById('password');
				password.addEventListener('keypress', function(){
					if(this.value != ''){
						this.classList.remove('error');
					}
				});
				loginForm.onsubmit = function(){
					var invalid = false;
					for (var i = 0, input; input = loginInputs[i]; i++) {
	            		if(input.type != 'submit'){
	            			if(input.value == ''){
	            				input.classList.add('error');
	            				invalid = true;
	            			}
	            			else{
	            				// validList[input.name] = true;
	            			}
	            		}
	            	}
	            	if(!invalid){
	            		var xhttp;
						if (window.XMLHttpRequest) {
					    	xhttp = new XMLHttpRequest();
					    } else {
					    	// code for IE6, IE5
					    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xhttp.onreadystatechange = function() {
					    	if (this.readyState == 4 && this.status == 200) {
					    		var result = JSON.parse(xhttp.response);
					    		if(result.status == 'SUCCESS'){
					    			location.reload();
					    		}
					    		else{
					    			document.getElementById('error').innerHTML = result.message;
					    		}
					    	}
					  	};
					  	var Data = new FormData();
					  	Data.append('username', username.value);
					  	Data.append('password', password.value);
					  	xhttp.open("POST", '<?php echo base_url(); ?>home/login', true);
					  	//xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						xhttp.send(Data);
					}
					return false;
				}
			})();
		</script>
	</body>
</html>