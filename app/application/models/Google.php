<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google extends CI_Model{
	public function checkexist($userid){
		$out = $this->db->where('user_id', $userid)->count_all_results('googleaccess');
		return $out;
	}
	public function add($data){
		$this->db->insert('googleaccess', $data);
	}
	public function addCalendar($tableName,$data){
		$this->db->insert($tableName, $data);
	}
	public function update($tableName, $id, $data){
		$this->db->where('id', $id)->update($tableName, $data);
	}
	public function update2($tableName, $id, $data){
		$this->db->where('user_id', $id)->update($tableName, $data);
	}
	public function dalete(){

	}
	public function check($table, $id){
		$out = $this->db->where('user_id', $id)->count_all_results($table);
		return $out;
	}
	public function get($userid){
		$out = $this->db->where('user_id', $userid)->get('googleaccess')->result_array();
		return $out;
	}
	public function getEventIds($userId){
		$out = $this->db->where('user_id', $userId)->get('calendarlist')->row();
		return unserialize($out->eventList);
	}
	public function getCalenderIdList($uid){
		$out = $this->db->where('user_id', $uid)->get('calendarlist')->result_array();
		$customeList = $this->db->where('user_id', $uid)->get('customcalendar')->result_array();
		foreach ($customeList as $key => $value) {
			$out[] = $value;
		}
		return $out;
	}
	public function getChildSupCalId($uid){
		$out = $this->db->where('user_id', $uid)->get('calendarlist')->result_array();
		return $out;
	}
	public function clearTemplate($id){
		$value = array('eventList' => '', 'eventType' => 3 );
		$this->db->where('user_id', $id)->update('calendarlist', $value);
	}
}

?>