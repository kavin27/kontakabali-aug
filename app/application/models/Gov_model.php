<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gov_model extends CI_Model
{
	public function getOurDetails($id){
		$this->db->select('
						user.user_email as `Email`, 
						CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Name`,
					    myinfo.street as `Street`,
					    myinfo.city as `City`,
					    myinfo.state as `State`,
					    myinfo.zipcode as `Zip Code`,
					    myinfo.phone as `Phone`,
					    CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Petitioner`,
					    CONCAT_WS(" ", spouseinfo.fname, spouseinfo.lname) as `Respondent`,
					    ourprofile.dateMarried as `Date of Married`,
					    if(kidsrelation.noofchild > 0 , 0, 1) as `NoOfChild`,
					    if(kidsrelation.legalCustody = "Y" , 1 , 0) as `Leagal Custody`,
					    if(kidsrelation.physicalCustody = "Y" , 1, 0) as `Physical Custody`,
					   	ourprofile.finSupport as `Final Support`,
					   	kidsrelation.notborn as `notborn`
					');
		$this->db->from('user');
		$this->db->join('myinfo', 'user.id = myinfo.user_id', 'inner'); 
        $this->db->join('spouseinfo', 'user.id = spouseinfo.user_id', 'inner'); 
        $this->db->join('ourprofile', 'user.id = ourprofile.user_id', 'inner'); 
        $this->db->join('kidsrelation', 'user.id = kidsrelation.user_id', 'inner'); 
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        $result = $query->result();
        $noofchilduser_meta = $this->db->select('meta_value')->from('user_meta')->where('meta_key', '_no_of_child_under_18')->where('user_id', $id)->get()->row();
		$result[0]->NoOfChild = $noofchilduser_meta->meta_value;
        return $result;
	}
	public function kidsDetails($user_id){
		$this->db->select('
			CONCAT_WS(" ", firstname, middleName, lastName) as `Name`,
			dob, 
			gender
			');
		$this->db->from('kids');
		$this->db->where('uids', $user_id);
		$query = $this->db->get();
		return $query->result();
	}
	public function getBasicDetails($id){
		$this->db->select('
						CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Name`,
					    myinfo.street as `Street`,
					    myinfo.city as `City`,
					    CONCAT_WS(" - ", myinfo.state, myinfo.zipcode) as `State Zip`,
					    myinfo.phone as `Phone`,
					    user.user_email as `Email`, 
						CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Petitioner`,
					    CONCAT_WS(" ", spouseinfo.fname, spouseinfo.lname) as `Respondent`,
					');
		$this->db->from('user');
		$this->db->join('myinfo', 'user.id = myinfo.user_id', 'inner'); 
        $this->db->join('spouseinfo', 'user.id = spouseinfo.user_id', 'inner'); 
        $this->db->join('ourprofile', 'user.id = ourprofile.user_id', 'inner'); 
        $this->db->join('kidsrelation', 'user.id = kidsrelation.user_id', 'inner'); 
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        return $query->result();
	}
	public function getBasicDetailsfl150($id){
		$this->db->select('
						CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Name`,
					    myinfo.street as `Street`,
					    myinfo.city as `City`,
					    CONCAT_WS(" - ", myinfo.state, myinfo.zipcode) as `State Zip`,
					    myinfo.phone as `Phone`,
					    user.user_email as `Email`, 
						CONCAT_WS(" ", myinfo.fname, myinfo.lname) as `Petitioner`,
					    CONCAT_WS(" ", spouseinfo.fname, spouseinfo.lname) as `Respondent`,
					    makespendcurrentjob.name as `Emp Name`,
					    CONCAT_WS(" ", makespendcurrentjob.address1, makespendcurrentjob.address2) as `Emp Address`,
					    makespendcurrentjob.startDate as `Job start`,
					    makespendcurrentjob.endDate as `Job End`,
					    makespendcurrentjob.taxStatus as `Tax Status`
					');
		$this->db->from('user');
		$this->db->join('myinfo', 'user.id = myinfo.user_id', 'inner'); 
        $this->db->join('spouseinfo', 'user.id = spouseinfo.user_id', 'inner'); 
        $this->db->join('ourprofile', 'user.id = ourprofile.user_id', 'inner'); 
        $this->db->join('kidsrelation', 'user.id = kidsrelation.user_id', 'inner'); 
        $this->db->join('makespendcurrentjob', 'user.id = makespendcurrentjob.user_id', 'inner'); 
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        return $query->result();
	}
	public function getkidsrelation($id){
		$this->db->select('
				kidsrelation.noofchild as "NoOfChild",
				kidsrelation.custodySchedule as "Custody",
				kidsrelation.kidslivingSameAddress as "livingSameAddress",
				kidsrelation.protective as `protective`,
				kidsrelation.legalClaims as `legalClaims`,
				kidsrelation.kidsLegalissue as `legalissue`
			');
		$this->db->from('user');
		$this->db->join('kidsrelation', 'user.id = kidsrelation.user_id', 'inner');
		$this->db->where('user.id', $id);
		$query = $this->db->get();
		$result = $query->row();
		$noofchilduser_meta = $this->db->select('meta_value')->from('user_meta')->where('meta_key', '_no_of_child_under_18')->where('user_id', $id)->get()->row();
		$result->NoOfChild = $noofchilduser_meta->meta_value;
		return $result;
	}
	public function kidsFull($user_id){
		$kidsFinal = array();
		$kids = $this->db->where('uids', $user_id)->get('kids')->result();
		foreach ($kids as $key => $value) {
			$kidsFinal[$key] = (array)$value;
			$kidsFinal[$key]['kidsAddress'] = $this->db->where('kidId', $value->id)->get('kidsaddress')->result();
			$kidsFinal[$key]['protective'] = $this->db->where('kidId', $value->id)->get('kidsprotective')->result();
			$kidsFinal[$key]['legalissue'] = $this->db->where('kidId', $value->id)->get('kidslegalissue')->result();
			//$kidsFinal[$key]['legalclaims'] = $this->db->where('kidId', $value->id)->get('kids')->row();
		}		
		return $kidsFinal;
	}
	public function zipName($user_id){
		return $this->db->select('lname')->from('myinfo')->where('user_id', $user_id)->get()->row();
	}
	public function getAssets($user_id){
		return $this->db->where('user_id', $user_id)->get('assets')->result();
	}
	public function getDebts($user_id){
		return $this->db->where('user_id', $user_id)->get('debt')->result();
	}
	public function getMakeSpend($user_id){
		$makeSpend = array();
		$makeSpend['income'] = $this->db->where('user_id', $user_id)->get('income')->result();
		$makeSpend['expense'] = $this->db->where('user_id', $user_id)->get('expense')->result();
		return $makeSpend;
	}
	public function dob($user_id){
		return $this->db->select('dob')->from('myinfo')->where('user_id', $user_id)->get()->row();
	}
	public function getkidsdob($user_id){
		$list = $this->db->select('dob')->from('kids')->where('uids', $user_id)->get()->result();
		return $list;
	}
	public function ourAddress($user_id){
		$address = $this->db->select('
				myinfo.street as `My Street`,
				myinfo.city as `My city`,
				myinfo.state as `My State`,
				myinfo.zipcode as `My Zip Code`,
				spouseinfo.street as `Spouse Street`,
				spouseinfo.city as `Spouse City`,
				spouseinfo.state as `Spouse State`,
				spouseinfo.zipcode as `Spouse Zip Code`
			')
		->from('user')
		->join('myinfo', 'user.id = myinfo.user_id', 'inner')
		->join('spouseinfo', 'user.id = spouseinfo.user_id', 'inner')
		->where('user.id', $user_id);
        $query = $this->db->get();
        return $query->row();
	}
	public function patitionerGender($id){
		return $this->db->select('gender')->from('myinfo')->where('user_id', $id)->get()->row();
	}
}
