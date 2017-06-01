<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('./application/libraries/REST_Controller.php');
require_once('./application/third_party/export/PHPExcel.php');
require_once('./application/third_party/export/PHPExcel/IOFactory.php');
require_once('./application/third_party/export/tcpdf/examples/tcpdf_include.php');
require_once('./application/third_party/export/tcpdf/tcpdf.php');

class Auth extends REST_Controller {

	public $config2 = array();
	public function __construct()
	{
	    parent::__construct();

	    $this->load->model('auth_model');
	    $this->load->library('session');
	    $this->load->library('user_agent');
	    $this->load->library('email');
	    $this->load->library('encryption');
	    $this->load->library('phpexcel');
        $this->load->library('PHPExcel_IOFactory');
        $this->load->library('TCPDF');
        $this->load->library('Mcapi');
	}
	public function index_get(){
		
	}
	public function login_post(){
		$data = $this->post();
		if(!empty($data['customer'])){
			$result = $this->auth_model->login($data['customer']['email'], $data['customer']['password']);
			if($result['status']=='SUCCESS'){
				$session_data = array(  
	                "uid" => $result['uid'],
	                "email" => $result['email'],
	                "welcome"=>$result['welcome'],
	                "userType"=>$result['userType']
	            );
	            $this->session->set_userdata($session_data);
			}
			$this->response($result);	
		}
		else{
			$this->response(array('status' =>'ERROR', 'message'=>'Username and password is empty' ));		
		}
	}
	public function profilePic_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$picName = $this->auth_model->loadProfile($this->session->userdata('logged_in'));
			$result = array('name' =>$picName );
		}
		else{
			$result = array('name' =>'3');
		}
		$this->response($result);
	}
	public function changeProfile_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$data['uid'] = $user['uid'];
			$data['email'] = $user['email'];
			$output = $this->auth_model->changePic($data);
			$result = array('status' =>'SUCCESS', 'message'=>'Profile Picture is Updated ' );
		}
		else{
			$result = array('status' => 'ERROR' , 'message'=>'User Not Logged In' );
		}
		$this->response($result);
	}
	public function forgotPassword_post(){
		$key = $this->encryption->create_key(32);
		$key = md5($key);
		$data = $this->post();
		$data['key'] = $key;
		if(isset($data['email']) && $data['email'] != ''){
			$result = $this->auth_model->forgotPassword($data);
			if($result['status'] == 'SUCCESS'){
				$email_config = Array(
		          'mailtype' => 'html', 
		          'charset' => 'iso-8859-1',
		          'wordwrap' => TRUE
				);
				$this->email->initialize($email_config);
				$this->email->from('anthony@newlineinfo.com', 'Antony');
				$this->email->to($data['email']);
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				$email = $data['email'];
				$link ="<a href='".$this->config->config['base_url']."account/resetPassword/?email=$email&key=$key'>Reset Password </a>";
				$message = '<!DOCTYPE html>
							<html>
							<head>
							    <meta charset="utf-8" />
							    <title>Anil Labs - Codeigniter mail templates</title>
							    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
							</head>
							<body>
							<div>
							   <div style="font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center" align="center" id="emb-email-header"></div>
							<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">Hey ,</p>
							<p style="Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px">'.$link.' </p>
							</div>
							</body>
							</html>';
				$this->email->subject('Email Test');
				$this->email->message($message);
				$this->email->send();
			}
		}
		else{
			$result = array('status' => 'ERROR' , 'message' => 'Please Enter Email id' );
		}
		$this->response($result);
	}
	public function signUp_post(){
		$data = $this->post();
		if (!filter_var($data['customer']['username'], FILTER_VALIDATE_EMAIL)){
			$result = array('status' => 'ERROR' , 'message' => 'User name like email format' );
		}
		else{
			if ($this->agent->is_browser())
			{
			    $agent = $this->agent->browser().' '.$this->agent->version();
			}
			elseif ($this->agent->is_robot())
			{
			    $agent = $this->agent->robot();
			}
			elseif ($this->agent->is_mobile())
			{
			    $agent = $this->agent->mobile();
			}
			else
			{
			    $agent = 'Unidentified User Agent';
			}
			if($this->agent->platform()){
				$agent .= '/'.$this->agent->platform();	
			}

			//confirm key generation
			$key = $this->encryption->create_key(32);
			$key = md5($key); 

			$system_details = array(
				'confirm_key' => $key,
				'ip' =>$_SERVER['REMOTE_ADDR'],
				'others' => $agent
			);
			$data['system'] = $system_details;
			$result = $this->auth_model->registration($data);

			if($result['status'] == 'SUCCESS'){
				// $success = $this->mcapi->listSubscribe(
				// 	'd84fa99fb2', 
				// 	$data['customer']['username'], 
				// 	array(
				// 		'FNAME' => $data['customer']['name'], 
				// 		'LNAME' => $data['customer']['name']
				// 	)
				// );

				$email_config = Array(
		          'mailtype' => 'html', 
		          'charset' => 'utf-8',
		          'wordwrap' => TRUE
				);
				$this->email->initialize($email_config);
				$this->email->from('hello@itsovereasy.com', 'Its Over Easy');
				$this->email->to($data['customer']['username']);
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				$email = $data['customer']['username'];
				$link ="<a style='display:inline-block' href='".$this->config->config['base_url']."account/?email=$email&key=$key'><img style='float:left; max-width: 100%;' src='http://yourdemo.live/IOE_new/static/img/nl/email_active_btn.png' alt='verfiy_email'></a>";
				$message = '<!DOCTYPE html>
								<html>
								<head>
								    <meta charset="utf-8" />
								    <title></title>
								    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
								</head>
								<body>
								<div>
									<div style="margin: 50px auto; padding: 20px; height: 521px; width: 556px; box-sizing: border-box; overflow: hidden; text-align: center; width: 556px; border-radius:5px; background: #fff url(http://yourdemo.live/IOE_new/static/img/nl/email_bg.png) no-repeat top left;">	
										<img style="float:left; visibility: hidden; opacity: 0; max-width: 100%;" src="http://yourdemo.live/IOE_new/static/img/nl/verfiy_email1.png" alt="verfiy_email1">
						<h1 style=" visibility: hidden; opacity: 0; display:inline-block; width:100%; position: relative; top: -3px; margin: 0px !important; padding: 19px 0px; font-size: 21px; color: #fff; background: #93acce; font-family: \'Memory\'; font-weight: 500; font-style: normal; font-stretch: normal; letter-spacing: 2px;">Verify Your Email Address</h1>
						<p style="visibility: hidden; opacity: 0; display:inline-block; width:100%; text-align: center; font-size: 18px;line-height: 21px; background:#fff; margin:0; padding: 0px; color: #5d5d5d;font-family: \'Avenir Book\';font-weight: 400;font-style: normal;font-stretch: normal;">Thank you for signing up for it’s over easy.com. <br>Click the button below to verify your email.</p>
						<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
							<strong style="display:inline-block" >'.$link.'</strong>
						</div>
					</div>
					
			</div>
								</div>
								</body>
								</html>';
				$this->email->subject('Confirm Your Account');
				$this->email->message($message);

				$this->email->send();
			}
		}
		$this->response($result);
	}
	public function welcomeData_post(){
		$data = $this->post();
		if(isset($this->session->userdata['uid'])){
			$data['uid'] = $this->session->userdata['uid'];
			$result = $this->auth_model->add_welcome_data($data);
		//	$result = array('status' => 'ERROR' , 'message'=>'User must login' );
		}
		else{
			$result = array('status' => 'ERROR' , 'message'=>'User must login' );
		}
		$this->response($result);
	}
	
	public function changePassword_post(){
		$datapost = $this->post();
		$data['email'] = $datapost['email'];
		$data['key'] = $datapost['key'];
		$this->load->view('account/changePassword', $data);
	}
	public function confirmChangePassword_post(){
		$data = $this->post();
		if($data['password'] == $data['rpassword']){
			$output = $this->auth_model->confirmChangePassword($data);
			if($output['status'] == 'SUCCESS')
				$result = array('status' =>'SUCCESS' , 'message' => 'Password successfully changed');
			else
				$result = array('status' =>'ERROR' , 'message' => 'Authendication Faild');
		}
		else{
			$result = array('status' =>'ERROR' , 'message' => 'Password does not match');
		}
		$this->load->view('account/changePassword', $result);
	}
	public function activate_post(){
		$result = $this->auth_model->activate_user($this->post());
		if(isset($result['status']) && $result['status'] == 'SUCCESS'){
			//$this->session->sess_destroy();
			$session_data = array(  
                "uid" => $result['uid'],
                "email" => $result['email']
            );
            $this->session->set_userdata('logged_in', $session_data);
		}
		$this->response($result);
	}
	public function resetPassword_post(){
		$result = $this->auth_model->checkResetPassword($this->post());
		$this->response($result);
	}
	public function session_get(){
		$data = $this->session->userdata('logged_in');
		if(isset($data['uid'])){
			$data['data'] = $this->auth_model->get_form_data($data['uid']);	
		}
		$this->response($data);
	}
	
	public function save_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$data['data']['uid'] = $user['uid'];
			$data['data']['email'] = $user['email'];
			$result = $this->auth_model->saveData($data['data']);	
		}
		else{
			$result = array('status' => 'ERROR' , 'message' => 'User Not Logged in' );	
		}		
		$this->response($result);
	}
	public function logout_get(){
		$sess_array = array();
		$this->session->unset_userdata('logged_in', $sess_array);
		$this->response(array('status' => 'SUCCESS' , 'message' => 'Logged out'));
	}
	public function loadFromData_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouse = $this->auth_model->getSpouse($user['uid']);
				if(!empty($spouse)){
					$access = array(
						'uid'=>$spouse->userId,
						'email'=>$user['email']
					);
					$output = $this->auth_model->loadUserData($access);
				}
				else{
					$output = array();
				}
			}
			else{
				$output = $this->auth_model->loadUserData($user);
			}
			$result = array('status' => 'SUCCESS' , 'message'=>'Data loaded' , 'data'=>$output);
		}
		else{
			$result = array('status' => 'ERROR' , 'message'=>'User Not Logged In' );
		}
		$this->response($result);
	}
	public function do_upload_post(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$config2['upload_path'] = './upload/';
			$config2['allowed_types'] = 'pdf';
			$config2['max_size'] = '10000';
			$config2['max_width'] = '10000';
			$config2['max_height'] = '10000';
			$file_name = 'Doc'.$user['uid'].'-'.date('Y-m-d-H-i-s');
			$config2['file_name'] = $file_name;
			$this->load->library('upload', $config2);
			if ( ! $this->upload->do_upload('file')) {
	            $error = array('error' => $this->upload->display_errors()); 
	            $this->response( $error); 
	        }
			else { 
	           // $data = array('upload_data' => $this->upload->data()); 
				$status = $this->upload->data();
				$data = array(
						'uploadedName ' => $status['file_name'],
						'documentName' => $status['client_name'],
						'uploaded' => date('m/d/Y')
					);
				$id = $this->post();
				$this->auth_model->uploadStatus($id['id'], $data);
				$email_config = Array(
		          'mailtype' => 'html', 
		          'charset' => 'utf-8',
		          'wordwrap' => TRUE
				);
				$this->email->initialize($email_config);
				$this->email->from('hello@itsovereasy.com', 'Its Over Easy');
				$this->email->to('checkdok@gmail.com');
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				$message = 'Document Upload';
				$this->email->subject('Legal Issue document');
				$this->email->message($message);
				$this->email->attach($status['full_path']);
				$this->email->send();
				$data = array('status'=>'SUCCESS', 'message'=>'Successfully uploaded'); 
	            $this->response($data); 
	        }
		}
	}
	public function updateBookmark_post(){
		//print_r($this->post());
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$data['data']['user_id'] = $user['uid'];
			//print_r($data);
			$result = $this->auth_model->updateBookmark($data);
			$out = array('status' => 'SUCCESS', 'message' => 'successfully updated');
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User not Logged In');
		}
		$this->response($data);
	}
	public function addAssets_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$data['data']['user_id'] = $user['uid'];
			$data['data']['updated'] = date('m/d/y');
			$this->auth_model->addAssets($data);
			$out = array('status' =>'SUCCESS', 'message'=>'successfully added');
		}
		else{
			$out = array('status' =>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function addDebt_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$data['data']['howMuchDebtGot'] = str_replace('$', '', $data['data']['howMuchDebtGot']);
			$data['data']['howMuchDebtGot'] = str_replace(',', '', $data['data']['howMuchDebtGot']);
			$data['data']['howMuchDebtGotSpouse'] = str_replace('$', '', $data['data']['howMuchDebtGotSpouse']);
			$data['data']['howMuchDebtGotSpouse'] = str_replace(',', '', $data['data']['howMuchDebtGotSpouse']);
			$data['data']['user_id'] = $user['uid'];
			if($data['data']['howMuchDebtGot']>0 && $data['data']['howMuchDebtGotSpouse']>0){
				$data['data']['whoWillKeep'] = 'shared';
			}
			else if($data['data']['howMuchDebtGot'] <= 0){
				$data['data']['whoWillKeep'] = 'spouse';
			}
			else{
				$data['data']['whoWillKeep'] = 'me';	
			}
			$data['data']['updated'] = date('m/d/y');
			$this->auth_model->addDebt($data);
			$out = array('status' =>'SUCCESS', 'message'=>'successfully added');
		}
		else{
			$out = array('status' =>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function loadDebt_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->getDebt($user['uid']);
			$result2 = array(
					"me" =>array(),
					"shared" =>array(),
					"spouse" =>array()
				);
			$me = 0;
			$shared = array('me'=>0, 'spouse'=>0);
			$spouse = 0;
			foreach ($result as $key => $value) {
				if($value->whoWillKeep == 'me'){
					$me +=floatval($value->howMuchDebtGot);
					$result2['me'][] = $value;
				}else if($value->whoWillKeep == 'spouse'){
					$spouse +=floatval($value->howMuchDebtGotSpouse);
					$result2['spouse'][] = $value;
				}else{
					$shared['me'] +=floatval($value->howMuchDebtGot);
					$shared['spouse'] +=floatval($value->howMuchDebtGotSpouse);
					$result2['shared'][] = $value;
				}
			}
			$total['me'] = $me;
			$total['shared'] = $shared;
			$total['spouse'] = $spouse;
			$out = array('status' => 'SUCCESS', 'message' => '' , 'data' => $result2, 'total' => $total);
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function loadAssets_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->getAssets($user['uid']);
			$result2 = array(
					"me" =>array(),
					"shared" =>array(),
					"spouse" =>array()
				);
			$me = 0;
			$spouse = 0;
			$shared = 0;
			foreach ($result as $key => $value) {
				if($value->whoWillKeep == 'me'){
					$me +=floatval($value->assetsEstimation);
					$result2['me'][] = $value;
				}else if($value->whoWillKeep == 'spouse'){
					$spouse +=floatval($value->assetsEstimation);
					$result2['spouse'][] = $value;
				}else{
					$shared +=floatval($value->assetsEstimation);
					$result2['shared'][] = $value;
				}
			}
			$total['me'] = $me;
			$total['shared'] = $shared;
			$total['spouse'] = $spouse;
			
	
			$out = array('status' => 'SUCCESS', 'message' => '' , 'data' => $result2, 'total' => $total);
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function editAsset_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$result = $this->auth_model->editAssets($data);
			$out = array('status' => 'SUCCESS', 'message' => '' , 'data' => $result);
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function dragUpdate_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($data['type'] == 'assets'){
				foreach ($data['data']['listsAssets'] as $key => $value) {
					if($key == 'me'){
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'me';
							$innervalue['updated'] = date('m/d/y');
							$this->auth_model->editAssets($innervalue['id'], $innervalue);
						}
					}
					else if($key == 'shared'){
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'shared';
							$innervalue['updated'] = date('m/d/y');
							$this->auth_model->editAssets($innervalue['id'], $innervalue);
						}
					}
					else{
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'spouse';
							$innervalue['updated'] = date('m/d/y');
							//print_r($innervalue['id']);
							$this->auth_model->editAssets($innervalue['id'], $innervalue);
						}
					}
				}
			}
			else if($data['type'] == 'debt'){
				foreach ($data['data']['listDebt'] as $key => $value) {
					if($key == 'me'){
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'me';
							$innervalue['howMuchDebtGot'] = $innervalue['debyEstimation'];
							$innervalue['howMuchDebtGotSpouse'] = 0;
							$innervalue['updated'] = date('m/d/y');
							$this->auth_model->editDebt($innervalue['id'], $innervalue);
						}
					}
					else if($key == 'shared'){
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'shared';
							$innervalue['howMuchDebtGot'] = $innervalue['debyEstimation']/2;
							$innervalue['howMuchDebtGotSpouse'] = $innervalue['debyEstimation']/2;
							$innervalue['updated'] = date('m/d/y');
							$this->auth_model->editDebt($innervalue['id'], $innervalue);
						}
					}
					else{
						foreach ($value as $innerkey => $innervalue) {
							$innervalue['whoWillKeep'] = 'spouse';
							$innervalue['howMuchDebtGot'] = 0;
							$innervalue['howMuchDebtGotSpouse'] = $innervalue['debyEstimation'];
							$innervalue['updated'] = date('m/d/y');
							//print_r($innervalue['id']);
							$this->auth_model->editDebt($innervalue['id'], $innervalue);
						}
					}
				}
			}
			
			$out = array('status' => 'SUCCESS', 'message' => '' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function loadHistory_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$final = array();
			$result = $this->auth_model->getAssets($user['uid']);
			foreach ($result as $key => $value) {
				$value->type = 'assets';
				$final[] = $value;
			}
			$result = $this->auth_model->getDebt($user['uid']);
			foreach ($result as $key => $value) {
				$value->type = 'debt';
				$final[] = $value;	
			}
			$out = array('status' => 'SUCCESS', 'message' => '' , 'data' => $final);
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function delete_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$this->auth_model->delete($data['type'], $data['id']);
			$out = array('status' => 'SUCCESS', 'message' => 'successfully Deleted' );
		}
		else{
			$out = array('status' => 'ERROR' , 'message' => 'User Not Logged in');
		}
		$this->response($out);
	}
	public function getSingle_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$result = $this->auth_model->getSingle($data['id'], $data['type']);
			$out = array('status' => 'SUCCESS', 'message'=>'successfully', 'data'=>$result );
		}
		else{
			$out = array('status' => 'ERROR' , 'message' => 'User Not Logged In');
		}
		$this->response($out);
	}
	public function editAssetsUpdate_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$result = $this->auth_model->editUpdate('assets', $data['data']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function editDebtUpdate_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			if($data['data']['howMuchDebtGotSpouse'] == '0'){
				$data['data']['whoWillKeep'] = 'me';
			}
			else if($data['data']['howMuchDebtGot'] == '0'){
				$data['data']['whoWillKeep'] = 'spouse';
			}
			else{
				$data['data']['whoWillKeep'] = 'shared';
			}
			$result = $this->auth_model->editUpdate('debt', $data['data']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function updateHoliday_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$this->auth_model->updateHoliday($user['uid'], $data['data']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		else{
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		$this->response($out);
	}
	public function getHolidays_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$out = $this->auth_model->getHolidays($user['uid']);
			if(!$out){
				$out = array('status' => 'ERROR', 'message' => 'Not Found');	
			}
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In');
		}
		
		$this->response($out);
	}
	public function csv1_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$this->load->helper('csv');
	        $out = $this->auth_model->loadAssetsCsv($user['uid']);
			echo array_to_csv($out, 'assets_'.date('Ymd_His').'.csv');
		}
		else{
			echo "User Not Logged In";
		}
	}
	public function csv_get(){

		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$assets = $this->auth_model->loadAssetsCsv($user['uid']);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->fromArray($assets, null, 'A1',true);
			$objPHPExcel->getActiveSheet()->setTitle('Assets');

			$objPHPExcel->createSheet();

			// Add some data to the second sheet, resembling some different data types
			$debts =$this->auth_model->loaddebtsCsv($user['uid']);
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->fromArray($debts, null, 'A1',true);

			// Rename 2nd sheet
			$objPHPExcel->getActiveSheet()->setTitle('Debts');

			// Save it as an excel 2003 file
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename=Report_'.date('Ymd_His').'.csv');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		else{
			echo "User Not Logged In";
		}
	}
	public function pdf_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$assetsTypeList = array(
				'',
	            'Checking Account',
	            'Savings Account',
	            'Investment Account',
	            'Qualified Retirement Account',
	            'Non-Qualified retirement account',
	            'Personal Item',
	            'Vehicle',
	            'Property',
	            'Pets'
	        );
			$assets = $this->auth_model->loadAssetsCsv($user['uid']);
			unset($assets[0]);
			$debtTypeList = array(
				'',
	            'Credit card',
	            'Past due child or spousal support',
	            'Personal loans',
	            'Student loans',
	            'Taxes',
	            'Property'
	        );
			$debts =$this->auth_model->loaddebtsCsv($user['uid']);
			unset($debts[0]);
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Nicola Asuni');
			$pdf->SetTitle('TCPDF Example 033');
			$pdf->SetSubject('TCPDF Tutorial');
			$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
			//$fontname = $pdf->addTTFfont('./application/third_party/export/tcpdf/fonts/fonts/Droid Serif Bold.ttf', 'TrueTypeUnicode', '', 32);
			// set default header data
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// add a page
			$pdf->AddPage();

			// set default font subsetting mode
			$pdf->setFontSubsetting(false);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Review', '', 0, 'C', 1, 0, false, false, 0);
			$pdf->Ln(7);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Me', '', 0, 'L', 1, 0, false, false, 0);

			$html ='<hr>';
			$pdf->writeHTML($html, false, false, true, false, '');
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 18);
			$pdf->Write(0, 'Assets', '', 0, 'L', 1, 0, false, false, 0);
			//$pdf->Ln(5);
			$assetsTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($assets as $key => $value) {
				if($value['whoWillKeep'] == 'me'){
					foreach ($assetsTypeList as $key2 => $value2) {
						if(strcmp($value['assetName'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/assets/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->Write(10, $value['assetName'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(10, '$'.$value['assetsEstimation'], '', 0, 'R', 1, 0, false, false, 0);
					$assetsTotal +=$value['assetsEstimation'];
				}

			}
			$pdf->Ln(10);

			$pdf->SetFont('helvetica', 'B', 18);
			$pdf->Write(0, 'Debts', '', 0, 'L', 1, 0, false, false, 0);
			//$pdf->Ln(5);
			$debtTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($debts as $key => $value) {
				if($value['whoWillKeep'] == 'me'){
					foreach ($debtTypeList as $key2 => $value2) {
						if(strcmp($value['debtType'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/debts/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->SetTextColor(0, 0, 0);
					$pdf->Write(10, $value['debtType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->SetTextColor(255, 0, 0);
					$pdf->Write(10, '-$'.$value['howMuchDebtGot'], '', 0, 'R', 1, 0, false, false, 0);
					$debtTotal +=$value['howMuchDebtGot'];
				}
			}
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 14);
			$total = $assetsTotal-$debtTotal;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Write(0, 'Total: $'.$total, '', 0, 'R', 1, 0, false, false, 0);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Spouse', '', 0, 'L', 1, 0, false, false, 0);

			$html ='<hr>';
			$pdf->writeHTML($html, false, false, true, false, '');
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Assets', '', 0, 'L', 1, 0, false, false, 0);

			$assetsTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($assets as $key => $value) {
				if($value['whoWillKeep'] == 'spouse'){
					foreach ($assetsTypeList as $key2 => $value2) {
						if(strcmp($value['assetName'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/assets/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
					}
					$pdf->Write(10, $value['assetName'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(10, '$'.$value['assetsEstimation'], '', 0, 'R', 1, 0, false, false, 0);
					$assetsTotal +=$value['assetsEstimation'];
				}
			}
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Debts', '', 0, 'L', 1, 0, false, false, 0);

			$debtTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($debts as $key => $value) {
				if($value['whoWillKeep'] == 'spouse'){
					foreach ($debtTypeList as $key2 => $value2) {
						if(strcmp($value['debtType'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/debts/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->SetTextColor(0, 0, 0);
					$pdf->Write(10, $value['debtType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->SetTextColor(255, 0, 0);
					$pdf->Write(10, '-$'.$value['howMuchDebtGotSpouse'], '', 0, 'R', 1, 0, false, false, 0);
					$debtTotal +=$value['howMuchDebtGotSpouse'];
				}
			}
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 14);
			$total = $assetsTotal-$debtTotal;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Write(0, 'Total: $'.$total, '', 0, 'R', 1, 0, false, false, 0);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Shared', '', 0, 'L', 1, 0, false, false, 0);

			$html ='<hr>';
			$pdf->writeHTML($html, false, false, true, false, '');
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Assets', '', 0, 'L', 1, 0, false, false, 0);

			$assetsTotalMe = 0;
			$assetsTotalSpouse = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($assets as $key => $value) {
				if($value['whoWillKeep'] == 'shared'){
					foreach ($assetsTypeList as $key2 => $value2) {
						if(strcmp($value['assetName'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/assets/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
					}
					$pdf->Write(10, $value['assetName'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(7, 'Me: $'.$value['assetsEstimation']/2, '', 0, 'R', 1, 0, false, false, 0);
					$pdf->Write(7, 'Spouse: $'.$value['assetsEstimation']/2, '', 0, 'R', 1, 0, false, false, 0);
					$assetsTotalMe +=$value['assetsEstimation']/2;
					$assetsTotalSpouse +=$value['assetsEstimation']/2;
					$pdf->Ln(1);
				}
			}
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Debts', '', 0, 'L', 1, 0, false, false, 0);

			$pdf->SetFont('helvetica', 'B', 12);
			$debtTotalMe = 0;
			$debtTotalSpouse = 0;
			foreach ($debts as $key => $value) {
				if($value['whoWillKeep'] == 'shared'){
					foreach ($debtTypeList as $key2 => $value2) {
						if(strcmp($value['debtType'],$value2) == 0){
							$pdf->Image('static/img/icons/have_owe/debts/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->SetTextColor(0, 0, 0);
					$pdf->Write(10, $value['debtType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->SetTextColor(255, 0, 0);
					$pdf->Write(7, 'Me: -$'.$value['howMuchDebtGot'], '', 0, 'R', 1, 0, false, false, 0);
					$pdf->Write(7, 'Spouse: -$'.$value['howMuchDebtGotSpouse'], '', 0, 'R', 1, 0, false, false, 0);
					$pdf->Ln(2);
					$debtTotalMe +=$value['howMuchDebtGot'];
					$debtTotalSpouse +=$value['howMuchDebtGotSpouse'];
				}
			}
			$pdf->Ln(5);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('helvetica', 'B', 14);
			$totalMe = $assetsTotalMe-$debtTotalMe;
			$totalSpouse = $assetsTotalSpouse-$debtTotalSpouse;
			$pdf->Write(0, 'My Total: $'.$totalMe, '', 0, 'R', 1, 0, false, false, 0);
			$pdf->Write(0, 'Spouse\'s Total: $'.$totalSpouse, '', 0, 'R', 1, 0, false, false, 0);

			//$pdf->writeHTML($assetsShared, true, false, true, false, '');
			// ---------------------------------------------------------
			//Close and output PDF document
			$pdf->Output('Report_'.date('Ymd_His').'.pdf', 'D');
			exit;
		}
		else{
			echo "User Not Logged In";
		}
	}
	public function loadData_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->loadData($user['uid']);
			$total = array();
			$me = 0;
			$spouse = 0;
			foreach ($result['income']['Me'] as $key2 => $value2) {
				$me +=$value2['howMuchIncome'];
			}
			foreach ($result['income']['Spouse'] as $key2 => $value2) {
				$spouse +=$value2['howMuchIncome'];
			}
			
			$total['income']['me'] = $me;
			$total['income']['spouse'] = $spouse;
			$me = 0;
			$spouse = 0;
			
			foreach ($result['expense']['Me'] as $key2 => $value2) {
				$me +=$value2['expenseEstimation'];
			}
			foreach ($result['expense']['Spouse'] as $key2 => $value2) {
				$spouse +=$value2['expenseEstimation'];
			}
			
			$total['expense']['me'] = $me;
			$total['expense']['spouse'] = $spouse;
			//$total = $this->auth_model->loadTotal($user['uid']);
			$out = array('status'=>'SUCCESS', 'message'=>'successfully', 'data'=>$result, 'total'=>$total);
		}
		else{

		}
		$this->response($out);
	}
	public function addIncome_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$data['data']['user_id'] = $user['uid'];
			$data['data']['updated'] = date('m/d/Y');
			$this->auth_model->addData('income', $data['data']);
			$out = array('status'=>'SUCCESS', 'message'=>'successfully added');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged in');
		}
		$this->response($out);
	}
	public function addExpense_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$data['data']['user_id'] = $user['uid'];
			$data['data']['updated'] = date('m/d/Y');
			$this->auth_model->addData('expense', $data['data']);
			$out = array('status'=>'SUCCESS', 'message'=>'Successfully Added');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function loadHistoryMS_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$final = array();
			$result = $this->auth_model->loadData($user['uid']);

			foreach ($result as $key => $value) {

				foreach ($value['Me'] as $key2 => $value2) {
					if($key == 'income'){
						$value2['type'] = 'income';
						$final[] = $value2;
					}else{
						$value2['type'] = 'expense';
						$final[] = $value2;
					}
				}
				foreach ($value['Spouse'] as $key2 => $value2) {
					if($key == 'income'){
						$value2['type'] = 'income';
						$final[] = $value2;
					}else{
						$value2['type'] = 'expense';
						$final[] = $value2;
					}	
				}
			}
			$out = array('status' => 'SUCCESS', 'message' => '' , 'data' => $final);
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function getDealData_get(){
		$user = $this->session->userdata('logged_in');
		if($user['uid']){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$data = $this->auth_model->getDealData($user['uid']);
			$out = array('status' => 'SUCCESS', 'message'=>'', 'data'=>$data);
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged Im');
		}
		$this->response($out);
	}
	public function csvMakeSpend_get(){

		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$assets = $this->auth_model->loadIncomeCsv($user['uid']);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->fromArray($assets, null, 'A1',true);
			$objPHPExcel->getActiveSheet()->setTitle('Income');

			$objPHPExcel->createSheet();

			// Add some data to the second sheet, resembling some different data types
			$debts =$this->auth_model->loadExpenseCsv($user['uid']);
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->fromArray($debts, null, 'A1',true);

			// Rename 2nd sheet
			$objPHPExcel->getActiveSheet()->setTitle('Expense');

			// Save it as an excel 2003 file
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename=Report_'.date('Ymd_His').'.csv');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
		else{
			echo "User Not Logged In";
		}
	}
	public function editIncomeUpdate_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$result = $this->auth_model->editUpdate('income', $data['data']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function editExpenseUpdate_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$result = $this->auth_model->editUpdate('expense', $data['data']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Updated' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function pdfMakeSpend_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$assetsTypeList = array(
				'',
				'Salary or wages',
				'Overtime',
				'Commissions or bonus',
				'Public assistance',
				'Spousal support',
				'Pension/retirement fund payments',
				'Social security retirement',
				'Disability',
				'Unemployment compensation',
				'Workers\' compensation',
				'Other',
				'Self-employment'
	        );
			$assets = $this->auth_model->loadIncomeCsv($user['uid']);
			unset($assets[0]);
			$debtTypeList = array(
				'',
	            'Auto',
				'Charitable contributions',
				'Child care',
				'Clothes',
				'Education',
				'Groceries/household',
				'Home',
				'Health-care cost not paid insurance',
				'Homeowner\'s insurance',
				'Installment payments',
				'Insurance',
				'Laundry/cleaning',
				'Maintenance and Repair',
				'Other',
				'Property taxes',
				'Recreational',
				'Savings/investment',
				'Telephone',
				'Utilities'
	        );
			$debts =$this->auth_model->loadExpenseCsv($user['uid']);
			unset($debts[0]);
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Nicola Asuni');
			$pdf->SetTitle('TCPDF Example 033');
			$pdf->SetSubject('TCPDF Tutorial');
			$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
			//$fontname = $pdf->addTTFfont('./application/third_party/export/tcpdf/fonts/fonts/Droid Serif Bold.ttf', 'TrueTypeUnicode', '', 32);
			// set default header data
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------

			// add a page
			$pdf->AddPage();

			// set default font subsetting mode
			$pdf->setFontSubsetting(false);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Review', '', 0, 'C', 1, 0, false, false, 0);
			$pdf->Ln(7);

			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Me', '', 0, 'L', 1, 0, false, false, 0);

			$html ='<hr>';
			$pdf->writeHTML($html, false, false, true, false, '');
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 18);
			$pdf->Write(0, 'Income', '', 0, 'L', 1, 0, false, false, 0);
			//$pdf->Ln(5);
			$assetsTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($assets as $key => $value) {
				if($value['incomeBelongto'] == 'Me'){
					foreach ($assetsTypeList as $key2 => $value2) {
						if(strcmp($value['incomeType'],$value2) == 0){
							$pdf->Image('static/img/icons/make_spend/income/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->Write(10, $value['incomeType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(10, '$'.$value['howMuchIncome'], '', 0, 'R', 1, 0, false, false, 0);
					$assetsTotal +=$value['howMuchIncome'];
				}

			}
			$pdf->SetFont('helvetica', 'B', 14);
			$total = $assetsTotal;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Write(0, 'Total: $'.$total, '', 0, 'R', 1, 0, false, false, 0);

			$pdf->Ln(10);

			$pdf->SetFont('helvetica', 'B', 18);
			$pdf->Write(0, 'Expense', '', 0, 'L', 1, 0, false, false, 0);
			//$pdf->Ln(5);
			$debtTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($debts as $key => $value) {
				if($value['belongTo'] == 'Me'){
					foreach ($debtTypeList as $key2 => $value2) {
						if(strcmp($value['expenseType'],$value2) == 0){
							$pdf->Image('static/img/icons/make_spend/expense/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->SetTextColor(255, 0, 0);
					$pdf->Write(10, $value['expenseType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(10, '-$'.$value['expenseEstimation'], '', 0, 'R', 1, 0, false, false, 0);
					$debtTotal +=$value['expenseEstimation'];
				}
			}
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetFont('helvetica', 'B', 14);
			$total = $debtTotal;
			$pdf->Write(0, 'Total: -$'.$total, '', 0, 'R', 1, 0, false, false, 0);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->Write(0, 'Spouse', '', 0, 'L', 1, 0, false, false, 0);
			$html ='<hr>';
			$pdf->writeHTML($html, false, false, true, false, '');
			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Income', '', 0, 'L', 1, 0, false, false, 0);

			$assetsTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($assets as $key => $value) {
				if($value['incomeBelongto'] == 'Spouse'){
					foreach ($assetsTypeList as $key2 => $value2) {
						if(strcmp($value['incomeType'],$value2) == 0){
							$pdf->Image('static/img/icons/make_spend/income/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
					}
					$pdf->Write(10, $value['incomeType'], '', 0, 'L', 0, 0, false, false, 0);
					$pdf->Write(10, '$'.$value['howMuchIncome'], '', 0, 'R', 1, 0, false, false, 0);
					$assetsTotal +=$value['howMuchIncome'];
				}
			}
			$pdf->SetFont('helvetica', 'B', 14);
			$total = $assetsTotal;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Write(0, 'Total: $'.$total, '', 0, 'R', 1, 0, false, false, 0);

			$pdf->Ln(5);

			$pdf->SetFont('helvetica', 'B', 15);
			$pdf->Write(0, 'Expense', '', 0, 'L', 1, 0, false, false, 0);

			$debtTotal = 0;
			$pdf->SetFont('helvetica', 'B', 12);
			foreach ($debts as $key => $value) {
				if($value['belongTo'] == 'Spouse'){
					foreach ($debtTypeList as $key2 => $value2) {
						if(strcmp($value['expenseType'],$value2) == 0){
							$pdf->Image('static/img/icons/make_spend/expense/'.$key2.'.png', '', '', '10', '10', 'PNG', '', 'T', false, 72, '', false, false, 1, false, false, false);		
						}
						else{

						}
					}
					$pdf->SetTextColor(255, 0, 0);
					$pdf->Write(10, $value['expenseType'], '', 0, 'L', 0, 0, false, false, 0);
					
					$pdf->Write(10, '-$'.$value['expenseEstimation'], '', 0, 'R', 1, 0, false, false, 0);
					$debtTotal +=$value['expenseEstimation'];
				}
			}
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetFont('helvetica', 'B', 14);
			$total = $debtTotal;
			$pdf->Write(0, 'Total: -$'.$total, '', 0, 'R', 1, 0, false, false, 0);

			//$pdf->writeHTML($assetsShared, true, false, true, false, '');
			// ---------------------------------------------------------
			//Close and output PDF document
			$pdf->Output('Report_'.date('Ymd_His').'.pdf', 'D');
			exit;
		}
		else{
			echo "User Not Logged In";
		}
	}
	public function saveCurrentJob_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$data['data']['user_id'] = $user['uid'];
			$result = $this->auth_model->saveCurrentJob($data);
			$out = array('status'=>'SUCCESS', 'message'=>'Successfully Added');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function loadCurrentJob_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->checkCurrentJob($user['uid']);
			$out = array('status'=>'SUCCESS', 'result'=>$result);
		}
		else{
			$out = array('status'=>'ERROR', 'result'=>false);
		}
		$this->response($out);
	}
	public function loadCurrentJobData_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->CurrentJobData($user['uid']);
			$out = array('status'=>'SUCCESS', 'result'=>$result);
		}
		else{
			$out = array('status'=>'ERROR', 'result'=>false);
		}
		$this->response($out);
	}
	public function DealStatus_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$result = $this->auth_model->loadBookmark($user['uid']);
			$out = array('status' => 'SUCCESS' , 'data' => $result );
		}
		else{
			$out = array('status' => 'ERROR', 'data' => '');
		}
		$this->response($out);
	}
	public function initInvite_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$result = $this->auth_model->initInvite($user['uid']);
			$out = array('status'=>'SUCCESS', 'message'=>'', 'result'=>$result);
		}
		else
		{
			$out = array('status'=>'ERROR', 'message'=>'user not logged in');
		}
		$this->response($out);
	}
	public function invite_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if(isset($user['uid'])){
			$checkSame = $this->auth_model->checkSame($user['uid'], $data['email']);
			if($checkSame){
				$out = array('status'=>'ERROR', 'message'=>'User Already Exists');
			}
			else{
				$key = $this->encryption->create_key(32);
				$key = md5($key); 
				$sdata = array(
						'userId'=>$user['uid'],
						'email'=>$data['email'],
						'inviteKey'=>$key,
					);
				$this->auth_model->addData('invite', $sdata);
				$email = $data['email'];
				$email_config = Array(
		          'mailtype' => 'html', 
		          'charset' => 'utf-8',
		          'wordwrap' => TRUE
				);
				$this->email->initialize($email_config);
				$this->email->from('anthony@newlineinfo.com', 'Antony');
				$this->email->to($data['email']);
				//$this->email->cc('another@another-example.com');
				//$this->email->bcc('them@their-example.com');
				$email = $data['email'];
				$link =$this->config->config['base_url']."account/invite/?email=".$email."&key=".$key;
				$message = '
<table 
	style="border-collapse:collapse" 
	cellspacing="0" 
	cellpadding="0" 
	border="0" 
	width="100%">
	<tbody>
		<tr>
			<td 
				style="
						background:#f7f7f7 none no-repeat center/cover;
						background-color:#f7f7f7;
						background-image:none;
						background-repeat:no-repeat;
						background-position:center;
						background-size:cover;
						border-top:0;
						border-bottom:0;
						padding-top:45px;
						padding-bottom:45px" 
				valign="top" 
				align="center">
				<table 
					style="border-collapse:collapse;
							max-width:600px!important" 
					cellspacing="0" 
					cellpadding="0" 
					align="center" 
					border="0" 
					width="100%">
					<tbody>
						<tr>
							<td 
								style="
									background:transparent none no-repeat center/cover;
									background-color:transparent;
									background-image:none;
									background-repeat:no-repeat;
									background-position:center;
									background-size:cover;
									border-top:0;
									border-bottom:0;
									padding-top:0;
									padding-bottom:0" 
								valign="top">
								<table 
									style="min-width:100%;
										border-collapse:collapse" 
									cellspacing="0" 
									cellpadding="0" 
									border="0" 
									width="100%">
    								<tbody>
            							<tr>
                							<td style="padding:9px" valign="top">
                    							<table 
                    								style="min-width:100%;border-collapse:collapse" 
                    								cellspacing="0" 
                    								cellpadding="0" 
                    								align="left" 
                    								border="0" 
                    								width="100%">
                        							<tbody>
                        								<tr>
                            								<td 
                            									style="padding-right:9px;
                            										padding-left:9px;
                            										padding-top:0;
                            										padding-bottom:0;
                            										text-align:center" 
                            									valign="top">
                                								<a href="http://yourdemo.site/img/logo.png" 
                                									title="" 
                                									style="max-width:149px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none" 
                                									align="middle" 
                                									width="149">
                                    							</a>
                            								</td>
                        								</tr>
                									</tbody>
                								</table>
                							</td>
            							</tr>
    								</tbody>
								</table>
								<table 
									style="min-width:100%;border-collapse:collapse" 
									cellspacing="0" 
									cellpadding="0" 
									border="0" 
									width="100%">
    								<tbody>
        								<tr>
            								<td style="padding-top:9px" valign="top">
								                <table 
								                	style="max-width:100%;min-width:100%;border-collapse:collapse" 
								                	cellspacing="0" 
								                	cellpadding="0" 
								                	align="left" 
								                	border="0" 
								                	width="100%">
                    								<tbody>
                    									<tr>
                        			                        <td 
                        			                        	style="padding-top:0;
                        			                        		padding-right:18px;
                        			                        		padding-bottom:9px;
                        			                        		padding-left:18px;
                        			                        		word-break:break-word;
                        			                        		color:#808080;
                        			                        		font-family:Helvetica;font-size:16px;
                        			                        		line-height:150%;
                        			                        		text-align:left" 
                        			                        	valign="top">
                            									<h1 style="display:block;
                            											margin:0;
                            											padding:0;
                            											color:#222222;
                            											font-family:Helvetica;
                            											font-size:40px;
                            											font-style:normal;
                            											font-weight:bold;
                            											line-height:150%;
                            											letter-spacing:normal;
                            											text-align:center"
                            											>Showcase your products.</h1>
                        									</td>
                    									</tr>
        											</tbody>
        										</table>
            								</td>
        								</tr>
    								</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
        </tr>
		<tr>
			<td style="background:#ffffff none no-repeat center/cover;
					background-color:#ffffff;
					background-image:none;
					background-repeat:no-repeat;
					background-position:center;
					background-size:cover;
					border-top:0;
					border-bottom:0;
					padding-top:36px;
					padding-bottom:45px" 
				valign="top" 
				align="center">
				<table 
					style="border-collapse:collapse;max-width:600px!important" 
					cellspacing="0" 
					cellpadding="0" 
					align="center" 
					border="0" 
					width="100%">
					<tbody>
						<tr>
							<td 
								style="background:transparent none no-repeat center/cover;
									background-color:transparent;
									background-image:none;
									background-repeat:no-repeat;
									background-position:center;
									background-size:cover;
									border-top:0;
									border-bottom:0;
									padding-top:0;
									padding-bottom:0" 
								valign="top">
								<table 
									style="min-width:100%;border-collapse:collapse" 
									cellspacing="0" 
									cellpadding="0" 
									border="0" 
									width="100%">
    								<tbody>
            							<tr>
                							<td 
                								style="padding:9px" 
                								valign="top">
                    							<table 
                    								style="min-width:100%;border-collapse:collapse" 
                    								cellspacing="0" 
                    								cellpadding="0" 
                    								align="left" 
                    								border="0" 
                    								width="100%">
                        							<tbody>
                        								<tr>
                            								<td 
                            									style="padding-right:9px;
                            										padding-left:9px;
                            										padding-top:0;
                            										padding-bottom:0;
                            										text-align:center" 
                            									valign="top">
                                						        <img alt="" 
                                						        	src="https://cdn-images.mailchimp.com/template_images/gallery/img-placeholder.png" style="max-width:1128px;
                                						        		padding-bottom:0;
                                						        		display:inline!important;
                                						        		vertical-align:bottom;
                                						        		border:0;
                                						        		height:auto;
                                						        		outline:none;
                                						        		text-decoration:none" 
                                						        	tabindex="0" 
                                						        	align="middle" 
                                						        	width="564">
                            								</td>
                    									</tr>
                    								</tbody>
                    							</table>
                							</td>
            							</tr>
    								</tbody>
								</table>
								<table 
									style="min-width:100%;border-collapse:collapse" 
									cellspacing="0" 
									cellpadding="0" 
									border="0" 
									width="100%">
    								<tbody>
        								<tr>
            								<td style="padding-top:9px" valign="top">
              					                <table 
              					                	style="max-width:100%;	
              					                		min-width:100%;
              					                		border-collapse:collapse" 
              					                	cellspacing="0" 
              					                	cellpadding="0" 
              					                	align="left" 
              					                	border="0" 
              					                	width="100%">
                    								<tbody>
                    									<tr>
                        			                        <td 
                        			                        	style="padding-top:0;
                        			                        		padding-right:18px;
                        			                        		padding-bottom:9px;
                        			                        		padding-left:18px;
                        			                        		word-break:break-word;
                        			                        		color:#808080;
                        			                        		font-family:Helvetica;
                        			                        		font-size:16px;
                        			                        		line-height:150%;
                        			                        		text-align:left" 
                        			                        	valign="top">
                        			                            <h3 style="display:block;
                        			                            		margin:0;padding:0;
                        			                            		color:#444444;
                        			                            		font-family:Helvetica;
                        			                            		font-size:22px;
                        			                            		font-style:normal;
                        			                            		font-weight:bold;
                        			                            		line-height:150%;
                        			                            		letter-spacing:normal;
                        			                            		text-align:left">Feature the star of your collection first.</h3>
																<p style="margin:10px 0;
																		padding:0;
																		color:#808080;
																		font-family:Helvetica;
																		font-size:16px;
																		line-height:150%;
																		text-align:left">To get started, replace the image above with a striking product photo to catch people\'s attention.</p>
																<p style="margin:10px 0;
																		padding:0;
																		color:#808080;
																		font-family:Helvetica;
																		font-size:16px;
																		line-height:150%;
																		text-align:left">Then, describe what makes your product unique, useful, or gift-worthy. Be sure to highlight the main features, and let people know where it\'s available.</p>
                    										</td>
                    									</tr>
                									</tbody>
                								</table>
        									</td>
        								</tr>
    								</tbody>
								</table>
								<table 
									style="min-width:100%;border-collapse:collapse" 
									cellspacing="0" 
									cellpadding="0" 
									border="0" 
									width="100%">
    								<tbody>
        								<tr>
        									<td 
        										style="padding-top:0;
        											padding-right:18px;
        											padding-bottom:18px;
        											padding-left:18px" 
        										valign="top" 
        										align="center">
                								<table 
                									style="border-collapse:separate!important;
                										border-radius:3px;
                										background-color:#00add8" 
                									cellspacing="0" 
                									cellpadding="0" 
                									border="0">
                									<tbody>
                        								<tr>
                            								<td style="font-family:Helvetica;font-size:18px;padding:18px" 
                            									valign="middle" 
                            									align="center">
                                								<a title="Start Shopping" href="'.$link.'"
                                									style="font-weight:bold;
                                										letter-spacing:-0.5px;
                                										line-height:100%;
                                										text-align:center;
                                										text-decoration:none;
                                										color:#ffffff;
                                										display:block">Confirm</a>
                    										</td>
                        								</tr>
                    								</tbody>
                								</table>
            								</td>
        								</tr>
    								</tbody>
								</table>
								
							</td>
						</tr>
					</tbody>
				</table>
			</td>
       </tr>
	</tbody>
</table>';
				$this->email->subject('Email Test');
				$this->email->message($message);

				$this->email->send();
				$out = array('status'=>'SUCCESS', 'message'=>'Successfully Invited');
			}
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function validateInvite_post(){
		$array_items = array("uid", "email", "welcome");
		$this->session->unset_userdata($array_items);
		
		$result = $this->auth_model->validateInvite($this->post());
		if($result){
			$out = array('status'=>'SUCCESS', 'message'=>'ok');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'Not Found');
		}
		$this->response($out);
	}
	public function addSpouse_post(){
		$result = $this->auth_model->validateInvite($this->post());
		if($result){
			$add = $this->auth_model->addSpouse($this->post());
			if(isset($add)){
				extract($this->post());
				$emailData = $this->auth_model->loadEmailData($user['uid']);
				$email_config = Array(
		          'mailtype' => 'html', 
		          'charset' => 'utf-8',
		          'wordwrap' => TRUE
				);
				$this->email->initialize($email_config);
				$this->email->from('hello@itsovereasy.com', 'Its Over Easy');
				$this->email->to($emailData->UserEamil);
				$message = "Your spouse ".$emailData->SpouseName." has joined the It's Over Easy. <br />
						Email ID - ".$email;
				$this->email->subject('Itsovereasy');
				$this->email->message($message);

				$this->email->send();
				
				$s = array(
						"uid" => $add,
		                "email" => $email,
		                "welcome"=>true
					);
				$this->session->userdata($s);
				
			}
			redirect("");
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'Not Found');
		}
	}
	public function confirmDob_post(){
		$data = $this->post();
		$result = $this->auth_model->validateInvite($data);
		if($result){
			$verify = $this->auth_model->verifyDob($data['dob'], $data['email']);
			
			$out = array('status'=>'SUCCESS', 'message'=>'successfully verified');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'Verification Failed');
		}
		$this->response($out);
	}
public function contactEmail_post(){
		$data = $this->post();
		$data = $data['data'];

		// $data['name'];
		// $data['phoneno'];
		// $data['email'];
		// $data['question'];
		// $data['message'];

		$email_config = Array(
          'mailtype' => 'html', 
          'charset' => 'utf-8',
          'wordwrap' => TRUE
		);
		$this->email->initialize($email_config);
		$this->email->from('hello@itsovereasy.com', 'Its Over Easy');
		$this->email->to('checkdok@gmail.com');
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		//$email = $data['customer']['username'];
		// $link ="<a style='display:inline-block' href='".$this->config->config['base_url']."account/?email=$email&key=$key'><img style='float:left; max-width: 100%;' src='http://yourdemo.live/IOE_new/static/img/nl/email_active_btn.png' alt='verfiy_email'></a>";
		$message = '<!DOCTYPE html>
						<html>
						<head>
						    <meta charset="utf-8" />
						    <title></title>
						    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
						</head>
						<body>
						<div>
							<div style="margin: 50px auto; padding: 20px; height: 650px; width: 556px; box-sizing: border-box; overflow: hidden; text-align: center; width: 556px; border-radius:5px; background: #fff url(http://yourdemo.live/IOE_new/static/img/nl/email_bg.png) no-repeat top left;">	
								<img style="float:left; visibility: hidden; opacity: 0; max-width: 100%;" src="http://yourdemo.site/app/static/img/nl/verfiy_email1.png" alt="verfiy_email1">
				<h1 style=" visibility: hidden; opacity: 0; display:inline-block; width:100%; position: relative; top: -3px; margin: 0px !important; padding: 19px 0px; font-size: 21px; color: #fff; background: #93acce; font-family: \'Memory\'; font-weight: 500; font-style: normal; font-stretch: normal; letter-spacing: 2px;">Verify Your Email Address</h1>
				<p style="visibility: hidden; opacity: 0; display:inline-block; width:100%; text-align: center; font-size: 18px;line-height: 21px; background:#fff; margin:0; padding: 0px; color: #5d5d5d;font-family: \'Avenir Book\';font-weight: 400;font-style: normal;font-stretch: normal;">Dear Admin,<br />You have received a Enquiry/feedback details below.</p>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" >Name: '.$data["name"].'</strong>
				</div>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" >Phone: '.$data["phoneno"].'</strong>
				</div>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" >Email: '.$data["email"].'</strong>
				</div>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" >What is your question related to?: '.$data["question"].'</strong>
				</div>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" >Message: '.$data["message"].'</strong>
				</div>
				<div style="width: 100%;float: left; text-align:center; margin: 15px 0px;">
					<strong style="display:inline-block" ></strong>
				</div>
			</div>
			
	</div>
						</div>
						</body>
						</html>';
		$this->email->subject('Contact Form');
		$this->email->message($message);

		$this->email->send();
	}
	public function addEmpty_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$add = array(
					'kidId'=>$data['kid']
				);
			$result = $this->auth_model->addEmpty('kidslegalissue', $add);
			$out = array('status'=>'SUCCESS', 'message'=>'', 'id'=>$result);
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function updateFlag_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		$qs = '';
		if(isset($user['uid'])){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$old = $this->auth_model->getInviteFlag($user['uid']);
			if(!empty($old)){
				$old = unserialize($old->data);
				if($data['kid'] == -1){
					$old[$data['name']] = $data['status'];
					$qs = $data['qs'];
				}
				else{
					if($data['kaid'] == -1 && $data['klid'] == -1 && $data['kpid'] == -1 && $data['klcid'] == -1){
						$old['kid'][$data['kid']][$data['name']] = $data['status'];
						$qs = "kid #".$data['kid']." ".$data['qs'];
					}
					else if($data['kaid'] != -1){
						$old['kid'][$data['kid']]['address'][$data['kaid']][$data['name']] = $data['status'];
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['kaid'];
					}
					else if($data['klid'] != -1){
						$old['kid'][$data['kid']]['legalissue'][$data['klid']][$data['name']] = $data['status'];
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['klid'];
					}
					else if($data['kpid'] != -1){
						$old['kid'][$data['kid']]['protective'][$data['kpid']][$data['name']] = $data['status'];	
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['kpid'];
					}
					else if($data['klcid'] != -1){
						$old['kid'][$data['kid']]['legalclaim'][$data['klcid']][$data['name']] = $data['status'];
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['klcid'];
					}
				}
				$update = array(
						'data'=>serialize($old),
						'updated'=>date('m/d/Y H:i:s')
					);

				$this->auth_model->updateinviteFlag($user['uid'], $update);
			}
			else{
				if($data['kid'] == -1){
					$new = array($data['name']=>$data['status']);
					$qs = $data['qs'];
				}
				else{
					if($data['kaid'] == -1 && $data['klid'] == -1 && $data['kpid'] == -1 && $data['klcid'] == -1){
						$new['kid'] = array(
							$data['kid'] => array(
									$data['name']=>$data['status']
								)
							);
						$qs = "kid #".$data['kid']." ".$data['qs'];
					}
					else if($data['kaid'] != -1){
						$new['kid'] = array(
							$data['kid'] => array(
									'address'=>array(
											$data['kaid'] => array(
													$data['name']=>$data['status']
												)
										)
								)
							);
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['kaid'];
					}
					else if($data['klid'] != -1){
						$new['kid'] = array(
							$data['kid'] => array(
									'Legalissue'=>array(
											$data['klid'] => array(
													$data['name']=>$data['status']
												)
										)
								)
							);
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['klid'];
					}
					else if($data['kpid'] != -1){
						$new['kid'] = array(
							$data['kid'] => array(
									'protective'=>array(
											$data['kpid'] => array(
													$data['name']=>$data['status']
												)
										)
								)
							);
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['kpid'];
					}
					else if($data['klcid'] != -1){
						$new['kid'] = array(
							$data['kid'] => array(
									'legalclaim'=>array(
											$data['klcid'] => array(
													$data['name']=>$data['status']
												)
										)
								)
							);
						$qs = "kid #".$data['kid']." ".$data['qs']." ".$data['klcid'];
					}
				}
				$add = array(
						'data'=>serialize($new),
						'userId'=>$user['uid']
					);
				$this->auth_model->addInviteFlag($add);
			}
			$emailData = $this->auth_model->loadEmailData($user['uid']);
			$email_config = Array(
	          'mailtype' => 'html', 
	          'charset' => 'utf-8',
	          'wordwrap' => TRUE
			);
			$this->email->initialize($email_config);
			$this->email->from('hello@itsovereasy.com', 'Its Over Easy');
			$this->email->to($emailData->UserEamil);
			$message = "
					Dear ".$emailData->MyName." <br/><br />

					Your spouse ".$emailData->SpouseName." has a question about: <br /><br />

					Question: ".$qs."<br />
					Response:  ".$data['ans']."<br /><br />

					Please log into your It's Over Easy account here (<a href='http://yourdemo.us-west-2.elasticbeanstalk.com/app/#!/dashboard'>links to login page</a>) to view this issue. <br /><br />
			";
			$this->email->subject('Itsovereasy');
			$this->email->message($message);

			$this->email->send();
			$out = array();
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
	public function loadInviteFlag_get(){
		$user = $this->session->userdata('logged_in');
		if($user['uid']){
			if($user['userType'] == 3){
				$spouseId = $this->auth_model->getSpouse($user['uid']);
				$user['uid'] = $spouseId->userId;
			}
			$old = $this->auth_model->getInviteFlag($user['uid']);
			$out = unserialize($old->data);
		}
		else{
			$out = array('status'=>'ERROR');
		}
		$this->response($out);
	}
}