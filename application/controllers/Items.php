<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {
	
	public function add_item(){

		$item_code = $_POST['itemCode'];
		$item_name = $_POST['itemName'];
		$item_value = $_POST['itemValue'];
		$item_quantity = $_POST['itemQuantity'];
		$status = 'available';
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$acadYr = $cons->acadYr;
		}

		$itemdata = array(
            'item_code' => $item_code,
            'item_name' => $item_name,
            'value' => $item_value,
            'quantity' => $item_quantity,
            'status' => $status,
            'acadYr' => $acadYr,
           	'stat'	=> 0
        );

		$status = $this->Items_model->insertItem($itemdata);
		echo $status;
        //echo $item_code.' '.$item_name.' '.$item_value.' '.$item_quantity;
	}

	public function update_item(){

		$id = $_POST['itemid'];
		$item_code = $_POST['itemCode'];
		$item_name = $_POST['itemName'];
		$item_value = $_POST['itemValue'];
		$item_quantity = $_POST['itemQuantity'];
		$status = $_POST['status'];
		$acadYr = $_POST['acadYr'];


		$itemdata = array(
            'item_code' => $item_code,
            'item_name' => $item_name,
            'value' => $item_value,
            'quantity' => $item_quantity,
            'status' => $status,
            'acadYr' => $acadYr,
            'stat'	=> 0
        );

		$status = $this->Items_model->updateItem($itemdata,$id);
		echo $status;
        //echo $item_code.' '.$item_name.' '.$item_value.' '.$item_quantity;
	}

	public function delete_item(){
		$id = $_POST['id'];

		$count = $this->Order_items_model->check_delete($id);
		if ($count > 0) {
			$status = 0;
		}else{
			$status = $this->Items_model->deleteItem($id);
		}
		
        echo $status;
	}
}
?>