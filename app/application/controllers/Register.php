<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

class Register extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('auth_model');
		$this->load->library('user_agent');
	    $this->load->library('email');
	    $this->load->library('encryption');
	}
	public function index_get()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			$this->load->view('home_view', $data);
		}
		else
		{
			$this->load->view('register');
		}
	}
	public function index_post()
	{
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
}
