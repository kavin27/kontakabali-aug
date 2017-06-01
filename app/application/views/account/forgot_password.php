<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div role="main" class="main">
	<div class="login_area">				
	<div class="container">
		<h1>Log in</h1>
		<p>Enter your email to reset your password.</p>
			<div class="col-md-12 login_form">	
				<form name="form_1">
					<input class="input_field" name="fandlname" ng-model="forgot.email" placeholder="Email" type="text">
					<input class="ioe_btn new" name="continue" ng-click="forgotPassword(forgot.email)" value="Reset Password" type="submit">
				</form>
			</div>
		</div>
	</div>

</div>