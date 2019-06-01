<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Constants_model extends CI_Model{

	function __construct() {
        $this->transTable = 'constants';
    }

    public function get_constant(){
        $query = $this->db->get_where($this->transTable, array('id' => 1));
        return $query->result();
    }

    public function insertConstant($data){
        $update = $this->db->update($this->transTable,$data,array('id'=>1));
        return $update?true:false;
    }
}
?>