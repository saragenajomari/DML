<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function add_order(){
		//echo var_export($_POST);
		$i = 0;
		$arr=array();
		$cid = $_POST['cid'];
		$data['class_details'] = $this->Classes_model->get_class_by_id($cid);
		foreach($_POST['id_list'] as $item){
  			$data['details'] = $this->Items_model->get_item($item);
  			foreach ($data['details'] as $details) {
  				$arr[$i]['id'] = $details->id;
  				$arr[$i]['item_name'] = $details->item_name;
  				$arr[$i]['quantity'] = $details->quantity;
  			}
  			$i++;
  		}
  		$data['array']=$arr;

  		//load quantity page
  		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_student',$data);
		$this->load->view('pages/add_order_quantity',$data);
		$this->load->view('includes/footer');
	}

	public function add_quantity(){
		$i = 0;
		$j = 0;
		$flag = 1;
		$check = 0;
		$last_id = 0;
		
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$cid = $_POST['cid'];

		foreach($_POST['id_list'] as $item){
			$arr[$i]['id'] = $item;
			$i++;
		}
		$data['array'] = $arr;

		foreach($_POST['quan_list'] as $quan){
			$data['item'] = $this->Items_model->get_item($arr[$j]['id']);
			foreach ($data['item'] as $item_det) {
				if ($quan>$item_det->quantity) {
					$check = 1;
				}else{
					if ($quan==0) {
						$check = 1;
					}else{
						$arr1[$j]['quan'] = $quan;
					}	
				}
			}
			$j++;
		}
		$data['array1'] = $arr1;

		if ($check == 0) {

			$orderdata = array(
            	'student' => $id,
            	'class' => $cid,
            	'status' => 'pending',
            	'date_ordered'	=> date("Y-m-d"),
            	'date_approved' => '',
            	'date_dispensed' => '',
            	'date_returned'	=> '',
            	'flag'			=> 0
        	);
        	$last_id = $this->Ordr_model->insertOrder($orderdata);
		}
		

        if ($last_id==FALSE||$check==1) {
        	$flag = 0;
        }
		
		if ($flag == 1) {
			for ($k=0; $k < $i ; $k++) { 

        		$itemdata = array(
            		'ordr' => $last_id,
            		'item' => $data['array'][$k]['id'],
            		'quantity' => $data['array1'][$k]['quan'],
            		'status' => 'working',
            		'flag'	 => 0
        		);
        	$this->Order_items_model->insertOrderItems($itemdata);
        	}

        	echo 1;
		}else{
			echo 0;
		}      
	}

	public function delete_order(){
		$oid = $_POST['oid'];
		$status = $this->Ordr_model->deleteOrdr($oid);
        echo $status;
	}

	public function approve_order(){
		$err = 0;
		$flag = 0;
		$oid = $_POST['oid'];
		$data['order_item'] = $this->Order_items_model->get_item_by_order($oid);

		foreach ($data['order_item'] as $order) {
			$data['item_details'] = $this->Items_model->get_item($order->item);
			foreach ($data['item_details'] as $item) {
				if ($order->quantity>$item->quantity) {
					$flag = 1;
				}
			}
		}

		if ($flag != 1){
		    foreach ($data['order_item'] as $order) {
				$data['item_details'] = $this->Items_model->get_item($order->item);
				foreach ($data['item_details'] as $item) {
					$net_quan = $item->quantity - $order->quantity;
					$status = $this->Items_model->updateItemQuan($net_quan, $order->item);
					if ($status == FALSE) {
						$err = 1;
					}
				}
			}
		}

		if ($err == 0 && $flag != 1) {
		    $oid = $_POST['oid'];
		    $date = date("Y-m-d");
			$status_two = $this->Ordr_model->updateOrdr($oid,$date);

			if ($status_two) {

			$item_list='';
			$data['ordr_details']=$this->Ordr_model->get_order_by_ordr($oid);
			foreach ($data['ordr_details'] as $data_ordr) {
			$data['class_details'] = $this->Classes_model->get_class_by_id($data_ordr->class);
				foreach ($data['class_details'] as $data_class) {
					$ccode = $data_class->ccode;
					$grpNo = $data_class->grpNo;
					if ($data_class->semester == 1) {
						$semester = '1st';
					}elseif ($data_class->semester == 2) {
						$semester = '2nd';
					}else{
						$semester = 'Summer';
					}
					$acadYr = $data_class->acadYr;
					$acadYr_end = $data_class->acadYr_end;
				}	
				$data['student_details'] = $this->Accounts_model->get_user($data_ordr->student);
				foreach ($data['student_details'] as $data_student) {
					$sname = $data_student->fname.' '.$data_student->mname.' '.$data_student->lname;
					$sid   = $data_student->school_id;
					$email = $data_student->email;
					$contact = $data_student->contact;
				}
			}

			$data['approved_batch'] = $this->Order_items_model->get_item_by_order($oid);
			foreach ($data['approved_batch'] as $approved_data) {
				$data['item_detail'] = $this->Items_model->get_item($approved_data->item);
				foreach ($data['item_detail'] as $detail_item) {
					$item_name = $detail_item->item_name;
				}
				$item_list .= '<strong>'.$item_name.'</strong> x<strong>'.$approved_data->quantity.'</strong><br>';
			}

			$subject = 'USC DML: Approved Order';
			$message = '<p>Hello <strong>'.$sname.'</strong> ('.$sid.'),<br><br> This is from DML, reminding you that your order has been approved, under this order are these item(s):<br>'.$item_list.'In the Class: <strong>'.$ccode.'</strong> Group: <strong>'.$grpNo.'</strong> of the <strong>'.$semester.' semester</strong> of Academic Year: <strong>'.$acadYr.'-'.$acadYr_end.'</strong><br> You can get your item(s) on the counter inside the laboratory during the class schedule.<br><br><br> USC TC Autolab.</p>';

			$catch = $this->send_email($subject,$message,$email);
			if ($catch) {
				$api_code = 'TR-ROYKR224194_QKMCM';
    			$message_sms = 'Good day! This is DML. Your order has been approved. Check your email for more details. Thank You!';
    			$result_sms = $this->itexmo($contact,$message_sms,$api_code);
					if ($result_sms == ""){
						echo "iTexMo: No response from server!!!
						Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
						Please CONTACT US for help. ";	
					}else if ($result_sms == 0){
						echo $catch;
					}else{	
						echo "Error Num ". $result . " was encountered!";
					}
			}
			//echo $catch;
		}

		} elseif ($err == 1) {
			echo 2;
		} elseif ($err == 0 && $flag == 1) {
			echo 3;
		}
	}

	public function release_item(){
		$flag = 0;
		$oid = $_POST['oid'];
		$oiid = $_POST['oiid'];
		
		$item_status = $this->Order_items_model->release_item($oiid);

		if ($item_status) {
			$count = $this->Order_items_model->count_working_order($oid);
			if ($count<1) {
				$flag = 1;
			}

			if ($flag == 1) {
				$date = date("Y-m-d");
				$order_status = $this->Ordr_model->updateOrdr_dispense($oid,$date);
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 3;
		}	
	}

	public function return_item(){
		$quantity = 0;
		$iid = 0;

		$flag = 0;
		$oiid = $_POST['oiid'];
		$oid = $_POST['oid'];

		$item_status = $this->Order_items_model->return_item($oiid);

		if ($item_status) {
			$data['spec_details']=$this->Order_items_model->get_order_item($oiid);
			foreach ($data['spec_details'] as $specifics) {
				$quantity = $specifics->quantity;
				$iid = $specifics->item;
			}

			$data['item_detail'] = $this->Items_model->get_item($iid);
			foreach ($data['item_detail'] as $item) {
				$quantity = $quantity + $item->quantity;
			}

			$status = $this->Items_model->updateItemQuan($quantity,$iid);

			$count = $this->Order_items_model->count_dispensed_order($oid);
			if ($count<1) {
				$flag = 1;
			}

			if ($flag == 1) {
				$date = date("Y-m-d");
				$check_broken = $this->Order_items_model->count_broken_order($oid);
				if ($check_broken > 0) {
					$order_status = $this->Ordr_model->updateOrdr_return_broken($oid,$date);
					//from here
					$this->email_details($oid);
				}else{
					$order_status = $this->Ordr_model->updateOrdr_return($oid,$date);
				}
				echo 1;
			}else{
				echo 2;
			}
		}else{
			echo 3;
		}
	}

	public function return_broken_item(){
		
		$item_list = '';
		$order_id=0;
		$item_name='';
		$quantity = 0;
		$quantity_final = 0;
		$iid = 0;
		$flag = 0;
		$oiid = $_POST['oiid'];
		$oid = $_POST['oid'];

		$item_status = $this->Order_items_model->return_item_broken($oiid);

		if ($item_status) {
			//return value in the item db
			$data['spec_details']=$this->Order_items_model->get_order_item($oiid);
			foreach ($data['spec_details'] as $specifics) {
				$quantity = $specifics->quantity;
				$iid = $specifics->item;
				$order_id = $specifics->ordr;
			}

			$data['item_detail'] = $this->Items_model->get_item($iid);
			foreach ($data['item_detail'] as $item) {
				$quantity_final = $quantity + $item->quantity;
			}

			$status = $this->Items_model->updateItemReturnBroken($quantity_final,$iid);


			//check if all items has been recorded including broken
			$count = $this->Order_items_model->count_dispensed_order($oid);
			if ($count<1) {
				$flag = 1;
			}

			if ($flag == 1) {
				$date = date("Y-m-d");
				$order_status = $this->Ordr_model->updateOrdr_return_broken($oid,$date);
				//from here
				$catcher = $this->email_details($order_id);
				if ($catcher == 1) {
					echo 1;
				}else{
					echo 3;
				}
			}else{
				echo 2;
			}
		}else{
			echo 3;
		}	
	}

	public function email_details($oid){

		//$oid = $_POST['oid'];
		//email details
		$item_list='';
		$data['ordr_details']=$this->Ordr_model->get_order_by_ordr($oid);
			foreach ($data['ordr_details'] as $data_ordr) {
			$data['class_details'] = $this->Classes_model->get_class_by_id($data_ordr->class);
				foreach ($data['class_details'] as $data_class) {
					$ccode = $data_class->ccode;
					$grpNo = $data_class->grpNo;
					if ($data_class->semester == 1) {
						$semester = '1st';
					}elseif ($data_class->semester == 2) {
						$semester = '2nd';
					}else{
						$semester = 'Summer';
					}
					$acadYr = $data_class->acadYr;
				}	
				$data['student_details'] = $this->Accounts_model->get_user($data_ordr->student);
				foreach ($data['student_details'] as $data_student) {
					$sname = $data_student->fname.' '.$data_student->mname.' '.$data_student->lname;
					$sid   = $data_student->school_id;
					$email = $data_student->email;
					$contact = $data_student->contact;
				}
				$date_notify = $data_ordr->date_returned;
			}

				//email (notifying the student via email in batch)
			$data['broken_batch'] = $this->Order_items_model->get_broken($oid);
			foreach ($data['broken_batch'] as $broken_data) {
				$data['item_detail'] = $this->Items_model->get_item($broken_data->item);
				foreach ($data['item_detail'] as $detail_item) {
					$item_name = $detail_item->item_name;
				}
				$item_list .= '<strong>'.$item_name.'</strong> x<strong>'.$broken_data->quantity.'</strong><br>';
			}
		//$catch = $this->send_email($item_list,$ccode,$grpNo,$acadYr,$semester,$sname,$sid,$date_notify,$email);

		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$acadYr_end			= $cons->acadYr_end; 
		}

		$subject = 'USC DML: Student Notification';
		$message = '<p>Hello <strong>'.$sname.'</strong> ('.$sid.'),<br><br> This is from DML, reminding you that you have possibly damaged/lost this item(s):<br>'.$item_list.'On <strong>'.$date_notify.'</strong> during the Class: <strong>'.$ccode.'</strong> Group: <strong>'.$grpNo.'</strong> of the <strong>'.$semester.' semester</strong> of Academic Year: <strong>'.$acadYr.'-'.$acadYr_end.'</strong><br> Please settle this matter at the DML office as soon as possible to avoid reprecusions.<br><br><br> USC TC Autolab.</p>';

		$catch = $this->send_email($subject,$message,$email);

		if ($catch) {
			$api_code = 'TR-ROYKR224194_QKMCM';
    		$message_sms = 'Hi! This is DML. You have damaged an item in your order. Check your email for more details. Thanks!';
    		$result_sms = $this->itexmo($contact,$message_sms,$api_code);
				if ($result_sms == ""){
					echo "iTexMo: No response from server!!!
					Please check the METHOD used (CURL or CURL-LESS). If you are using CURL then try CURL-LESS and vice versa.	
					Please CONTACT US for help. ";	
				}else if ($result_sms == 0){
					return $catch;
				}else{	
					echo "Error Num ". $result . " was encountered!";
				}
		}	
		//return $catch;
	}

	public function send_email($subject,$message,$email){
		
		$this->load->library('email');
		
		/*$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$acadYr_end			= $cons->acadYr_end; 
		}

		$subject = 'USC DML: Student Notification';
		$message = '<p>Hello <strong>'.$sname.'</strong> ('.$sid.'),<br><br> This is from DML, reminding you that you have possibly damaged/lost this item(s):<br>'.$item_list.'On <strong>'.$date_notify.'</strong> during the Class: <strong>'.$ccode.'</strong> Group: <strong>'.$grpNo.'</strong> of the <strong>'.$semester.' semester</strong> of Academic Year: <strong>'.$acadYr.'-'.$acadYr_end.'</strong><br> Please settle this matter at the DML office as soon as possible to avoid reprecusions.<br><br><br> USC TC Autolab.</p>';*/

		// Get full html:
		$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
    		<meta http-equiv="Content-Type" content="text/html; charset=' . strtolower(config_item('charset')) . '" />
    		<title>' . html_escape($subject) . '</title>
    		<style type="text/css">
        	body {
            	font-family: Arial, Verdana, Helvetica, sans-serif;
            	font-size: 16px;
        	}
    		</style>
			</head>
			<body>
			' . $message . '
			</body>
			</html>';
		// Also, for getting full html you may use the following internal method:
		//$body = $this->email->full_html($subject, $message);

		$result = $this->email
    		->from('jomaridummy@gmail.com')		//change here and email config file
    		->reply_to('')    // Optional, an account where a human being reads.
    		->to($email) // to($email)
   		 	->subject($subject)
    		->message($body)
    		->send();

    		return $result;
			//var_dump($result);
			//echo '<br />';
			//echo $this->email->print_debugger();

			//exit;
	}

	public function broken_item_ok(){
		$oiid = $_POST['oiid'];
		$oid  = $_POST['oid'];

		$status_order_item = $this->Order_items_model->update_broken_item_to_ok($oiid);

		if ($status_order_item) {
			$data['broken_item'] = $this->Order_items_model->get_order_item($oiid);
			foreach ($data['broken_item'] as $broken) {
				$status_item = $this->Items_model->updateBrokenItemOK($broken->item);
			}

			if ($status_item) {
				$no_of_broken =  $this->Order_items_model->count_broken_order($oid);
				if ($no_of_broken < 1) {
					$this->Ordr_model->updateOrdr_return_broken_ok($oid);
					echo 1;
				}else{
					echo 2;
				}
			}
		}
	}

	public function itexmo($number,$message,$apicode){
		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode);
		$param = array(
    		'http' => array(
        	'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        	'method'  => 'POST',
        	'content' => http_build_query($itexmo),
   			),
		);
		$context  = stream_context_create($param);
		return file_get_contents($url, false, $context);
	}
}
?>