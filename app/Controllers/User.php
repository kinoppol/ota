<?php

namespace App\Controllers;

class User extends BaseController
{
	public function login($userType=false)
	{
        
        $data=array(
			'title'=>'เข้าสู่ระบบ',
			'userType'=>$userType,
			'systemName'=>SYSTEMNAME,
		);
		$data=array(
            //'content'=>view('login',$data)
			'content'=>view('ggLogin',$data)
        );
        return view('_authen',$data);
	}
	public function loginSelector()
	{
        
        $data=array(
			'title'=>'เข้าสู่ระบบ',
			'systemName'=>SYSTEMNAME,
		);
		$data=array(
            //'content'=>view('login',$data)
			'content'=>view('loginSelector',$data)
        );
        return view('_authen',$data);
	}
	public function forgetPassword()
	{
        
        $data=array(
			'title'=>'เข้าสู่ระบบ',
			'systemName'=>SYSTEMNAME,
			'onlyMail'=>true,
		);
		$data=array(
            //'content'=>view('login',$data)
			'content'=>view('ggLogin',$data)
        );
        return view('_authen',$data);
	}
	public function registerNewUser()
	{
        
        $data=array(
			'title'=>'ลงทะเบียนสมาชิกใหม่',
			'systemName'=>SYSTEMNAME,
		);
		$data=array(
            //'content'=>view('login',$data)
			'content'=>view('registerNewUser',$data)
        );
        return view('_authen',$data);
	}
	public function checkGoogle(){
		$userModel = model('App\Models\UserModel');
		helper('google');
		$result=checkToken($_POST);
		if($result['status']=='ok'){
			$user=$userModel->checkEmail($result['data']['email']);
			
			$loginTime=time()+36000;
			if(count($user)>=1){
				$uUpdate=$userModel->updateUser($result['data']['email'],array('last_login'=>date('Y-m-d H:i:s')));
				$url=$result['data']['picture'];
				$handle = curl_init($url);
				curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
				$response = curl_exec($handle);
				$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
				if($httpCode == 200) {
					/* Handle 200 here. */
					$img_path="images/user/".$result['data']['email'].".jpg";
					$user_image=fopen(APPPATH.'../'.$img_path,"w");
					fwrite($user_image,$response);
					fclose($user_image);


						$data=array(//ถ้ามีข้อมูลอยู่แล้วไม่อัพเดตอะไรยกเว้นรูปภาพ
							//'name'=>$result['data']['given_name'],
							//'surname'=>$result['data']['family_name'],
							'picture'=>$img_path,
						);
						$userModel->updateUser($result['data']['email'],$data);
				}

				curl_close($handle);
			}else{
				$data=array(
				'username'=>$result['data']['email'],
				'email'=>$result['data']['email'],
				'name'=>$result['data']['given_name'],
				'surname'=>$result['data']['family_name'],
				'password'=>md5(time()),
				'picture'=>$result['data']['picture'],
			);				
				$userModel->addUser($data);
			}
			$user=$userModel->checkEmail($result['data']['email']);
			setcookie("current_user", serialize($user), $loginTime,'/');
		}
		return json_encode($result);
	}

	public function register(){
		helper('user');

		
		$userModel = model('App\Models\UserModel');
		//print_r($_POST);
		if(isset($_POST['user_type'])&&$_POST['user_type']!=''&&$_POST['org_code']!=''){
			$data=array(
				'user_id'=>current_user('user_id'),
				'user_type'=>$_POST['user_type'],
				'org_code'=>$_POST['org_code'],
			);
			$result=$userModel->register($data);
			//print "REGISTER";
			$data=array(
				'name'=>$_POST['name'],
				'surname'=>$_POST['surname'],
				'position'=>$_POST['position'],
				'email'=>$_POST['email'],
				'tel'=>$_POST['tel'],
			);
			$result=$userModel->updateUser(current_user('email'),$data);
		}

		$orgModel = model('App\Models\OrgModel');

		$schools=$orgModel->getSchool();
		$institute=$orgModel->getInstitute();

		$registerData=$userModel->getRegister(current_user('user_id'));
		//print "XXX".current_user('user_id');
		$data=array(
			'registerData'=>$registerData[0],
			'schools'=>$schools,
			'institutes'=>$institute,
		);
		$data=array(
			'title'=>'ลงทะเบียนผู้ใช้งาน',
			'systemName'=>'ระบบฐานข้อมูลความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>view('register',$data),
		);
        return view('_main',$data);
	}

	public function checkLogin(){
		$userModel = model('App\Models\UserModel');
        $data=array(
			'username'=>$_POST['username'],
			'password'=>md5($_POST['password']),
			'user_active'=>'Y'
		);
		$loginTime=time()+3600;// ล็อกอิน 1 ชั่วโมง
		if(isset($_POST['rememberme'])&&$_POST['rememberme']=='yes')$loginTime=time()+3600*365;//ล็อกอิน 1 ปี
		$result=$userModel->checkUser($data);
		if($result){
			$uUpdate=$userModel->updateUser($result['data']['email'],array('last_login'=>date('Y-m-d H:i:s')));
			setcookie("current_user", serialize($result), $loginTime,'/');
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/home/dashboard').'">';
		}else{
			$_SESSION['message']="ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/user/login').'">';
		}
	}

	public function checkSignUp(){
		if($_POST['password']!=$_POST['confirmPassword']){
			$_SESSION['message']="รหัสผ่านไม่ตรงกัน";
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/user/registerNewUser').'">';
		}
		$userModel = model('App\Models\UserModel');
        $data=array(
			'username'=>$_POST['username']
		);
		$data2=array(
			'email'=>$_POST['email']
		);
		$result=$userModel->checkUser($data);
		$result2=$userModel->checkUser($data2);
		if($result){
			$_SESSION['message']="ชื่อผู้ใช้ <b>".$_POST['username']."</a> มีอยู่ในระบบแล้วโปรดเปลี่ยนชื่อผู้ใช้";
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/user/registerNewUser').'">';
		}else if($result2){
			$_SESSION['message']="อีเมล <b>".$_POST['email']."</a> มีอยู่ในระบบแล้วโปรดเปลี่ยนอีเมล";
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/user/registerNewUser').'">';
		}{
			$data=array(
				'username'	=>$_POST['username'],
				'name'		=>$_POST['name'],
				'surname'	=>$_POST['surname'],
				'email'		=>$_POST['email'],
				'password'	=>md5($_POST['password']),
				);				
			$userModel->addUser($data);
			$_SESSION['message']="การสมัครสมาชิกสำเร็จโปรดเข้าสู่ระบบเพื่อดำเนินการต่อ";
			return 'การสมัครสมาชิกสำเร็จกรุณารอสักครู่..<meta http-equiv="refresh" content="3;url='.site_url('public/user/loginSelector').'">';
		}
	}
	public function logout(){
			setcookie("current_user", "", time() - 3600,'/');
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/user/loginSelector').'">';
	}
}
