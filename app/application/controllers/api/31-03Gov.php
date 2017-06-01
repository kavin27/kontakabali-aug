<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/REST_Controller.php');
require_once('./application/third_party/GovForms/Pdf.php');
//require_once('./application/third_party/GovForms/fpdm/fpdm.php');
use mikehaertl\pdftk\Pdf;
class Gov extends REST_Controller {
	public function __construct()
	{
	    parent::__construct();
	    $this->load->model('gov_model');
	    $this->load->library('zip');
	    $this->load->helper("file");
	    $this->load->library('session');

	}
	public function index_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$this->fam020_get();
			$this->fl100_get();
			$this->fl105_get();
			$this->fl110_get();
		    $this->zip->read_file('./application/controllers/api/temp/fam020.pdf', FALSE);
		    $this->zip->read_file('./application/controllers/api/temp/fl100.pdf', FALSE);
		    $this->zip->read_file('./application/controllers/api/temp/fl105.pdf', FALSE);
		    $this->zip->read_file('./application/controllers/api/temp/fl110.pdf', FALSE);
		    
		    $zipname = $this->gov_model->zipname($userSe['uid']); 
		    $zipname = $zipname->lname."_Petitioner_Forms.zip";

		    //print_r($this->gov_model->zipname($userSe['uid']));
		    $this->zip->download($zipname);
	    }
	    else{

	    }
	}
	public function fam020_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
			$basicDetails = array_values((array)$basic[0]);

		    $pdf = new Pdf('./application/controllers/api/files/fam020.pdf');
		    $combine['Text1'] = $basicDetails[0]."\n".$basicDetails[1]."\n".$basicDetails[2].", ".$basicDetails[3]."\n".$basicDetails[4];
		    $combine['PETITIONERPLAINTIFF'] = $basicDetails[6];
		    $combine['RESPONDENTDEFENDANT'] = $basicDetails[7];
		    $combine['Check Box3'] = 1;
		    if(file_exists('./application/controllers/api/temp/fam020.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fam020.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fam020.pdf');
		}
	}
	public function fl100_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$outDetail = $this->gov_model->getOurDetails($userSe['uid']);
			$outDetailVal = array_values((array)$outDetail[0]);

			$finalSupport = $outDetailVal[13];
			//echo $finalSupport;
			unset($outDetailVal[13]);
			$pdf = new Pdf('./application/controllers/api/files/fl100.pdf');
			$key = array(
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].Email_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyName_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyStreet_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyCity_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyState_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyZip_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].Phone_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].TitlePartyName[0].Petitioner_tf[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].TitlePartyName[0].Respondent_tf[0]',
				'topmostSubform[0].Page1[0].DateOfMarriage_dt[0]',
				'topmostSubform[0].Page1[0].ThereAreNoMinorChildren_cb[0]',
				'topmostSubform[0].Page2[0].ToBothJointly_cb[0]',
				'topmostSubform[0].Page2[0].ToBothJointly_cb[1]'
			);
			$combine = array_combine($key, $outDetailVal);
			if(!$outDetailVal[11]){
				$combine['topmostSubform[0].Page2[0].ToOther_cb[0]'] = true;
			}
			if(!$outDetailVal[12]){
				$combine['topmostSubform[0].Page2[0].ToOther_cb[1]'] = true;
			}
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].AttyInfo[0].AttyState_ft[0]'] = 'CA';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].CrtCounty_ft[0]'] = 'Los Angeles';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].Street_ft[0]'] = '111 North Hill Street';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].MailingAdd_ft[0]'] = '111 North Hill Street';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].CityZip_ft[0]'] = 'Los Angeles, CA 90012';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].Branch_ft[0]'] = 'Stanley Mosk Courthouse';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].FormTitle[0].DissolutionOf_cb[0]'] = true;
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].FormTitle[0].Marriage_cb[0]'] = true;
			$combine['topmostSubform[0].Page1[0].WeAreMarried_cb[0]'] = true;
			$combine['topmostSubform[0].Page1[0].RespondentMeetsResidencyReqs_cb[0]'] = true;
			$combine['topmostSubform[0].Page1[0].PetitionerMeetsResidencyReqs_cb[0]'] = true;
			$combine['topmostSubform[0].Page2[0].SepTypeDef_cb[1]'] = true;
			$combine['topmostSubform[0].Page2[0].SepBasis_cb[0]'] = true;
			if($finalSupport == 'I will receieve support'){
				$combine['topmostSubform[0].Page2[0].PaySupport_cb[0]'] = true;
				$combine['topmostSubform[0].Page2[0].PaySupporttoPetitioner_cb[0]'] = true;
			}
			else if($finalSupport == 'My spouse will receive support'){
				$combine['topmostSubform[0].Page2[0].PaySupport_cb[0]'] = true;
				$combine['topmostSubform[0].Page2[0].PaySupportoRespondent_cb[0]'] = true;
			}
			else if($finalSupport == 'Not sure / neither'){
				$combine['topmostSubform[0].Page2[0].PartiesSignedVoluntaryPaternityDec_cb[0]'] = true;
			}
			$combine['topmostSubform[0].Page2[0].ConfirmSeparateProperty_sf[0].SeparatePropertyList1_tf[0]'] = 'Miscellaneous jewelry and other personal effects';
			$combine['topmostSubform[0].Page2[0].ConfirmSeparateProperty_sf[0].ConfirmPropertyList1To_tf[0]'] = 'Petitioner';
			$combine['topmostSubform[0].Page2[0].ConfirmSeparateProperty_sf[0].SeparatePropertyList2_tf[0]'] = 'Earnings and accumulations of Petitioner from and after the date of separation ';
			$combine['topmostSubform[0].Page2[0].ConfirmSeparateProperty_sf[0].ConfirmPropertyList2To_tf[0]'] = 'Petitioner';
			$combine['topmostSubform[0].Page2[0].ConfirmSeparateProperty_sf[0].SeparatePropertyList3_tf[0]'] = 'There are additional separate property assets and obligations of the parties, the exact nature and extent of which are not presently known.';
			$combine['topmostSubform[0].Page3[0].CommQuasiProperty_sf[0].ListProperty_ft[0]'] = "\n There are community and quasi-community assets and obligations of the parties, the exact nature and extent of which are unknown to Petitioner at this time.";
			

			if(!$outDetailVal[10]){
				$kidsDetails = $this->gov_model->kidsDetails($userSe['uid']);
				$i = 0;
				foreach ($kidsDetails as $key1 => $value) {
					$i++;
					$kid = array_values((array)$value);
					$namekey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child'. $i .'Name_tf[0]';
					$dobkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child'.$i.'Birthdate_dt[0]';
					if($i == 1){
						$genderkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child2Gender_tf[0]';				 		
					}
				 	else if($i == 2){
						$genderkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child2Gender_tf[1]';						
					}
					else if($i == 3){
						$dobkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child3Date_dt[0]';
						$genderkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child3Gender_tf[0]';
					}
					else{
						$genderkey = 'topmostSubform[0].Page1[0].MinorChildren_sf[0].Child'.$i.'Gender_tf[0]';	
					}
					$combine[$namekey] = $kid[0];
					$combine[$dobkey] = $kid[1];
					$combine[$genderkey] = $kid[2];
				}
			}
			if(file_exists('./application/controllers/api/temp/fl100.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl100.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl100.pdf');

		}
	}

	public function fl105_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
			$basicDetails = array_values((array)$basic[0]);
			$kidsrelation = $this->gov_model->getkidsrelation($userSe['uid']);
			$kidsrelation = array_values((array)$kidsrelation);
		    $pdf = new Pdf('./application/controllers/api/files/fl105.pdf');
		    $key = array(
		    	'FillText89',
				'FillText180',
				'FillText17',
				'FillTxt17',
				'FillText21',
				'FillText30',
				'FillText59',
				'FillText63'
			);
			$combine = array_combine($key, $basicDetails);
			//$combine['']
			$combine['FillText262'] = 'Los Angeles';
			$combine['FillText42'] = '111 North Hill Street';
			$combine['FillText38'] = '111 North Hill Street';
			$combine['FillText51'] = 'Los Angeles, 90012';
			$combine['FillText55'] = 'Stanley Mosk Courthouse';
			$combine['FillText79'] = $kidsrelation[0];
			$kidsComplete = $this->gov_model->kidsFull($userSe['uid']);

			if($kidsrelation[2] == 'N'){
$combine['FillText83'] = $kidsComplete[0]['firstName'].' '.$kidsComplete[0]['middleName'].' '.$kidsComplete[0]['lastName'];
$combine['FillText87'] = $kidsComplete[0]['birthPlace'];
$combine['FillText91'] = $kidsComplete[0]['dob'];
$combine['FillText95'] = ($kidsComplete[0]['gender'] == 'M') ? 'Male' : ($kidsComplete[0]['gender'] == 'F') ? 'Female' : '';
				
if(!empty($kidsComplete[0]['kidsAddress'])){

$combine['FillText99'] = $kidsComplete[0]['kidsAddress'][0]->fromDate;
$combine['FillText1233r34231'] = $kidsComplete[0]['kidsAddress'][0]->street;
$combine['FillText103'] = $kidsComplete[0]['kidsAddress'][0]->city.( $kidsComplete[0]['kidsAddress'][0]->city != '' ? ', ' : '').$kidsComplete[0]['kidsAddress'][0]->state.( $kidsComplete[0]['kidsAddress'][0]->state != '' ? '-' : '').$kidsComplete[0]['kidsAddress'][0]->zip;
$combine['FillText107'] = $kidsComplete[0]['kidsAddress'][0]->livedWith;
$combine['FillText111'] = $kidsComplete[0]['kidsAddress'][0]->Relationship;

$combine['FillText115'] = isset($kidsComplete[0]['kidsAddress'][1]->fromDate) ? $kidsComplete[0]['kidsAddress'][1]->fromDate : '';
$combine['FillText119'] = isset($kidsComplete[0]['kidsAddress'][1]->toDate) ? $kidsComplete[0]['kidsAddress'][1]->toDate : '';
$combine['FillText123x'] = isset($kidsComplete[0]['kidsAddress'][1]->street) ? $kidsComplete[0]['kidsAddress'][1]->street : '';
$combine['FillText123'] = (isset($kidsComplete[0]['kidsAddress'][1]->city) ? $kidsComplete[0]['kidsAddress'][1]->city.', ' : '').(isset($kidsComplete[0]['kidsAddress'][1]->state) ? $kidsComplete[0]['kidsAddress'][1]->state.'-' : '').(isset($kidsComplete[0]['kidsAddress'][1]->zip) ? $kidsComplete[0]['kidsAddress'][1]->zip : '');
$combine['FillText127'] = isset($kidsComplete[0]['kidsAddress'][1]->livedWith) ? $kidsComplete[0]['kidsAddress'][1]->livedWith : '';
//$combine['FillTxt127'] = isset($kidsComplete[0]['kidsAddress'][1]->livedWith) ? $kidsComplete[0]['kidsAddress'][1]->livedWith : '';
$combine['FillText131'] = isset($kidsComplete[0]['kidsAddress'][1]->Relationship) ? $kidsComplete[0]['kidsAddress'][1]->Relationship : '';

$combine['FillText135'] = isset($kidsComplete[0]['kidsAddress'][2]->fromDate) ? $kidsComplete[0]['kidsAddress'][2]->fromDate : '';
$combine['FillText143'] = isset($kidsComplete[0]['kidsAddress'][2]->toDate) ? $kidsComplete[0]['kidsAddress'][2]->toDate : '';
$combine['FillText107413561254'] = isset($kidsComplete[0]['kidsAddress'][2]->street) ? $kidsComplete[0]['kidsAddress'][2]->street : '';
$combine['FillText139'] = (isset($kidsComplete[0]['kidsAddress'][2]->city) ? $kidsComplete[0]['kidsAddress'][2]->city.', ' : '').(isset($kidsComplete[0]['kidsAddress'][2]->state) ? $kidsComplete[0]['kidsAddress'][2]->state.'-' : '').(isset($kidsComplete[0]['kidsAddress'][2]->zip) ? $kidsComplete[0]['kidsAddress'][2]->zip : '');
$combine['FillText148'] = isset($kidsComplete[0]['kidsAddress'][2]->livedWith) ? $kidsComplete[0]['kidsAddress'][2]->livedWith : '';
//$combine['FillTxt148'] = isset($kidsComplete[0]['kidsAddress'][2]->livedWith) ? $kidsComplete[0]['kidsAddress'][2]->livedWith : '';
$combine['FillText152'] = isset($kidsComplete[0]['kidsAddress'][2]->Relationship) ? $kidsComplete[0]['kidsAddress'][2]->Relationship : '';

$combine['FillText156'] = isset($kidsComplete[0]['kidsAddress'][3]->fromDate) ? $kidsComplete[0]['kidsAddress'][3]->fromDate : '';
$combine['FillText160'] = isset($kidsComplete[0]['kidsAddress'][3]->toDate) ? $kidsComplete[0]['kidsAddress'][3]->toDate : '';
$combine['FillText107413561254r4234'] = isset($kidsComplete[0]['kidsAddress'][3]->street) ? $kidsComplete[0]['kidsAddress'][3]->street : '';
$combine['FillText164'] = (isset($kidsComplete[0]['kidsAddress'][3]->city) ? $kidsComplete[0]['kidsAddress'][3]->city.', ' : '').(isset($kidsComplete[0]['kidsAddress'][3]->state) ? $kidsComplete[0]['kidsAddress'][3]->state.'-' : '').(isset($kidsComplete[0]['kidsAddress'][3]->zip) ? $kidsComplete[0]['kidsAddress'][3]->zip : '');
//$combine['FillText164'] = isset($kidsComplete[0]['kidsAddress'][3]->state) ? $kidsComplete[0]['kidsAddress'][3]->state : '';
$combine['FillTxt168'] = isset($kidsComplete[0]['kidsAddress'][3]->livedWith) ? $kidsComplete[0]['kidsAddress'][3]->livedWith : '';
//$combine['FillText168'] = isset($kidsComplete[0]['kidsAddress'][3]->livedWith) ? $kidsComplete[0]['kidsAddress'][3]->livedWith : '';

$combine['FillText172'] = isset($kidsComplete[0]['kidsAddress'][3]->Relationship) ? $kidsComplete[0]['kidsAddress'][3]->Relationship : '';
}
if(!empty($kidsComplete[1])){
	$combine['FillText176'] = $kidsComplete[1]['firstName'].' '.$kidsComplete[1]['middleName'].' '.$kidsComplete[1]['lastName'];
	$combine['FillText6'] = $kidsComplete[1]['birthPlace'];
	$combine['FillText181'] = $kidsComplete[1]['dob'];
	$combine['FillText18'] = ($kidsComplete[1]['gender'] == 'M') ? 'Male' : ($kidsComplete[1]['gender'] == 'F') ? 'Female' : '';

	if(!empty($kidsComplete[1]['kidsAddress'])){
		$combine['FillText22'] = $kidsComplete[1]['kidsAddress'][0]->fromDate;
		$combine['qwerqwerq532'] = $kidsComplete[1]['kidsAddress'][0]->street;
		$combine['FillText27'] = $kidsComplete[1]['kidsAddress'][0]->city.', '.$kidsComplete[1]['kidsAddress'][0]->state.'-'.$kidsComplete[1]['kidsAddress'][0]->zip ;
		$combine['FillText35'] = $kidsComplete[1]['kidsAddress'][0]->Relationship;
		$combine['FillText31'] = $kidsComplete[1]['kidsAddress'][0]->livedWith;


		$combine['FillText43'] = isset($kidsComplete[1]['kidsAddress'][1]->fromDate) ? $kidsComplete[1]['kidsAddress'][1]->fromDate : '';
		$combine['FillText39'] = isset($kidsComplete[1]['kidsAddress'][1]->toDate) ? $kidsComplete[1]['kidsAddress'][1]->toDate : '';
		//$combine['FillTxt56'] = isset($kidsComplete[1]['kidsAddress'][1]->street) ? $kidsComplete[1]['kidsAddress'][1]->street : '';
		$combine['FillText52'] = (isset($kidsComplete[1]['kidsAddress'][1]->city) ? $kidsComplete[1]['kidsAddress'][1]->city.', ' : '').(isset($kidsComplete[1]['kidsAddress'][1]->state) ? $kidsComplete[1]['kidsAddress'][1]->state.'-' : '').(isset($kidsComplete[1]['kidsAddress'][1]->zip) ? $kidsComplete[1]['kidsAddress'][1]->zip : '');
		$combine['FillText56'] = isset($kidsComplete[1]['kidsAddress'][1]->livedWith) ? $kidsComplete[1]['kidsAddress'][1]->livedWith : '';
		$combine['FillText60'] = isset($kidsComplete[1]['kidsAddress'][1]->Relationship) ? $kidsComplete[1]['kidsAddress'][1]->Relationship : '';

		$combine['FillText64'] = isset($kidsComplete[1]['kidsAddress'][2]->fromDate) ? $kidsComplete[1]['kidsAddress'][2]->fromDate : '';
		$combine['FillText68'] = isset($kidsComplete[1]['kidsAddress'][2]->toDate) ? $kidsComplete[1]['kidsAddress'][2]->toDate : '';
		$combine['3534254321534'] = isset($kidsComplete[1]['kidsAddress'][2]->street) ? $kidsComplete[1]['kidsAddress'][2]->street : '';;
		$combine['FillText72'] = (isset($kidsComplete[1]['kidsAddress'][2]->city) ? $kidsComplete[1]['kidsAddress'][2]->city.', ' : '').(isset($kidsComplete[1]['kidsAddress'][2]->state) ? $kidsComplete[1]['kidsAddress'][2]->state.'-' : '').(isset($kidsComplete[1]['kidsAddress'][2]->zip) ? $kidsComplete[1]['kidsAddress'][2]->zip : '');
		$combine['FillText76'] = isset($kidsComplete[1]['kidsAddress'][2]->livedWith) ? $kidsComplete[1]['kidsAddress'][2]->livedWith : '';
		$combine['FillText80'] = isset($kidsComplete[1]['kidsAddress'][2]->Relationship) ? $kidsComplete[1]['kidsAddress'][2]->Relationship : '';

		$combine['FillText84'] = isset($kidsComplete[1]['kidsAddress'][3]->fromDate) ? $kidsComplete[1]['kidsAddress'][3]->fromDate : '';
		$combine['FillText88'] = isset($kidsComplete[1]['kidsAddress'][3]->toDate) ? $kidsComplete[1]['kidsAddress'][3]->toDate : '';
		$combine['3534254321534ef4wqr5325'] = isset($kidsComplete[1]['kidsAddress'][3]->street) ? $kidsComplete[1]['kidsAddress'][3]->street : '';
		$combine['FillText92'] = (isset($kidsComplete[1]['kidsAddress'][3]->city) ? $kidsComplete[1]['kidsAddress'][3]->city.', ' : '').(isset($kidsComplete[1]['kidsAddress'][3]->state) ? $kidsComplete[1]['kidsAddress'][3]->state.'-' : '').(isset($kidsComplete[1]['kidsAddress'][3]->zip) ? $kidsComplete[1]['kidsAddress'][3]->zip : '');
		$combine['FillText96'] = isset($kidsComplete[1]['kidsAddress'][3]->livedWith) ? $kidsComplete[1]['kidsAddress'][3]->livedWith : '';
		$combine['FillText100'] = isset($kidsComplete[1]['kidsAddress'][3]->Relationship) ? $kidsComplete[1]['kidsAddress'][3]->Relationship : '';
	}
}
if(!empty($kidsComplete[0]['protective'])){
	foreach ($kidsComplete[0]['protective'] as $key => $value) {
		if($value->protectiveCourt == 'Criminal'){
			$combine['CheckBox27'] = true;	
			$combine['FillText162'] = $value->protectiveCountry;	
			$combine['FillText166'] = $value->protectiveState;
			$combine['FillText170'] = $value->protectiveCaseNumber;
			$combine['FillText174'] = $value->protectiveExpire;
		}
		if($value->protectiveCourt == 'Family'){
			$combine['CheckBox28'] = true;	
			$combine['FillText178'] = $value->protectiveCountry;	
			$combine['FillText8'] = $value->protectiveState;
			$combine['FillText183'] = $value->protectiveCaseNumber;
			$combine['FillText20'] = $value->protectiveExpire;
		}
		if($value->protectiveCourt == 'Juvenile Law'){
			$combine['CheckBox29'] = true;	
			$combine['FillText24'] = $value->protectiveCountry;	
			$combine['FillText29'] = $value->protectiveState;
			$combine['FillText33'] = $value->protectiveCaseNumber;
			$combine['FillText37'] = $value->protectiveExpire;
		}
		if($value->protectiveCourt == 'Other'){
			$combine['CheckBox30'] = true;	
			$combine['FillText45'] = $value->protectiveCountry;	
			$combine['FillText41'] = $value->protectiveState;
			$combine['FillText54'] = $value->protectiveCaseNumber;
			$combine['FillText58'] = $value->protectiveExpire;
		}
	}
}
				if(!empty($kidsComplete[0]['legalissue'])){
					// $combine['FillText107e34256432dgweet13'] = 'two';
						$combine['FillText133'] = 'three';
					// $combine['CheckBox413'] = true;
					foreach ($kidsComplete[0]['legalissue'] as $key => $value) {
						if($value->type == 'Guardianship'){
							$combine['CheckBox19'] = true;	
							$combine['FillText129'] = $value->court;	
							$combine['FillText117'] = '';
							$combine['FillText1170'] = $value->caseStatus;
							$combine['FillText121'] = $value->caseNumber;
							$combine['FillText133'] = $value->judgementDate;
							$combine['FillText1178'] = '';
						}
						if($value->type == 'Family'){
							$combine['CheckBox18'] = true;	
							$combine['FillText101'] = $value->court;	
							$combine['FillText113'] = '';
							$combine['FillText1132'] = $value->caseStatus;
							$combine['FillText97'] = $value->caseNumber;
							$combine['FillText105'] = $value->judgementDate;
							$combine['FillText1138'] = '';
						}
						if($value->type == 'Juvenile Law'){
							$combine['CheckBox29'] = true;	
							$combine['FillText150'] = $value->court;	
							//$combine['FillText29'] = $value->caseStatus;
							$combine['FillText141'] = $value->caseNumber;
							$combine['FillText37'] = $value->judgementDate;
							$combine['FillText113'] = '';
						}
						if($value->type == 'Other'){
							$combine['CheckBox30'] = true;	
							$combine['FillText125'] = $value->court;	
							//$combine['FillText41'] = $value->caseStatus;
							$combine['FillText109'] = $value->caseNumber;
							$combine['FillText137'] = $value->judgementDate;
							$combine['FillText145'] = '';
						}						
					}
				}
			}
			
			//$combine['FillText113'] = 'test39';
			//$combine['FillText117'] = 'test40';
			//$combine['FillText145'] = 'test41';
			if(file_exists('./application/controllers/api/temp/fl105.pdf')){
				@unlink('C:\\xampp\htdocs\IOE_new\application\controllers\api\temp\fl105.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl105.pdf');
		}
	}
	public function fl110_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl110.pdf');
			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
	    	$basicDetails = array_values((array)$basic[0]);
		    $combine['topmostSubform[0].Page1[0].T91[0]'] = date('m/d/Y');
		    $combine['topmostSubform[0].Page1[0].OtherSpecify_tf[0]'] = "Stanley Mosk Courthouse, \n 111 North Hill Street, \n Los Angeles, CA 90012";
		    $combine['topmostSubform[0].Page1[0].TextField2[0]'] = $basicDetails[7];
		    $combine['topmostSubform[0].Page1[0].TextField2[1]'] = $basicDetails[6];
		    $combine['topmostSubform[0].Page1[0].T89[0]'] = $basicDetails[0]."\n".$basicDetails[1].", ".$basicDetails[2].", ".$basicDetails[3].",\n".$basicDetails[4];

		    if(file_exists('./application/controllers/api/temp/fl110.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl110.pdf');
			}
			else{

			}
		    $pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl110.pdf');

		}
	}
	public function fl130_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl130.pdf');
			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
		    $basicDetails = array_values((array)$basic[0]);
		    $key = array(
		    	'FillText39',
				'FillText37',
				'FillText36',
				'FillText35',
				'FillText34',
				'FillText32',
				'FillText25',
				'FillText24'
			);
			$combine = array_combine($key, $basicDetails);
			$combine['FillText29'] = 'Los Angeles';
			$combine['FillText28'] = '111 North Hill Street';
			$combine['FillText30'] = '111 North Hill Street';
			$combine['FillText27'] = 'Los Angeles, 90012';
			$combine['FillText26'] = 'Stanley Mosk Courthouse';
			$combine['ChckBox1'] = true;
			
			if(file_exists('./application/controllers/api/temp/fl130.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl130.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl130.pdf');
		}		
	}
	public function fl140_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl140.pdf');

			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
			$basicDetails = array_values((array)$basic[0]);
			// $key = array(
		 //    	'FillText39',
			// 	'FillText37',
			// 	'FillText36',
			// 	'FillText35',
			// 	'FillText34',
			// 	'FillText32',
			// 	'FillText25',
			// 	'FillText24'
			// );
			//$combine = array_combine($key, $basicDetails);
			$combine['form1[0].Page1[0].StdP1Header_sf[0].AddInfo[0].PartyAttyAddInfo_ft[0]'] = "\n".$basicDetails[0].", \n".$basicDetails[1].", ".$basicDetails[2].", \n".$basicDetails[3];
			$combine['form1[0].Page1[0].StdP1Header_sf[0].OtherContact[0].Phone_ft[0]'] = $basicDetails[4];
			$combine['form1[0].Page1[0].StdP1Header_sf[0].OtherContact[0].Email_ft[0]'] = $basicDetails[5];
			$combine['form1[0].Page1[0].StdP1Header_sf[0].CourtInfo[0].CrtCounty_ft[0]'] = 'Los Angeles';
			$combine['form1[0].Page1[0].StdP1Header_sf[0].CourtInfo[0].Street_ft[0]'] = '111 North Hill Street';
			$combine['form1[0].Page1[0].StdP1Header_sf[0].CourtInfo[0].MailingAdd_ft[0]'] = '111 North Hill Street';
			$combine['form1[0].Page1[0].StdP1Header_sf[0].CourtInfo[0].CityZip_ft[0]'] = 'Los Angeles, 90012';
			$combine['form1[0].Page1[0].StdP1Header_sf[0].CourtInfo[0].Branch_ft[0]'] = 'Stanley Mosk Courthouse';
			$combine['form1[0].Page1[0].StdP1Header_sf[0].TitlePartyName[0].Party1_ft[0]'] = $basicDetails[6];
			$combine['form1[0].Page1[0].StdP1Header_sf[0].TitlePartyName[0].Party2_ft[0]'] = $basicDetails[7];
			$combine['form1[0].Page1[0].StdP1Header_sf[0].FormTitle[0].caption_cb[0].CheckBox61[0]'] = true;
			
			if(file_exists('./application/controllers/api/temp/fl140.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl140.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->send('fl140.pdf');
			//echo "<pre>"; print_r($pdf);
		}
	}
	public function fl142_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl142.pdf');
			$basic = $this->gov_model->getBasicDetails($userSe['uid']);
			unset($basic[0]->Email);
			$basicDetails = array_values((array)$basic[0]);
			$key = array(
		    	'FillText272',
				'FillText270',
				'FillText268',
				'FillText266',
				'FillText271',
				'FillText263',
				'FillText273'
			);
			$combine = array_combine($key, $basicDetails);
			$assetsList = $this->gov_model->getAssets($userSe['uid']);
