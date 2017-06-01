<?php defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;

class Home extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('auth_model');
	}
	public function index_get()
	{
		$user = $this->session->userdata();
		if(!isset($user['logged_in']) && empty($user['logged_in'])){
			$this->load->view('login_view');	
		}
		else{
			$this->load->view('default');
		}
		
	}
	public function login_post(){
		$this->form_validation->set_message('valid_email', 'Please enter valid Email Address');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$out = array('status'=>'ERROR', 'message'=>validation_errors());
		} else {
			$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
			);
			$result = $this->auth_model->login($this->input->post('username'), $this->input->post('password'));
			
			if(isset($result['uid'])){
				$session_data = array(
					"uid" => $result['uid'],
		            "email" => $result['email'],
	                "welcome"=>$result['welcome'],
	                "userType"=>$result['userType']
				);
				
				$this->session->set_userdata('logged_in', $session_data);
				$out = array('status'=>'SUCCESS', 'message'=>'');	
			}
			else{
				$out = $result;
			}
		}
		$this->response($out);
	}
	public function homeView_get($page = 'home_page'){
		$this->load->view($page);
	}
	public function ourProcess_get(){
		$this->load->view('account/price_comparison');
	}
	public function logout_get(){
		$sess_array = array();
		$this->session->unset_userdata('logged_in', $sess_array);
		redirect(base_url(), 'refresh');
	}

}
