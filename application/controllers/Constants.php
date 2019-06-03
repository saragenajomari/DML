<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Constants extends CI_Controller {

	public function new_semester(){

		$reset_old_ui = $_POST['rpass'];
		$reset_new = $_POST['nrpass'];
		$semester = '';
		$data['constant'] =$this->Constants_model->get_constant();

		foreach ($data['constant'] as $data_constant) {

			$acadYr_start = $data_constant->acadYr;
			$acadYr_end = $data_constant->acadYr_end;
			$reset_old =  $data_constant->reset;

			if ($data_constant->semester == '1') {
				$semester = '2';
			}elseif ($data_constant->semester == '2') {
				$semester = '3';
			}elseif ($data_constant->semester == '3') {
				$semester = '1';
				$acadYr_start = $acadYr_end;
				$acadYr_end = date('Y',strtotime('+1 year'));
			}
		}

		if ($reset_old_ui == $reset_old) {
		$constantdata = array(
            'semester' => $semester,
            'acadYr' => $acadYr_start,
            'acadYr_end' => $acadYr_end,
            'reset'		=> $reset_new
        );
        $status = $this->Constants_model->insertConstant($constantdata);
		}else{
			$status = 0;
		}
		
        echo $status;
	}
}

?>