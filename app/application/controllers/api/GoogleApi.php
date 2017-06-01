<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('./application/libraries/REST_Controller.php');

class GoogleApi extends REST_Controller {

	private $clientApi;
	private $cal;

	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('google');
		include APPPATH . 'third_party/googleApi/Google_Client.php';
		include APPPATH . 'third_party/googleApi/contrib/Google_CalendarService.php';
		$this->clientApi = new Google_Client();
		$this->cal = new Google_CalendarService($this->clientApi);
	}
	public function index_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$isExist = $this->google->check('googleaccess', $user['uid']);
			if($isExist){
				$token = $this->google->get($user['uid']);
				$this->clientApi->setAccessToken($token[0]['token']);
				return true;
			}
			else{
				/*$authUrl = $this->clientApi->createAuthUrl();
				if(!isset($_GET['code'])){
					redirect($authUrl);
				}
				else{
					$this->clientApi->authenticate($_GET['code']);
					$tokenValue = $this->clientApi->getAccessToken();
					$token = json_decode($tokenValue);
					$data = array(
							'user_id' =>$user['uid'] ,
							'token' => $tokenValue,
							'access_token' => $token->access_token,
							'refresh_token' => $token->refresh_token
						);
					$this->google->add($data);
					redirect('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
				} */
				return false;
			}
			
		}
		else{
			return false;
		}
	}
	public function install_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			$authUrl = $this->clientApi->createAuthUrl();
			if(!isset($_GET['code'])){
				redirect($authUrl);
			}
			else{
				$this->clientApi->authenticate($_GET['code']);
				$tokenValue = $this->clientApi->getAccessToken();
				$token = json_decode($tokenValue);
				$data = array(
						'user_id' =>$user['uid'] ,
						'token' => $tokenValue,
						'access_token' => $token->access_token,
						'refresh_token' => $token->refresh_token
					);
				$this->google->add($data);
				redirect($this->config->config['base_url']."#/form/kids");
			} 
		}
	}
	public function callback_get(){
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if(isset($_GET['code'])){
				$this->clientApi->authenticate($_GET['code']);
				$tokenValue = $this->clientApi->getAccessToken();
				$token = json_decode($tokenValue);
				$data = array(
					'user_id' =>$user['uid'] ,
					'token' => $tokenValue,
					'access_token' => $token->access_token,
					'refresh_token' => $token->refresh_token
				);
				$this->google->add($data);
				$this->createCalendar();
				redirect($this->config->config['base_url']."#!/form/calendar");
			} 
		}
	}
	public function getCalenderList_get(){
		if($this->index_get()){
			//$out = array('afd' =>'asf');
			$calList = $this->cal->calendarList->listCalendarList();
  			$out = array('status' => 'SUCCESS' , 'message' =>'', 'data'=> $calList['items'] ); 
		}
		else{
			$out = array( 'status'=>'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function getCal_get(){
		//$this->index_get();
		print_r($this->cal->calendarList->get('9rjekidrqe98gcol2jt6v4cqf4@group.calendar.google.com'));
	}
	public function getCalendarAll_get(){
		if($this->index_get()){
			$uid = $this->session->userdata('logged_in');
			$list = $this->google->getCalenderIdList($uid['uid']);
			$calList = array();
			foreach ($list as $key => $value) {
				$calVal = $this->cal->calendarList->get($value['calendarId']);
				$calVal['selected'] = $value['selected'];
				$calVal['eventType'] = $value['eventType'];
				$calList[] = $calVal;
				//$calList['selected'] = $value['selected'];
			}
  			$out = array('status' => 'SUCCESS' , 'message' =>'', 'data'=> $calList); 
		}
		else{
			$out = array( 'status'=>'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function getEventList_post(){
		$data = $this->post();
		if($this->index_get()){
			$uid = $this->session->userdata('logged_in');
			$list = $this->google->getCalenderIdList($uid['uid']);
			$calList = $this->cal->events->listEvents($list[0]['calendarId']);
  			$out = $calList['items'];
  			foreach ($out as $key => $value) {
  				$startDate = isset($value['start']['dateTime'])? $value['start']['dateTime'] : $value['start']['date'];
  				$endDate = isset($value['end']['dateTime'])? $value['end']['dateTime'] : $value['end']['date'];
  				$startDate = new DateTime($startDate);
  				$endDate = new DateTime($endDate);
  				$startDate = $startDate->format('d-m-Y');
  				$endDate = $endDate->format('d-m-Y');
  				if(isset($value['recurrence'])){
  					$prule = trim($value['recurrence'][0], "RRULE:");
	  				$prule = explode(';',$prule);
	  				$repeatValue = array();
	  				foreach ($prule as $prulekey => $prulevalue) {
	  					$explodeValue = explode('=', $prulevalue);
	  					$repeatValue[$explodeValue[0]] = $explodeValue[1];
	  				}
	  				if($repeatValue['FREQ'] == 'DAILY'){
	  					if(isset($repeatValue['UNTIL'])){
	  						$day = substr($repeatValue['UNTIL'], -2);
							$month = substr($repeatValue['UNTIL'], -4, 2);
							$year = substr($repeatValue['UNTIL'], -8, 4);
							$repeatUntil = $day.'-'.$month.'-'.$year;	
	  					}
	  					else{
	  						$repeatUntil = date('d-m-Y', strtotime($startDate.'+1 year'));
	  					}
	  					if($value['colorId'] == 1){
	  						$backgroundColor = '#a4bdfc';
	  						$textColor = '#000';
	  					}
	  					else{
	  						$backgroundColor = '#7ae7bf';
	  						$textColor = '#000';
	  					}
	  					$start = date('d-m-Y', strtotime($startDate));
	  					$end = date('d-m-Y', strtotime($endDate));
	  					$repeatLoop = $repeatValue['INTERVAL'] * 1;
	  					$i = 0;
	  					while(strtotime($start) < strtotime($repeatUntil) && $i < 26){
	  						$dateFormatstart = new DateTime($start);
	  						$dateFormatstart = $dateFormatstart->format('Y-m-d');
	  						$dateFormatend = new DateTime($end);
	  						$dateFormatend = $dateFormatend->format('Y-m-d');
	  						$event = array(
	  								'title' => $value['summary'],
	  								'start' => $dateFormatstart,
			  						'end' => $dateFormatend,
			  						'backgroundColor' => $backgroundColor,
			  						'textColor' => $textColor
	  							);
	  						$eventList[] = $event;
	  						$i++;
	  						$start = date('d-m-Y', strtotime($start."+".$repeatLoop." days"));
	  						$end = date('d-m-Y', strtotime($end."+".$repeatLoop." days"));
	  					} 
  					}
  				}
  				else{
  					if($value['colorId'] == 1){
  						$backgroundColor = '#a4bdfc';
  						$textColor = '#000';
  					}
  					else{
  						$backgroundColor = '#7ae7bf';
  						$textColor = '#000';
  					}
  					$dateFormatstart = new DateTime($startDate);
					$dateFormatstart = $dateFormatstart->format('Y-m-d');
					$dateFormatend = new DateTime($endDate);
					$dateFormatend = $dateFormatend->format('Y-m-d');
  					$event = array(
  						'id' => $value['id'],
						'title' => isset($value['summary']) ? $value['summary'] : '',
						'start' => $dateFormatstart,
						'end' => $dateFormatend,
						'backgroundColor' => $backgroundColor,
						'textColor' => $textColor
					);
					//print_r($event);
					$eventList[] = 	$event;
  				}
  				$out = $eventList;
  			}
		}
		else{
			$out = array(  'ERROR' => 'User Not Logged In' );
		}
//		print_r($out);
		$this->response($out);
	}
	public function getEventList_get(){
		$data = $this->post();
		if($this->index_get()){
			$calList = $this->cal->events->listEvents('nubu7grbcgqa801p6ol279ugqo@group.calendar.google.com');
  			$out = $calList['items'];
  			foreach ($out as $key => $value) {
  				$startDate = isset($value['start']['dateTime'])? $value['start']['dateTime'] : $value['start']['date'];
  				$endDate = isset($value['end']['dateTime'])? $value['end']['dateTime'] : $value['end']['date'];
  				$startDate = new DateTime($startDate);
  				$endDate = new DateTime($endDate);
  				$startDate = $startDate->format('d-m-Y');
  				$endDate = $endDate->format('d-m-Y');
  				if(isset($value['recurrence'])){
  					$prule = trim($value['recurrence'][0], "RRULE:");
	  				$prule = explode(';',$prule);
	  				$repeatValue = array();
	  				foreach ($prule as $prulekey => $prulevalue) {
	  					$explodeValue = explode('=', $prulevalue);
	  					$repeatValue[$explodeValue[0]] = $explodeValue[1];
	  				}
	  				if($repeatValue['FREQ'] == 'DAILY'){
	  					if(isset($repeatValue['UNTIL'])){
	  						$day = substr($repeatValue['UNTIL'], -2);
							$month = substr($repeatValue['UNTIL'], -4, 2);
							$year = substr($repeatValue['UNTIL'], -8, 4);
							$repeatUntil = $day.'-'.$month.'-'.$year;	
	  					}
	  					else{
	  						$repeatUntil = date('d-m-Y', strtotime($startDate.'+1 year'));
	  					}
	  					if($value['colorId'] == 1){
	  						$backgroundColor = '#a4bdfc';
	  						$textColor = '#000';
	  					}
	  					else{
	  						$backgroundColor = '#7ae7bf';
	  						$textColor = '#000';
	  					}
	  					$start = date('d-m-Y', strtotime($startDate));
	  					$end = date('d-m-Y', strtotime($endDate));
	  					$repeatLoop = $repeatValue['INTERVAL'] * 7;
	  					$i = 0;

	  					while(strtotime($start) < strtotime($repeatUntil) && $i < 52){
	  						$dateFormatstart = new DateTime($start);
	  						$dateFormatstart = $dateFormatstart->format('Y-m-d');
	  						$dateFormatend = new DateTime($end);
	  						$dateFormatend = $dateFormatend->format('Y-m-d');
	  						$event = array(
	  								'title' => $value['summary'],
	  								'start' => $dateFormatstart,
			  						'end' => $dateFormatend,
			  						'backgroundColor' => $backgroundColor,
			  						'textColor' => $textColor
	  							);
	  						$eventList[] = $event;
	  						$i++;
	  						$start = date('d-m-Y', strtotime($start."+".$repeatLoop." days"));
	  						$end = date('d-m-Y', strtotime($end."+".$repeatLoop." days"));
	  					} 
	  					$out = $eventList;
	  				}
  				}
  				else{
  					if($value['colorId'] == 1){
  						$backgroundColor = '#a4bdfc';
  						$textColor = '#000';
  					}
  					else{
  						$backgroundColor = '#7ae7bf';
  						$textColor = '#000';
  					}
  					$dateFormatstart = new DateTime($startDate);
					$dateFormatstart = $dateFormatstart->format('Y-m-d');
					$dateFormatend = new DateTime($endDate);
					$dateFormatend = $dateFormatend->format('Y-m-d');
  					$event = array(
  						'id' => $value['id'],
						'title' => isset($value['summary']) ? $value['summary'] : '',
						'start' => $dateFormatstart,
						'end' => $dateFormatend,
						'backgroundColor' => $backgroundColor,
						'textColor' => $textColor
					);
					$eventList[] = 	$event;
  				
  				$out = $eventList;
  				}
  				
  			}
		}
		else{
			$out = array(  'ERROR' => 'User Not Logged In' );
		}
		$this->response($out);
	} 
	public function createCalendar(){
		$data = array('data' => 'Kids Schedule - Petitioner(You)' );
		$user = $this->session->userdata('logged_in');
		$checkexist = $this->google->Check('calendarlist',$user['uid']);
		if($checkexist){

		}
		else{
			$cal = new Google_Calendar(array('summary' => $data['data']));
			$newCal = $this->cal->calendars->insert($cal);
			$insertData = array(
				'user_id' => $user['uid'], 
				'calendarId'=> $newCal['id']
			);
			$this->google->addCalendar('calendarlist' ,$insertData);
			$out = array('status' => 'SUCCESS' , 'message' =>'' ); 
		}
	}
	public function createCustomCal_post(){
		$data = $this->post();
		$user = $this->session->userdata('logged_in');
		if(isset($user['uid'])){
			if($this->index_get()){
				$cal = new Google_Calendar(array('summary' => $data['name']));
				$newCal = $this->cal->calendars->insert($cal);
				$insertData = array(
					'user_id' => $user['uid'], 
					'calendarId'=> $newCal['id'],
					'other'=>serialize($newCal)
				);
				$this->google->addCalendar('customcalendar' ,$insertData);
				$out = array('status' => 'SUCCESS', 'message' => 'Calendar Successfully Created');
			}else{
				$out = array('status' => 'ERROR', 'message' => 'Error in Google Api');	
			}
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In');
		}
		$this->response($out);
	}
	public function updateEvent_post(){
		if($this->index_get()){
			$out = array();
			$data = $this->post();
			$user = $this->session->userdata('logged_in');
			$dateNow = new DateTime($data['start']);
			$currentYear = $dateNow->format('Y');
			$until = new DateTime($data['start']." +1 year");
			$until = "UNTIL=".$until->format('Ymd').";";
			//$until = "UNTIL=".$currentYear."1231;";
			$dateNow = $dateNow->format('Y-m-d');
			if(isset($user['uid'])){
				$calId = $this->google->getChildSupCalId($user['uid']);
				if($data['data'] != 3){
					$postBodyData = array();
					if($data['data'] == 1){
						$dateOne = new DateTime( $data['start']." +2 day");
						$dateOne = $dateOne->format('Y-m-d');
						$dateTwo = new DateTime( $data['start']." +4 day");
						$dateTwo = $dateTwo->format('Y-m-d');
						$dateThree = new DateTime( $data['start']." +7 day");
						$dateThree = $dateThree->format('Y-m-d');
						$dateFour = new DateTime( $data['start']." +9 day");
						$dateFour = $dateFour->format('Y-m-d');
						$dateFive = new DateTime( $data['start']." +11 day");
						$dateFive = $dateFive->format('Y-m-d');
						$dateSix = new DateTime( $data['start']." +14 day");
						$dateSix = $dateSix->format('Y-m-d');
						$interval = 14;
					}
					elseif ($data['data'] == 2) {
						$dateOne = new DateTime( $data['start']." +2 day");
						$dateOne = $dateOne->format('Y-m-d');
						$dateTwo = new DateTime( $data['start']." +4 day");
						$dateTwo = $dateTwo->format('Y-m-d');
						$dateThree = new DateTime( $data['start']." +9 day");
						$dateThree = $dateThree->format('Y-m-d');
						$dateFour = new DateTime( $data['start']." +11 day");
						$dateFour = $dateFour->format('Y-m-d');
						$dateFive = new DateTime( $data['start']." +13 day");
						$dateFive = $dateFive->format('Y-m-d');
						$dateSix = new DateTime( $data['start']." +18 day");
						$dateSix = $dateSix->format('Y-m-d');
						$interval = 18;
					}
					$values = array(
						array(
							'summary' => 'Petitioner (You)', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $dateNow,
					  		),
						  	'end' => array(
					  			'date' => $dateOne, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
						array(
							'summary' => 'Respondent (Spouse)', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $dateOne,
					  		),
						  	'end' => array(
					  			'date' => $dateTwo, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
						array(
							'summary' => 'Petitioner (You)', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $dateTwo,
					  		),
						  	'end' => array(
					  			'date' => $dateThree, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
						array(
							'summary' => 'Respondent (Spouse)', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $dateThree,
					  		),
						  	'end' => array(
					  			'date' => $dateFour, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
						array(
							'summary' => 'Petitioner (You)', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $dateFour,
					  		),
						  	'end' => array(
					  			'date' => $dateFive, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
						array(
							'summary' => 'Respondent (Spouse)', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $dateFive,
					  		),
						  	'end' => array(
					  			'date' => $dateSix, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL='.$interval
						  	)
						),
					);
					$eventIds = $this->google->getEventIds($user['uid']);
					if(empty($eventIds)){
						$list = $this->cal->events->listEvents($calId[0]['calendarId']);
						foreach ($list['items'] as $key => $value) {
							$this->cal->events->delete($calId[0]['calendarId'], $value['id']);
						}
						foreach ($values as $key => $value) {
							$postBody = new Google_Event($value);	
							//if(!$calId[0]['eventType']){
								$out[] = $this->cal->events->insert($calId[0]['calendarId'], $postBody);	
								$flag = true; 
							//}
							//else{
							//	$flag = false; 
							//}
						}
					}
					else{
						foreach ($eventIds as $key => $value) {
							$postBody = new Google_Event($values[$key]);
							$out[] = $this->cal->events->update($calId[0]['calendarId'], $value['id'], $postBody);
							$flag = true; 
						}	
					}

					if($flag){
						$updateEventList = array('eventList' => serialize($out), 'eventType' => $data['data']);
						$this->google->update('calendarlist', $calId[0]['id'], $updateEventList);	
					}
				}
				else{
					$list = $this->cal->events->listEvents($calId[0]['calendarId']);
					foreach ($list['items'] as $key => $value) {
						$this->cal->events->delete($calId[0]['calendarId'], $value['id']);
					}
					$this->google->clearTemplate($user['uid']);
					$updateEventList = array('eventType' => $data['data']);
					$this->google->update('calendarlist', $calId[0]['id'], $updateEventList);	
				}

				$out = array('status' => 'SUCCESS', 'message' => 'Successfully updated' );
			}
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged in' );
		}
		$this->response($out);
	}
	public function addEvent_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if($this->index_get()){
			if($user['uid']){
				if($data['data']['title'] == 'Petitioner (You)'){
					$colorId = 1;
				}
				else{
					$colorId = 2;
				}
				$calId = $this->google->getChildSupCalId($user['uid']);
				$start = new DateTime($data['data']['start'].' +1 day');
				$start = $start->format('Y-m-d');
				$end = new DateTime($data['data']['end'].' +2 day');
				$end = $end->format('Y-m-d');
				$values = array(
							'summary' => $data['data']['title'], 
							'colorId' => $colorId,
							'start' => array(
						    	'date' => $start,
					  		),
						  	'end' => array(
					  			'date' => $end, 
							)
						);
				$postBody = new Google_Event($values);
				$result = $this->cal->events->insert($calId[0]['calendarId'], $postBody);
				$out = array('status' => 'SUCCESS', 'message' => 'Event Successfully created', 'result'=>$result);
			}
			else{
				$out = array('status' => 'SUCCESS', 'message' => 'User Not Logged In');
			}
		}
		else{
			$out = array('status' => 'SUCCESS', 'message' => 'User Not Logged In');
		}
		$this->response($out);
	}
	public function ClearEvents_post(){
		$user = $this->session->userdata('logged_in');
		if($user['uid']){
			$calId = $this->google->getChildSupCalId($user['uid']);
			if($this->index_get()){
				$list = $this->cal->events->listEvents($calId[0]['calendarId']);
				foreach ($list['items'] as $key => $value) {
					$this->cal->events->delete($calId[0]['calendarId'], $value['id']);
				}
				$this->google->clearTemplate($user['uid']);
			}
			$out = array('status' => 'SUCCESS', 'message'=>'All the Events are cleared');
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In');
		}
		$this->response($out);
	}
	public function selectCal_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if($user['uid']){
			if($data['data'] == 'me'){
				$value = array('selected' => $data['selected'] ? false : true);
			}
			else{
				$value = array('spouseSelected' => $data['selected'] ? false : true );	
			}
			$this->google->update2('calendarlist',$user['uid'], $value);
			$out = array('status' => 'SUCCESS', 'message' => 'updated' );
		}
		else{
			$out = array('status' => 'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function deleteEvent_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if($this->index_get()){
			$calId = $this->google->getChildSupCalId($user['uid']);
			$this->cal->events->delete($calId[0]['calendarId'], $data['id']);
			$out = array('status' => 'SUCCESS', 'message' => 'Successfully Deleted');
		}
		else{
			$out = array('status' => 'ERROR' , 'message' => 'User Not Logged Id');
		}
		$this->response($out);
	}
	public function updateSingleEvent_post(){
		$user = $this->session->userdata('logged_in');
		$data = $this->post();
		if($this->index_get()){
			$calId = $this->google->getChildSupCalId($user['uid']);
			if($data['data']['title'] == 'Petitioner (You)'){
				$colorId = 1;
			}
			else{
				$colorId = 2;
			}
			$start = new DateTime($data['data']['start']);
			$start = $start->format('Y-m-d');
			$end = new DateTime($data['data']['end']);
			$end = $end->format('Y-m-d');
			$values = array(
						'summary' => $data['data']['title'], 
						'colorId' => $colorId,
						'start' => array(
					    	'date' => $start,
				  		),
					  	'end' => array(
				  			'date' => $end, 
						)
					);
			$postBody = new Google_Event($values);
			$result = $this->cal->events->update($calId[0]['calendarId'], $data['id'], $postBody);
			$out = array('status'=>'SUCCESS', 'message'=>'Successfully Updated');
		}
		else{
			$out = array('status'=>'ERROR', 'message'=>'User Not Logged In');
		}
		$this->response($out);
	}
}

?>