<!DOCTYPE html>
<html>
	<head>
	<?php Loader::element('header_required'); ?>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
		<link rel="apple-touch-icon" href="img/apple-touch-icon.png">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Web Fonts  -->
		<!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">-->

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/animate/animate.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/magnific-popup/magnific-popup.min.css">
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/theme.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/theme-elements.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/theme-blog.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/vendor/circle-flip-slideshow/css/component.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo $this->getThemePath(); ?>/css/custom.css">

		<!-- Head Libs -->
		<!-- <script src="<?php echo $this->getThemePath(); ?>/vendor/modernizr/modernizr.min.js"></script> -->

	</head>
	<body>
	<div class="<?php $c->getPageWrapperClass()?>">
		<div class="body">
			<header id="header" class="header-narrow header-full-width" data-plugin-options='{"stickyEnabled": true, "stickyEnableOnBoxed": true, "stickyEnableOnMobile": true, "stickyStartAt": 0, "stickySetTop": "0"}'>
				<div class="header-body">
					<div class="header-container container">
						<div class="header-row">
							<div class="header-column">
								<div class="header-logo">
									<a href="index.html">
										<img alt="IOE" width="auto" height="auto" src="<?php echo $this->getThemePath(); ?>/img/logo.png">
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
													<li class="dropdown"><a href="./">Home</a></li>
													<li class="dropdown"><a href="app/home/ourProcess">Our Process</a></li>
													<li class="dropdown"><a href="#">Help</a></li>
													<li class="dropdown ble"><a href="app">Sign In</a></li>													
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


				
			<div role="main" class="main" id="ban">
				<!--<div style="background: #565656; text-align: center;position: relative;z-index: 99;"><img src="img/nl/homepage_banner_img.png" alt="homepage_banner_img" class="temp_banner"></div>-->
				<div class="slider-container rev_slider_wrapper" style="z-index: 99;">
					<div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"delay": 9000, "gridwidth": 1200, "gridheight": 690, "disableProgressBar": "on"}'>
						<ul>
						<!--FIRST SLIDER STARTS -->
							<li data-transition="fade">
								<img src="<?php echo $this->getThemePath(); ?>/img/slides/slide-bg1.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									class="rev-slidebg">
											
				
								<div class="tp-caption top-label"
									data-x="367"
									data-y="200"
									data-start="500"
									data-transform_in="y:[-300%];opacity:0;s:500;"><img src="<?php echo $this->getThemePath(); ?>/img/nl/slider_egg.png" alt="slider_egg"></div>

									<div class="tp-caption main-label1"
									data-x="400"
									data-y="450"
									data-start="1500"
									data-whitespace="nowrap"						 
									data-transform_in="y:[100%];s:500;"
									data-transform_out="opacity:0;s:500;"
									data-mask_in="x:0px;y:0px;">it’s over easy.</div>

									<div class="tp-caption bottom-label1"
									data-x="430"
									data-y="530"
									data-start="2000"
									data-transform_in="y:[100%];opacity:0;s:500;">DIVORCE THE EASY WAY</div>

									<div class="tp-caption"
									data-x="480"
									data-y="588"
									data-start="2500"
									data-transform_in="z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;s:1300;"><a href="app/register"><img src="<?php echo $this->getThemePath(); ?>/img/nl/new_green_btn.png" alt="banner_btn"></a></div>
												
							</li>
							<!--FIRST SLIDER ENDS -->

							<!--SECOND SLIDER STARTS -->
							<li data-transition="fade">
								<img src="<?php echo $this->getThemePath(); ?>/img/slides/slide-bg1.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									class="rev-slidebg">
											
				
								<div class="tp-caption top-label"
									data-x="367"
									data-y="200"
									data-start="500"
									data-transform_in="y:[-300%];opacity:0;s:500;"><img src="<?php echo $this->getThemePath(); ?>/img/nl/slider_egg.png" alt="slider_egg"></div>

									<div class="tp-caption main-label1"
									data-x="400"
									data-y="450"
									data-start="1500"
									data-whitespace="nowrap"						 
									data-transform_in="y:[100%];s:500;"
									data-transform_out="opacity:0;s:500;"
									data-mask_in="x:0px;y:0px;">it’s over easy.</div>

									<div class="tp-caption bottom-label1"
									data-x="430"
									data-y="530"
									data-start="2000"
									data-transform_in="y:[100%];opacity:0;s:500;">DIVORCE THE EASY WAY</div>

									<div class="tp-caption"
									data-x="480"
									data-y="588"
									data-start="2500"
									data-transform_in="z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;s:1300;"><a href="app/register"><img src="<?php echo $this->getThemePath(); ?>/img/nl/new_green_btn.png" alt="banner_btn"></a></div>
												
							</li>
							<!--SECOND SLIDER ENDS -->

							<!--THIRD SLIDER STARTS -->
							
							<li data-index="rs-23" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off" data-easein="default" data-easeout="default" data-masterspeed="300" data-rotate="0" data-saveperformance="off" data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="" class="tp-revslider-slidesli rs-pause-timer-always active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 20; visibility: inherit; opacity: 1; background-color: rgba(255, 255, 255, 0);">
		<!-- MAIN IMAGE -->
		<div class="slotholder" style="position: absolute; top: 0px; left: 0px; z-index: 0; width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"><!--Runtime Modification - Img tag is Still Available for SEO Goals in Source - <img src="http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png" style="background-color:#707070" alt="" title="Home" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg defaultimg" data-no-retina="">--><div class="tp-bgimg defaultimg" style="background-color: rgb(112, 112, 112); background-repeat: no-repeat; background-image: url(&quot;http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png&quot;); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit; z-index: 20;" src="http://yourdemo.live/reid-insurance/wp-content/plugins/revslider/admin/assets/images/transparent.png"></div></div>
		<!-- LAYERS -->

		<!-- LAYER NR. 1 -->
		<div class="tp-parallax-wrap" style="position: absolute; visibility: visible; left: 0px; top: 0px; z-index: 5;"><div class="tp-loop-wrap" style="position:absolute;"><div class="tp-mask-wrap" style="position: absolute; overflow: visible; height: auto; width: auto;"><div class="tp-caption   tp-resizeme tp-videolayer HasListener coverscreenvideo rs-apiready" id="slide-23-layer-1" data-x="0" data-y="0" data-transform_idle="o:1;" data-transform_in="opacity:0;s:300;e:Power2.easeInOut;" data-transform_out="opacity:0;s:300;" data-start="500" data-responsive_offset="on" data-vimeoid="84" data-videoattributes="title=0&amp;byline=0&amp;portrait=0&amp;api=1" data-videowidth="100%" data-videoheight="100%" data-videoloop="none" data-forcecover="1" data-aspectratio="16:9" data-autoplay="on" data-videoposter="http://yourdemo.live/reid-insurance/wp-content/uploads/2016/12/135.jpg" data-noposteronmobile="off" data-volume="100" style="z-index: 5; visibility: inherit; width: 1349px; height: 492px; transition: none 0s ease 0s ; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: translate3d(0px, 0px, 0px); transform-origin: 50% 50% 0px;"> <div class="tp-videoposter noSwipe" style="cursor: pointer; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; z-index: 3; background-image: url(&quot;http://yourdemo.live/reid-insurance/wp-content/uploads/2016/12/135.jpg&quot;); background-size: cover; background-position: center center; transition: none 0s ease 0s ; line-height: 18px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; visibility: hidden; opacity: 0; transform: matrix(1, 0, 0, 1, 0, 0);"></div><iframe style="position: absolute; left: 0px; top: -27.1151%; width: 100%; height: 154.23%; display: block; visibility: inherit; opacity: 1;" src="https://player.vimeo.com/video/183514621?autoplay=0&amp;title=0&amp;byline=0&amp;portrait=0&amp;api=1&amp;player_id=iframe43328&amp;api=1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" class="resizelistener" id="iframe43328" width="100%" height="100%"></iframe></div></div></div></div>
	</li>
							<!--THIRD SLIDER ENDS -->
							
						</ul>
					</div>
				</div>
				<!--testmonial SECTION STARTS -->

				<!--VERTICAL NAVIGATION SECTION STARTS - ->
				<div class="vetical_nav_sec">
					<nav id="cd-vertical-nav">
						<ul>
						<li><a href="#section1" data-number="1"><span class="cd-dot"></span></a></li>
						<li><a href="#section2" data-number="2"><span class="cd-dot"></span></a></li>
						<li><a href="#section3" data-number="3"><span class="cd-dot"></span></a></li>
						<li><a href="#section4" data-number="4"><span class="cd-dot"></span></a></li>
						<li><a href="#section5" data-number="5"><span class="cd-dot"></span></a></li>
						<li><a href="#section6" data-number="6"><span class="cd-dot"></span></a></li>
						</ul>
					</nav>
				</div>
				<!--VERTICAL NAVIGATION SECTION ENDS -->

				<div class="ban_bot_sect">
					<!-- <h1>It’s Over Easy helps divorcing couples become the masters of their own destiny</h1> -->
					<!-- <h1> -->
						<?php
							$a = new Area('bannerbottom'); 
							$a->display($c);
						?>						
					<!-- </h1> -->
				</div>
				<div class="step_section_area">
					<?php 
						$a = new Area('Our Online Head Section'); 
						$a->display($c);
					?>	
					<!-- <h1>Our Online Divorce Process</h1> -->
					<div class="container">
						<div class="inn_section_steps">
							<div class="first_row_Sec12">
								<div class="first_row_p1">
									<div class="fs_lt">
									<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n1.png" alt="step1"> -->
										<?php 
												$a = new Area('STEP1 IMAGE SECTION'); 
												$a->display($c);
											?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 1</h3> -->
										<!-- <h3> -->
											<?php 
												$a = new Area('STEP1_SECTION'); 
												$a->display($c);
											?>		
										<!-- </h3> -->
										<?php 
											$a = new Area('STEP1_SECTION_PARA'); 
											$a->display($c);
										?>	
										<!-- <p>Complete our online survey to determine if you qualify for an online divorce</p> -->
									</div>
								</div>
								<div class="first_row_p2">								
									<div class="fs_lt">
									<?php /*<img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n3.png" alt="step3"> */ ?>						
										<?php 
											$a = new Area('STEP3 IMAGE SECTION'); 
											$a->display($c);
										?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 3</h3> -->
										<!-- <h3> -->
											<?php
												$a = new Area('STEP3_SECTION'); 
												$a->display($c);
											?>		
										<!-- </h3> -->
										<?php 
											$a = new Area('STEP3_SECTION_PARA'); 
											$a->display($c);
										?>	
										<!-- <p>We have solutions and <br> tools for all family types</p> -->
									</div>
								</div>
								<div class="first_row_p3">
									<div class="fs_lt">
									<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n5.png" alt="step5"> -->									
										<?php 
											$a = new Area('STEP5 IMAGE SECTION'); 
											$a->display($c);
										?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 5</h3> -->
										<!-- <h3> -->
											<?php
												$a = new Area('STEP5_SECTION'); 
												$a->display($c);
											?>		
										<!-- </h3> -->
										<?php 
											$a = new Area('STEP5_SECTION_PARA'); 
											$a->display($c);
										?>	
										<!-- <p>Generate your legal documents after you and your spouse have completed all the required forms</p> -->
									</div>								
								</div>
							</div>
							<div class="mid_row_Sect12" style="text-align:center;">
							
								<img src="<?php echo $this->getThemePath(); ?>/img/nl/step_line.png" alt="step_line">
							</div>
							<div class="secont_row_Sec12">
								<div class="first_row_p4">
									<div class="fs_lt">
									<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n2.png" alt="step2"> -->
									<?php 
										$a = new Area('STEP2 IMAGE SECTION'); 
										$a->display($c);
									?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 2</h3> -->
										<h3>
											<?php
												$a = new Area('STEP2_SECTION'); 
												$a->display($c);
											?>		
										</h3>
										<?php 
											$a = new Area('STEP2_SECTION_PARA'); 
											$a->display($c);
										?>	
										<!-- <p>Tell us about your<br> situation</p> -->
									</div>
								</div>
								<div class="first_row_p5">								
									<div class="fs_lt">
									<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n4.png" alt="step4"> -->									
									<?php 
										$a = new Area('STEP4 IMAGE SECTION'); 
										$a->display($c);
									?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 4</h3> -->
										<h3>
											<?php
												$a = new Area('STEP4_SECTION'); 
												$a->display($c);
											?>		
										</h3>
										<?php 
												$a = new Area('STEP4_SECTION_PARA'); 
												$a->display($c);
										?>	
										<!-- <p>Use our tools to organize information, such as assets, debts, income and expenses</p> -->
									</div>
								</div>
								<div class="first_row_p6">
									<div class="fs_lt">
									<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/step_n6.png" alt="step6"> -->									
									<?php 
										$a = new Area('STEP6 IMAGE SECTION'); 
										$a->display($c);
									?>	
									</div>
									<div class="fs_rt">
										<!-- <h3>Step 6</h3> -->
										<h3>
											<?php
												$a = new Area('STEP6_SECTION'); 
												$a->display($c);
											?>		
										</h3>
										<?php 
												$a = new Area('STEP6_SECTION_PARA'); 
												$a->display($c);
										?>	
										<!-- <p>File your documents with the county court after you and your spouse approve the terms of the divorce</p> -->
									</div>								
								</div>							
							</div>
						</div>
					</div>
				</div>

				<!--WEDDING SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner">
							<div class="col-sm-6">
								<!-- <h1>We help couples file for an <br>uncontested divorce</h1> -->
							
								<?php 
										$a = new Area('WEDDING SECTION TITLE'); 
										$a->display($c);
								?>	
								
								<?php 
									$a = new Area('WEDDING_SECTION_PARA'); 
									$a->display($c);
								?>	
								<!-- <p>We help couple file for an uncontested divorce, wherein <br> both parties mutually agree on the division of community <br> property, child custody, co-parenting arrangements and <br>
