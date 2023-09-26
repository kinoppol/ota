<?php

namespace App\Controllers;

class Boc extends BaseController
{
	public function detail()
	{
		helper('user');
		$orgModel = model('App\Models\OrgModel');
		$schoolModel = model('App\Models\SchoolModel');
		$bocModel = model('App\Models\BocModel');
		$locationModel = model('App\Models\LocationModel');

		$province=$locationModel->getProvince();
		$district=$locationModel->getDistrict();
		$subdistrict=$locationModel->getSubdistrict();
		$bocData=$bocModel->bocData();

		$sumStudentCount=$schoolModel->getSumStudent(false);
		$sumStudentDVECount=$schoolModel->getSumStudent(false,'dve');
		//print_r($sumStudentCount);
			$datas=array(
				'provinceData'=>$province,
				'districtData'=>$district,
				'subdistrictData'=>$subdistrict,
				'bocData'=>$bocData,
				'totalStudent'=>$sumStudentCount->count_val,
				'totalDVEStudent'=>$sumStudentDVECount->count_dve_val,
			);

		$data=array(
			'province'=>$province,
			'district'=>$district,
			'subdistrict'=>$subdistrict,
			'bocData'=>$bocData,
			'editForm'=>view('editBoc',$datas),
		);
        $data=array(
			'title'=>'ข้อมูลสำนักความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>view('bocDetail',$data),
		);
        return view('_main',$data);
    }
	public function saveBoc(){

		$bocModel = model('App\Models\BocModel');

		$data=array();
		foreach($_POST as $k=>$v){
			$data[$k]=$v;
		}
		//	return print_r($data);
		$result=$bocModel->bocUpdate($data['org_id'],$data);
		return 'บันทึกข้อมูลสำเร็จ<br>โปรดรอสักครู่..<meta http-equiv="refresh" content="1;url='.site_url('public/boc/detail').'">';
	}
    
}