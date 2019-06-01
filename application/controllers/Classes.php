<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {

	public function add_class(){


		$ccode = $_POST['ccode'];
		$grpNo = $_POST['grpNo'];
		$ts		= $_POST['ts'];
		$te		= $_POST['te'];
		$teacher = $_POST['teacher'];
		$day	= $_POST['day'];
		$pname	= $_POST['pname'];
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; 
			$acadYr			= $cons->acadYr;
			$acadYr_end		= $cons->acadYr_end;
		}

		$classdata = array(
            'ccode' => $ccode,
            'grpNo' => $grpNo,
            'semester' => $semester,
            'acadYr' => $acadYr,
            'acadYr_end' => $acadYr_end,
            'time_start' => $ts,
            'time_end' => $te,
            'teacher' => $teacher,
            'day'	=>	$day,
            'status' => 'active',
            'pname'	=> $pname
        );

		$status = $this->Classes_model->insertClass($classdata);
		echo $status;
	}

	public function edit_class(){

		$ccode = $_POST['ccode'];
		$grpNo = $_POST['grpNo'];
		//$semester = $_POST['semester'];
		//$acadYr = $_POST['acadYr'];
		$ts		= $_POST['ts'];
		$te		= $_POST['te'];
		$teacher = $_POST['teacher'];
		$day	= $_POST['day'];
		$cid	= $_POST['cid'];
		$pname	= $_POST['pname'];
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; //make this dynamic 
			$acadYr			= $cons->acadYr; //make this dynamic
			$acadYr_end		= $cons->acadYr_end;
		}

		$classdata = array(
            'ccode' => $ccode,
            'grpNo' => $grpNo,
            'semester' => $semester,
            'acadYr' => $acadYr,
            'acadYr_end' => $acadYr_end,
            'time_start' => $ts,
            'time_end' => $te,
            'teacher' => $teacher,
            'day'	=>	$day,
            'status' => 'active',
            'pname'	=> $pname
        );

		$status = $this->Classes_model->updateClass($classdata,$cid);
		echo $status;
	}

	public function disable_class(){
		$id = $_POST['id'];
		$status = $this->Classes_model->disableClass($id);
        echo $status;
	}

	public function check_class_availability_add(){
		$ccode = $_POST['ccode'];
		$grpNo = $_POST['grpNo'];
		//$semester = $_POST['semester'];
		//$acadYr = $_POST['acadYr'];
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; 
			$acadYr			= $cons->acadYr; 
		}

		$exist = $this->Classes_model->checkClass($ccode,$grpNo,$semester,$acadYr);
		echo $exist;

	}

	public function check_class_availability_edit(){
		$ccode = $_POST['ccode'];
		$grpNo = $_POST['grpNo'];
		//$semester = $_POST['semester'];
		//$acadYr = $_POST['acadYr'];
		$cid 	= $_POST['cid'];
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester;  
			$acadYr			= $cons->acadYr; 
		}
		$data['class_details'] = $this->Classes_model->get_class_by_id($cid);
		foreach ($data['class_details'] as $data_class) {
			if ($data_class->ccode == $ccode && $data_class->grpNo == $grpNo && $data_class->acadYr == $acadYr && $data_class->semester == $semester) {
				echo 0;
			}else{
				$exist = $this->Classes_model->checkClass($ccode,$grpNo,$semester,$acadYr);
				echo $exist;
			}
		}
	}

	//specific class
	public function add_student_to_class(){
		$id = $_POST['id'];
		$cid = $_POST['cid'];
		$acadYr = $_POST['acadYr'];
		$semester = $_POST['semester'];

		$classdata = array(
            'class' => $cid,
            'student' => $id,
            'acadYr' => $acadYr,
            'semester' => $semester
        );
		$status = $this->Class_grp_model->insertClassDetails($classdata);
        echo $status;
	}

	public function delete_member(){
		$id = $_POST['id'];
		$status = $this->Class_grp_model->deleteMember($id);
        echo $status;
	}

	public function check_student(){
		$id 		= $_POST['id'];
		$cid 		= $_POST['cid'];
		$acadYr	 	= $_POST['acadYr'];
		$semester 	= $_POST['semester'];
		//$semester 	= 1; //make this dynamic 
		//$acadYr		= 2019; //make this dynamic
		$data['constant'] =$this->Constants_model->get_constant();
		foreach ($data['constant'] as $cons) {
			$semester 		= $cons->semester; //make this dynamic 
			$acadYr			= $cons->acadYr; //make this dynamic
		}
		$flag 		= 0;
		

		$data['class_details'] = $this->Classes_model->get_class_by_id($cid);
		$data['student_classes'] = $this->Class_grp_model->get_classes_of_student($id,$acadYr,$semester);
		
		foreach ($data['student_classes'] as $data_student_class) {
			$data['specific_class'] = $this->Classes_model->get_class_by_id($data_student_class->class);
			foreach ($data['specific_class'] as $data_specific) {
				foreach ($data['class_details'] as $data_detail) {
					if ($data_specific->ccode == $data_detail->ccode && $data_specific->acadYr == $data_detail->acadYr && $data_specific->semester == $data_detail->semester) {
						$flag = 1;
					}else{
						$time_one_start = $data_detail->time_start;
						$time_one_end = $data_detail->time_end;
						$time_two_start = $data_specific->time_start;
						$time_two_end = $data_specific->time_end;
						if ($data_specific->day == $data_detail->day) {
							if ($time_one_start == $time_two_start) {
								$flag = 1;
							}elseif ($time_one_start>$time_two_start && $time_one_start < $time_two_end) {
								$flag = 1;
							}elseif ($time_one_end>$time_two_start && $time_one_end>$time_two_end) {
								$flag = 1;
							}
						}
					}
				}
			}
		}
		echo $flag;
	}
}
?>