spousal support, An uncontested divorce can only be filed <br> if both parties agree on all related issues. The first step is <br> filing an initial Petition for divorce</p> -->
								<!-- <a href="#">Find out if I qualify</a> -->																
								<?php 
									$a = new Area('FIND_OUT_TEXT1'); 
									$a->display($c);
								?>									
							</div>
							<div class="col-sm-6 wed_img">
								<!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/wed.png" alt="wedding"> -->
								<?php 
									$a = new Area('WEEDING_CAKE_IMG1'); 
									$a->display($c);
								?>	
							</div>
						</div>
					</div>
				</section>
				<!--WEDDING SECTION ENDS -->

				<!--PIG SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner">
							<div class="col-sm-6 wed_img"><!-- <img src="<?php echo $this->getThemePath(); ?>/img/nl/pig.png" alt="pig"> -->
								<?php 
									$a = new Area('pig-img'); 
									$a->display($c);
								?>	
							<br><br><br></div>
							<div class="col-sm-6"><br><br><br><br>
								<?php 
									$a = new Area('pig-heading'); 
									$a->display($c);
								?>
								<!-- <h1>Divorce for less money in a <br> shorter amount of time</h1> -->
								<?php 
									$a = new Area('pig-content'); 
									$a->display($c);
								?>
								<!-- <p>Obtain a divorce at a significantly cheaper cost than hiring an<br> attorney, in a shorter amount of time. The cost of a traditional<br> divorce attorney is approximately $27,00, compared to $750<br> for an online divorce.</p> -->
								<?php 
									$a = new Area('button2'); 
									$a->display($c);
								?>	
								<!-- <a href="#">Find out if I qualify</a> -->
							</div>
						</div>
					</div>
				</section>
				<!--PIG SECTION ENDS -->

				<!--LAURA SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner top_no">
							<div class="col-sm-6"><br><br><br><br>
								<?php 
									$a = new Area('divorce-heading'); 
									$a->display($c);
								?>
								<!-- <h1>Intuitive, simplified process<br> by a divorce attorney</h1> -->
								<?php 
									$a = new Area('divorce-content'); 
									$a->display($c);
								?>
								<!-- <p>Laura Wasser is the founder of It’s Over Easy and is also a<br> family law attorney based in Los Angeles. She has handled a<br> number of high-profile, high-net worth dissolutions, including<br> those for Angelina Jolie, Heidi Klum, Kim Kardashian, and Ryan<br> Reynolds, among many others.</p> -->
								<?php 
									$a = new Area('divorce-button'); 
									$a->display($c);
								?>
								<!-- <a href="#">Find out if I qualify</a> -->
							</div>
							<div class="col-sm-6 wed_img">
								<?php 
												$a = new Area('Women-Image'); 
												$a->display($c);
								?>	
							</div>
							<!--<div class="col-sm-6 wed_img"><img src="<?php echo $this->getThemePath(); ?>/img/nl/women1.png" alt="women"></div>-->
						</div> 
					</div>
				</section>
				<!--LAURA SECTION ENDS -->


				<!--LAPTOP SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner">
							<div class="col-sm-7 wed_img">
							<?php 
									$a = new Area('Laptop-Image'); 
									$a->display($c);
								?>
								<!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/laptop.png" alt="laptop">-->
							</div>
							<div class="col-sm-5 five_sect"><br><br><br>
								<?php 
									$a = new Area('co-parenting-heading'); 
									$a->display($c);
								?>
								<!-- <h1>Child custody and<br> co-parenting tools</h1> -->
								<?php 
									$a = new Area('co-parenting-content'); 
									$a->display($c);
								?>
								<!-- <p>Structure successful child custody arrangements and co-parenting schedules, based on proven solutions, Use these tools to complete the “Declaration of Uniform Child Custody Jurisdiction and Enforcement Act” form.</p> -->
								<?php 
									$a = new Area('co-parenting-button'); 
									$a->display($c);
								?>
								<!-- <a href="#">Find out if I qualify</a> -->
							</div>
							<br>
						</div>
					</div>
				</section>
				<!--LAPTOP SECTION ENDS -->


				<!--COMMUNITY SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner top_no">
							<div class="col-sm-5 five_sect"><br><br><br><br>
								<?php 
									$a=new Area('community-heading');
									$a->display($c);
								?>
								<!-- <h1>Community property <br>allocation tools</h1> -->
								<?php 
									$a=new Area('community-content');
									$a->display($c);
								?>
								<!-- <p>Allocate a fair split of community property. Our interactive guides help you and your spouse understand what you own and what you owe, in addition to figuring out who is responsible for the assets and debts, Use these tools to complete “Schedule of Assets and Debs” and “Property Declaration” forms.</p> -->
								<?php 
									$a=new Area('community-button');
									$a->display($c);
								?>
								<!-- <a href="#">Find out if I qualify</a> -->
							</div>
							<div class="col-sm-7 wed_img">
							<br><br>
								<?php 
									$a=new Area('Tab-Image');
									$a->display($c);
								?>
								<br><br><!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/tab.png" alt="tab"><br><br><br>-->
							</div>
						</div> 
					</div>
				</section>
				<!--COMMUNITY SECTION ENDS -->

				<!--CHILD  SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner">
							<div class="col-sm-6 wed_img">
								<?php 
									$a=new Area('Vertical-Image');
									$a->display($c);
								?>
								<!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/tab_vertical.png" alt="tab_vertical"><br><br><br>-->
							</div>
							<div class="col-sm-6 five_sect"><br><br><br><br>
								<?php 
									$a=new Area('spousal-heading');
									$a->display($c);
								?>
								<!-- <h1>Child and spousal support <br>calculation tools</h1> -->
								<?php 
									$a=new Area('spousal-content');
									$a->display($c);
								?>
								<!-- <p>Upload income and expenses to determine which party is potentially eligible to pay and receive support. Use these tools to complete “Income and Expense Declaration” forms and create a finacial support proposal.</p> -->
								<?php 
									$a=new Area('spousal-button');
									$a->display($c);
								?>
								<!-- <a href="#">Find out if I qualify</a> -->
							</div>
						</div>
					</div>
				</section>
				<!--CHILD SECTION ENDS -->

				<!--CALL CENTER SECTION STARTS -->
				<section class="wedding_section">
					<div class="container">
						<div class="wedding_Section_inner top_no bot_no1">
							<div class="col-sm-6 five_sect"><br><br><br><br><br>
								<?php 
									$a=new Area('experts-heading');
									$a->display($c);
								?>
								<!-- <h1>Experts available to assist<br> you at every stage</h1> -->
								<?php 
									$a=new Area('experts-content');
									$a->display($c);
								?>
								<!-- <p>What is we disagree? There is a chance that your spouse might have different ideas about support and custody. Not to worry, we can connect you with mediators that will help you work through the issues, We are here to provide you with effective solutions that most people use, but can also work with you in creating custom solutions.</p> -->
								<!-- <a href="#">Find out if I qualify</a> -->
								<?php 
									$a=new Area('experts-button');
									$a->display($c);
								?>
							</div>
							<div class="col-sm-6 wed_img call_img"><br><br><br><br>
								<?php 
									$a=new Area('call-center-Image');
									$a->display($c);
								?>
								<!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/call_center1.png" alt="call_center">--> 
							</div>
						</div> 
					</div>
				</section>
				<!--CALL CENTER SECTION ENDS -->

				<!--BLUE MANGT SECTION START -->
				<div class="blue_mgnt">
					<?php 
						$a=new Area('attorneys');
						$a->display($c);
					?>
					<!-- <h1>Maintain control in divorce rather than handing over control to attorneys</h1> -->
				</div>
				<!--BLUE MANGT SECTION ENDS -->

				<!--PRICE COMPARE SECTION STARTS -->
				<section class="price_sect_new">
					<div class="container">
						<?php 
							$a=new Area('price');
							$a->display($c);
						?>
						<!-- <h1>Price Comparison</h1> -->
						<div class="price_Sect_list_area">
						<!--TRAIL SECTION STARTS -->
							<div class="three_sec nopadding">
								<div class="top_section_price lt">
									<?php 
										$a=new Area('trial');
										$a->display($c);
									?>
									<!-- <h4>Trial</h4> -->
									<hr>
									<?php 
										$a=new Area('free');
										$a->display($c);
									?>
									<!-- <h1>Free</h1>	 -->								
								</div>
								<div class="tri_area lt"></div>
								<div class="sign_btn_price">
									<?php 
										$a=new Area('Sign-Up');
										$a->display($c);
									?>
									<!-- <a href="#">Sign Up</a> -->
								</div>
								<div class="list_details_sec">
									<?php 
										$a=new Area('list');
										$a->display($c);
									?>
									<!-- <ul>										
										<li>Articles, updates and news<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Full access to all forms <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li><li>Forms for both spouses<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li><li>Co-parenting resources <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li><li>Community property <br>allocation tools <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li><li>Spousal support tools<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>										
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>

									</ul> -->
								</div>
							</div>
						<!--TRAIL SECTION ENDS -->

						<!--MEMBER SECTION STARTS -->
							<div class="three_sec nopadding">							
								<div class="top_section_price dr">
									<?php 
										$a=new Area('member');
										$a->display($c);
									?>
									<!-- <h4>Member</h4> -->
									<hr>
									<?php 
										$a=new Area('mem-amt');
										$a->display($c);
									?>
									<!-- <h1>$1,000</h1> -->
								</div>
								<div class="tri_area dr"></div>
								<div class="sign_btn_price">
									<?php 
										$a=new Area('mem-button');
										$a->display($c);
									?>
									<!-- <a href="#">Sign Up</a> -->
								</div>
								<div class="list_details_sec">
									<?php 
										$a=new Area('mem-list');
										$a->display($c);
									?>
									<!-- <ul>
										<li>Free 45 minute phone <br> consultation with It’s Over Easy<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
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
										<li>Community property<br> allocation tools <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Spousal support tools <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Temporary separation<br> agreement <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Divorce Judgement Upon<br> Agreement of both Spouses <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
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
										<li>&nbsp;</li>
										<li>&nbsp;</li>
										<li>&nbsp;</li>
									</ul> -->
								</div>
							</div>
						<!--MEMBER SECTION ENDS -->

						<!--PREMIUM SECTION ENDS -->
							<div class="three_sec">								
								<div class="top_section_price ex_dr">
									<?php 
										$a=new Area('premium');
										$a->display($c);
									?>
									<!-- <h4>Premium</h4> -->
									<hr>
									<?php 
										$a=new Area('pre-amt');
										$a->display($c);
									?>
									<!-- <h1>$2,500</h1> -->
								</div>
								<div class="tri_area ex_dr"></div>
								<div class="sign_btn_price">
									<?php 
										$a=new Area('pre-button');
										$a->display($c);
									?>
									<!-- <a href="#">Sign Up</a> -->
								</div>
								<div class="list_details_sec">
									<?php 
										$a=new Area('pre-list');
										$a->display($c);
									?>
									<!-- <ul>
										<li>Free 90 minute phone <br> consultation with It’s Over Easy <div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
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
										<li>Community property<br> allocation tools<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Spousal support tools<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Temporary separation<br> agreement<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
