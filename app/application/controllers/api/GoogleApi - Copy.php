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
		$user = $this->session->userdata;
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
		$user = $this->session->userdata;
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
		$user = $this->session->userdata;
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
				redirect($this->config->config['base_url']."#/form/kids");
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
	public function getCalendarAll_get(){
		if($this->index_get()){
			$uid = $this->session->userdata;
			$list = $this->google->getCalenderIdList($uid['uid']);
			$calList = array();
			foreach ($list as $key => $value) {
				$calList[] = $this->cal->calendarList->get($value['calendarId']);
			}
			
  			$out = array('status' => 'SUCCESS' , 'message' =>'', 'data'=> $calList ); 
		}
		else{
			$out = array( 'status'=>'ERROR', 'message' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function getEventList_post(){
		$data = $this->post();
		if($this->index_get()){
			$calList = $this->cal->events->listEvents($data['data']);
  			$out = $calList['items'];
  			foreach ($out as $key => $value) {
  				$startDate = isset($value['start']['dateTime'])? $value['start']['dateTime'] : $value['start']['date'];
  				$endDate = isset($value['end']['dateTime'])? $value['end']['dateTime'] : $value['end']['date'];
  				$startDate = new DateTime($startDate);
  				$endDate = new DateTime($endDate);
  				$startDate = $startDate->format('d-m-Y');
  				$endDate = $endDate->format('d-m-Y');

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
  					while($start < $repeatUntil && $i < 26){
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
		}
		else{
			$out = array(  'ERROR' => 'User Not Logged In' );
		}
		$this->response($out);
	}
	public function getEventList_get(){
		$data = $this->post();
		if($this->index_get()){
			$calList = $this->cal->events->listEvents('m1lq6lkqfadf1673qk88ekl9tc@group.calendar.google.com');
  			$out = $calList['items'];
  			foreach ($out as $key => $value) {
  				$startDate = isset($value['start']['dateTime'])? $value['start']['dateTime'] : $value['start']['date'];
  				$endDate = isset($value['end']['dateTime'])? $value['end']['dateTime'] : $value['end']['date'];
  				$startDate = new DateTime($startDate);
  				$endDate = new DateTime($endDate);
  				$startDate = $startDate->format('d-m-Y');
  				$endDate = $endDate->format('d-m-Y');
print_r($value['recurrence'][0]);
  				$prule = trim($value['recurrence'][0], "RRULE:");
  				$prule = explode(';',$prule);
  				$repeatValue = array();
  				foreach ($prule as $prulekey => $prulevalue) {
  					$explodeValue = explode('=', $prulevalue);
  					$repeatValue[$explodeValue[0]] = $explodeValue[1];
  				}
  				if($repeatValue['FREQ'] == 'WEEKLY'){
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
  					while($start < $repeatUntil && $i < 26){
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
		}
		else{
			$out = array(  'ERROR' => 'User Not Logged In' );
		}
		$this->response($out);
	} 
	public function createCalendar(){
		$data = array('data' => 'Child Support' );
		$user = $this->session->userdata;
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
			$this->google->addCalendar($insertData);
			$out = array('status' => 'SUCCESS' , 'message' =>'' ); 
		}
	}
	public function updateEvent_post(){
		if($this->index_get()){
			$out = array();
			$data = $this->post();
			$user = $this->session->userdata;
			$dateNow = new DateTime($data['start']);
			$currentYear = $dateNow->format('Y');
			$until = "UNTIL=".$currentYear."1231;";
			$dateNow = $dateNow->format('Y-m-d');
			//$datePlusTwo = new DateTime( $data['start']." +2 day");
			//$datePlusTwo = $datePlusTwo->format('Y-m-d');
			//$datePlusFour = new DateTime( $data['start']." +4 day");
			//$datePlusFour = $datePlusFour->format('Y-m-d');
			//$datePlusSeven = new DateTime( $data['start']." +7 day");
			//$datePlusSeven = $datePlusSeven->format('Y-m-d');
			//$datePlusNine = new DateTime( $data['start']." +9 day");
			//$datePlusNine = $datePlusNine->format('Y-m-d');
			//$datePlusElven = new DateTime( $data['start']." +11 day");
			//$datePlusElven = $datePlusElven->format('Y-m-d');
			//$datePlusFourteen = new DateTime( $data['start']." +14 day");
			//$datePlusFourteen = $datePlusFourteen->format('Y-m-d');

			$datePlusThirteen = new DateTime( $data['start']." +13 day");
			$datePlusThirteen = $datePlusThirteen->format('Y-m-d');
			$datePlusEighteen = new DateTime( $data['start']." +18 day");
			$datePlusEighteen = $datePlusEighteen->format('Y-m-d');

			if(isset($user['uid'])){
				$calId = $this->google->getCalenderIdList($user['uid']);
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
					/*foreach ($values as $key => $value) {
						$postBody = new Google_Event($value);	
						if(!$calId[0]['eventType']){
							$out[] = $this->cal->events->insert($calId[0]['calendarId'], $postBody);	
							$flag = true; 
						}
						else{
							$flag = false; 
							//$out = array();
						}
						//$out = array('status' => 'SUCCESS' , 'message' => 'Successfully updated' );
					}
				/*	if($flag){
						$updateEventList = array('eventList' => serialize($out), 'eventType' => '1');
						$this->google->update('calendarlist', $calId[0]['id'], $updateEventList);	
					}
					$out = array('status' => 'SUCCESS', 'message' => 'Successfully updated' ); */
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
					/*$values = array(
						array(
							'summary' => 'P Turn', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $dateNow,
					  		),
						  	'end' => array(
					  			'date' => $datePlusTwo, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
						array(
							'summary' => 'R Turn', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $datePlusTwo,
					  		),
						  	'end' => array(
					  			'date' => $datePlusFour, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
						array(
							'summary' => 'P Turn', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $datePlusFour,
					  		),
						  	'end' => array(
					  			'date' => $datePlusNine, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
						array(
							'summary' => 'R Turn', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $datePlusNine,
					  		),
						  	'end' => array(
					  			'date' => $datePlusElven, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
						array(
							'summary' => 'P Turn', 
							'colorId' => 1,
							'start' => array(
						    	'date' => $datePlusElven,
					  		),
						  	'end' => array(
					  			'date' => $datePlusThirteen, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
						array(
							'summary' => 'R Turn', 
							'colorId' => 2,
							'start' => array(
						    	'date' => $datePlusThirteen,
					  		),
						  	'end' => array(
					  			'date' => $datePlusEighteen, 
							),
						  	'recurrence' => array(
						    	'RRULE:FREQ=DAILY;'.$until.'INTERVAL=18'
						  	)
						),
					); */
				}
				$values = array(
						array(
							'summary' => 'P Turn', 
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
							'summary' => 'R Turn', 
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
							'summary' => 'P Turn', 
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
							'summary' => 'R Turn', 
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
							'summary' => 'P Turn', 
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
							'summary' => 'R Turn', 
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
				print_r($values);
				exit;
				foreach ($values as $key => $value) {
					$postBody = new Google_Event($value);	
					if(!$calId[0]['eventType']){
						$out[] = $this->cal->events->insert($calId[0]['calendarId'], $postBody);	
						$flag = true; 
					}
					else{
						$flag = false; 
						//$out = array();
					}
					//$out = array('status' => 'SUCCESS' , 'message' => 'Successfully updated' );
				}
				if($flag){
					$updateEventList = array('eventList' => serialize($out), 'eventType' => $data['data']);
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
}

?>