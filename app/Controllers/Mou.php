<?php

namespace App\Controllers;

class Mou extends BaseController
{
	public function list($year='')
	{
		helper('user');
		if($year=='')$year=date('Y');
		$mouModel = model('App\Models\MouModel');
		$data=array(
			'data'=>$mouModel->getMou(['year'=>$year,'school_id'=>current_user('org_code')]),
			'year'=>$year,
		);
		$data=array(
			'title'=>'รายการความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>view('listMou',$data),
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
	public function search()
	{
	
		$data=array(
			'title'=>'ค้นหาข้อมูลความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
	public function add($business_id='')
	{
		$businessModel = model('App\Models\BusinessModel');
		$locationModel = model('App\Models\LocationModel');
		$data=array(
			'business_data'=>$businessModel->getBusiness($business_id),
			'province'=>$locationModel->getProvince(),
			'district'=>$locationModel->getDistrict(),
			'subdistrict'=>$locationModel->getSubdistrict(),
		);
		$data=array(
			'title'=>'เพิ่มข้อมูล MOU',
			'mainMenu'=>view('_menu'),			
			'content'=>view('detailMou',$data),
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
	public function edit($mou_id='')
	{
		$businessModel = model('App\Models\BusinessModel');
		$locationModel = model('App\Models\LocationModel');
		$mouModel = model('App\Models\MouModel');
		$mou_data=$mouModel->getMou(['mou_id'=>$mou_id]);
		//print_r($mou_data['mou']);
		$data=array(
			'mou_data'=>$mou_data['mou'][0],
			'business_data'=>$businessModel->getBusiness($mou_data['mou'][0]->business_id),
			'province'=>$locationModel->getProvince(),
			'district'=>$locationModel->getDistrict(),
			'subdistrict'=>$locationModel->getSubdistrict(),
		);
		$data=array(
			'title'=>'แก้ไขข้อมูล MOU',
			'mainMenu'=>view('_menu'),			
			'content'=>view('detailMou',$data),
			'notification'=>'',
			'task'=>'',
		);
		return view('_main',$data);
	}
	public function save(){
		//print_r($_POST);
		helper('image');
		$businessModel = model('App\Models\MouModel');
		$mouModel = model('App\Models\MouModel');
		$data=array(
			'business_id'	=>$_POST['business_id'],
			'school_id'		=>$_POST['org_id'],
			'level'			=>$_POST['level'],
			'investment'	=>$_POST['investment'],
			'educationalSupport'=>(isset($_POST['educationalSupport'])?'Y':'N'),
			'personalSupport'=>(isset($_POST['personalSupport'])?'Y':'N'),
			'executiveSupport'=>(isset($_POST['executiveSupport'])?'Y':'N'),
			'support_vc_edu'=>(isset($_POST['support_vc_edu'])?'Y':'N'),
			'support_hvc_edu'=>(isset($_POST['support_hvc_edu'])?'Y':'N'),
			'support_btech_edu'=>(isset($_POST['support_btech_edu'])?'Y':'N'),
			'support_short_course'=>(isset($_POST['support_short_course'])?'Y':'N'),
			'support_no_specific'=>(isset($_POST['support_no_specific'])?'Y':'N'),
			'support_normal'=>(isset($_POST['support_normal'])?'Y':'N'),
			'support_dve'	=>(isset($_POST['support_dve'])?'Y':'N'),
			'support_local_training'=>(isset($_POST['support_local_training'])?'Y':'N'),
			'support_oversea_training'=>(isset($_POST['support_oversea_training'])?'Y':'N'),
			'director_name'	=>$_POST['govSignName'],
			'director_type'	=>$_POST['govSignNamePosition'],
			'ceo_name'		=>$_POST['businessSignName'],
			'ceo_type'		=>$_POST['businessSignNamePosition'],
			'mou_date'		=>$_POST['mou_date'],
			'mou_start_date'=>$_POST['mou_start_date'],
			'mou_end_date'	=>$_POST['mou_end_date'],
			'mou_sign_place'=>$_POST['mou_sign_place'],
			'major'			=>$_POST['major'],
			'object'		=>$_POST['object'],
			'dve_target'	=>isset($_POST['dve_target'])?$_POST['dve_target']:0,
			'wage'			=>$_POST['wage'],
			'benefits'		=>$_POST['benefits'],
			'obligation'	=>$_POST['obligation'],
		);
		

		if(isset($_POST['mou_id'])&&$_POST['mou_id']!=''){
			$mouData=$mouModel->getMouData($_POST['mou_id']);
			$result=$businessModel->updateMou($_POST['mou_id'],$data);
		}else $result=$businessModel->addMou($data);
		//print_r($_FILES);
		if($_FILES['mou_file']['type']=='application/pdf'){
			$mouFilePath=FCPATH.'../docs/mou/';
			$pdf_file=$result.'.pdf';
			$mouFile=$mouFilePath.$pdf_file;
			move_uploaded_file($_FILES['mou_file']['tmp_name'],$mouFile);
			$data=array(
				'mou_file'=>$pdf_file,
			);
			$businessModel->updateMou($result,$data);
			//print "UPLOAD";
		}
		$path=FCPATH.'../images/mou/';
            $pictures=uploadPic('mou_picture',$path);
			if(count($pictures)>0){
            	$data['mou_picture']=(isset($mouData->mou_picture)&&$mouData->mou_picture!=''?$mouData->mou_picture.',':'').implode(',',$pictures);
				$businessModel->updateMou($result,$data);
			}

		$data=array(
			'title'=>'บันทึกข้อมูลการลงนามความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/list').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	}
	public function pdf($id)
	{		
		error_reporting(0);
		helper('mpdf');
		$mouModel = model('App\Models\MouModel');
		$mou_data=$mouModel->getMou(['mou_id'=>$id]);
		//print_r($mou_data['mou'][0]);
		$data=array(
			'id'=>$id,
		);
		$html='<div align="center"><b>บันทึกข้อตกลงความร่วมมือ</b></div>';
		$html.='<div align="center"><b>ระหว่าง</b></div>';
		$html.='<div align="center"><b>สำนักงานคณะกรรมการการอาชีวศึกษา โดย '.$mou_data['school'][$mou_data['mou'][0]->school_id].'</b></div>';
		$html.='<div align="center"><b>'.$mou_data['business'][$mou_data['mou'][0]->business_id].'</b></div>';
		$html.='<div align="center">******************************************************</div>';
		$html.='<div align="left"><b>บันทึกข้อตกลงนี้ทำขึ้นระหว่าง</b></div>';
		$pdf_data=array(
			'html'=>$html,
			'size'=>"A4",
			'fontsize'=>16,
			'marginL'=>20,
			'marginR'=>10,
			'marginT'=>10,
			'marginB'=>10,
			'header'=>'',
			'wartermark'=>'',
			'wartermarkimage'=>'',
			'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' สำนักความร่วมมือ สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
			//'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
		);
		//print $html;
		$location=FCPATH.'/pdf/';
		$fname=$id.'.pdf';
		$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
		//return '';
		return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'">';
	}

	public function searchBusiness()
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
			'title'=>'ค้นหาสถานประกอบการที่ทำ MOU',
			'mainMenu'=>view('_menu'),
            'content'=>view('listBusiness',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function curriculumDev(){
		
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$curriculum=$mouModel->curriculumGet(['school_id'=>current_user('org_code')]);
		$data=array(
			'curriculum'=>$curriculum,
		);

		$data=array(
			'title'=>'หลักสูตรที่ร่วมกับสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>view('curriculumList',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	public function curriculumAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$curriculumData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$curriculumData,
		);
		$data=array(
			'title'=>'ข้อมูลหลักสูตร',
			'mainMenu'=>view('_menu'),
            'content'=>view('curriculumDetail',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	public function curriculumDetail($id){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$curriculumData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$curriculumData=$mouModel->curriculumGet(['id'=>$id]);
		$data=array(
			'mouData'=>$curriculumData,
			'curriculumData'=>$curriculumData['curriculum'][0],
		);
		$data=array(
			'title'=>'ข้อมูลหลักสูตร',
			'mainMenu'=>view('_menu'),
            'content'=>view('curriculumDetail',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	public function curriculumSave(){
		//print_r($_POST);

		$data=array(
			'business_id'		=>$_POST['business_id'],
			'school_id'			=>$_POST['school_id'],
			'curriculum_name'	=>$_POST['curriculum_name'],
			'curriculum_type'	=>$_POST['curriculum_type'],
			'curriculum_year'	=>$_POST['curriculum_year'],
			'skill_gap'			=>$_POST['skill_gap'],
			'skill_01'			=>isset($_POST['skill_01'])?$_POST['skill_01']:'N',
			'skill_02'			=>isset($_POST['skill_02'])?$_POST['skill_02']:'N',
			'skill_03'			=>isset($_POST['skill_03'])?$_POST['skill_03']:'N',
			'skill_04'			=>isset($_POST['skill_04'])?$_POST['skill_04']:'N',
			'skill_05'			=>isset($_POST['skill_05'])?$_POST['skill_05']:'N',
			'skill_06'			=>isset($_POST['skill_06'])?$_POST['skill_06']:'N',
			'skill_07'			=>isset($_POST['skill_07'])?$_POST['skill_07']:'N',
			'skill_08'			=>isset($_POST['skill_08'])?$_POST['skill_08']:'N',
			'skill_09'			=>isset($_POST['skill_09'])?$_POST['skill_09']:'N',
			'skill_10'			=>isset($_POST['skill_10'])?$_POST['skill_10']:'N',
			'support_vc_edu'	=>isset($_POST['support_edu'])&&$_POST['support_edu']=='support_vc_edu'?'Y':'N',
			'support_hvc_edu'	=>isset($_POST['support_edu'])&&$_POST['support_edu']=='support_hvc_edu'?'Y':'N',
			'support_btech_edu'	=>isset($_POST['support_edu'])&&$_POST['support_edu']=='support_btech_edu'?'Y':'N',
			'support_short_course'=>isset($_POST['support_edu'])&&$_POST['support_edu']=='support_short_course'?'Y':'N',
			'support_no_specific'=>isset($_POST['support_edu'])&&$_POST['support_edu']=='support_no_specific'?'Y':'N',
			'curriculum_hour'	=>$_POST['curriculum_hour'],
			'curriculum_target'	=>$_POST['curriculum_target'],
			'business_action'	=>$_POST['business_action'],
			'training_amount'	=>$_POST['training_amount'],
		);
		
		$mouModel = model('App\Models\MouModel');
		 
		if(!isset($_POST['id'])){
			$result=$mouModel->curriculumAdd($data);
		}else{
			$result=$mouModel->curriculumUpdate($_POST['id'],$data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลหลักสูตร',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/curriculumDev').'">':'บันทึกข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 

	public function curriculumDelete($id){

		$mouModel = model('App\Models\MouModel');
		 
			$result=$mouModel->curriculumDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลหลักสูตร',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/curriculumDev').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 

	
	public function result(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$result=$mouModel->resultGet(['school_id'=>current_user('org_code')]);
		$data=array(
			'result'=>$result,
		);
		$data=array(
			'title'=>'ผลสัมฤทธิ์ของความร่วมมือ',
			'mainMenu'=>view('_menu'),
            'content'=>view('mouResultList',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	public function resultAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		//$curriculumData=$mouModel->curriculumGet(['id'=>$id]);
		$data=array(
			'mouData'=>$resultData,
			//'curriculumData'=>$curriculumData['curriculum'][0],
		);

		$data=array(
			'title'=>'เพิ่มข้อมูลผลสัมฤทธิ์ของความร่วมมือ',
			'mainMenu'=>view('_menu'),
            'content'=>view('resultDetail',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	public function resultDetail($id){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$resultData=$mouModel->resultGet(['id'=>$id]);
		$data=array(
			'mouData'=>$resultData,
			'resultData'=>$resultData['result'][0],
		);

		$data=array(
			'title'=>'แก้ไขข้อมูลผลสัมฤทธิ์ของความร่วมมือ',
			'mainMenu'=>view('_menu'),
            'content'=>view('resultDetail',$data),
			'notification'=>'',
			'task'=>'',
		);       
		return view('_main',$data);
	}

	
	public function resultSave(){
		helper('user');
		helper('user');
		$mouModel = model('App\Models\MouModel');
		
		foreach($_POST as $k=>$v){
			$data[$k]=$v;
		}
		/*
		$data=array(
			'business_id'=>$_POST['business_id'],
			'school_id'=>$_POST['school_id'],
			'result_year'=>$_POST['result_year'],
			'trainee_majors'=>$_POST['trainee_majors'],
			'trainee_amount'=>$_POST['trainee_amount'],
			'employee_majors'=>$_POST['employee_majors'],
			'employee_amount'=>$_POST['employee_amount'],
			'donate_detail'=>$_POST['donate_detail'],
			'donate_value'=>$_POST['donate_value'],
			'donate_other'=>$_POST['donate_other'],
		);*/

		if(!isset($_POST['id'])||$_POST['id']==''){
			$result=$mouModel->resultAdd($data);
		}else{
			$result=$mouModel->resultUpdate($_POST['id'],$data);
		}

		//print_r($_POST);


		$data=array(
			'title'=>'บันทึกข้อมูลผลสัมฤทธิ์',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/result').'">':'บันทึกข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
	}

	public function resultDelete($id){

		$mouModel = model('App\Models\MouModel');
		 
			$result=$mouModel->resultDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลผลสัมฤทธิ์',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/result').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 
	public function viewMOU($id){		
		$mouModel = model('App\Models\MouModel');
		$mou=$mouModel->getMouData($id);
		$pdfUrl=site_url('/docs/mou/'.$mou->mou_file);
		$data=array(
			'title'=>'หนังสือการลงนามความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>$mou->mou_file==''?'ขออภัยไม่พบไฟล์ที่ระบุ':'<iframe id="iframepdf" src="'.$pdfUrl.'" width="100%" height="600"></iframe>',
		  'notification'=>'',
		  'task'=>'',
		);
		return view('_main',$data);
	}
	public function viewPicture($id){
		helper('thai');
		$mouModel = model('App\Models\MouModel');
		$mou=$mouModel->getMouData($id);
		$pics=$mou->mou_picture;
		$pics=explode(',',$pics);
		$pictures=array();
		foreach($pics as $pic){
			if($pic=='')continue;
			$pictures[]['url']=site_url('/images/mou/'.$pic);
		}
		$data=array(
			'galleryName'=>'ภาพการลงนามความร่วมมือ วันที่ '.dateThai($mou->mou_date,true,false,true),
			'pictures'=>$pictures,
			'deleteLink'=>site_url('public/mou/delMouPicture/'.$id.'/'),
		);
		$data=array(
			'title'=>'ภาพการลงนามความร่วมมือ',
			'mainMenu'=>view('_menu'),
			'content'=>view('gallery',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);
	}
	public function delete($id){

		$mouModel = model('App\Models\MouModel');
		$mouData = $mouModel->getMouData($id);
			$result=$mouModel->deleteMou(['id'=>$id]);

		$pics=explode(',',$mouData->mou_picture);
		foreach($pics as $pic){
			if($pic=='')continue;
		chdir(FCPATH);
        $picPath=realpath('../images/mou').'/'.$pic;
			if(file_exists($picPath)){
				unlink($picPath);
			}
		}
		$mou_file=$mouData->mou_file;
		chdir(FCPATH);
        $mouPath=realpath('../docs/mou').'/'.$mou_file;
			if(file_exists($mouPath)){
				unlink($mouPath);
			}
		$data=array(
			'title'=>'ลบข้อมูลการลงนามความร่วมมือ',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/list').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 

	public function delMouPicture($mou_id,$pictureName){
		$mouModel = model('App\Models\MouModel');
		$mou=$mouModel->getMouData($mou_id);
		$pics=$mou->mou_picture;
		$pics=explode(',',$pics);
		
        chdir(FCPATH);
        $picPath=realpath('../images/mou').'/'.$pictureName;
        //print $picPath;
        if(file_exists($picPath)){
            unlink($picPath);
        }
        unset($pics[(array_search($pictureName,$pics))]);

        $data=array(
            'mou_picture'=>implode(',',$pics),
        );
        
        $result=$mouModel->updateMou($mou_id,$data);

		$data=array(
			'title'=>'ลบรูป',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบรูปภาพสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mou/viewPicture/'.$mou_id).'">':'ลบรูปภาพไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
    }
}
