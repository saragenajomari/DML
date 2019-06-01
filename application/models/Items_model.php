<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items_model extends CI_Model{
	
	function __construct() {
        $this->transTable = 'item';
    }

    public function insertItem($data){
        $insert = $this->db->insert($this->transTable,$data);
        return $insert?true:false;
    }

    public function get_all_items(){
    	$query = $this->db->get($this->transTable);
        return $query->result();
    }

    public function get_item($id){
    	$query = $this->db->get_where($this->transTable, array('id' => $id));
        return $query->result();
    }

    public function get_ok_items(){
        
        $this->db->select('*');
        $this->db->from($this->transTable);
        $this->db->where('status', 'available');
        $this->db->where('quantity >', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function updateItem($data,$id){
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable, $data);
        return $update?true:false;
    }

    public function updateItemReturn($quantity,$iid){
        $this->db->set('quantity', $quantity);
        $this->db->where('id', $iid);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function deleteItem($id){
        $delete = $this->db->delete($this->transTable, array('id' => $id));
        return $delete?true:false;
    }

     public function updateItemQuan($quantity,$id){
        $this->db->set('quantity', $quantity);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateItemReturnBroken($quantity,$id){
        $this->db->set('status', 'broken');
        $this->db->set('quantity', $quantity);
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }

    public function updateBrokenItemOK($id){
        $this->db->set('status', 'repair');
        $this->db->where('id', $id);
        $update = $this->db->update($this->transTable);
        return $update?true:false;
    }
} 
?>