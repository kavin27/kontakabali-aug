<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
		$this->load->view('account/activate');
	}
	public function invite(){
		$this->load->view('account/invite');
	}
	public function resetPassword()
	{
		$this->load->view('account/reset_password');
	}
	public function view($page = 'login_form')
    {
    	$this->load->view('account/'.$page);
    }

}
