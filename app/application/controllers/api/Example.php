<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{



		$this->load->view('welcome_message');
	

	}
	public function addsubscribe(){
		// Load the library, which in turn grabs the API key from the config file
	$this->load->library('Mcapi');
	
	// just as an example here, i'm sending across first,
	// and last names into mailchimp
			
	//$name = explode(' ', $arr['name']);
	
	// subscribe the individual to a list.
	// for information about what parameters to send, please 
	// view the mcapi.php library file. It's all documented.
		
	//$success = $this->mcapi->listSubscribe('11111111', $arr['email'], array('FNAME' => $name[0], 'LNAME' => $name[1]));
	$success = $this->mcapi->listSubscribe('d84fa99fb2', "catherinei@newlineinfo.com", array('FNAME' => "catherine", 'LNAME' => "john"));
 
 	if($success)
	{
		echo "test success";

		log_message('info', 'Woop! Person added successfully');
	}
	else
	{
		echo "test fail";

		log_message('error', 'Uh oh! Person could not be added to the list.');
	}	
	}
}

