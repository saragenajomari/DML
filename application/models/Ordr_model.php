<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ordr_model extends CI_Model{
	function __construct() {
        $this->transTable = 'ordr';
    }

    public function insertOrder($data){
    	
    	$insert = $this->db->insert($this->transTable,$data);
    	if ($insert) {
    		$val = $this->db->insert_id();
    	}else{
    		$val = FALSE;
    	}
        return $val;
    }

    public function get_order_by_id($id){
        $query = $this->db->get_where($this->transTable, array('student' => $id));
        return $query->result();
    }

    public function get_order_by_ordr($oid){
        $query = $this->db->get_where($this->transTable, array('id' => $oid));
        return $query->result();
    }

    public function get_order_by_status(){
        $query = $this->db->get_where($this->transTable, array('status' => 'pending'));
        return $query->result();
    }

    public function get_approved_order(){
        $query = $this->db->get_where($this->transTable, array('status' => 'approved'));
        return $query->result();
    }

    public function get_dispensed_order(){
        $query = $this->db->get_where($this->transTable, array('status' => 'dispensed'));
        return $query->result();
    }

    public function get_order_with_broken(){
        $query = $this->db->get_where($this->transTable, array('flag' => 1));
        return $query->result();
    }

    public function deleteOrdr($id){
        $this->db->set('status', 'removed');
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateOrdr($id,$date){
        $this->db->set('status', 'approved');
        $this->db->set('date_approved', $date);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateOrdr_dispense($id,$date){
        $this->db->set('status', 'dispensed');
        $this->db->set('date_dispensed', $date);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateOrdr_return($id,$date){
        $this->db->set('status', 'returned');
        $this->db->set('date_returned', $date);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

     public function updateOrdr_return_broken($id,$date){
        $this->db->set('flag', 1);
        $this->db->set('status', 'returned');
        $this->db->set('date_returned', $date);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateOrdr_return_broken_ok($oid){
        $this->db->set('flag', 0);
        $this->db->where('id', $oid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }
}
?>