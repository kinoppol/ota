<?php

namespace App\Controllers;

class Admin extends BaseController
{
	public function systemSetting()
	{
		helper('user');
		$data=array(
			'title'=>'ตั้งค่าระบบ',
			'systemName'=>'ระบบฐานข้อมูลความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>'ตั้งค่าระบบ',
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
	public function userManage()
	{
		$userModel = model('App\Models\UserModel');
		$data=array(
			'title'=>'ผู้ใช้งานระบบ',
			'user_status'=>'registered',
			'users'=>$userModel->getUsers($onlyRegistered=true),
		);
		$data2=array(
			'title'=>'ผู้ใช้งานที่ยังไม่อนุมัติ',
			'user_status'=>'unregister',
			'registerData'=>$userModel->getRegister(),
			'users'=>$userModel->getUnregisterUsers(),
		);
		$data=array(
			'title'=>'จัดการผู้ใช้',
			'systemName'=>'ระบบฐานข้อมูลความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>view('listUser',$data).
			view('listUser',$data2),
			'notification'=>'',
			'task'=>'',
		);

		
		return view('_main',$data);
	}

	public function editUser($userId)
	{
		$userModel = model('App\Models\UserModel');
		$userData=$userModel->getUser($userId);


		$orgModel = model('App\Models\OrgModel');
		$schools=$orgModel->getSchool();
		$institute=$orgModel->getInstitute();

		$data=array(
			'userData'=>$userData,
			'schools'=>$schools,
			'institutes'=>$institute,
		);
		$data=array(
			'title'=>'แก้ไขผู้ใช้งาน',
			'mainMenu'=>view('_menu'),
			'content'=>view('editUser',$data),
			'notification'=>'',
			'task'=>'',
		);

		
		return view('_main',$data);
	}

	public function saveUser(){
		$user_id=$_POST['user_id'];
		$userModel = model('App\Models\UserModel');
		$userData=$userModel->getUser($user_id);
		$error=0;
		$message='';
		$data=array();
		foreach($userData as $k=>$v){
			$data[$k]=$v;
		}
		if($_POST['password']!=$_POST['confirm_password']){
			$error++;
			$message.='รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน';
		}

		if($_POST['password']!=''&&$_POST['password']==$_POST['confirm_password']){
			if(mb_strlen($_POST['password'])>=8){
				$data['password']=md5($_POST['password']);
			}else{
				$error++;
				$message.='รหัสผ่านจะต้องมีความยาวไม่น้อยกว่า 8 ตัวอักษร';
			}
		}
		
		if($error>0){

			$content=$message.'<br><button class="btn btn-primary" onclick="goBack()">กลับไปแก้ไข</button>

			<script>
			function goBack() {
			  window.history.back();
			}
			</script>
			';
			$data=array(
				'title'=>'บันทึกข้อมูลผู้ใช้งาน',
				'mainMenu'=>view('_menu'),
				'content'=>$content,
				'notification'=>'',
				'task'=>'',
			);
			return view('_main',$data);

		}
			$data['username']	=trim($_POST['username']);
			$data['name']		=trim($_POST['name']);
			$data['surname']	=trim($_POST['surname']);
			$data['email']		=trim($_POST['email']);
			$data['ref_number']		=trim($_POST['ref_number']);
			$data['user_active']=trim($_POST['user_active']);
			$data['user_type']	=trim($_POST['user_type']);
			$data['org_code']	=trim($_POST['org_code']);
		$result=$userModel->updateUser($userData->email,$data);
		$content='บันทึกข้อมูลสำเร็จ<br>โปรดรอสักครู่..<meta http-equiv="refresh" content="2;url='.site_url('public/admin/userManage').'">';
		$data=array(
			'title'=>'บันทึกข้อมูลผู้ใช้งาน',
			'mainMenu'=>view('_menu'),
			'content'=>$content,
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
		///return 'บันทึกข้อมูลสำเร็จ<br>โปรดรอสักครู่..<meta http-equiv="refresh" content="2;url='.site_url('public/admin/userManage').'">';
	}

	public function approveUser($user_id){
		$userModel = model('App\Models\UserModel');
		$userData=$userModel->getUser($user_id);
		$registerData=$userModel->getRegister($user_id);
		//print_r($registerData);
		$data=array(
			'user_type'=>$registerData[0]->user_type,
			'org_code'=>$registerData[0]->org_code,
		);
		$result=$userModel->updateUser($userData->email,$data);
		$data=array(
			'user_id'=>$registerData[0]->user_id,
			'user_type'=>$registerData[0]->user_type,
			'org_code'=>$registerData[0]->org_code,
			'register_status'=>'approved'
		);
		$userModel->register($data);
		return '<meta http-equiv="refresh" content="0;url='.site_url('public/admin/userManage').'">';
	}
	public function disapproveUser($user_id){
		$userModel = model('App\Models\UserModel');
		$registerData=$userModel->getRegister($user_id);
		$data=array(
			'user_id'=>$registerData[0]->user_id,
			'user_type'=>$registerData[0]->user_type,
			'org_code'=>$registerData[0]->org_code,
			'register_status'=>'disapproval'
		);
		$userModel->register($data);
		return '<meta http-equiv="refresh" content="0;url='.site_url('public/admin/userManage').'">';
	}
	public function deleteUser($user_id){
		$userModel = model('App\Models\UserModel');
		$result=$userModel->deleteUser($user_id);

		$data=array(
			'title'=>'ลบข้อมูลผู้ใช้',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลผู้ใช้สำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/admin/userManage').'">':'ลบข้อมูลผู้ใช้ไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
	}
}

