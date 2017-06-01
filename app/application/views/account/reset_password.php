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
	 $fields[] = $key . '=' . $value;
	}
	$fields = implode ('&', $fields);

	curl_setopt($ch, CURLOPT_URL, base_url() . "api/auth/resetPassword");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);

	$server_output = curl_exec ($ch);
	$result = json_decode($server_output);
	curl_close ($ch);

	
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
		<!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css"> -->

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/animate/animate.min.css">
		<link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
		<link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">

		<!-- Theme CSS -->
		<link rel="stylesheet" href="css/theme.css">
		<link rel="stylesheet" href="../../static/css/theme-elements.css">
		<link rel="stylesheet" href="css/theme-blog.css">
		<link rel="stylesheet" href="css/theme-shop.css">

		<!-- Current Page CSS -->
		<link rel="stylesheet" href="vendor/rs-plugin/css/settings.css">
		<link rel="stylesheet" href="vendor/rs-plugin/css/layers.css">
		<link rel="stylesheet" href="vendor/rs-plugin/css/navigation.css">
		<link rel="stylesheet" href="vendor/circle-flip-slideshow/css/component.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skins/default.css">

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="../../static/css/custom.css">

		<!-- Head Libs -->
		<script src="vendor/modernizr/modernizr.min.js"></script>

	</head>
	<body class="email_branded_bg">
	<?php 
	if($result->status == 'SUCCESS'){
		?>
		<div class="body email_branded">
			<div class="email_branded_out">
					<div class="email_brand_inner step2">	
						<div class="bg_ge">
							<img src="../../static/img/nl/reset_pwd25.png" alt="reset_pwd25">
							<h1>Forgot your Password?</h1>
						</div>
						<div class="reset_pwd">
							<form method="post" action="<?php echo base_url(); ?>api/auth/changePassword">
								<input type="hidden" name="email" value="<?php echo $_REQUEST['email']; ?>" />
								<input type="hidden" name="key" value="<?php echo $_REQUEST['key']; ?>" />
								<input type="submit" name="submit" value="Reset Password" class="rest_pwd" />
							</form>
							<!-- <a class="rest_pwd" href="#">Reset Password</a> -->
						</div>
					</div>
			</div>
		</div>
		<?php	
	}
	else if($result->status == 'ERROR'){
		?>
<h1><?php echo $result->message; ?></h1>
		<?php
	}
	?>
		

	</body>
</html>
