<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index()
	{
		$this->load->helper('form');
		//$this->load->view('includes/header');
		$this->load->view('pages/login');
		$this->load->view('includes/footer');

	}


	//Accounts Pages
	public function admin_home_page(){
		
		$id = $_SESSION['uid'];

		$data['info'] = $this->Accounts_model->get_user($id);
		

        $data['accounts'] =  $this->Accounts_model->get_user_active();

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/admin_accounts',$data);
		$this->load->view('includes/footer');
	}

	public function edit_account_page($id){
		$data['info'] = $this->Accounts_model->get_user($id);
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/edit_acc');
		$this->load->view('includes/footer');
	}

	public function edit_account_page_student($id){
		$data['info'] = $this->Accounts_model->get_user($id);
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_student',$data);
		$this->load->view('pages/edit_acc');
		$this->load->view('includes/footer');
	}

	public function add_account_page(){

		$id = $_SESSION['uid'];

		$data['info'] = $this->Accounts_model->get_user($id);
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/add_acc');
		$this->load->view('includes/footer');
	}

	//Classes Pages
	public function admin_class_page(){
		
		$i=0;
      	$arr=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; //make this dynamic 
			$acadYr			= $cons->acadYr; //make this dynamic
			$acadYr_end		= $cons->acadYr_end;
		}

		//to get clases with teachers name
		$data['class'] = $this->Classes_model->get_classes();
		foreach ($data['class'] as $data_class) {
			$arr[$i]['id'] = $data_class->id;
			$arr[$i]['ccode'] = $data_class->ccode;
          	$arr[$i]['grpNo'] = $data_class->grpNo;
          	if ($data_class->semester == '1') {
          		$arr[$i]['semester'] = 'First Semester';
          	}elseif ($data_class->semester == '2') {
          		$arr[$i]['semester'] = 'Second Semester';
          	}else{
          		$arr[$i]['semester'] = 'Summer';
          	}	
          	$arr[$i]['acadYr'] = $data_class->acadYr;
          	$arr[$i]['acadYr_end'] = $data_class->acadYr_end;
          	$arr[$i]['grpNo'] = $data_class->grpNo;
          	$arr[$i]['day'] = $data_class->day;
          	$arr[$i]['ts'] = $data_class->time_start;
          	$arr[$i]['te'] = $data_class->time_end;
          	$data['teacher'] = $this->Classes_model->get_teacher($data_class->teacher);
          	foreach ($data['teacher'] as $data_teacher) {
          		$arr[$i]['fname'] = $data_teacher->fname;
          		$arr[$i]['lname'] = $data_teacher->lname;
          	}
          	if ($semester == $data_class->semester) {
          		if ($acadYr != $data_class->acadYr) {
          			$arr[$i]['flag'] = TRUE;
          		}else{
          			$arr[$i]['flag'] = FALSE;
          		}
          	}else{
          		$arr[$i]['flag'] = TRUE;
          	}
          	$i++;
		}
		$data['array']=$arr;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/admin_classes',$data);
		$this->load->view('includes/footer');
	}

	public function add_class_page(){

		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
		$data['teachers'] =  $this->Accounts_model->get_teachers();
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/add_class',$data);
		$this->load->view('includes/footer');
	}

	public function check_class_page($cid){
		
		$i=0;
		$acadYr=0;
		$semester = 0;
		$arr=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester_con 		= $cons->semester; //make this dynamic 
			$acadYr_start			= $cons->acadYr; //make this dynamic
			$acadYr_end		= $cons->acadYr_end;
		}
		
		$data['class_details'] = $this->Classes_model->get_class_by_id($cid);
		foreach ($data['class_details'] as $data_class_details) {
		 	$arr[0]['cid'] = $data_class_details->id;
		 	$acadYr		   = $data_class_details->acadYr;
		 	$arr[0]['acadYr'] = $acadYr;
		 	$semester = $data_class_details->semester;
		 	$arr[0]['semester'] = $semester;
		 	$arr[0]['pname'] = $data_class_details->pname;
		 	if ($semester_con == $data_class_details->semester) {
          		if ($acadYr_start != $data_class_details->acadYr) {
          			$arr[0]['flag'] = TRUE;
          		}else{
          			$arr[0]['flag'] = FALSE;
          		}
          	}else{
          		$arr[0]['flag'] = TRUE;
          	}
		} 
		$data['array']=$arr;

		$arr2=array();
		$data['students_master_list'] = $this->Accounts_model->get_user_active_students();
		$data['class_master_list'] = $this->Class_grp_model->get_master_list($cid,$acadYr,$semester);

		foreach ($data['class_master_list'] as $data_details) {
			$arr2[$i]['lid'] = $data_details->id;
			if ($semester_con == $data_details->semester) {
          		if ($acadYr_start != $data_details->acadYr) {
          			$arr2[$i]['flag'] = TRUE;
          		}else{
          			$arr2[$i]['flag'] = FALSE;
          		}
          	}else{
          		$arr2[$i]['flag'] = TRUE;
          	}
			$data['student'] = $this->Accounts_model->get_user($data_details->student);
			foreach ($data['student'] as $data_student) {
				$arr2[$i]['id'] = $data_student->id;
				$arr2[$i]['school_id'] = $data_student->school_id;
				$arr2[$i]['pp'] = $data_student->profilepic;
				$arr2[$i]['fname'] = $data_student->fname;
				$arr2[$i]['mname'] = $data_student->mname;
				$arr2[$i]['lname'] = $data_student->lname;
			}
			$i++;
		}
		$data['array_two']=$arr2;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/class_details',$data);
		$this->load->view('includes/footer');
	}

	public function edit_class_page($cid){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
		$data['class_info'] = $this->Classes_model->get_class_by_id($cid);
		$data['teachers'] =  $this->Accounts_model->get_teachers();
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/edit_class',$data);
		$this->load->view('includes/footer');
	}

	//Student Account Pages

	public function admin_student_page(){
		
		$id = $_SESSION['uid'];

		$data['info'] = $this->Accounts_model->get_user($id);
		

        //$data['accounts'] =  $this->Accounts_model->get_user_pending_students();
        $data['students'] =  $this->Accounts_model->get_user_students();

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/admin_accounts_students',$data);
		$this->load->view('includes/footer');
	}

	//Inventory
	public function inventory_page(){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		//static model function for forcasting 
		$data['items_2019'] = $this->Items_model->get_all_items_2019(2019);
		$data['items_2020'] = $this->Items_model->get_all_items_2020(2020);
        
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/inventory',$data);
		$this->load->view('includes/footer');
	}

	public function add_item_page(){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
        
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/add_item',$data);
		$this->load->view('includes/footer');
	}

	public function edit_item_page($iid){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
        $data['item'] = $this->Items_model->get_item($iid);
        
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/edit_item',$data);
		$this->load->view('includes/footer');
	}

	//reset semester
	public function start_new_sem_page(){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['constant'] =$this->Constants_model->get_constant();
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_admin',$data);
		$this->load->view('pages/new_semester',$data);
		$this->load->view('includes/footer');
	}

	//Student Home Pages
	public function student_home_page(){

		$i=0;
		$id = $_SESSION['uid'];
		$arr=array();
		$data['info'] 	= $this->Accounts_model->get_user($id);
		//$semester 		= 1; //make this dynamic 
		//$acadYr			= 2019; //make this dynamic
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; //make this dynamic 
			$acadYr			= $cons->acadYr; //make this dynamic
		}
		$data['classes'] 	= $this->Class_grp_model->get_classes_of_student($id,$acadYr,$semester);
		foreach ($data['classes'] as $data_class) {
			$data['class_details'] = $this->Classes_model->get_class_by_id($data_class->class);
			foreach ($data['class_details'] as $data_details) {
				$arr[$i]['ccode'] = $data_details->ccode;
				$arr[$i]['grpNo'] = $data_details->grpNo;
				$arr[$i]['day'] = $data_details->day;
				$arr[$i]['ts'] = $data_details->time_start;
				$arr[$i]['te'] = $data_details->time_end;
				$arr[$i]['pname'] = $data_details->pname;
				$arr[$i]['id'] = $data_details->id;
				$data['teacher_details'] = $this->Accounts_model->get_user($data_details->teacher);
				foreach ($data['teacher_details'] as $data_teacher) {
					$arr[$i]['fname'] = $data_teacher->fname;
					$arr[$i]['lname'] = $data_teacher->lname;
				}
			}
			$i++;
		}

		$data['array']=$arr;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_student',$data);
		$this->load->view('pages/student_order',$data);
		$this->load->view('includes/footer');
	}

	public function add_order($cid){
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);

		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$acadYr = $cons->acadYr;
		}

		$data['class_details'] = $this->Classes_model->get_class_by_id($cid);
		$data['items'] = $this->Items_model->get_ok_items($acadYr);

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_student',$data);
		$this->load->view('pages/add_order',$data);
		$this->load->view('includes/footer');
	}

	public function view_orders_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_by_id($id);
		foreach($data['orders'] as $orders){
			$data['order_item'] = $this->Order_items_model->get_item_by_order($orders->id);
			foreach ($data['order_item'] as $order_items) {
				$data['item_details'] = $this->Items_model->get_item($order_items->item);
				foreach ($data['item_details'] as $details) {
					$arr1[$i][$j]['item_name']	=	$details->item_name;
				}
				$arr1[$i][$j]['quantity']	=	$order_items->quantity;
				$j++;
			}

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
			}
			$arr[$i]['date_ordered'] = $orders->date_ordered;
			$arr[$i]['date_approved'] = $orders->date_approved;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_student',$data);
		$this->load->view('pages/view_orders',$data);
		$this->load->view('includes/footer');
	}

	//teacher pages

	public function teacher_home_page(){

		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_by_status();
		foreach($data['orders'] as $orders){
			//newly added
			$data['class_det'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class_det'] as $det) {
				if ($det->teacher == $id) {
					//newly added
					$data['order_item'] = $this->Order_items_model->get_item_by_order($orders->id);
					foreach ($data['order_item'] as $order_items) {
						$data['item_details'] = $this->Items_model->get_item($order_items->item);
						foreach ($data['item_details'] as $details) {
							$arr1[$i][$j]['item_name']	=	$details->item_name;
						}
						$arr1[$i][$j]['quantity']	=	$order_items->quantity;
						$j++;
					}
					$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
					foreach ($data['class'] as $class) {
						$arr[$i]['class_name']	=	$class->pname;
					}
					$data['student'] = $this->Accounts_model->get_user($orders->student);
					foreach ($data['student'] as $student) {
						$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
						$arr[$i]['id']				=	$student->school_id;
					}
					$arr[$i]['date_ordered'] = $orders->date_ordered;
					$arr[$i]['oid'] = $orders->id;
					$i++;
				//newly added	
				}
			}
			//newly added
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_teacher',$data);
		$this->load->view('pages/pending_orders',$data);
		$this->load->view('includes/footer');
	}

	public function approved_orders_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_approved_order();
		foreach($data['orders'] as $orders){
			$data['order_item'] = $this->Order_items_model->get_item_by_order($orders->id);
			foreach ($data['order_item'] as $order_items) {
				$data['item_details'] = $this->Items_model->get_item($order_items->item);
				foreach ($data['item_details'] as $details) {
					$arr1[$i][$j]['item_name']	=	$details->item_name;
				}
				$arr1[$i][$j]['quantity']	=	$order_items->quantity;
				$j++;
			}

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
			}
			$data['student'] = $this->Accounts_model->get_user($orders->student);
			foreach ($data['student'] as $student) {
				$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
				$arr[$i]['id']				=	$student->school_id;
			}
			$arr[$i]['date_ordered'] = $orders->date_ordered;
			$arr[$i]['date_approved'] = $orders->date_approved;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_teacher',$data);
		$this->load->view('pages/all_order',$data);
		$this->load->view('includes/footer');
	}

