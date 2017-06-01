<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div role="main" class="main">
	<div class="login_area">				
	<div class="container">
		<h1>Log in</h1>
		<p>Welcome back! Please enter your<br>username and password to sign in.</p>
			<div class="col-md-12 login_form">	
				<form name="form_1">
					<input class="input_field user_name1" name="fandlname" placeholder="Email Address" type="text" ng-model="login.email" autocomplete="off" >
					<input class="input_field" name="fandlname" placeholder="Password" type="password" ng-model="login.password" autocomplete="off">
					<label class="error">{{loginerror}}</label>
					<input class="ioe_btn new" name="continue" ng-disabled="{{$scope.logindisable}}" value="Log In" type="submit" ng-click="doLogin(login)" >
				</form>
				<p><a href="<?php echo base_url(); ?>#!/forgot_password">Forgot Password?</a></p>
			</div>
		</div>
	</div>

</div>