//			echo "<pre>";
			//print_r($assetsList);
			$property = array();
			$personalItems = array();
			$vehicle = array();
			$savingAccount = array();
			$checkingAccount = array();
			$pets = array();
			$desc = array(
				'checkingAccount'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					), 
				'savingsAccount'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'InvestmentAccount'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'QualifiedRetirementAccount'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'Non-Qualifiedretirementaccount'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'PersonalItem'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'Vehicle'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'Property'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					),
				'Pets'=>array(
						'text' => '',
						'acDate'=>'',
						'estimation'=>'',
						'outstanding'=>''
					)
			);
			foreach ($assetsList as $key => $value) {
				if($value->assetName == '1'){
					$desc['checkingAccount']['text'] .= "Checking Account \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['checkingAccount']['acDate'] .= $dateformat->format('m/d/y')."\n";
					$desc['checkingAccount']['estimation'] .= $value->assetsEstimation."\n";
					$desc['checkingAccount']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '2'){
					$desc['savingsAccount']['text'] .= "Savings Account \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['savingsAccount']['acDate'] .= $dateformat->format('m/d/y')."\n";
					$desc['savingsAccount']['estimation'] .= $value->assetsEstimation."\n";
					$desc['savingsAccount']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '3'){
					$desc['InvestmentAccount']['text'] .= "Investment Account \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['InvestmentAccount']['acDate'] .= $dateformat->format('m/d/y')."\n";
					$desc['InvestmentAccount']['estimation'] .= $value->assetsEstimation."\n";
					$desc['InvestmentAccount']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '4'){
					$desc['QualifiedRetirementAccount']['text'] .= "Qualified Retirement Account \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['QualifiedRetirementAccount']['acDate'] .= $dateformat->format('m/d/y')."\n";
					$desc['QualifiedRetirementAccount']['estimation'] .= $value->assetsEstimation."\n";
					$desc['QualifiedRetirementAccount']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '5'){
					$desc['Non-Qualifiedretirementaccount']['text'] .= "Non-Qualified retirement account \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['Non-Qualifiedretirementaccount']['acDate'] .= $dateformat->format('m/d/y')."\n";
					$desc['Non-Qualifiedretirementaccount']['estimation'] .= $value->assetsEstimation."\n";
					$desc['Non-Qualifiedretirementaccount']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '6'){
					$desc['PersonalItem']['text'] .= "Personal Item \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['PersonalItem']['acDate'] .= $dateformat->format('m/d/y')."\n";	
					$desc['PersonalItem']['estimation'] .= $value->assetsEstimation."\n";	
					$desc['PersonalItem']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '7'){
					$desc['Vehicle']['text'] .= "Vehicle \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['Vehicle']['acDate'] .= $dateformat->format('m/d/y')."\n";	
					$desc['Vehicle']['estimation'] .= $value->assetsEstimation."\n";	
					$desc['Vehicle']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '8'){
					$desc['Property']['text'] .= "Property \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['Property']['acDate'] .= $dateformat->format('m/d/y')."\n";	
					$desc['Property']['estimation'] .= $value->assetsEstimation."\n";	
					$desc['Property']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
				else if($value->assetName == '9'){
					$desc['Pets']['text'] .= "Pets \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireAssetsDate);
					$desc['Pets']['acDate'] .= $dateformat->format('m/d/y')."\n";	
					$desc['Pets']['estimation'] .= $value->assetsEstimation."\n";	
					$desc['Pets']['outstanding'] .= $value->outstandingLoanValue."\n";
				}
			}
			//print_r($desc);
			$combine['FillText273a'] = $desc['Property']['text'];
			//$combine['FillText250'] = 'FillText250';
			$combine['FillText251'] = "\n \n".$desc['Property']['acDate'];
			$combine['FillText252'] = "\n \n".$desc['Property']['estimation'];
			$combine['FillText253'] = "\n \n".$desc['Property']['outstanding'];
			$combine['FillText273b'] = $desc['PersonalItem']['text'];
			// $combine['FillText254'] = "";
			$combine['FillText255'] = "\n".$desc['PersonalItem']['acDate'];
			$combine['FillText256'] = "\n".$desc['PersonalItem']['estimation'];
			$combine['FillText257'] = "\n".$desc['PersonalItem']['outstanding'];
			// $combine['FillText273c'] = "FillText273c";
			// $combine['FillText258'] = "FillText258";
			// $combine['FillText259'] = "FillText259";
			// $combine['FillText260'] = "FillText260";
			// $combine['FillText261'] = "FillText261";
			$combine['FillText400a'] = $desc['Vehicle']['text'];
			// $combine['FillText236'] = 
			$combine['FillText235'] = "\n".$desc['Vehicle']['acDate'];
			$combine['FillText234'] = "\n".$desc['Vehicle']['estimation'];
			$combine['FillText233'] = "\n".$desc['Vehicle']['outstanding'];
			$combine['FillText400b'] = $desc['savingsAccount']['text'];
			// $combine['FillText232'] = 
			$combine['FillText231'] = "\n".$desc['savingsAccount']['acDate'];
			$combine['FillText230'] = "\n".$desc['savingsAccount']['estimation'];
			$combine['FillText229'] = "\n".$desc['savingsAccount']['outstanding'];
			$combine['FillText400c'] = $desc['checkingAccount']['text'];
			// $combine['FillText228'] = 
			$combine['FillText227'] = "\n".$desc['checkingAccount']['acDate'];
			$combine['FillText226'] = "\n".$desc['checkingAccount']['estimation'];
			$combine['FillText225'] = "\n".$desc['checkingAccount']['outstanding'];
			// $combine['FillText400d'] = "FillText400d";
			// $combine['FillText224'] = "FillText224";
			// $combine['FillText223'] = "FillText223";
			// $combine['FillText222'] = "FillText222";
			// $combine['FillText221'] = "FillText221";
			// $combine['FillText400e'] = "FillText400e";
			// $combine['FillText220'] = "FillText220";
			// $combine['FillText219'] = "FillText219";
			// $combine['FillText218'] = "FillText218";
			// $combine['FillText217'] = "FillText217";
			// $combine['FillText400f'] = "FillText400f";
			// $combine['FillText216'] = "FillText216";
			// $combine['FillText215'] = "FillText215";
			// $combine['FillText214'] = "FillText214";
			// $combine['FillText213'] = "FillText213";
			// $combine['FillText400g'] = "FillText400g";
			// $combine['FillText212'] = "FillText212";
			// $combine['FillText211'] = "FillText211";
			// $combine['FillText210'] = "FillText210";
			// $combine['FillText209'] = "FillText209";
			// $combine['FillText400h'] = "FillText400h";
			// $combine['FillText180'] = "FillText180";
			// $combine['FillText179'] = "FillText179";
			// $combine['FillText178'] = "FillText178";
			// $combine['FillText177'] = "FillText177";
			$combine['FillText400i'] = $desc['QualifiedRetirementAccount']['text'];
			// $combine['FillText176'] = 
			$combine['FillText175'] = "\n".$desc['QualifiedRetirementAccount']['acDate'];
			$combine['FillText174'] = "\n".$desc['QualifiedRetirementAccount']['estimation'];
			$combine['FillText173'] = "\n".$desc['QualifiedRetirementAccount']['outstanding'];
			//$combine['FillText175'] = "FillText175";
			$combine['FillText400J'] = $desc['Non-Qualifiedretirementaccount']['text'];
			// $combine['FillText172'] = 
			$combine['FillText171'] = "\n".$desc['Non-Qualifiedretirementaccount']['acDate'];
			$combine['FillText170'] = "\n".$desc['Non-Qualifiedretirementaccount']['estimation'];
			$combine['FillText169'] = "\n".$desc['Non-Qualifiedretirementaccount']['outstanding'];
			// $combine['FillText400k'] = "FillText400k";
			// $combine['FillText168'] = "FillText168";
			// $combine['FillText167'] = "FillText167";
			// $combine['FillText166'] = "FillText166";
			// $combine['FillText165'] = "FillText165";
			// $combine['FillText400l'] = "FillText400l";
			// $combine['FillText164'] = "FillText164";
			// $combine['FillText163'] = "FillText163";
			// $combine['FillText162'] = "FillText162";
			// $combine['FillText161'] = "FillText161";
			$combine['FillText400n'] = $desc['Pets']['text'];
			// $combine['FillText160'] = 
			$combine['FillText159'] = "\n".$desc['Pets']['acDate'];
			$combine['FillText158'] = "\n".$desc['Pets']['estimation'];
			$combine['FillText157'] = "\n".$desc['Pets']['outstanding'];
			// $combine['FillText156'] = "FillText156";
			// $combine['FillText155'] = "FillText155";
			// $combine['FillText154'] = "FillText154";
			// $combine['FillText153'] = "FillText153";
			// $combine['FillText152'] = "FillText152";
			// $combine['FillText151'] = "FillText151";
			$debtVal = array(
					'Creditcard'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
					'Pastduechildorspousalsupport'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
					'Personalloans'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
					'Studentloans'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
					'Taxes'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
					'Property'=>array(
							'text'=>'',
							'acDate'=>'',
							'estimation'=>'',
							'outstanding'=>''
						),
				);
			$debtList = $this->gov_model->getDebts($userSe['uid']);
			foreach ($debtList as $key => $value) {
				if ($value->debtType == '1') {
					$debtVal['Creditcard']['text'] = "Credit card \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Creditcard']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Creditcard']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Creditcard']['text'] = ;
				} else if ($value->debtType == '2') {
					$debtVal['Pastduechildorspousalsupport']['text'] = "Past due child or spousal support \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Pastduechildorspousalsupport']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Pastduechildorspousalsupport']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Pastduechildorspousalsupport']['text'] = ;
				} else if ($value->debtType == '3') {
					$debtVal['Personalloans']['text'] = "Personal loans \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Personalloans']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Personalloans']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Personalloans']['text'] = ;
				} else if ($value->debtType == '4') {
					$debtVal['Studentloans']['text'] = "Student loans \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Studentloans']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Studentloans']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Studentloans']['text'] = ;
				} else if ($value->debtType == '5') {
					$debtVal['Taxes']['text'] = "Taxes \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Taxes']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Taxes']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Taxes']['text'] = ;
				} else if ($value->debtType == '6') {
					$debtVal['Property']['text'] = "Property \n";
					$dateformat = DateTime::createFromFormat('m/d/Y', $value->acquireDebyDate);
					$debtVal['Property']['acDate'] = $dateformat->format('m/d/y')."\n";
					$debtVal['Property']['estimation'] = $value->debyEstimation."\n";
					// $debtVal['Property']['text'] = ;
				} 
				
			}
			//print_r($debtVal);
			$combine['FillText114e'] = $debtVal['Studentloans']['text'];
			// $combine['FillText98']
			$combine['FillText99'] = "\n".$debtVal['Studentloans']['estimation'];
			$combine['FillText100'] = "\n".$debtVal['Studentloans']['acDate'];

			$combine['FillText114d'] = "\n".$debtVal['Taxes']['text'];
			// $combine['FillText101']
			$combine['FillText102'] = "\n".$debtVal['Taxes']['estimation'];
			$combine['FillText103'] = "\n".$debtVal['Taxes']['acDate'];

			$combine['FillText114c'] = "\n".$debtVal['Pastduechildorspousalsupport']['text'];
			// $combine['FillText104']
			$combine['FillText105'] = "\n".$debtVal['Pastduechildorspousalsupport']['estimation'];
			$combine['FillText106'] = "\n".$debtVal['Pastduechildorspousalsupport']['acDate'];

			$combine['FillText114b'] = "\n".$debtVal['Personalloans']['text'];
			// $combine['FillText107']
			$combine['FillText108'] = "\n".$debtVal['Personalloans']['estimation'];
			$combine['FillText109'] = "\n".$debtVal['Personalloans']['acDate'];

			$combine['FillText114a'] = "\n".$debtVal['Creditcard']['text'];
			// $combine['FillText107']
			// $combine['FillText110']
			$combine['FillText111'] = "\n".$debtVal['Creditcard']['estimation'];
			$combine['FillText112'] = "\n".$debtVal['Creditcard']['acDate'];

			
			//$combine['FillText272'] = 'Antony';
			if(file_exists('./application/controllers/api/temp/fl142.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl142.pdf');
			}
			else{

			}

			//$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl142.pdf');
			$pdf->fillForm($combine)->needAppearances()->flatten()->send('fl142.pdf');
		}
	}
	public function fl150_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl150.pdf');
			$basic = $this->gov_model->getBasicDetailsfl150($userSe['uid']);
			//unset($basic[0]->Email);
			if(empty($basic)){
				return;
			}
			$basicDetails = array_values((array)$basic[0]);

			$taxstatus = $basicDetails[12];
			unset($basicDetails[12]);
			$key = array(
		    	'FillText193',
				'FillText191',
				'FillText190',
				'FillText189',
				'FillText188',
				'FillText187',
				'FillText180',
				'FillText179',
				'FillText176',
				'FillText175',
				'FillText172',
				'FillText171'
			);
			$combine = array_combine($key, $basicDetails);
			//$combine['FillText193'] = 'Antony';
			$combine['FillText185'] = 'Los Angeles';
			$combine['FillText184'] = '111 North Hill Street';
			$combine['FillText183'] = '111 North Hill Street';
			$combine['FillText182'] = 'Los Angeles, 90012';
			$combine['FillText181'] = 'Stanley Mosk Courthouse';
			$dob  = $this->gov_model->dob($userSe['uid']);
			//print_r($dob);
			$dob = DateTime::createFromFormat('m/d/Y', $dob->dob);
			$today = new DateTime('today');
			
			$combine['FillText168'] = $dob->diff($today)->y;

			if($taxstatus == 'Single'){
				$combine['CheckBox23'] = 1;	
			}
			else if($taxstatus == 'Married, filing single'){
				$combine['CheckBox23'] = 3;	
			}
			else if($taxstatus == 'Married, filing jointly'){
				$combine['CheckBox23'] = 4;	
			}
			$combine['CheckBox22'] = 1;
			$income = array(
					'salaryWages'=>array(
							'last'=>0,
							'average'=> 0
						),
					'overtime'=>array(
							'last'=>0,
							'average'=> 0
						),
					'commission'=>array(
							'last'=>0,
							'average'=> 0
						),
					'publicassistance'=>array(
							'last'=>0,
							'average'=> 0
						),
					'spousal'=>array(
							'last'=>0,
							'average'=> 0
						),
					'partner'=>array(
							'last'=>0,
							'average'=> 0
						),
					'pensionretirement'=>array(
							'last'=>0,
							'average'=> 0
						),
					'social'=>array(
							'last'=>0,
							'average'=> 0
						),
					'diability'=>array(
							'last'=>0,
							'average'=> 0
						),
					'unemployment'=>array(
							'last'=>0,
							'average'=> 0
						),
					'workers'=>array(
							'last'=>0,
							'average'=> 0
						),
					'other'=>array(
							'last'=>0,
							'average'=> 0
						),
					'self'=>array(
							'last'=>0,
							'average'=> 0
						)
				);
			$expense = array(
					'home'=> 0,
					'Eatingout'=> 0,
					'healthCare'=> 0,
					'childCare'=> 0,
					'Groceries'=> 0,
					'Utilities'=> 0,
					'Telephone'=> 0,
					'Laundry'=> 0,
					'Clothes'=> 0,
					'Education'=> 0,
					'Entertainment'=> 0,
					'Auto'=> 0,
					'Insurance'=> 0,
					'Savings'=> 0,
					'Charitable'=> 0,
					'installment'=> 0,
					'Other'=> 0,
					'Maintenance'=> 0,
					'realProperty'=> 0,
					'Homeowners'=> 0
				);
			$valmakespend = $this->gov_model->getMakeSpend($userSe['uid']);
			$c1=0;
			$c2=0;
			$c3=0;
			$c4=0;
			$c5=0;
			$c6=0;
			$c7=0;
			$c8=0;
			$c9=0;
			$c10=0;
			$c11=0;
			$c12=0;
			foreach ($valmakespend['income'] as $key => $value) {
				if($value->incomeType == '1'){
					$c1++;
					$income['salaryWages']['last'] += $value->howMuchIncome;
					$income['salaryWages']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '2'){
					$c2++;
					$income['overtime']['last'] += $value->howMuchIncome;
					$income['overtime']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '3'){
					$c3++;
					$income['commission']['last'] += $value->howMuchIncome;
					$income['commission']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '4'){
					$c4++;
					$income['publicassistance']['last'] += $value->howMuchIncome;
					$income['publicassistance']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '5'){
					$c5++;
					$income['spousal']['last'] += $value->howMuchIncome;
					$income['spousal']['average'] += $value->howMuchIncome;
				}
				// else if($value->incomeType == '5'){
				// 	$income['partner']['last'] = $value->howMuchIncome;
				// 	$income['partner']['average'] += $value->howMuchIncome;
				// }
				else if($value->incomeType == '6'){
					$c6++;
					$income['pensionretirement']['last'] += $value->howMuchIncome;
					$income['pensionretirement']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '7'){
					$c7++;
					$income['social']['last'] += $value->howMuchIncome;
					$income['social']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '8'){
					$c8++;
					$income['diability']['last'] += $value->howMuchIncome;
					$income['diability']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '9'){
					$c9++;
					$income['unemployment']['last'] += $value->howMuchIncome;
					$income['unemployment']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '10'){
					$c10++;
					$income['workers']['last'] += $value->howMuchIncome;
					$income['workers']['average'] += $value->howMuchIncome;
				}
				else if($value->incomeType == '11'){
					$c11++;
					$income['other']['last'] += $value->howMuchIncome;
					$income['other']['average'] += $value->howMuchIncome;
				}
				else{
					$c12++;
					$income['self']['last'] += $value->howMuchIncome;
					$income['self']['average'] += $value->howMuchIncome;	
				}
			}
			foreach ($valmakespend['expense'] as $key => $value) {
				if($value->expenseType == '1'){
					$expense['Auto'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '2'){
					$expense['Charitable'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '3'){
					$expense['childCare'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '4'){
					$expense['Clothes'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '5'){
					$expense['Education'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '6'){
					$expense['Groceries'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '7'){
					$expense['home'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '8'){
					$expense['healthCare'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '9'){
					$expense['Homeowners'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '10'){
					$expense['installment'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '11'){
					$expense['Insurance'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '12'){
					$expense['Laundry'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '13'){
					$expense['Maintenance'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '14'){
					$expense['Other'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '15'){
					$expense['realProperty'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '16'){
					$expense['Eatingout'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '17'){
					$expense['Savings'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '18'){
					$expense['Telephone'] +=$value->expenseEstimation;
				}
				else if($value->expenseType == '19'){
					$expense['Utilities'] +=$value->expenseEstimation;
				}
			}

			//$combine['FillText168'] = 'FillText168';

			if($c1){
				$combine['FillText290'] = $income['salaryWages']['last']/$c1;
				$combine['FillText291'] = $income['salaryWages']['average']/$c1;	
			}
			if($c2){
				$combine['FillText262'] = $income['overtime']['last']/$c2;
				$combine['FillText263'] = $income['overtime']['average']/$c2;	
			}
			if($c3){
				$combine['FillText289'] = $income['commission']['last']/$c3;
				$combine['FillText288'] = $income['commission']['average']/$c3;	
			}
			if($c4){
				$combine['FillText261'] = $income['publicassistance']['last']/$c4;
				$combine['FillText260'] = $income['publicassistance']['average']/$c4;	
			}
			if($c5){
				$combine['FillText258'] = $income['spousal']['last']/$c5;
				$combine['FillText259'] = $income['spousal']['average']/$c5;
			}
			
			// $combine['FillText256'] = $income['partner']['last'];
			// $combine['FillText257'] = $income['partner']['average'];
			if($c6){
				$combine['FillText254'] = $income['pensionretirement']['last']/$c6;
				$combine['FillText255'] = $income['pensionretirement']['average']/$c6;	
			}
			if($c7){
				$combine['FillText252'] = $income['social']['last']/$c7;
				$combine['FillText253'] = $income['social']['average']/$c7;	
			}
			if($c8){
				$combine['FillText250'] = $income['diability']['last']/$c8;
				$combine['FillText251'] = $income['diability']['average']/$c8;	
			}
			if($c9){
				$combine['FillText248'] = $income['unemployment']['last']/$c9;
				$combine['FillText249'] = $income['unemployment']['average']/$c9;	
			}
			if($c10){
				$combine['FillText246'] = $income['workers']['last']/$c10;
				$combine['FillText247'] = $income['workers']['average']/$c10;	
			}
			if($c11){
				$combine['FillText244'] = $income['other']['last']/$c11;
				$combine['FillText245'] = $income['other']['average']/$c11;	
			}
			if($c12){
				$combine['FillText287'] = $income['self']['last']/$c12;
				$combine['FillText286'] = $income['self']['average']/$c12;
			}
			
			// $combine['FillText248'] = $income['unemployment']['last'];
			// $combine['FillText249'] = $income['unemployment']['average'];

			// $combine['FillText404'] = 'FillText404';
			// $combine['FillText403'] = 'FillText403';
			$combine['FillText401'] = $expense['realProperty'];
			$combine['FillText399'] = $expense['Homeowners'];
			$combine['FillText397'] = $expense['Maintenance'];

			$combine['FillText395'] = $expense['healthCare'];
			$combine['FillText394'] = $expense['childCare'];
			$combine['FillText390'] = $expense['Groceries'];
			$combine['FillText389'] = $expense['Eatingout'];
			$combine['FillText388'] = $expense['Utilities'];
			$combine['FillText387'] = $expense['Telephone'];
			$combine['FillText409'] = $expense['Laundry'];
			$combine['FillText408'] = $expense['Clothes'];
			$combine['FillText406'] = $expense['Education'];
			// $combine['FillText405'] = 'FillText405';
			$combine['FillText402'] = $expense['Auto'];
			$combine['FillText400'] = $expense['Insurance'];
			$combine['FillText398'] = $expense['Savings'];
			$combine['FillText396'] = $expense['Charitable'];

			
			if(file_exists('./application/controllers/api/temp/fl150.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl150.pdf');
			}
			else{

			}
			$pdf->fillForm($combine)->needAppearances()->flatten()->send('fl150.pdf');
		}
	}
public function fl160_get(){
		$userSe = $this->session->userdata;
		if(isset($userSe['uid'])){
			$pdf = new Pdf('./application/controllers/api/files/fl160.pdf');
			$outDetail = $this->gov_model->getOurDetails($userSe['uid']);
			$outDetailVal = array_values((array)$outDetail[0]);
			unset($outDetailVal[9]);
			unset($outDetailVal[10]);
			unset($outDetailVal[11]);
			unset($outDetailVal[12]);
			unset($outDetailVal[13]);
			
			$key = array(
		    	'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].Email_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyName_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyStreet_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyCity_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyState_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyZip_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].Phone_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].TitlePartyName[0].Party1_ft[0]',
				'topmostSubform[0].Page1[0].CaptionP1_sf[0].TitlePartyName[0].Party2_ft[0]'
			);
			$combine = array_combine($key, $outDetailVal);
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].AddInfo[0].AttyState_ft[0]'] = 'CA';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].CrtCounty_ft[0]'] = 'Los Angeles';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].Street_ft[0]'] = '111 North Hill Street';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].MailingAdd_ft[0]'] = '111 North Hill Street';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].CityZip_ft[0]'] = 'Los Angeles, CA 90012';
			$combine['topmostSubform[0].Page1[0].CaptionP1_sf[0].CourtInfo[0].Branch_ft[0]'] = 'Stanley Mosk Courthouse';
			
			$haveOwe = $this->gov_model->getAssets($userSe['uid']);
			$othersC = 0;
			$propertyC = 0;
			$vehicleC = 0;
			$SavingsC = 0;
			$CheckingC = 0;
			$personalItemC = 0;
			foreach ($haveOwe as $key => $value) {
				if($value->assetName == '9'){
					$othersC++;
					if($othersC < 4){
						$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.Desc\.ft[0]'] = 'Pets';
						$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.DateAcq\.dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.GrossFMV\.dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.Debt\.dc[0]'] = $value->outstandingLoanValue;
						$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.NetFMV\.dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;
						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.Div\.Pet\.ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'Div\.Res\.ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'\.Div\.Pet\.ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page2[0].Table5[0].OtherAssets'.$othersC.'\.ft[0].OtherAssets'.$othersC.'Div\.Res\.ft[0]'] = $value->assetsEstimation/2;	
						}
					}
					
				}
				if($value->assetName == '8'){
					$propertyC++;
					if($propertyC < 3){
						if($propertyC == 2){
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RealEstate_Des_ft[0]'] = 'Property';	
						}
						else{
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RealEstate'.$propertyC.'_Des_ft[0]'] = 'Property';	
						}
						$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'DateAcq_dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'GrossFMV_dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'Debt_dc[0]'] = $value->outstandingLoanValue;	
						$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'NetFMV_dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;

						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'DivPet_ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$propertyC.'[0].RE'.$propertyC.'DivRes_ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$othersC.'[0].RE'.$othersC.'DivPet_ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page1[0].Table5[0].RealEstate'.$othersC.'[0].RE'.$othersC.'DivRes_ft[0]'] = $value->assetsEstimation/2;	
						}
					}
				}
				if($value->assetName == '7'){
					$vehicleC++;
					if($vehicleC < 4){
						$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'Desc_ft[0]'] = 'Vehicle';
						$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'DateAcq_dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'GrossFMV_dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'Debt_dc[0]'] = $value->outstandingLoanValue;	
						$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'NetFMV_dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;
						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'DivPet_ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'DivRes_ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'DivPet_ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page1[0].Table5[0].Vehicles'.$vehicleC.'_ft[0].Vehicles'.$vehicleC.'DivRes_ft[0]'] = $value->assetsEstimation/2;	
						}
					}
				}
				if($value->assetName == '6'){
					$personalItemC++;
					if($personalItemC < 6){
						$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'Desc_ft[0]'] = 'Personal Item';
						$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'DateAcq_dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'GrossFMV_dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'Debt_dc[0]'] = $value->outstandingLoanValue;
						$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'NetFMV_dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;
						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'DivPet_ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'DivRes_ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'DivPet_ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page1[0].Table5[0].Household'.$personalItemC.'FFA_ft[0].HFFA'.$personalItemC.'DivRes_ft[0]'] = $value->assetsEstimation/2;	
						}
					}
				}
				if($value->assetName == '2'){
					$SavingsC++;
					if($SavingsC < 4){
						$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'Desc_ft[0]'] = 'Savings Account';
						$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'DateAcq_dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'GrossFMV_dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'Debt_dc[0]'] = $value->outstandingLoanValue;	
						$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'NetFMV_dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;
						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'DivPet_ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'DivRes_ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'DivPet_ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page1[0].Table5[0].Savings'.$SavingsC.'_ft[0].Savings'.$SavingsC.'DivRes_ft[0]'] = $value->assetsEstimation/2;	
						}
					}
				}
				if($value->assetName == '1'){
					$CheckingC++;
					if($CheckingC < 4){
						$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'Desc_ft[0]'] = 'Checking Account';
						$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'DateAcq_dt[0]'] = $value->acquireAssetsDate;
						$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'GrossFMV_dc[0]'] = $value->assetsEstimation;
						$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'Debt_dc[0]'] = $value->outstandingLoanValue;
						$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'NetFMV_dc[0]'] = $value->assetsEstimation - $value->outstandingLoanValue;
						if($value->whoWillKeep == 'me'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'DivPet_ft[0]'] = $value->assetsEstimation;	
						}
						else if($value->whoWillKeep == 'spouse'){
							$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'DivRes_ft[0]'] = $value->assetsEstimation;	
						}
						else {
							$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'DivPet_ft[0]'] = $value->assetsEstimation/2;	
							$combine['topmostSubform[0].Page1[0].Table5[0].Checking'.$CheckingC.'_ft[0].Checking'.$CheckingC.'DivRes_ft[0]'] = $value->assetsEstimation/2;	
						}
					}
				}
			}
			$debtList = $this->gov_model->getDebts($userSe['uid']);
			$CreditcardC = 0;
			$personalC = 0;
			$StudentloansC = 0;
			$TaxesC = 0;

			foreach ($debtList as $key => $value) {

				if($value->debtType == '1'){
					$CreditcardC++;
					if($CreditcardC < 7){
						$combine['topmostSubform[0].Page3[0].Debts[0].CCards'.$CreditcardC.'_rw[0].CCards'.$CreditcardC.'_tx[0]'] = 'Credit Card';
						$combine['topmostSubform[0].Page3[0].Debts[0].CCards'.$CreditcardC.'_rw[0].CCards'.$CreditcardC.'Date_dt[0]'] = $value->acquireDebyDate;
						$combine['topmostSubform[0].Page3[0].Debts[0].CCards'.$CreditcardC.'_rw[0].CCards'.$CreditcardC.'Debt_dc[0]'] = $value->debyEstimation;
						$combine['topmostSubform[0].Page3[0].Debts[0].CCards'.$CreditcardC.'_rw[0].CCards'.$CreditcardC.'Pet_ft[0]'] = $value->howMuchDebtGot;
						$combine['topmostSubform[0].Page3[0].Debts[0].CCards'.$CreditcardC.'_rw[0].CCards'.$CreditcardC.'Resp_ft[0]'] = $value->howMuchDebtGotSpouse;		
					}
				}
				if($value->debtType == '3'){
					$personalC++;
					if($personalC < 5){
						$combine['topmostSubform[0].Page3[0].Debts[0].UnsecLoans'.$personalC.'_rw[0].UnsecLoans'.$personalC.'_tx[0]'] = 'Personal loans';
						$combine['topmostSubform[0].Page3[0].Debts[0].UnsecLoans'.$personalC.'_rw[0].UnsecLoans'.$personalC.'Date_dt[0]'] = $value->acquireDebyDate;
						$combine['topmostSubform[0].Page3[0].Debts[0].UnsecLoans'.$personalC.'_rw[0].UnsecLoans'.$personalC.'Debt_dc[0]'] = $value->debyEstimation;
						$combine['topmostSubform[0].Page3[0].Debts[0].UnsecLoans'.$personalC.'_rw[0].UnsecLoans'.$personalC.'Pet_ft[0]'] = $value->howMuchDebtGot;
						$combine['topmostSubform[0].Page3[0].Debts[0].UnsecLoans'.$personalC.'_rw[0].UnsecLoans'.$personalC.'Resp_ft[0]'] = $value->howMuchDebtGotSpouse;		
					}
				}
				if($value->debtType == '4'){
					$StudentloansC++;
					if($StudentloansC < 6){
						$combine['topmostSubform[0].Page3[0].Debts[0].StLoans'.$StudentloansC.'_rw[0].StLoans'.$StudentloansC.'_tx[0]'] = 'Student loans';
						$combine['topmostSubform[0].Page3[0].Debts[0].StLoans'.$StudentloansC.'_rw[0].StLoans'.$StudentloansC.'Date_dt[0]'] = $value->acquireDebyDate;
						$combine['topmostSubform[0].Page3[0].Debts[0].StLoans'.$StudentloansC.'_rw[0].StLoans'.$StudentloansC.'Debt_dc[0]'] = $value->debyEstimation;
						$combine['topmostSubform[0].Page3[0].Debts[0].StLoans'.$StudentloansC.'_rw[0].StLoans'.$StudentloansC.'Pet_ft[0]'] = $value->howMuchDebtGot;
						$combine['topmostSubform[0].Page3[0].Debts[0].StLoans'.$StudentloansC.'_rw[0].StLoans'.$StudentloansC.'Resp_ft[0]'] = $value->howMuchDebtGotSpouse;		
					}
				}
				if($value->debtType == '5'){
					$TaxesC++;
					if($TaxesC < 5){
						$combine['topmostSubform[0].Page3[0].Debts[0].Taxes'.$TaxesC.'_rw[0].Taxes'.$TaxesC.'_tx[0]'] = 'Taxes';
						$combine['topmostSubform[0].Page3[0].Debts[0].Taxes'.$TaxesC.'_rw[0].Taxes'.$TaxesC.'Date_dt[0]'] = $value->acquireDebyDate;
						$combine['topmostSubform[0].Page3[0].Debts[0].Taxes'.$TaxesC.'_rw[0].Taxes'.$TaxesC.'Debt_dc[0]'] = $value->debyEstimation;
						$combine['topmostSubform[0].Page3[0].Debts[0].Taxes'.$TaxesC.'_rw[0].Taxes'.$TaxesC.'Pet_ft[0]'] = $value->howMuchDebtGot;
						$combine['topmostSubform[0].Page3[0].Debts[0].Taxes'.$TaxesC.'_rw[0].Taxes'.$TaxesC.'Resp_ft[0]'] = $value->howMuchDebtGotSpouse;		
					}
				}
			}			
			
			
			if(file_exists('./application/controllers/api/temp/fl160.pdf')){
				@unlink('/home3/yourdemo/public_html/app/application/controllers/api/temp/fl160.pdf');
			}
			else{

			}
			//$pdf->fillForm($combine)->needAppearances()->flatten()->saveAs('./application/controllers/api/temp/fl160.pdf');
			$pdf->fillForm($combine)->needAppearances()->flatten()->send('fl160.pdf');
		}		
	}
}
?>