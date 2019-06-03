<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_items_model extends CI_Model{
	function __construct() {
        $this->transTable = 'order_items';
    }

    public function insertOrderItems($data){
    	$insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }

    public function get_item_by_order($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid));
        return $query->result();
    }

    public function get_item_by_order_broken($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'flag'=>1));
        return $query->result();
    }

    public function get_item_in_order($iid,$oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'item',$iid));
        return $query->result();
    }

    public function count_working_order($oid){
        $this->db->where('ordr', $oid);
        $this->db->where('status', 'working');
        return $this->db->count_all_results($this->transTable); 
    }

    public function count_dispensed_order($oid){
        $this->db->where('ordr', $oid);
        $this->db->where('status', 'dispensed');
        return $this->db->count_all_results($this->transTable); 
    }

    public function get_item_by_order_releasing($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'status'=>'working'));
        return $query->result();
    }

    public function get_item_by_order_returning($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'status'=>'dispensed'));
        return $query->result();
    }

    public function get_item_by_order_flag($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'status'=>'returned','flag'=>1));
        return $query->result();
    }

    public function release_item($oiid){
        $this->db->set('status', 'dispensed');
        $this->db->where('id', $oiid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function return_item($oiid){
        $this->db->set('status', 'returned');
        $this->db->where('id', $oiid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function return_item_broken($oiid){
        $this->db->set('status', 'returned');
        $this->db->set('flag', 1);
        $this->db->where('id', $oiid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function get_order_item($oiid){
        $query = $this->db->get_where($this->transTable, array('id'=>$oiid));
        return $query->result();
    }

    public function get_broken($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'flag'=> 1));
        return $query->result();
    }

    public function update_broken_item_to_ok($oiid){
        $this->db->set('flag', 0);
        $this->db->where('id', $oiid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function count_broken_order($oid){
        $this->db->where('ordr', $oid);
        $this->db->where('flag', 1);
        return $this->db->count_all_results($this->transTable); 
    }

    public function get_item_by_order_complete($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'flag'=>0,'status'=>'returned'));
        return $query->result();
    }

    public function get_item_by_order_flag_0($oid){
        $query = $this->db->get_where($this->transTable, array('ordr'=>$oid,'status'=>'returned','flag'=>0));
        return $query->result();
    }

    public function check_delete($iid){
        $this->db->where('item', $iid);
        $this->db->where('status', 'working');
        $this->db->or_where('status', 'dispensed');
        return $this->db->count_all_results($this->transTable); 
    }
}
?>