curabitur tellus molestie
nec, eu nulla nullam, sit
pulvinar etiam amet.</span></div></li>
										<li>Divorce Judgement Upon<br> Agreement of both Spouses<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
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
										<li>Free delivery of forms to court<div class="tooltip "><i class="fa fa-info" aria-hidden="true"></i><span class="tooltiptext tooltip-top">Duis nulla, posuere nisl
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
									</ul> -->
								</div>
							</div>
						<!--PREMIUM SECTION ENDS -->
						</div>
					</div>
				</section>
				<!--PRICE COMPARE SECTION END -->

				<!-- DID YOU KNOW SECTION STARTS -->
				<section class="did_you_know_section">
					<div class="container">
						<?php 
							$a=new Area('did-you-know');
							$a->display($c);
						?>
						<!-- <h1>Did you know?</h1> -->
						<?php 
							$a=new Area('america');
							$a->display($c);
						?>
						<!-- <h3>In America, there is...</h3> -->
					</div>
					<div class="container">
						
						<div class="four_Sec1">
							<?php 
								$a=new Area('Green-Image');
								$a->display($c);
							?>
							<!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/dy1.png" alt="dy1">-->
							<?php 
								$a=new Area('green-clock');
								$a->display($c);
							?>
							<!-- <p>1 divorce ever <br>36 seconds</p> -->
						</div>
						<div class="four_Sec2">
							<?php 
								$a=new Area('Orange-Image');
								$a->display($c);
							?>
							<?php/*<img src="<?php echo $this->getThemePath(); ?>/img/nl/dy2.png" alt="dy1">--> */?>
							<?php 
								$a=new Area('orange-clock');
								$a->display($c);
							?>
							<!-- <p>2,400 divorces <br>every day</p> -->
						</div>
						<div class="four_Sec3">
							<?php 
								$a=new Area('Blue-Image');
								$a->display($c);
							?>
							<?php/*<img src="<?php echo $this->getThemePath(); ?>/img/nl/dy3.png" alt="dy1">--> */?>
							<?php 
								$a=new Area('blue-calendar');
								$a->display($c);
							?>
							<!-- <p>16,800 divorces <br>every week</p> -->
						</div>
						<div class="four_Sec4">
					       <?php 
						        $a=new Area('Yellow-Image');
						        $a->display($c);
					       ?>
					       <?php/*<!--<img src="<?php echo $this->getThemePath(); ?>/img/nl/dy4.png" alt="dy1">-->*/?>
					       <?php 
						        $a=new Area('yellow-calendar');
						        $a->display($c);
					       ?>
					       <!-- <p>876,000 divorces<br> every year</p> -->       
				      </div>
					</div>
					<div class="gray_section_bg"></div>
					<div class="container">
						<div class="did_you_know_para">
							<?php 
								$a=new Area('best-divorce-content');
								$a->display($c);
							?>
							<!-- <p>Divorce is just a part of life so let's handle it is the best way we can. Let’s compare traditional methods <br>of getting divorced to our online method and then you can decide what works for you.</p> -->
						</div>
					</div>
				</section>
				<!-- DID YOU KNOW SECTION ENDS -->

				<!-- TRADITIONAL SECTION STARTS -->
				<section class="gray_half_sec_outer">
					<div class="gray_half_sec">
						<div class="container">
							<div class="col-sm-5">
								<?php 
									$a=new Area('traditional');
									$a->display($c);
								?>
								<!-- <h1>Traditional</h1> -->
							</div>
							<div class="col-sm-2">
								<?php 
									$a=new Area('vs');
									$a->display($c);
								?>
								<!-- <h1>vs</h1> -->
							</div>
							<div class="col-sm-5">
								<?php 
									$a=new Area('ioe');
									$a->display($c);
								?>
								<!-- <h1>It’s Over Easy</h1> -->
							</div>
						</div>
					</div>
					<div class="gray_half_sec not_pad_ara">
						<div class="container">
							<div class="col-sm-12">
								<!-- <p class="how_much_cst">How much does it cost?</p> -->
								<?php 
									$a=new Area('cost');
									$a->display($c);
								?>
							</div>
						</div>
					</div>
					<div class="gray_half_sec not_pad_ara">
						<div class="container nw_color_bg">
							<div class="col-sm-5 wh">
								<?php 
									$a=new Area('cost-amt');
									$a->display($c);
								?>
								<!-- <h1>$27,000 total</h1> -->
							</div>
							<div class="col-sm-2"><img src="<?php echo $this->getThemePath(); ?>/img/nl/rs_dollar.png" alt="rs_dollar"></div>
							<div class="col-sm-5 gr">
								<?php 
									$a=new Area('cost-amt1');
									$a->display($c);
								?>
								<!-- <h1>$750 total</h1> -->
							</div>
						</div>
					</div>
					<div class="gray_half_sec not_pad_ara">
						<div class="container">
							<div class="col-sm-12">
								<!-- <p class="how_much_cst">How much time does it take?</p> -->
								<?php 
									$a=new Area('how-much-time');
									$a->display($c);
								?>
							</div>
						</div>
					</div>
					<div class="gray_half_sec not_pad_ara pd_bt">
						<div class="container nw_color_bg">
							<div class="col-sm-5 wh">
								<?php 
									$a=new Area('unlimited');
									$a->display($c);
								?>
								<!-- <h1>Unlimited</h1> -->
							</div>
							<div class="col-sm-2"><img src="<?php echo $this->getThemePath(); ?>/img/nl/blue_clock.png" alt="blue_clock"></div>
							<div class="col-sm-5 gr">
								<?php 
									$a=new Area('month');
									$a->display($c);
								?>
								<!-- <h1>6 months</h1> -->
							</div>
						</div>
					</div>
				</section>
				<!-- TRADITIONAL SECTION STARTS -->

			<div class="second_slider_Section">
				<div class="container">
					<div class="resource_sec_new">
						<?php 
							$a=new Area('resources');
							$a->display($c);
						?>
						<!-- <h1>Resources</h1> -->
					</div>
				</div>
				<!--SECOND SLIDER STARTS -->
				<div class="slider-container rev_slider_wrapper" style="z-index: 99;">
					<div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options='{"delay": 9000, "gridwidth": 1200, "gridheight": 1032, "disableProgressBar": "on"}'>
						<ul>
						<!--FIRST SLIDER STARTS -->
							<li data-transition="fade">
								<img src="<?php echo $this->getThemePath(); ?>/img/nl/ban1.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									class="rev-slidebg">
								<div class="tp-caption top-label25"
									data-x="580"
									data-y="700"
									data-start="500"
									data-width="990" 
									data-height="200" 
									data-transform_in="y:[-300%];opacity:0;s:500;"
									data-responsive_offset="on"
									style="background-color: rgba(0, 0, 0, 0.7);"><h1>&nbsp;</h1></div> 

									<div class="tp-caption main-label2"
									data-x="630"
									data-y="750"
									data-start="1500"
									data-whitespace="nowrap"						 
									data-transform_in="y:[100%];s:500;"
									data-transform_out="opacity:0;s:500;"
									data-mask_in="x:0px;y:0px;"
									data-responsive_offset="on">Announcing Your Divorce - How Will You Be Perceived?</div>

									<div class="tp-caption bottom-label2"
									data-x="630"
									data-y="800"
									data-start="2000"
									data-transform_in="y:[100%];opacity:0;s:500;"
									data-responsive_offset="on">Something that is often just as bad (if not worse) than the divorce itself, is <br>announcing it to your friends and family. <a href="#">READ MORE</a></div>
							
							</li>
							<!--FIRST SLIDER ENDS -->

							<!--SECOND SLIDER STARTS -->
								<li data-transition="fade">
									<img src="<?php echo $this->getThemePath(); ?>/img/nl/ban2.jpg"  
										alt=""
										data-bgposition="center center" 
										data-bgfit="cover" 
										data-bgrepeat="no-repeat" 
										class="rev-slidebg">
									<div class="tp-caption top-label25"
										data-x="580"
										data-y="700"
										data-start="500"
										data-width="990" 
										data-height="200" 
										data-transform_in="y:[-300%];opacity:0;s:500;"
										data-responsive_offset="on"
										style="background-color: rgba(0, 0, 0, 0.7);"><h1>&nbsp;</h1></div> 

										<div class="tp-caption main-label2"
										data-x="630"
										data-y="750"
										data-start="1500"
										data-whitespace="nowrap"						 
										data-transform_in="y:[100%];s:500;"
										data-transform_out="opacity:0;s:500;"
										data-mask_in="x:0px;y:0px;"
										data-responsive_offset="on">Announcing Your Divorce - How Will You Be Perceived?</div>

										<div class="tp-caption bottom-label2"
										data-x="630"
										data-y="800"
										data-start="2000"
										data-transform_in="y:[100%];opacity:0;s:500;"
										data-responsive_offset="on"><a href="#">READ MORE</a></div>
								
								</li>
							<!--SECOND SLIDER ENDS -->

							<!--THIRD SLIDER STARTS -->
								<li data-transition="fade">
									<img src="<?php echo $this->getThemePath(); ?>/img/nl/ban3.jpg"  
										alt=""
										data-bgposition="center center" 
										data-bgfit="cover" 
										data-bgrepeat="no-repeat" 
										class="rev-slidebg">
									<div class="tp-caption top-label25"
										data-x="580"
										data-y="700"
										data-start="500"
										data-width="990" 
										data-height="200" 
										data-transform_in="y:[-300%];opacity:0;s:500;"
										data-responsive_offset="on"
										style="background-color: rgba(0, 0, 0, 0.7);"><h1>&nbsp;</h1></div> 

										<div class="tp-caption main-label2"
										data-x="630"
										data-y="750"
										data-start="1500"
										data-whitespace="nowrap"						 
										data-transform_in="y:[100%];s:500;"
										data-transform_out="opacity:0;s:500;"
										data-mask_in="x:0px;y:0px;"
										data-responsive_offset="on">Announcing Your Divorce - How Will You Be Perceived?</div>

										<div class="tp-caption bottom-label2"
										data-x="630"
										data-y="800"
										data-start="2000"
										data-transform_in="y:[100%];opacity:0;s:500;"
										data-responsive_offset="on"><a href="#">READ MORE</a></div>
								
								</li>
							<!--THIRD SLIDER ENDS -->

							<!--FOUR SLIDER STARTS -->
								<li data-transition="fade">
									<img src="<?php echo $this->getThemePath(); ?>/img/nl/ban4.jpg"  
										alt=""
										data-bgposition="center center" 
										data-bgfit="cover" 
										data-bgrepeat="no-repeat" 
										class="rev-slidebg">
									<div class="tp-caption top-label25"
										data-x="580"
										data-y="700"
										data-start="500"
										data-width="990" 
										data-height="200" 
										data-transform_in="y:[-300%];opacity:0;s:500;"
										data-responsive_offset="on"
										style="background-color: rgba(0, 0, 0, 0.7);"><h1>&nbsp;</h1></div> 

										<div class="tp-caption main-label2"
										data-x="630"
										data-y="750"
										data-start="1500"
										data-whitespace="nowrap"						 
										data-transform_in="y:[100%];s:500;"
										data-transform_out="opacity:0;s:500;"
										data-mask_in="x:0px;y:0px;"
										data-responsive_offset="on">Announcing Your Divorce - How Will You Be Perceived?</div>

										<div class="tp-caption bottom-label2"
										data-x="630"
										data-y="800"
										data-start="2000"
										data-transform_in="y:[100%];opacity:0;s:500;"
										data-responsive_offset="on"><a href="#">READ MORE</a></div>
								
								</li>
							<!--FOUR SLIDER ENDS -->

							<!--FIVE SLIDER STARTS -->
								<li data-transition="fade">
									<img src="<?php echo $this->getThemePath(); ?>/img/nl/ban5.jpg"  
										alt=""
										data-bgposition="center center" 
										data-bgfit="cover" 
										data-bgrepeat="no-repeat" 
										class="rev-slidebg">
									<div class="tp-caption top-label25"
										data-x="580"
										data-y="700"
										data-start="500"
										data-width="990" 
										data-height="200" 
										data-transform_in="y:[-300%];opacity:0;s:500;"
										data-responsive_offset="on"
										style="background-color: rgba(0, 0, 0, 0.7);"><h1>&nbsp;</h1></div> 

										<div class="tp-caption main-label2"
										data-x="630"
										data-y="750"
										data-start="1500"
										data-whitespace="nowrap"						 
										data-transform_in="y:[100%];s:500;"
										data-transform_out="opacity:0;s:500;"
										data-mask_in="x:0px;y:0px;"
										data-responsive_offset="on">Announcing Your Divorce - How Will You Be Perceived?</div>

										<div class="tp-caption bottom-label2"
										data-x="630"
										data-y="800"
										data-start="2000"
										data-transform_in="y:[100%];opacity:0;s:500;"
										data-responsive_offset="on"><a href="#">READ MORE</a></div>
								
								</li>
							<!--FIVE SLIDER ENDS -->
						</ul>
					</div>
				</div>
				<!--SECOND SLIDER ENDS -->
			</div>


				<!--IOE FOOTER UPPER SECTION STARTS -->
				<section class="foter_upper_sectio123">
					<div class="container">						
						<div class="wedding_Section_inner">
							<div class="col-sm-6 wed_img"><iframe src="https://player.vimeo.com/video/204249783?title=0&byline=0&portrait=0" width="100%" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe><br><br><br><br></div>
							<div class="col-sm-6 five_sect"><br><br>
								<?php 
									$a=new Area('founder');
									$a->display($c);
								?>
								<!-- <h1>About the Founder,<br> Laura A. Wasser</h1> --><br><br>
								<?php 
									$a=new Area('founder-desc');
									$a->display($c);
								?>
								<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labo ris nisi ut aliquip ex ea commodo consequat. Duis aute irure</p>	 -->							
							</div>
						</div>
					</div>
				</section>
				<!--IOE FOOTER UPPER SECTION ENDS -->
				<!--IOE FOOTER SECTION STARTS -->
				<div class="footer_full_sec">
				<div class="container">
					<div class="footer_sec">
						<!-- <h1><a href="#"><img src="<?php echo $this->getThemePath(); ?>/img/nl/footer_logo_Sec.png" alt="footer_logo_Sec"></a></h1> -->
						<?php 
									$a=new Area('footer-logo');
									$a->display($c);
								?>
						<div class="menu_list_Sect234">
							<div class="col-sm-4 footer_uperr">
								<?php 
									$a=new Area('home-link');
									$a->display($c);
								?>
								<!-- <ul>
									<li><a href="#">Home</a></li>
									<li><a href="#">Find Out if I Qualify</a></li>
									<li><a href="#">Our Process</a></li>
									<li><a href="#">FAQ</a></li>
									<li><a href="#">Contact Us</a></li>
								</ul> -->
							</div>
							<div class="col-sm-4 footer_uperr">
								<?php 
									$a=new Area('child-custody-link');
									$a->display($c);
								?>
								<!-- <ul>
									<li><a href="#">Child Custody</a></li>
									<li><a href="#">Co-parenting</a></li>
									<li><a href="#">Divorce & Finances</a></li>
									<li><a href="#">Support Calculators</a></li>
									<li><a href="#">Relationship Quizzes</a></li>
								</ul>	 -->							
							</div>
							<div class="col-sm-4 footer_uperr no_bt0">
								<?php 
									$a=new Area('register-link');
									$a->display($c);
								?>
								<!-- <ul>
									<li><a href="#">Register</a></li>
									<li><a href="#">Login</a></li>
									<li><a href="#">Help</a></li>
									<li><a href="#">Terms and Conditions</a></li>
									<li><a href="#">Privacy Policy</a></li>
								</ul> -->								
							</div>
						</div>
						<ul class="Copyright_Sect">
							<li>
								<?php 
									$a=new Area('copyright');
									$a->display($c);
								?>
								<!-- <a href="./">Copyright 2017 It’s Over Easy</a> -->
							</li>
						</ul>
						
					</div>
				</div>
				<div class="social_icon"><a href="#"><img src="<?php echo $this->getThemePath(); ?>/img/nl/fb_icon.png" alt="fb_icon"></a>&nbsp;&nbsp;<a href="#"><img src="<?php echo $this->getThemePath(); ?>/img/nl/tw_icon.png" alt="tw_icon"></a></div>
			</div>
				<!--IOE FOOTER SECTION ENDS -->

			<div class="chat-sec"><a href="#"><img src="<?php echo $this->getThemePath(); ?>/img/nl/callout.png"></a></div>
		</div>

		<!-- Vendor -->
		
		<!-- Vendor -->
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/isotope/jquery.isotope.min.js"></script>
  <?php /*<!-- <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.appear/jquery.appear.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery-cookie/jquery-cookie.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/common/common.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.validation/jquery.validation.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/jquery.gmap/jquery.gmap.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/vendor/vide/vide.min.js"></script> -->
   */ ?>
  <!-- Theme Base, Components and Settings -->
  <script src="<?php echo $this->getThemePath(); ?>/js/theme.js"></script> 
  
  <!-- Current Page Vendor and Views -->
  <script src="<?php echo $this->getThemePath(); ?>/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
  
  <script src="<?php echo $this->getThemePath(); ?>/vendor/circle-flip-slideshow/js/jquery.flipshow.min.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/js/views/view.home.js"></script> 
  
  <!-- Theme Custom -->
   <script src="<?php echo $this->getThemePath(); ?>/js/custom.js"></script> 
  
  <!-- Theme Initialization Files -->
   <script src="<?php echo $this->getThemePath(); ?>/js/theme.init.js"></script> 
  <!-- <script type="text/javascript">
  jQuery(document).ready(function($){
    function smoothScroll(target) {
           $('body,html').animate(
            {'scrollTop':target.offset().top},
            600
           );
    }
   });
  </script> -->

</div>

<?php Loader::element('footer_required'); ?>
	</body>
</html>

