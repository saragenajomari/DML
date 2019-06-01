<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Class_grp_model extends CI_Model{

	function __construct() {
        $this->transTable = 'class_grp';
    }

    public function get_master_list($cid,$acadYr,$semester){
        $query = $this->db->get_where($this->transTable, array('class' => $cid,'acadYr'=>$acadYr,'semester'=>$semester));
        return $query->result();
    }

    public function insertClassDetails($data){
        $insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }

    public function deleteMember($id){
        $delete = $this->db->delete($this->transTable, array('id' => $id));
        return $delete?true:false;
    }

    public function get_classes_of_student($sid,$acadYr,$semester){
        $query = $this->db->get_where($this->transTable, array('student' => $sid,'acadYr'=>$acadYr,'semester'=>$semester));
        return $query->result();
    }
}
?>