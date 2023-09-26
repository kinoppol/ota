<?php

namespace App\Controllers;

class institute extends BaseController
{
    public function detail(){
		helper('user');
        $schoolModel = model('App\Models\SchoolModel');
        $instituteModel = model('App\Models\InstituteModel');

		$school_id=$instituteModel->getSchool(current_user('org_code'));
		$insitute_data=$instituteModel->getInstituteData(current_user('org_code'));

		$sumStudentCount=$schoolModel->getSumStudent($school_id,false);
		$sumStudentDVECount=$schoolModel->getSumStudent($school_id,'dve');

		foreach($school_id as $school){
			$student_school[$school]=$schoolModel->getSumStudent($school,false);
		}

		$data=array(
			'institute_data'=>$insitute_data,
		);
		$data=array(
			'student_school'=>$student_school,
			'in_school_id'=>$school_id,
			'institute_data'=>$insitute_data,
			'totalStudent'=>$sumStudentCount->count_val,
			'totalDVEStudent'=>$sumStudentDVECount->count_dve_val,
			'editForm'=>view('editInstitute',$data),
		);

		$data=array(
			'title'=>'ข้อมูลพื้นฐานสถาบันการอาชีวศึกษา',
			'mainMenu'=>view('_menu'),
            'content'=>view('instituteDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        
        return view('_main',$data);
    }

	public function saveInstitute(){
        $instituteModel = model('App\Models\InstituteModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		$result=$instituteModel->instituteUpdate($data['institute_id'],$data);


		$data=array(
			'title'=>'บันทึกข้อมูลสถาบัยการอาชีวศึกษา',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/institute/detail').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	}
}