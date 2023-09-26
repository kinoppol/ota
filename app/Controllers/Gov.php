<?php

namespace App\Controllers;

class Gov extends BaseController
{
	public function meettingRecord()
	{
		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'meettingData'=>$govModel->getMeetting(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'รายงานการประชุม',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_meetingRecode',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function meettingAdd()
	{
		helper('user');
        
		$govModel = model('App\Models\GovModel');
        /*$data=array(
            'meettingData'=>$govModel->getMeetting(current_user('org_code')),
        );*/
		$data=array(
			'title'=>'รายงานการประชุม',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_meettingDetail'),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function meettingDetail($id)
	{
		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'meettingData'=>$govModel->getMeettingData($id),
        );
		$data=array(
			'title'=>'รายงานการประชุม',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_meettingDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function detail()
	{
		helper('user');
		$govModel = model('App\Models\GovModel');

		$orgModel = model('App\Models\OrgModel');
		$schools=$orgModel->getSchool();

		$govData=$govModel->getGovData(current_user('org_code'));
		$gov_school_id=explode(',',$govData->gov_school_id);
		
		$schoolModel = model('App\Models\SchoolModel');

		$data=array(
			'minor_code'=>isset($govData->gov_minor)?explode(',',$govData->gov_minor):array(),
		);
		$sumStudentCount=$schoolModel->getSumStudent($gov_school_id,false,$data);
		//print $sumStudentCount->count_val;
		$sumStudentDVECount=$schoolModel->getSumStudent($gov_school_id,'dve',$data);

		$minorModel = model('App\Models\MinorModel');
		$minors=$minorModel->getMinor();

		$student_school=array();
		foreach($gov_school_id as $school_id){
			$student_school[$school_id]=$schoolModel->getSumStudent($school_id,false,$data);
		}

		$data=array(
			'govData'=>$govData,
			'schools'=>$schools,
			'minors'=>$minors,
		);

		$data=array(
			'govData'=>$govData,
			'totalStudent'=>$sumStudentCount->count_val,
			'totalDVEStudent'=>$sumStudentDVECount->count_dve_val,
			'student_school'=>$student_school,
			'editForm'=>view('editGov',$data),
		);
        $data=array(
			'title'=>'ข้อมูลพื้นฐาน อ.กรอ.อศ.',
			'mainMenu'=>view('_menu'),
            'content'=>'ข้อมูล อ.กรอ.อศ.',
			'notification'=>'',
			'task'=>'',
			'content'=>view('govDetail',$data),
		);
		return view('_main',$data);
	}
    public function saveGov(){

		$orgModel = model('App\Models\OrgModel');
		$data=array();
		//print_r($_POST);
		foreach($_POST as $k=>$v){
			if($k=='gov_school_id'){
				$data[$k]=implode(',',$v);
			}else if($k=='gov_minor'){
				$data[$k]=implode(',',$v);				
			}else{
				$data[$k]=$v;
			}
		}
		//print_r($data);
		$result=$orgModel->updateGov($data['gov_id'],$data);
		$data=array(
			'title'=>'บันทึกข้อมูล อ.กรอ.อศ.',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/detail').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	}
	public function saveMeetting(){

        helper('image');
		$govModel = model('App\Models\GovModel');

		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		helper('user');
		$data['recorder_id']=current_user('user_id');
		$data['gov_id']=current_user('org_code');
		$data['record_time']=date('y-m-d H:i:s');

		if(!isset($_POST['id'])||$_POST['id']==''){
			$mid=$result=$govModel->meettingAdd($data);
		}else{
			$result=$govModel->meettingUpdate($_POST['id'],$data);
			$mid=$_POST['id'];
		}

		$mettingFilePath=FCPATH.'../docs/meettingRecord/';
		

		if($_FILES['meettingRecord']['type']=='application/pdf'){
			$pdf_file=$mid.'.pdf';
			$meettingRecord=$mettingFilePath.$pdf_file;
			move_uploaded_file($_FILES['meettingRecord']['tmp_name'],$meettingRecord);
		}
		$path=FCPATH.'../images/meettingRecord/';
            $pictures=uploadPic('pictures',$path);
            $data['pictures']=implode(',',$pictures);
		//อัพเดตข้อมูลไฟล์แนบ
			$meettingData=$govModel->getMeettingData($mid);
			$mRecord_id=$mid;
			$data=array();
			if(isset($pdf_file)&&$pdf_file!='')$data['meettingRecord']=$pdf_file;
			if(isset($pictures)&&count($pictures)>0){
				$pics=implode(',',$pictures);
				$data['pictures']=$meettingData->pictures!=''?$meettingData->pictures.','.$pics:$pics;
			}
			if(count($data)>0){
				$govModel->meettingUpdate($mRecord_id,$data);
			}

		$data=array(
			'title'=>'บันทึกข้อมูลการประชุม อ.กรอ.อศ.',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/meettingRecord').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	}
	public function viewMeettingRecord($id){		
		$govModel = model('App\Models\GovModel');
		$report=$govModel->getMeettingData([$id]);
		$pdfUrl=site_url('/docs/meettingRecord/'.$report->meettingRecord);
		$data=array(
			'title'=>'รายงานการประชุม อ.กรอ.อศ.',
			'mainMenu'=>view('_menu'),
			'content'=>'<iframe id="iframepdf" src="'.$pdfUrl.'" width="100%" height="600"></iframe>',
		  'notification'=>'',
		  'task'=>'',
		);
		return view('_main',$data);
	}
	public function meettingDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->meettingDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลผลการประชุม',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/meettingRecord').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 
	public function meettingPrint($id){		
		$govModel = model('App\Models\GovModel');
		$orgModel = model('App\Models\OrgModel');
		$report=$govModel->getMeettingData($id);
		$govDetail=$govModel->getGovData($report->gov_id);
		$school_detail=$orgModel->schoolData($govDetail->secretary_school_id);

		$secretary_name=$school_detail->director_name;
		if($govDetail->secretary_position=='deputy_planning'){
			$secretary_name=$school_detail->deputy_planning_name;
		}else if($govDetail->secretary_position=='deputy_resources'){
			$secretary_name=$school_detail->deputy_resources_name;
		}else if($govDetail->secretary_position=='deputy_academic'){
			$secretary_name=$school_detail->deputy_academic_name;
		}else if($govDetail->secretary_position=='deputy_activity'){
			$secretary_name=$school_detail->deputy_activity_name;
		}

		$pdfUrl=site_url('meettingRecord/doc/'.$report->meettingRecord);
		$budYear=mb_substr($report->meetting_date,0,4);
		$mount=mb_substr($report->meettingRecord,5,2);
		if($mount>=10)$budYear=(int)$budYear+1;
		$budYear=(int)$budYear+543;

		error_reporting(0);
		helper('mpdf');
		helper('user');
		helper('org');
		helper('thai');
			//return $result;
			$html='<table width="100%">
			<tr>
				<td style="text-align:center;">
					<h3>แบบรายงานผลการประชุม อ.กรอ.อศ. ปีงบประมาณ พ.ศ. '.$budYear.'</h3>
					อ.กรอ.อศ. '.org_name($report->gov_id).'<br>
					ครั้งที่ '.$report->book_no.' วันที่ '.dateThai($report->meetting_date,true,false,true).' สถานที่ '.$report->meetting_place.'<br>
				</td>
			</tr>
			</table>';
			$html.='<table width="100%" class="table table-bordered table-striped table-hover'.$class.' dataTable"  border="1" cellspacing="0" style="border-collapse: collapse; ">';
			$html.='
			<thead>
				<tr>
					<th width="50%">
					ผลการประชุม
					</th>
					<th width="50%">
					ข้อเสนอแนะ
					</th>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td valign="top" height="600">
				'.$report->meetting_result.'
				</th>
				<td valign="top">
				'.$report->meetting_comment.'
				</th>
			</tr>
			</tbody>
			</table>
			<!--
			<table width="100%">
				<tr>
					<td valign="top" width="12%"><u>หมายเหตุ</u></td>
					<td valign="top" width="88%">ส่งรายงานการประชุม สารบรรณอิเล็กทรอนิกส์ : (AMS e-office) : bocadmin<br> ผู้ประสานงาน : อรพิน  พรมนอก  โทรศัพท์ 09 9281 8842 E-mail: ora.ovec@gmail.com</td> 
				</tr>
			</table>
			--><br>&nbsp;
			<table width="100%">
				<tr>
					<td valign="top" width="50%">&nbsp;</td>
					<td valign="top" width="50%" style="text-align:center;"><br>ผู้รายงาน.........................................................<br>
					('.$secretary_name.')<br>
					เลขานุการ อ.กรอ.อศ. '.org_name($report->gov_id).'<br>
					วันที่รายงานผล.................................
					</td>
				</tr>
			</table>
			';
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
				'header'=>'<div style="text-align: right; font-weight: normal;">แบบฟอร์มที่ 1</div>'
			);
			$location=FCPATH.'/pdf/';
			$fname=current_user('org_code').'_school_01.pdf';
			$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
			//return '';
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
		return view('_main',$data);
	}
	public function publicRecord()
	{
		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'publicData'=>$govModel->getPublic(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'การประชาสัมพันธ์เพิ่มผู้เรียนในกลุ่ม อ.กรอ.อศ.',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_publicRecode',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function publicAdd()
	{
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$resultData,
		);

		$data=array(
			'title'=>'รายงานการประชาสัมพันธ์',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_publicDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function publicDetail($id)
	{
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$govModel = model('App\Models\GovModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$publicData=$govModel->getPublicData($id);
		$data=array(
			'mouData'=>$resultData,
			'publicData'=>$publicData,
		);

		$data=array(
			'title'=>'รายงานการประชาสัมพันธ์',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_publicDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function publicSave(){
		$govModel = model('App\Models\GovModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$govModel->publicUpdate($data['id'],$data);
		}else{
			$result=$govModel->publicAdd($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลการประชาสัมพันธ์',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/publicRecord').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}

	public function publicDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->publicDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลการประชาสัมพันธ์',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/publicRecord').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 

	public function trainerDev(){

		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'trainerDevData'=>$govModel->getTrainerDev(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'การพัฒนาครูฝึกในสถานประกอบการ',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_trainerDev',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);

	} 
	public function trainerDevAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$resultData,
		);

		$data=array(
			'title'=>'การพัฒนาครูฝึก',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_trainerDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function trainerDevSave(){
		$govModel = model('App\Models\GovModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		$data['record_date']=date('Y-m-d');
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$govModel->trainerDevUpdate($data['id'],$data);
		}else{
			$result=$govModel->trainerDevAdd($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลการพัฒนาครูฝึก',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/trainerDev').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}
	public function trainerDevDetail($id){
		helper('user');
		$govModel = model('App\Models\GovModel');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$trainerDevData=$govModel->getTrainerDevData($id);
		$data=array(
			'mouData'=>$resultData,
			'trainerDevData'=>$trainerDevData,
		);

		$data=array(
			'title'=>'การพัฒนาครูฝึก',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_trainerDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function trainerDevDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->trainerDevDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลการพัฒนาครูฝึก',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/trainerDev').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 


	public function teacherDev(){

		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'teacherDevData'=>$govModel->getTeacherDev(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'การพัฒนาครูในสถานศึกษา',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_teacherDev',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);

	} 
	public function teacherDevAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$resultData,
		);

		$data=array(
			'title'=>'การพัฒนาครูผู้สอนในสถานศึกษา',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_teacherDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function teacherDevSave(){
		$govModel = model('App\Models\GovModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		$data['record_date']=date('Y-m-d');
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$govModel->teacherDevUpdate($data['id'],$data);
		}else{
			$result=$govModel->teacherDevAdd($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลการพัฒนาครูในสถานศึกษา',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/teacherDev').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}
	public function teacherDevDetail($id){
		helper('user');
		$govModel = model('App\Models\GovModel');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$teacherDevData=$govModel->getteacherDevData($id);
		$data=array(
			'mouData'=>$resultData,
			'teacherDevData'=>$teacherDevData,
		);

		$data=array(
			'title'=>'การพัฒนาครูผู้สอนในสถานศึกษา',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_teacherDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function teacherDevDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->teacherDevDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลการพัฒนาครูผู้สอนในสถานศึกษา',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/teacherDev').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 


	public function studentDev(){

		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'studentDevData'=>$govModel->getStudentDev(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'การพัฒนาผู้เรียน',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_studentDev',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);

	} 
	public function studentDevAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$resultData,
		);

		$data=array(
			'title'=>'การพัฒนาผู้เรียน',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_studentDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function studentDevSave(){
		$govModel = model('App\Models\GovModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		$data['record_date']=date('Y-m-d');
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$govModel->studentDevUpdate($data['id'],$data);
		}else{
			$result=$govModel->studentDevAdd($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลการพัฒนาผู้เรียน',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/studentDev').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}
	public function studentDevDetail($id){
		helper('user');
		$govModel = model('App\Models\GovModel');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$studentDevData=$govModel->getStudentDevData($id);
		$data=array(
			'mouData'=>$resultData,
			'studentDevData'=>$studentDevData,
		);

		$data=array(
			'title'=>'การพัฒนาผู้เรียน',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_studentDevDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function studentDevDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->studentDevDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลการพัฒนาผู้เรียน',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/studentDev').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	} 

	public function projectRecord(){

		helper('user');
        
		$govModel = model('App\Models\GovModel');
        $data=array(
            'projectRecordData'=>$govModel->getProject(['gov_id'=>current_user('org_code')]),
        );
		$data=array(
			'title'=>'การดำเนินโครงการอื่นๆ',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_projectRecord',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);

	} 
	public function projectAdd(){
		helper('user');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$data=array(
			'mouData'=>$resultData,
		);

		$data=array(
			'title'=>'การดำเนินโครงการอื่น ๆ',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_projectDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function projectSave(){
		$govModel = model('App\Models\GovModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		$data['record_date']=date('Y-m-d');
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$govModel->projectUpdate($data['id'],$data);
		}else{
			$result=$govModel->projectAdd($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลการดำเนินโครงการอื่น ๆ',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/projectRecord').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}
	public function projectDetail($id){
		helper('user');
		$govModel = model('App\Models\GovModel');
		$mouModel = model('App\Models\MouModel');
		$resultData=$mouModel->getMou(['school_id'=>current_user('org_code')]);
		$projectData=$govModel->getProjectData($id);
		$data=array(
			'mouData'=>$resultData,
			'projectData'=>$projectData,
		);

		$data=array(
			'title'=>'การดำเนินโครงการอื่น ๆ',
			'mainMenu'=>view('_menu'),
            'content'=>view('gov_projectDetail',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}
	public function projectDelete($id){

		$govModel = model('App\Models\GovModel');
		 
			$result=$govModel->projectDelete(['id'=>$id]);

		$data=array(
			'title'=>'ลบข้อมูลการดำเนินโครงการ',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/gov/projectRecord').'">':'ลบข้อมูลไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);

	}

	public function research(){

		$data=array(
			'title'=>'แบบสอบถามความพึงพอใจ',
			'mainMenu'=>view('_menu'),
			'content'=>view('research'),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);
	}

	public function viewMeettingPicture($meettingID){

		$govModel = model('App\Models\GovModel');
		$meettingData=$govModel->getMeettingData($meettingID);
		$pics=$meettingData->pictures;
		$pics=explode(',',$pics);
		$pictures=array();
		foreach($pics as $pic){
			$pictures[]['url']=site_url('/images/meettingRecord/'.$pic);
		}
		$data=array(
			'galleryName'=>$meettingData->subject,
			'pictures'=>$pictures,
			'deleteLink'=>site_url('public/gov/delPicture/'.$meettingID.'/'),
		);
		$data=array(
			'title'=>'ภาพประกอบรายงานการประชุม',
			'mainMenu'=>view('_menu'),
			'content'=>view('gallery',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);
	}
}