//staff page
	public function staff_home_page(){
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);
		$data['students'] =  $this->Accounts_model->get_user_students();

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/admin_accounts_students',$data);
		$this->load->view('includes/footer');
	}	

	public function staff_inventory_page(){
		$id = $_SESSION['uid'];
		$data['info'] 	= $this->Accounts_model->get_user($id);
		//$data['items'] = $this->Items_model->get_all_items();
		$data['items_2019'] = $this->Items_model->get_all_items_2019(2019);
		$data['items_2020'] = $this->Items_model->get_all_items_2020(2020);

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/inventory',$data);
		$this->load->view('includes/footer');
	}

	public function staff_add_item_page(){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
        
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/add_item',$data);
		$this->load->view('includes/footer');
	}

	public function staff_edit_item_page($iid){
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);
        $data['item'] = $this->Items_model->get_item($iid);
        
		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/edit_item',$data);
		$this->load->view('includes/footer');
	}

	public function staff_approved_order_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_approved_order();
		foreach($data['orders'] as $orders){
			$data['order_item'] = $this->Order_items_model->get_item_by_order($orders->id);
			foreach ($data['order_item'] as $order_items) {
				$data['item_details'] = $this->Items_model->get_item($order_items->item);
				foreach ($data['item_details'] as $details) {
					$arr1[$i][$j]['item_name']	=	$details->item_name;
				}
				$arr1[$i][$j]['quantity']	=	$order_items->quantity;
				$j++;
			}

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
				$data['teacher'] = $this->Accounts_model->get_user($class->teacher);
				foreach ($data['teacher'] as $teacher) {
					$arr[$i]['teacher_name']	=	$teacher->fname.' '.$teacher->lname;	
				}
			}
			$data['student'] = $this->Accounts_model->get_user($orders->student);
			foreach ($data['student'] as $student) {
				$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
				$arr[$i]['id']				=	$student->school_id;
			}
			$arr[$i]['date_approved'] = $orders->date_approved;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/approved_order',$data);
		$this->load->view('includes/footer');
	}

	public function staff_check_order_page($oid){
		$j=0;
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_by_ordr($oid);
		$data['order_item'] = $this->Order_items_model->get_item_by_order_releasing($oid);
		foreach ($data['order_item'] as $order_items) {
			$data['item_details'] = $this->Items_model->get_item($order_items->item);
			foreach ($data['item_details'] as $details) {
				$arr1[$j]['item_name']	=	$details->item_name;
				$arr1[$j]['item_code']	=	$details->item_code;
				$arr1[$j]['item_id']	=	$details->id;
			}
			$arr1[$j]['oiid']	=	$order_items->id;
			$arr1[$j]['quantity']	=	$order_items->quantity;
			$j++;
		}

		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/approved_order_items',$data);
		$this->load->view('includes/footer');
	}

	public function staff_return_order_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_dispensed_order();
		foreach($data['orders'] as $orders){
			$data['order_item'] = $this->Order_items_model->get_item_by_order($orders->id);
			foreach ($data['order_item'] as $order_items) {
				$data['item_details'] = $this->Items_model->get_item($order_items->item);
				foreach ($data['item_details'] as $details) {
					$arr1[$i][$j]['item_name']	=	$details->item_name;
				}
				$arr1[$i][$j]['quantity']	=	$order_items->quantity;
				$j++;
			}

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
				$data['teacher'] = $this->Accounts_model->get_user($class->teacher);
				foreach ($data['teacher'] as $teacher) {
					$arr[$i]['teacher_name']	=	$teacher->fname.' '.$teacher->lname;	
				}
			}
			$data['student'] = $this->Accounts_model->get_user($orders->student);
			foreach ($data['student'] as $student) {
				$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
				$arr[$i]['id']				=	$student->school_id;
			}
			$arr[$i]['date_dispensed'] = $orders->date_dispensed;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/return_order',$data);
		$this->load->view('includes/footer');
	}	

	public function staff_check_order_for_return_page($oid){
		$j=0;
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_by_ordr($oid);
		$data['order_item'] = $this->Order_items_model->get_item_by_order_returning($oid);
		foreach ($data['order_item'] as $order_items) {
			$data['item_details'] = $this->Items_model->get_item($order_items->item);
			foreach ($data['item_details'] as $details) {
				$arr1[$j]['item_name']	=	$details->item_name;
				$arr1[$j]['item_code']	=	$details->item_code;
				$arr1[$j]['item_id']	=	$details->id;
			}
			$arr1[$j]['oiid']	=	$order_items->id;
			$arr1[$j]['quantity']	=	$order_items->quantity;
			$j++;
		}

		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/return_order_items',$data);
		$this->load->view('includes/footer');
	}

	public function staff_broken_item_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_with_broken();
		foreach($data['orders'] as $orders){
			$data['order_item'] = $this->Order_items_model->get_item_by_order_broken($orders->id);
			foreach ($data['order_item'] as $order_items) {
				$data['item_details'] = $this->Items_model->get_item($order_items->item);
				foreach ($data['item_details'] as $details) {
					$arr1[$i][$j]['item_name']	=	$details->item_name;
				}
				$arr1[$i][$j]['quantity']	=	$order_items->quantity;
				$j++;
			}

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
				$data['teacher'] = $this->Accounts_model->get_user($class->teacher);
				foreach ($data['teacher'] as $teacher) {
					$arr[$i]['teacher_name']	=	$teacher->fname.' '.$teacher->lname;	
				}
			}
			$data['student'] = $this->Accounts_model->get_user($orders->student);
			foreach ($data['student'] as $student) {
				$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
				$arr[$i]['id']				=	$student->school_id;
			}
			$arr[$i]['date_returned'] = $orders->date_returned;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/return_order_with_broken',$data);
		$this->load->view('includes/footer');
	}	

	public function staff_check_order_for_broken_page($oid){
		$j=0;
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_order_by_ordr($oid);
		$data['order_item'] = $this->Order_items_model->get_item_by_order_flag($oid);
		foreach ($data['order_item'] as $order_items) {
			$data['item_details'] = $this->Items_model->get_item($order_items->item);
			foreach ($data['item_details'] as $details) {
				$arr1[$j]['item_name']	=	$details->item_name;
				$arr1[$j]['item_code']	=	$details->item_code;
				$arr1[$j]['item_id']	=	$details->id;
			}
			$arr1[$j]['oiid']	=	$order_items->id;
			$arr1[$j]['quantity']	=	$order_items->quantity;
			$j++;
		}

		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/broken_order_items',$data);
		$this->load->view('includes/footer');
	}

	public function staff_completed_order_page(){
		$i=0;
		$j=0;
		$arr=array();
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['orders'] = $this->Ordr_model->get_completed_order();
		foreach($data['orders'] as $orders){

			$data['class'] = $this->Classes_model->get_class_by_id($orders->class);
			foreach ($data['class'] as $class) {
				$arr[$i]['class_name']	=	$class->pname;
				$arr[$i]['acadYr']		=	$class->acadYr;
				$arr[$i]['acadYr_end']	=	$class->acadYr_end;
				$arr[$i]['semester']	=	$class->semester;
				$arr[$i]['grpNo']	=	$class->grpNo;
				$data['teacher'] = $this->Accounts_model->get_user($class->teacher);
				foreach ($data['teacher'] as $teacher) {
					$arr[$i]['teacher_name']	=	$teacher->fname.' '.$teacher->lname;	
				}
			}
			$data['student'] = $this->Accounts_model->get_user($orders->student);
			foreach ($data['student'] as $student) {
				$arr[$i]['student_name']	=	$student->fname.' '.$student->lname;
				$arr[$i]['id']				=	$student->school_id;
			}
			$arr[$i]['date_approved'] = $orders->date_approved;
			$arr[$i]['date_dispensed'] = $orders->date_dispensed;
			$arr[$i]['date_returned'] = $orders->date_returned;
			$arr[$i]['oid'] = $orders->id;
			$arr[$i]['status']	= $orders->status;
			$i++;
		}

		$data['array'] = $arr;
		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/completed_orders',$data);
		$this->load->view('includes/footer');
	}	

	public function staff_check_completed_page($oid){
		$j=0;
		$arr1=array();
		$id = $_SESSION['uid'];
		$data['info'] = $this->Accounts_model->get_user($id);

		$data['order_item'] = $this->Order_items_model->get_item_by_order_flag_0($oid);
		foreach ($data['order_item'] as $order_items) {
			$data['item_details'] = $this->Items_model->get_item($order_items->item);
			foreach ($data['item_details'] as $details) {
				$arr1[$j]['item_name']	=	$details->item_name;
				$arr1[$j]['item_code']	=	$details->item_code;
				$arr1[$j]['item_id']	=	$details->id;
			}
			$arr1[$j]['oiid']	=	$order_items->id;
			$arr1[$j]['quantity']	=	$order_items->quantity;
			$j++;
		}

		$data['array1'] = $arr1;

		$this->load->view('includes/header');
		$this->load->view('includes/navbar_staff',$data);
		$this->load->view('pages/completed_order_items',$data);
		$this->load->view('includes/footer');
	}

	//Logout

	function logout(){
        unset(
            $_SESSION['uid'],
            $_SESSION['fname'],
            $_SESSION['lname'],
            $_SESSION['mname'],
            $_SESSION['type'],
            $_SESSION['logged_in']
            );
        session_destroy();
        redirect('pages/index');
    }
}
?>