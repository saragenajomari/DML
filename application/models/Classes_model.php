<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Classes_model extends CI_Model{

	function __construct() {
        $this->transTable = 'class';
        $this->transTableUser = 'user';
    }

    public function insertClass($data){
    	$insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }

    public function get_classes(){
        $query = $this->db->get_where($this->transTable, array('status' => 'active'));
        return $query->result();
    }

    public function get_teacher($id){
        $query = $this->db->get_where($this->transTableUser, array('id' => $id));
        return $query->result();
    }

    public function disableClass($id){
        $this->db->set('status', 'disabled');
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function get_class_by_id($cid){
        $query = $this->db->get_where($this->transTable, array('id' => $cid));
        return $query->result();
    }

    public function updateClass($data,$cid){
        $this->db->where('id', $cid);
        $update = $this->db->update($this->transTable, $data);
        return $update?true:false;
    }
    public function checkClass($ccode,$grpNo,$semester,$acadYr){
        $this->db->where('ccode', $ccode);
        $this->db->where('grpNo', $grpNo);
        $this->db->where('semester', $semester);
        $this->db->where('acadYr', $acadYr);
        return $this->db->count_all_results($this->transTable);
    }
}
?>