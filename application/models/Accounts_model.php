<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accounts_model extends CI_Model{

	function __construct() {
        $this->transTable = 'user';
    }

    public function login($uname,$password){
        $this->db->where('username', $uname);
        $this->db->where('password', $password);
        $this->db->where('status', 'active');
        return $this->db->count_all_results($this->transTable); 
  	}

  	public function login_get_user($uname,$password){
        $query = $this->db->get_where($this->transTable, array('username' => $uname, 'password' => $password));
        return $query->result();
 	}

    public function insertAccount($data){
        $insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }

    public function check_id_num($id){
        $this->db->where('school_id', $id);
        return $this->db->count_all_results($this->transTable); 
    }

    public function get_user($id){
        $query = $this->db->get_where($this->transTable, array('id' => $id));
        return $query->result();
    }

    public function updateAccount($data,$id){
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable, $data);
        return $update?true:false;
    }

    public function get_user_active(){
        $this->db->select('*');
        $this->db->from($this->transTable);
        $this->db->where('status', 'active');
        $this->db->where('type', 'teacher');
        $this->db->or_where('type', 'staff');
        $this->db->or_where('type', 'admin');
        $query = $this->db->get();
        return $query->result();
    }

    public function disableAccount($id){
        $this->db->set('status', 'disabled');
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

     public function activateAccount($id,$rfid){
        $this->db->set('status', 'active');
        $this->db->set('rfid', $rfid);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function get_teachers(){
        $query = $this->db->get_where($this->transTable, array('type' => 'teacher'));
        return $query->result();
    }

    public function get_user_pending_students(){
        $query = $this->db->get_where($this->transTable, array('status' => 'pending', 'type' => 'student'));
        return $query->result();
    }

    public function get_user_active_students(){
        $query = $this->db->get_where($this->transTable, array('status' => 'active', 'type' => 'student'));
        return $query->result();
    }

    public function get_user_students(){
        $query = $this->db->get_where($this->transTable, array('type' => 'student'));
        return $query->result();
    }
}
?>