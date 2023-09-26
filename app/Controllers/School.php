<?php

namespace App\Controllers;

class School extends BaseController
{
	public function detail()
	{
		helper('user');
		$orgModel = model('App\Models\OrgModel');
		$schoolModel = model('App\Models\SchoolModel');
		$locationModel = model('App\Models\LocationModel');

		$province=$locationModel->getProvince();
		$district=$locationModel->getDistrict();
		$subdistrict=$locationModel->getSubdistrict();
		$schoolData=$orgModel->schoolData(current_user('org_code'));

		$sumStudentCount=$schoolModel->getSumStudent(current_user('org_code'));
		$sumStudentDVECount=$schoolModel->getSumStudent(current_user('org_code'),'dve');
		//print_r($sumStudentCount);
			$datas=array(
				'provinceData'=>$province,
				'districtData'=>$district,
				'subdistrictData'=>$subdistrict,
				'schoolData'=>$schoolData,
				'totalStudent'=>$sumStudentCount->count_val,
				'totalDVEStudent'=>$sumStudentDVECount->count_dve_val,
			);

		$data=array(
			'province'=>$province,
			'district'=>$district,
			'subdistrict'=>$subdistrict,
			'schoolData'=>$schoolData,
			'editForm'=>view('editSchool',$datas),
		);
        $data=array(
			'title'=>'ข้อมูลสถานศึกษา',
			'systemName'=>'ระบบฐานข้อมูลความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>view('schoolDetail',$data),
		);
        return view('_main',$data);
    }
	public function saveSchool(){

		$orgModel = model('App\Models\OrgModel');

		$data=array();
		foreach($_POST as $k=>$v){
			$data[$k]=$v;
		}
		//	return print_r($data);
		$result=$orgModel->updateSchool($data['school_id'],$data);
		return 'บันทึกข้อมูลสำเร็จ<br>โปรดรอสักครู่..<meta http-equiv="refresh" content="1;url='.site_url('public/school/detail').'">';
	}
}