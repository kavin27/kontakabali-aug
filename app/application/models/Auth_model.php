<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public $table = 'projects';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }
    public function login($username='', $password=''){
    	if($username!='' && $password!=''){
    		$password = md5($password);
	    	$result = $this->db->where('user_email', $username)->where('password', $password)->get('user')->row();
	    	if($result){
                if($result->confirmed){
                    $firsttime = $this->db->where('user_id', $result->id)->count_all_results('login_history');
                    if($firsttime){
                        $welcome = false;
                    }
                    else{
                        $welcome = true;    
                    }
                    $loggedin = array('user_id' => $result->id);
                    $this->db->insert('login_history', $loggedin);
                    $output = array(
                            'status' =>'SUCCESS', 
                            'message'=>'Successfully logged in', 
                            'uid'=>$result->id, 
                            'email'=>$result->user_email, 
                            'welcome'=>$welcome,
                            'userType'=>$result->user_type
                        );    
                }
                else{
                    $output = array('status' =>'ERROR' , 'message'=>'<p>User activation mail is not confirmed</p>' );
                }
                
	    	}
	    	else{
	    		$output = array('status' =>'ERROR', 'message'=>'<p>Username and password does not match</p>');
	    	}
    	}
    	else{
    		$output = array('status' =>'ERROR', 'message'=>'Username and password is empty' );
    	}
    	return $output;
    }
    public function loadProfile($data){
        $output = $this->db->where('id', $data['uid'])->get('user')->row();
        //print_r($output);
        if($output->profile_photo==''){
            $output->profile_photo = 3;
        }
        return $output->profile_photo;
    }
    public function changePic($data){
        if(isset($data['uid'])){
            $pic = array('profile_photo' => $data['pic'] );
            $pic = $pic == '' ? '3' : $pic;
            $output = $this->db->where('id', $data['uid'])->update('user', $pic);
        }
        else{
            $output = array('status' => 'ERROR');
        }
        return $output;
    }
    public function forgotPassword($data){
        if($data['email'] !='' ){
            $check_exist = $this->db->where('user_email', $data['email'])->count_all_results('user');
            if($check_exist){
                $reset_key = array('recovery_key' => $data['key'] );
                $result = $this->db->where('user_email', $data['email'])->update('user', $reset_key );    
                $output = array('status' => 'SUCCESS' , 'message' => 'Reset Password link send to email');
            }
            else{
                $output = array('status' => 'ERROR' , 'message' => 'This is not a registered user.  Please enter the information again.' );
            }
        }
        return $output;
    }
    public function registration($data){
        if($data['customer']['username'] != '' && $data['customer']['password'] != ''){
            $password = md5($data['customer']['password']);
            $exist = $this->exist_user($data['customer']['username']);
            if($exist){
                $result = array('status' => 'ERROR' , 'message' => 'Email Already exist' );
            }
            else{
                $set = array(
                    'user_type' => 2,
                    'first_name' => $data['customer']['name'] , 
                    'user_email' => $data['customer']['username'],
                    'password' => $password,
                    'confirmation_key' => $data['system']['confirm_key'],
                    'ip' => $data['system']['ip'],
                    'others' => $data['system']['others'],
                    'dateSperation'=>$data['customer']['dateSperation']
                );
                $this->db->insert('user', $set);
                $user_id = $this->db->insert_id();
                $myinfo = array(
                        'user_id'=>$user_id,
                        'fname'=>$data['customer']['name'],
                        'lname'=>$data['customer']['lname']
                    );
                $this->db->insert('myinfo', $myinfo);
                $this->insert_user_meta($user_id, '_six_month_ca_living_status', $data['customer']['living_status']);
                $this->insert_user_meta($user_id, '_process_status', $data['customer']['process_status']);
                $this->insert_user_meta($user_id, '_prenuptial_status', $data['customer']['prenuptial']);
                $this->insert_user_meta($user_id, '_no_of_child_under_18', $data['customer']['noc_under_18']);
                $this->insert_user_meta($user_id, '_reach_a_settlement', $data['customer']['settlement_status']);
                $result = array('status' => 'SUCCESS', 'message' => 'Successfully Registered');
            }
        }
        else{
            $result = array('status' => 'ERROR', 'message' => 'Please try again');   
        }
        return $result;
    }
    public function insert_user_meta($user_id, $meta_key, $meta_value){
        $data = array(
            'user_id' => $user_id, 
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        );
        $this->db->insert('user_meta' ,$data);
        return $this->db->insert_id();
    }
    public function exist_user($email){
        $result = $this->db->where('user_email', $email)->get('user')->row();
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    public function count(){

    }
    public function activate_user($data){
        $result = $this->db->where('user_email', $data['email'])->get('user')->row();
        if(!empty($result)){
            if($result->confirmation_key == $data['key']){
            	$confirm_date = date('Y-m-d H:i:s');
            	$change = array('confirmation_key' =>'' , 'confirmed'=>'1', 'confirmed_date'=>$confirm_date );
            	$confirm = $this->db->where('user_email', $data['email'])->update('user', $change);
                $output = array(
                	'status' => 'SUCCESS' , 
                	'message' => 'Successfully Authenticated', 
                	'uid'=>$result->id, 
                	'email'=>$result->user_email, 
                	'wellcome'=>true
                );
            }
            else{
                $output = array('status' => 'ERROR' , 'message' => 'Authentication Faild' );
            }
        }
        else{
            $output = array('status' => 'ERROR' , 'message' => 'Unkown User' );
        }
        return $output;
    }
    public function add_welcome_data($data){
        $this->insert_user_meta($data['uid'], '_welcome_data', $data['welcomecontent']);    
        $output = array('status' => 'SUCCESS' , 'message' => 'Successfully added welcome data');
        return $output;
    }
    public function checkResetPassword($data){
        if(isset($data['email']) && isset($data['key'])){
            $result = $this->db->where('user_email', $data['email'])->get('user')->row();
            if($result->recovery_key == $data['key']){
                $output = array('status' => 'SUCCESS' , 'message' => 'Successfully' );
            }
            else{
                $output = array('status' => 'ERROR' , 'message' => 'Invalid Information' );   
            }
        }
        else{
            $output = array('status' => 'ERROR' , 'message' => 'Email Not Found' );
        }
        return $output;
    }
    public function confirmChangePassword($data){
        if(isset($data['email']) && isset($data['key'])){
            $result = $this->db->where('user_email', $data['email'])->get('user')->row();
            if($result->recovery_key == $data['key']){
                $password = md5($data['password']);
                $reset_key = array('password' => $password, 'recovery_key'=>'' );
                $result = $this->db->where('user_email', $data['email'])->update('user', $reset_key );    

                $output = array('status' => 'SUCCESS' , 'message' => 'Successfully' );
            }
            else{
                $output = array('status' => 'ERROR' , 'message' => 'Invalid Information' );   
            }
        }
        else{
            $output = array('status' => 'ERROR' , 'message' => 'Email Not Found' );
        }
        return $output;
    }
    public function saveData($data){
        //print_r($data);
        if(isset($data['uid'])){
            $noofchildData = array('meta_value'=>$data['noofchild']);
            $this->db->where('user_id', $data['uid'])->where('meta_key', '_no_of_child_under_18')->update('user_meta',$noofchildData);
            $data2 = array();
            // if(isset($data['myInfo']['dob'])){
            //     $data['myInfo']['dob'] = implode('/', $data['myInfo']['dob']);
            // }

            if(isset($data['myInfo'])){
                foreach ($data['myInfo'] as $myinfokey => $myinfovalue) {
                    $data2[$myinfokey] = $myinfovalue;
                }    
            }
            $check_exist = $this->db->where('user_id', $data['uid'])->count_all_results('myinfo');
            if(!$check_exist){
                isset($data['uid']) ? ($data2['user_id'] = $data['uid']) : '';
                $this->db->insert('myinfo', $data2);
            }
            else{
                $data2['last_updated'] = date('Y-m-d H:i:s');
                $this->db->where('user_id', $data['uid'])->update('myinfo', $data2 );    
            }
            unset($data2);

            // if(isset($data['spouseinfo']['dob'])){
            //     $data['spouseinfo']['dob'] = implode('/', $data['spouseinfo']['dob']);
            // }
            if (isset($data['spouseinfo'])) {
                foreach ($data['spouseinfo'] as $spouseinfokey => $spouseinfovalue) {
                    $data2[$spouseinfokey] = $spouseinfovalue;
                }
            }
            $check_exist = 0;
            $check_exist = $this->db->where('user_id', $data['uid'])->count_all_results('spouseinfo');
            if(!$check_exist){
                isset($data['uid']) ? ($data2['user_id'] = $data['uid']) : '';
                $this->db->insert('spouseinfo', $data2);
            }
            else{
                $data2['last_updated'] = date('Y-m-d H:i:s');
                $this->db->where('user_id', $data['uid'])->update('spouseinfo', $data2 ); 
            }
            unset($data2);

            // if(isset($data['ourProfile']['dom'])){
            //     $data['ourProfile']['dateMarried'] = implode('/', $data['ourProfile']['dom']);
            //     unset($data['ourProfile']['dom']);
            // }
            //$data['ourProfile']['dateMarried'] = $data['ourProfile']['dom'];
            //unset($data['ourProfile']['dom']);
            if(isset($data['ourProfile'])){
                foreach ($data['ourProfile'] as $ourProfilekey => $ourProfilevalue) {
                    $data2[$ourProfilekey] = $ourProfilevalue;
                }
            }
            $check_exist = 0;
            $check_exist = $this->db->where('user_id', $data['uid'])->count_all_results('ourprofile');
            if(!$check_exist){
                isset($data['uid']) ? ($data2['user_id'] = $data['uid']) : '';
                $this->db->insert('ourprofile', $data2);
            }
            else{
                $data2['last_updated'] = date('Y-m-d H:i:s');
                $this->db->where('user_id', $data['uid'])->update('ourprofile', $data2 ); 
            }
            unset($data2);

            $data2 = array();
            if(isset($data['kidsRelation'])){
                foreach ($data['kidsRelation'] as $kidsrelationkey => $kidsrelationvalue) {
                    $data2[$kidsrelationkey] = $kidsrelationvalue;
                }
            }
            $check_exist = 0;
            $check_exist = $this->db->where('user_id', $data['uid'])->count_all_results('kidsrelation');
            if(!$check_exist){
                isset($data['uid']) ? ($data2['user_id'] = $data['uid']) : '';
                $this->db->insert('kidsrelation', $data2);
            }
            else{
               // $data2['last_updated'] = date('Y-m-d H:i:s');
               // print_r($data2);
                if(!empty($data2))
                    $this->db->where('user_id', $data['uid'])->update('kidsrelation', $data2 ); 
            }
            unset($data2);

            foreach ($data['kids'] as $key => $value) {
                $kidsinnerdetails = array();
                foreach ($value as $key2 => $value2) {
                    if(!is_array($value2)){
                        $data2[$key2] = $value2;    
                    }
                    else{
                        foreach ($value2 as $kidsinnerkey => $kidsinnervalue) {
                            $kidsinnerdetails[$key2][$kidsinnerkey] = $kidsinnervalue;
                        }
                    }
                }

                if(isset($data2['id'])){
                    $resa = $this->db->where('id', $data2['id'])->update('kids', $data2 );
                    $kidsId = $data2['id'];
                    foreach ($kidsinnerdetails as $kidsinnerdetailskey => $kidsinnerdetailsvalue) {
                        foreach ($kidsinnerdetailsvalue as $kidsinnerdetailsvaluekey => $kidsinnerdetailsvaluevalue) {
                            if(!empty($kidsinnerdetails[$kidsinnerdetailskey][$kidsinnerdetailsvaluekey])){
                               $kidsinnerdetails[$kidsinnerdetailskey][$kidsinnerdetailsvaluekey]['kidId'] = $data2['id'];
                            }
                        }
                    } 
                }
                else{
                    //if(isset($data2) && !empty($data2)){
                        isset($data['uid']) ? ($data2['uids'] = $data['uid']) : '';    
                        $this->db->insert('kids', $data2);
                        $kidsId = $this->db->insert_id();
                    //}
                }
                foreach ($kidsinnerdetails as $kidsinnerdetailskey => $kidsinnerdetailsvalue) {
                    foreach ($kidsinnerdetailsvalue as $kidsinnerdetailsvaluekey => $kidsinnerdetailsvaluevalue) {
                        if(!empty($kidsinnerdetails[$kidsinnerdetailskey][$kidsinnerdetailsvaluekey])){
                            $kidsinnerdetails[$kidsinnerdetailskey][$kidsinnerdetailsvaluekey]['kidId'] = $kidsId;
                        }
                    }
                }
                foreach ($kidsinnerdetails as $kidsinnerdetailskey => $kidsinnerdetailsvalue) {
                    foreach ($kidsinnerdetailsvalue as $kidsinnerdetailsvaluekey => $kidsinnerdetailsvaluevalue) {
                        if(isset($kidsinnerdetailsvaluevalue['id'])){
                            $this->db->where('id', $kidsinnerdetailsvaluevalue['id'])->update($kidsinnerdetailskey,$kidsinnerdetailsvaluevalue);
                        }
                        else{
                            if(!empty($kidsinnerdetailsvaluevalue)){
                                $this->db->insert($kidsinnerdetailskey, $kidsinnerdetailsvaluevalue);    
                            }
                        }
                    }
                }
                unset($data2);
                unset($kidsinnerdetails);
            }
            $send = array('uid' => $data['uid'], 'email' => $data['email'] );
            $output = $this->loadUserData($send);
            $result = array('status' =>'SUCCESS' , 'message'=>'Successfully updated', 'others'=>$check_exist, 'data' => $output );    
        }
        else{
            $result = array('status' =>'ERROR' , 'message'=>'User Not logged in' );
        }
       // $result = $data;
        return $result;
    }
    public function get_form_data($uid){
        $data = array();
        $data['myInfo'] = $this->db->where('user_id', $uid)->get('myinfo')->row();
        if(!empty($data['myinfo'])){
            $data['myInfo']->dob = explode('/', $data['myInfo']->dob) ;
            unset($data['myInfo']->id);
            unset($data['myInfo']->user_id);
            unset($data['myInfo']->created_date);
            unset($data['myInfo']->last_updated);    
        }
        $data['spouseinfo'] = $this->db->where('user_id', $uid)->get('spouseinfo')->row();
        if(!empty($data['spouseinfo'])){
            $data['spouseinfo']->dob = explode('/', $data['spouseinfo']->dob) ;
            unset($data['spouseinfo']->id);
            unset($data['spouseinfo']->user_id);
            unset($data['spouseinfo']->created_date);
            unset($data['spouseinfo']->last_updated);    
        }
        return $data;
    }
    public function loadUserData($access){
        if(isset($access['uid']) && isset($access['email']) ){
            $userdata = $this->db->where('id', $access['uid'])->where('user_email', $access['email'])->get('user')->row();
            $noofchild = $this->db->where('user_id', $access['uid'])->where('meta_key', '_no_of_child_under_18')->get('user_meta')->row();
            $output['noofchild'] = isset($noofchild->meta_value) ? $noofchild->meta_value : 0;
            $myinfo = $this->db->where('user_id', $access['uid'])->get('myinfo')->row();
            $output['myInfo'] = !empty($myinfo) ? $myinfo : array();
            // if(isset($output['myInfo']->dob)){
            //     $output['myInfo']->dob = explode('/', $output['myInfo']->dob);
            // }

            $spouseinfo = $this->db->where('user_id', $access['uid'])->get('spouseinfo')->row();

            $output['spouseinfo'] = $spouseinfo;
            // if(isset($output['spouseinfo']->dob))
            //     $output['spouseinfo']->dob = explode('/', $output['spouseinfo']->dob);

            $ourProfile = $this->db->where('user_id' , $access['uid'])->get('ourprofile')->row();

            $output['ourProfile'] = $ourProfile;
            // if(isset($output['ourProfile']->dateMarried))
            //     $output['ourProfile']->dom = explode('/', $output['ourProfile']->dateMarried);

            $kids = $this->db->where('uids', $access['uid'])->get('kids')->result();

            if(!$kids){
                //echo "string";
            }
            $output['kids'] = $kids;
            
            foreach ($kids as $kidskey => $kidsvalue) {
              //  print_r($output['kids'][$kidskey]);
                $kidsaddress = $this->db->where('kidId', $kidsvalue->id)->get('kidsaddress')->result();
                if(empty($kidsaddress)){
                    $kidsaddress = array( (object)array());
                }
                $output['kids'][$kidskey]->kidsaddress = $kidsaddress;

                $kidslegalissue = $this->db->where('kidId', $kidsvalue->id)->get('kidslegalissue')->result();
                if(empty($kidslegalissue)){
                    $kidslegalissue = array( (object)array());
                }
                $output['kids'][$kidskey]->kidslegalissue = $kidslegalissue;

                $kidsprotective = $this->db->where('kidId', $kidsvalue->id)->get('kidsprotective')->result();
                if(empty($kidsprotective)){
                    $kidsprotective = array( (object)array());
                }
                $output['kids'][$kidskey]->kidsprotective = $kidsprotective;
            }
            if(empty($kids)){
                $noofchildArray = array();
                for($noofc=0; $noofc<$output['noofchild']; $noofc++) {
                    $noofchildArray[] = (object)array('kidsaddress'=>array((object)array()));
                }
                $output['kids'] = $noofchildArray;
                //$output['kids'] =array( (object)array('kidsaddress'=>array((object)array())));
            }

            $kidsRelation = $this->db->where('user_id', $access['uid'])->get('kidsrelation')->row();
            //unset($kidsRelation->legalCustody);
            //unset($kidsRelation->physicalCustody);
            $output['kidsRelation'] = $kidsRelation;
            //print_r($myinfo);

            $bookmark = $this->db->where('user_id', $access['uid'])->get('bookmark')->row();
            if($bookmark != null){
                $bookmark->forms = unserialize($bookmark->forms);
                //print_r($bookmark);
            }
            else{
                $bookmark['forms'] =array(
                        'basic' => array(
                            'currentStep' => 'myInfo1',
                            'completedPercent' => '0%', 
                            'i' => 0,
                            'j' => 0,
                            'k' => 0
                        ),
                        'kids' => array(
                            'currentStep' => 'Custody1',
                            'completedPercent' => '0%', 
                            'i' => 1,
                            'j' => 0,
                            'k' => 0
                        ) 
                    );
            }
            $output['bookmark'] = $bookmark;

        }
        else{
            $output = array('status' => 'ERROR' , 'message' => 'User Authentication Failed');
        }
        return $output;
    }
    public function updateBookmark($data){
        if(isset($data['data']['forms'])){
            $data['data']['forms'] = serialize($data['data']['forms']);
        }
        $check_exist = $this->db->where('user_id', $data['data']['user_id'])->count_all_results('bookmark');
        if($check_exist){
            $this->db->where('user_id', $data['data']['user_id'])->update('bookmark', $data['data']);
        }
        else{
            $this->db->insert('bookmark', $data['data']);
        }
        return $data;
    }

    public function addAssets($data){
        $this->db->insert('assets', $data['data']);
    }
    public function addDebt($data){
        $this->db->insert('debt', $data['data']);
    }
    public function getAssets($user){
        $out = $this->db->where('user_id', $user)->get('assets')->result();
        return $out;
    }
    public function getDebt($user){
        $out = $this->db->where('user_id', $user)->get('debt')->result();
        return $out;
    }
    public function editAssets($id, $data){
        //print_r($data);
        unset($data['created']);
        return $this->db->where('id', $id)->update('assets', $data);
    }
    public function editDebt($id, $data){
        //print_r($data);
        unset($data['created']);
        return $this->db->where('id', $id)->update('debt', $data);
    }
    public function delete($tableName, $id){
        $this->db->where('id', $id)->delete($tableName);
    }
    public function getSingle($id, $tableName){
        $out = $this->db->where('id', $id)->get($tableName)->row();
        //print_r($out);
        return $out;
    }
    public function editUpdate($tableName, $data){
        $this->db->where('id', $data['id'])->update($tableName, $data);
    }
    public function updateHoliday($id, $data){
        $value = array('data' => serialize($data));
        $check_exist = $this->db->where('user_id', $id)->count_all_results('holidaysselected');
        if($check_exist){
            $value['updated'] = date('Y-m-d');
            $this->db->where('user_id', $id)->update('holidaysselected', $value);    
        }
        else{
            $value['user_id'] = $id;
            $this->db->insert('holidaysselected', $value);
        }

    }
    public function getHolidays($uid){
        $out = $this->db->where('user_id', $uid)->get('holidaysselected')->row();
        if($out){
            $result = unserialize($out->data);  
        }
        else{
            $result = $out;
        }
        return $result;
    }
    public function loadAssetsCsv($uid){
        $result = array(
            array(
                    'Asset Name', 
                    'Accquire Assets Date', 
                    'Assets Estimation', 
                    'Outstanding Loan Value',
                    'Who Will Keep',
                    'Addtional Details',
                    'Acquire Assets',
                    'Assets Name'
                )
        );
        $assetsTypeList = array('',
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
        $out = $this->db->where('user_id', $uid)->get('assets')->result();
        foreach ($out as $key => $value) {

            unset($value->id);
            unset($value->user_id);
            unset($value->description);
            unset($value->assetBelongto);
            unset($value->created);
            unset($value->updated);
            $value->assetName = $assetsTypeList[$value->assetName];
            $result[] = (array)$value;
        }
        return $result;
    }
    public function loaddebtsCsv($uid){
        $result = array(
            array(
                    'Debt Type', 
                    'Accquire Debt',
                    'Accquire Debt Date', 
                    'Debt Estimation', 
                    'How Much you Get',
                    'How Much Spouse Get',
                    'Monthly Pay You',
                    'Monthly Pay Spouse',
                    'Addtional Details',
                    'Who Will Keep',
                    'Debt Name'
                )
        );
        $assetsTypeList = array('',
            'Credit card',
            'Past due child or spousal support',
            'Personal loans',
            'Student loans',
            'Taxes',
            'Property'
        );
        $out = $this->db->where('user_id', $uid)->get('debt')->result();
        foreach ($out as $key => $value) {

            unset($value->id);
            unset($value->user_id);
            unset($value->description);
            unset($value->belongTo);
            unset($value->user_id);
            unset($value->created);
            unset($value->updated);
            $value->debtType = $assetsTypeList[$value->debtType];
            $result[] = (array)$value;
        }
        return $result;
    }
    public function loadIncomeCsv($uid){
        $result = array(
            array(
                    'Income Belong To',
                    'Income Type', 
                    'Description', 
                    'How much income', 
                    'How often pay', 
                    'Income Name'
                )
        );
        $incomeTypeList = array('',
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
        $out = $this->db->where('user_id', $uid)->get('income')->result();
        foreach ($out as $key => $value) {

            unset($value->id);
            unset($value->user_id);
            unset($value->additionalDetails);
            unset($value->created);
            unset($value->updated);
            $value->incomeType = $incomeTypeList[$value->incomeType];
            $result[] = (array)$value;
        }
        return $result;
    }
    public function loadExpenseCsv($uid){
        $result = array(
            array(  
                    'Expense Belong To',
                    'Expense Type', 
                    'Description', 
                    'Accquire Expense',
                    'Accquire Expense Date', 
                    'Expense Estimation', 
                    'How Much you pay',
                    'How Much Spouse pay',
                    'How often pay',
                    'Expense Name'
                )
        );
        $assetsTypeList = array('',
            'Auto',
            'Charitable contributions',
            'Child care',
            'Clothes',
            'Education',
            'Groceries/household',
            'not SSI',
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
        $out = $this->db->where('user_id', $uid)->get('expense')->result();
        foreach ($out as $key => $value) {
            unset($value->id);
            unset($value->user_id);
            //unset($value->belongTo);
            unset($value->additional);
            unset($value->user_id);
            unset($value->created);
            unset($value->updated);
            $value->expenseType = $assetsTypeList[$value->expenseType];
            $result[] = (array)$value;
        }
        return $result;
    }
    public function addData($tableName, $data){
        $this->db->insert($tableName, $data);
    }
    public function loadData($id){
        $income = $this->db->where('user_id', $id)->get('income')->result();
        //print_r($income);
        $income2 = array('Me'=>array(), 'Spouse'=>array());
        foreach ($income as $key => $value) {
            if($value->incomeBelongto == 'Me'){
                $income2['Me'][] = (array)$value;
            }
            else{
                $income2['Spouse'][] = (array)$value;   
            }
        }
        $expense = $this->db->where('user_id', $id)->get('expense')->result();
        $expense2 = array('Me'=>array(), 'Spouse'=>array());
        foreach ($expense as $key => $value) {
            if($value->belongTo == 'Me'){
                $expense2['Me'][] = (array)$value;
            }
            else{
                $expense2['Spouse'][] = (array)$value;   
            }
        }
        $data['income'] = $income2;
        $data['expense'] = $expense2;
        return $data;
    }
    public function getDealData($id){
        $this->db->select('
                CONCAT_WS(" ", myinfo.fname, myinfo.lname) as "Your name", 
                CONCAT_WS(" ", spouseinfo.fname, spouseinfo.lname) as "Your spouse’s name", 
                myinfo.street as Address, 
                CONCAT_WS(", ", myinfo.city, myinfo.state, myinfo.zipcode) as csz, 
                myinfo.phone as Phone, 
                user.user_email as "Your Email"');
        $this->db->from('user');
        $this->db->join('myinfo', 'user.id = myinfo.user_id', 'right outer'); 
        $this->db->join('spouseinfo', 'user.id = spouseinfo.user_id', 'right outer'); 
        //$this->db->join('spouseinfo', 'user.id = spouseinfo.cid', 'right outer'); 
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    public function saveCurrentJob($data){
        $this->db->insert('makespendcurrentjob', $data['data']);
    }
    public function checkCurrentJob($id){
        return $this->db->where('user_id', $id)->count_all_results('makespendcurrentjob');
    }
    public function CurrentJobData($id){
        return $this->db->where('user_id', $id)->get('makespendcurrentjob')->result();
    }
    public function initInvite($id){
        return $this->db->select('status')->from('invite')->where('userId', $id)->get()->row();
    }
    public function checkSame($id, $email){
        //return $this->db->where('user_email', $email)->where('id', $id)->count_all_results('user');
        return $this->db->where('user_email', $email)->count_all_results('user');
    }
    public function validateInvite($data){
        $result = $this->db->where('email', $data['email'])->where('inviteKey', $data['key'])->where('status', 0)->count_all_results('invite');
        return $result;
    }
    public function addSpouse($data){
        extract($data);
        $password = md5($password);
        $userData = array(
                'user_type'=>3,
                'user_email'=>$email,
                'password'=>$password,
                'confirmed'=>1
            );
        $user = $this->db->insert('user', $userData);
        $user_id = $this->db->insert_id();
        $invite = array(
                'inviteKey'=>'',
                'status'=>1,
                'spouse_id'=>$user_id,
                'updated'=>date('m/d/Y')
            );
        $this->db->where('email', $email)->update('invite', $invite);
        return $user_id;
    }
    public function verifyDob($dob, $email){
        $result = $this->db->select('invite.userId')
            ->from('invite')
            ->join('spouseinfo', 'invite.userId = spouseinfo.user_id', 'inner')
            ->where('invite.email', $email)
            ->where('spouseinfo.dob', $dob)
            ->get()->row();
            //print_r($this->db);
        return $result;
    }
    public function loadBookmark($id){
        $bookmark = $this->db->select('basic, kids, haveOwe, makeSpend')->from('bookmark')->where('user_id', $id)->get()->row();
        return $bookmark;
    }
    public function uploadStatus($id, $data){
        $this->db->where('id', $id)->update('kidslegalissue', $data);
    }
    public function addEmpty($tableName, $data){
        $data = $this->db->insert($tableName, $data);
        $id = $this->db->insert_id();
        return $id;
    }
    public function getSpouse($id){
        $result = $this->db->select('userId')->where('spouse_id', $id)->get('invite')->row();
        return $result;
    }
    public function getInviteFlag($id){
        $result = $this->db->select('data')->where('userId', $id)->get('inviteflag')->row();
        return $result;
    }
    public function addInviteFlag($data){
        $this->db->insert('inviteflag', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    public function updateinviteFlag($id, $data){
        $this->db->where('userId', $id)->update('inviteflag', $data);
    }
    public function loadEmailData($id){
        $this->db->select('
                myinfo.fname as "MyName", 
                spouseinfo.fname as "SpouseName", 
                user.user_email as "UserEamil"
            ');
        $this->db->from('user');
        $this->db->join('myinfo', 'user.id = myinfo.user_id', 'inner'); 
        $this->db->join('spouseinfo', 'user.id = spouseinfo.user_id', 'inner'); 
        //$this->db->join('spouseinfo', 'user.id = spouseinfo.cid', 'right outer'); 
        $this->db->where('user.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
}

/* End of file Project_model.php */
/* Location: ./application/models/Auth_model.php */