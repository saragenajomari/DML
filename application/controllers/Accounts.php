<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function determine_user(){
		$id =  $this->uri->segment(3);

		$data['info'] = $this->Accounts_model->get_user($id);
		foreach($data['info'] as $data_item_userdata){
            $type = $data_item_userdata->type;
            $status = $data_item_userdata->status;
        } 

		if ($type=='student') {
			redirect('Pages/student_home_page/');
		}else if ($type=='admin') {
			redirect('Pages/admin_home_page/');
		}else if ($type=='teacher'){
			redirect('Pages/teacher_home_page/');
		}else if ($type=='staff'){
			redirect('Pages/staff_home_page/');
		}
	}

	public function Check_id(){
		$id 		= 	$_POST['id_num'];
		$count = $this->Accounts_model->check_id_num($id);
		echo $count;
	}

	public function register(){

		$random = uniqid();
		$fileNameNew;
		$type = 'student';
		$status = 'pending';
		if (isset($_POST['type'])) {
		$type = $_POST['type'];
		$status = 'active';
		}
		$id 		= 	$_POST['id_num'];
		$fname		= 	$_POST['fname'];
		$lname		= 	$_POST['lname'];
		$mname		= 	$_POST['mname'];
		$password 	= 	$_POST['password']; 
		$email 		= 	$_POST['email']; 
		$cnum 		= 	$_POST['cnum']; 
		$uname 		= 	$_POST['uname'];

		
        $_FILES['file']['name']     = $_FILES['file']['name'];
        $_FILES['file']['type']     = $_FILES['file']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['file']['tmp_name'];
        $_FILES['file']['error']     = $_FILES['file']['error'];
        $_FILES['file']['size']     = $_FILES['file']['size'];

        $ext = pathinfo($_FILES["file"]["name"])['extension'];
        $fileNameNew  = $random.'.'.$ext;
    
        $config['file_name'] = $fileNameNew;
        $config['upload_path']=  "./uploads/userImage";
        $config['allowed_types'] = "jpg|jpeg|png";

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('file')){
            if(is_file($config['upload_path'])){
                chmod($config['upload_path'], 777); 
            }
            $this->upload->data();

        $userdata = array(
            'fname' => $fname,
            'lname' => $lname,
            'mname' => $mname,
            'school_id' => $id,
            'email' => $email,
            'password' => $password,
            'status' => $status,
            'type' => $type,
            'contact' => $cnum,
            'username' => $uname,
            'profilepic' => $fileNameNew,
            'rfid' 		=> ''
        );

        $status = $this->Accounts_model->insertAccount($userdata);
        echo $status;

        }else{
            $data['error'] = array('error' => $this->upload->display_errors());
            echo $data['error']['error'];
        }  
	}

	public function login(){

		$uname 		= 	$_POST['uname'];
		$password 	= 	$_POST['password'];

		$exist = $this->Accounts_model->login($uname,$password);
		if ($exist) {
			$data['logged'] = $this->Accounts_model->login_get_user($uname,$password);
			foreach($data['logged'] as $data_item_userdata){
				$status				= 	$data_item_userdata->status;
				if ($status == 'active') {
					$uid 				= 	$data_item_userdata->id;
                	$_SESSION['fname'] 	= 	$data_item_userdata->fname;
                	$_SESSION['mname'] 	= 	$data_item_userdata->mname;
                	$_SESSION['lname'] 	= 	$data_item_userdata->lname;
                	$_SESSION['type'] 	= 	$data_item_userdata->type;
                	$_SESSION['uid'] 	= 	$data_item_userdata->id;
                	echo $uid;
				}else{
					echo 0;
				} 
            }
		}else{
			echo $exist;
		}
		
	}

	public function do_edit_account(){

		$id 		= 	$_POST['id_num'];
		$fname		= 	$_POST['fname'];
		$lname		= 	$_POST['lname'];
		$mname		= 	$_POST['mname'];
		$password 	= 	$_POST['password']; 
		$email 		= 	$_POST['email']; 
		$cnum 		= 	$_POST['cnum']; 
		$uname 		= 	$_POST['uname'];
		$file   	= 	$_POST['file'];

		$type   	= 	$_SESSION['type'];
		$uid 		= 	$_SESSION['uid'];

		$userdata = array(
            'fname' => $fname,
            'lname' => $lname,
            'mname' => $mname,
            'school_id' => $id,
            'email' => $email,
            'password' => $password,
            'status' => 'active',
            'type' => $type,
            'contact' => $cnum,
            'username' => $uname,
            'profilepic' => $file,
            'rfid' 		=> ''
        );

        $status = $this->Accounts_model->updateAccount($userdata,$uid);
        echo $status;
	}

	public function disable_account(){
		$id = $_POST['id'];
		$status = $this->Accounts_model->disableAccount($id);
        echo $status;
	}

	public function activate_account(){
		$id = $_POST['id'];
		$rfid = $_POST['rfid'];
		$status = $this->Accounts_model->activateAccount($id,$rfid);
        echo $status;
	}
}
