<?php

namespace App\Controllers;

class Business extends BaseController
{
	public function list()
	{
        helper('system');
		$businessModel = model('App\Models\BusinessModel');
		$locationModel = model('App\Models\LocationModel');
        $province_id='10';
        if(isset($_POST['province_id']))$province_id=$_POST['province_id'];
        if(isset($_POST['q'])&&$_POST['q']!=''){
            $data=array(            
                'province'=>$locationModel->getProvince(),
                'district'=>$locationModel->getDistrict(),
                'subdistrict'=>$locationModel->getSubdistrict(),
                'business'=>$businessModel->searchBusiness(['province_id'=>$province_id,'q'=>$_POST['q']]),
            );
        }else{
            $data=array(            
                'province'=>$locationModel->getProvince(),
                'district'=>$locationModel->getDistrict(),
                'subdistrict'=>$locationModel->getSubdistrict(),
                'business'=>$businessModel->searchBusiness(['province_id'=>$province_id]),
            );
        }
		$data=array(
			'title'=>'รายชื่อสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>view('listBusiness',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
    public function add(){
		$orgModel = model('App\Models\OrgModel');
        $province = $orgModel->getProvince();
        $data=array(
            'province'=>$province,
        );
		$data=array(
			'title'=>'เพิ่มข้อมูลสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>view('businessDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
    }
    public function districtInProvince($province_id){
		$orgModel = model('App\Models\OrgModel');
        $data = $orgModel->getDistrict($province_id);
        return json_encode($data);
    }

    public function subdistrictInDistrict($district_id){
		$orgModel = model('App\Models\OrgModel');
        $data = $orgModel->getSubDistrict($district_id);
        return json_encode($data);
    }

    public function saveBusiness(){
        helper('user');
        helper('image');
		$businessModel = model('App\Models\BusinessModel');
        $data=array();
        foreach($_POST as $k=>$v){
            $data[$k]=$v;
        }
        //print_r($_FILES);
        if(isset($_FILES['picture'])){
            $path=FCPATH.'../images/business/';
            $picture=uploadPic('picture',$path);
            $data['picture']=implode(',',$picture);
        }
        $data['school_id']=current_user('org_code');
        if(isset($_POST['business_id'])&&$_POST['business_id']!=''){
            $businessData=$businessModel->getBusiness($_POST['business_id']);
            if(isset($data['picture'])){
                $data['picture']=$businessData->picture!=''?$businessData->picture.=','.$data['picture']:$data['picture'];
            }
            $result=$businessModel->businessUpdate($_POST['business_id'],$data);
        }else{
            $result=$businessModel->businessAdd($data);
        }
        
		$data=array(
			'title'=>'บันทึกข้อมูลสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/business/list').'">':'บันทึกข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
    }

    public function detail($id){
		$businessModel = model('App\Models\BusinessModel');
        $businessData=$businessModel->getBusiness($id);
		$orgModel = model('App\Models\OrgModel');
        $province = $orgModel->getProvince();

		$locationModel = model('App\Models\LocationModel');
        $district = $locationModel->getDistrict();
        $subdistrict = $locationModel->getSubdistrict();
        $data=array(
            'businessData'=>$businessData,
            'province'=>$province,
            'district'=>$district,
            'subdistrict'=>$subdistrict,
        );
		$data=array(
			'title'=>'ข้อมูลสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>view('businessDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
    }

    public function picture($id){
		$businessModel = model('App\Models\BusinessModel');
        $businessData=$businessModel->getBusiness($id);
		$pics=$businessData->picture;
		$pics=explode(',',$pics);
		$pictures=array();
		foreach($pics as $pic){
            if($pic=='')continue;
			$pictures[]['url']=site_url('images/business/'.$pic);
		}
		$data=array(
			'galleryName'=>$businessData->business_name,
			'pictures'=>$pictures,
            'deleteLink'=>site_url('public/business/delPicture/'.$id.'/'),
		);
		$data=array(
			'title'=>'ภาพสถานประกอบการ',
			'mainMenu'=>view('_menu'),
			'content'=>view('gallery',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);
	}

    public function check_duplicate(){
        return json_encode(array(
            'percent'=>80,
        ));
    }

    public function delPicture($business_id,$pictureName){
		$businessModel = model('App\Models\BusinessModel');
        $businessData=$businessModel->getBusiness($business_id);
		$pics=$businessData->picture;
		$pics=explode(',',$pics);
		
        chdir(FCPATH);
        $picPath=realpath('../images/business').'/'.$pictureName;
        //print $picPath;
        if(file_exists($picPath)){
            unlink($picPath);
        }
        unset($pics[(array_search($pictureName,$pics))]);

        $data=array(
            'picture'=>implode(',',$pics),
        );
        
        $result=$businessModel->businessUpdate($business_id,$data);

		$data=array(
			'title'=>'ลบรูป',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบรูปภาพสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/business/picture/'.$business_id).'">':'ลบรูปภาพไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
    }
}