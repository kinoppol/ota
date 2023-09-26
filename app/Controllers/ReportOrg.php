<?php

namespace App\Controllers;

class ReportOrg extends BaseController
{
	public function school_01($title,$print=false)
	{
		
		if(!isset($title))$title=$_POST['title'];
		helper('report');
		helper('table');
		helper('user');
		helper('org');
		helper('thai');
		
		$org_code=isset($_POST['org_id'])?$_POST['org_id']:current_user('org_code');
		if($org_code=='all'){
			$org_name="สถานศึกษาทุกแห่งในสังกัด".org_name(current_user('org_code'));
			$org_id=$_SESSION['subORG'];
		}else if(mb_substr($org_code,0,1)=='p'){
			$province_code=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในจังหวัด".provinceName($province_code);
			$org_id=schoolInProvince($province_code);
		}else if(mb_substr($org_code,0,1)=='z'){
			$zone_id=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในภาค".zoneName($zone_id);
			$org_id=schoolInZone($zone_id);
		}else{
			$org_name=isset($_POST['org_id'])?org_name($_POST['org_id']):org_name(current_user('org_code'));
			$org_id=$org_code;
		}
		$data=array(
			'org_code'=>$org_code=='all'||!is_numeric($org_code)?current_user('org_code'):$org_code,
			'org_name'=>$org_code=='all'||!is_numeric($org_code)?org_name(current_user('org_code')):$org_name,
		);
		$org_type_name=org_type_name($data);
		$signBox=signBox($data);

		$data=array(
			'title'=>$title,
			'label'=>'ปีที่ลงนาม',
			'org_ids'=>org_ids(),
		);
		$form=orgYearFilter($data);
		$result='';
		$resultHead=array(
			'ที่',
			'สถานประกอบการ',
			'ลักษณะงาน',
			'ระดับ<br>ความร่วมมือ',
			'การร่วมลงทุน<br>กับ'.$org_type_name,
			'ระดับ<br>การศึกษา',
			//'วันที่ลงนาม',
			'วันที่เริ่ม<br>ความร่วมมือ',
			'วันที่สิ้นสุด<br>ความร่วมมือ',
			'สถานที่ลงนาม',
			'หมายเหตุ',
		);
		if(isset($_POST['year'])){

			$caption='<b>'.$title.'ระหว่าง'.$org_type_name.'และสถานประกอบการ ปี '.($_POST['year']+543).'</b><br>'.$org_name;

			$mouModel = model('App\Models\MouModel');
			$resultData=$mouModel->getMou(['year'=>$_POST['year'],
											'school_id'=>$org_id]);
			
			$school=$resultData['school'];
			$business=$resultData['business'];
			$gov=$resultData['gov'];
			$resultRows=array();
			$i=0;
			foreach ($resultData['mou'] as $mou){
				$mou = get_object_vars($mou);

				if(!isset($business[$mou['business_id']]))continue;
				$i++;

				$supEdu='';
				if($mou['support_vc_edu']=='Y')$supEdu='ปวช.';
				if($mou['support_hvc_edu']=='Y'){if($supEdu!='')$supEdu.='<br>'; $supEdu.='ปวส.';}
				if($mou['support_btech_edu']=='Y'){if($supEdu!='')$supEdu.='<br>'; $supEdu.='ทล.บ.';}
				if($mou['support_short_course']=='Y'){if($supEdu!='')$supEdu.='<br>'; $supEdu.='ระยะสั้น';}
				if($mou['support_no_specific']=='Y'){if($supEdu!='')$supEdu.='<br>'; $supEdu.='ไม่ระบุ';}

				$trainingPlace='';
				if($mou['support_local_training']=='Y')$trainingPlace='ฝึกงานในประเทศ';
				if($mou['support_oversea_training']=='Y'){if($trainingPlace!='')$trainingPlace.='<br>'; $trainingPlace.='ฝึกงานต่างประเทศ';}

				$org_name='';
					if(isset($school[$mou['school_id']]))$org_name=$school[$mou['school_id']];
					else if(isset($gov[$mou['school_id']]))$org_name=$gov[$mou['school_id']];

					
				$resultRows[]=array(
					$i,
					'business_id'=>$business[$mou['business_id']]['business_name'],
					'job_description'=>$business[$mou['business_id']]['job_description'],
					'level'=>isset($mou['level'])&&$mou['level']!=''?'ระดับ '.$mou['level']:'',
					'investment'=>isset($mou['investment'])&&$mou['investment']!=''?$mou['investment']:'ยังไม่มี',
					'support_edu'=>$supEdu,
					//'mou_date'=>dateThai($mou['mou_date']),
					'mou_start_date'=>dateThai($mou['mou_start_date']),
					'mou_end_date'=>dateThai($mou['mou_end_date']),
					'mou_sign_place'=>$mou['mou_sign_place'],
					'note'=>$trainingPlace,
				);
			}

			$mouArr=array(
					'caption'=>$caption,
					'thead'=>$resultHead,
					'tbody'=>$resultRows,
			);
			$result=genTable($mouArr,$export=true,$noFoot=true);
		}else{

			$result='โปรดกดปุม "ตกลง" เพื่อดูรายงาน';
		}
		$data=array(
			'form'=>$form,
			'result'=>$result,
		);
		if($print==false){
		$data=array(
			'title'=>$title,
			'mainMenu'=>view('_menu'),
            'content'=>view('reportView',$data),
			'notification'=>'',
			'task'=>'',
		);
		}else{
			$result.='
			<table width="100%">
			<tr>
			<td>
			<u>หมายเหตุ</u><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ระดับ ๑ หมายถึง ดำเนินกิจกรรมเกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น)<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ระดับ ๒ หมายถึง ดำเนินกิจกรรมเกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น) และจัดการเรียนการสอนทวิภาคี<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ระดับ ๓ หมายถึง ดำเนินกิจกรรมเกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น) และจัดการเรียนการสอนทวิภาคี และมีการร่วมลงทุนระหว่างสถานประกอบการและสถานศึกษา
			</td>
			</tr>
			</table>
			'.$signBox;
			error_reporting(0);
			helper('mpdf');
			//return $result;
			$pdf_data=array(
				'html'=>$result,
				'size'=>"A4-L",
				'fontsize'=>16,
				'marginL'=>20,
				'marginR'=>10,
				'marginT'=>25,
				'marginB'=>15,
				'header'=>'',
				'wartermark'=>'',
				'wartermarkimage'=>'',
				'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' สำนักความร่วมมือ สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
				'header'=>'<div style="text-align: right; font-weight: normal;"><b>แบบฟอร์มที่ 4</b> <br> หน้า{PAGENO}/{nbpg}</div>'
			);
			$location=FCPATH.'/pdf/';
			$fname=$_POST['org_id'].'_school_01.pdf';
			$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
			//return '';
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
		}
		return view('_main',$data);
	}

	///// Report 2
	public function school_02($title,$print=false)
	{
		$skill=array(
			'1'=>'1. ยานยนต์สมัยใหม่',
			'2'=>'2. อิเล็กทรอนิกส์อัจฉริยะ',
			'3'=>'3. ท่องเที่ยวกลุ่มรายได้ดี',
			'4'=>'4. เกษตรและเทคโนโลยีชีวภาพ',
			'5'=>'5. แปรรูปอาหาร',
			'6'=>'6. หุ่นยนต์เพื่อการอุตสาหกรรม',
			'7'=>'7. การบินและโลจิสติกส์',
			'8'=>'8. เชื้อเพลิงชีวภาพเคมีชีวภาพ',
			'9'=>'9. ดิจิตอล',
			'10'=>'10. การแพทย์ครบวงจร',
		);
        $check='✔';
		if($print)$check='<img src="'.site_url('images/check.jpg').'" width="16">';
		
		if(!isset($title))$title=$_POST['title'];
		helper('report');
		helper('table');
		helper('user');
		helper('org');
		helper('thai');
		
		$org_code=isset($_POST['org_id'])?$_POST['org_id']:current_user('org_code');
		if($org_code=='all'){
			$org_name="สถานศึกษาทุกแห่งในสังกัด".org_name(current_user('org_code'));
			$org_id=$_SESSION['subORG'];
		}else if(mb_substr($org_code,0,1)=='p'){
			$province_code=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในจังหวัด".provinceName($province_code);
			$org_id=schoolInProvince($province_code);
		}else if(mb_substr($org_code,0,1)=='z'){
			$zone_id=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในภาค".zoneName($zone_id);
			$org_id=schoolInZone($zone_id);
		}else{
			$org_name=isset($_POST['org_id'])?org_name($_POST['org_id']):org_name(current_user('org_code'));
			$org_id=$org_code;
		}
		$data=array(
			'org_code'=>$org_code=='all'||!is_numeric($org_code)?current_user('org_code'):$org_code,
			'org_name'=>$org_code=='all'||!is_numeric($org_code)?org_name(current_user('org_code')):$org_name,
		);
		$org_type_name=org_type_name($data);
		$signBox=signBox($data);

		$title='รายงานการพัฒนาหลักสูตรระหว่าง '.$org_type_name.' ร่วมกับสถานประกอบการ';

		$data=array(
			'title'=>$title,
			'label'=>'ปีที่จัดอบรม',
		);
		$form=orgYearFilter($data);
		$result='';
		$resultHead=array(
			'ที่',
			'สถานประกอบการ',
			'ชื่อหลักสูตร',
			'ปวช.',
			'ปวส.',
			'ทล.บ.',
			'ระยะสั้น',
			'ไม่กำหนด',
			'Skill Gap',
			'S-Curve',
			'จำนวน<br>ชั่วโมง',
			'เป้าหมาย<br>(คน)',
			'ผู้เข้าอบรม<br>(คน)',
			'หมายเหตุ',
		);
		if(isset($_POST['year'])){

			$caption='<b>'.$title.' ปี '.($_POST['year']+543).' </b><br>'.$org_name;

			$mouModel = model('App\Models\MouModel');
			$resultData=$mouModel->curriculumGet(['curriculum_year'=>$_POST['year'],
											'school_id'=>$org_id]);
			
			//$school=$resultData['school'];
			$business=$resultData['business'];
			//$gov=$resultData['gov'];
			$resultRows=array();
			$i=0;
			foreach ($resultData['curriculum'] as $cur){
				$i++;
				//$cur = get_object_vars($curriculum);

				$KG='';

				if($cur->skill_01=='Y'){$KG.=$skill['1'];}				
				if($cur->skill_02=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['2'];}				
				if($cur->skill_03=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['3'];}				
				if($cur->skill_04=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['4'];}				
				if($cur->skill_05=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['5'];}				
				if($cur->skill_06=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['6'];}				
				if($cur->skill_07=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['7'];}				
				if($cur->skill_08=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['8'];}				
				if($cur->skill_09=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['9'];}				
				if($cur->skill_10=='Y'){if($KG!='')$KG.='<br>';$KG.=$skill['10'];}

				$resultRows[]=array(
					$i,
					'business_id'=>$business[$cur->business_id]['business_name'],
					'curriculum_name'=>$cur->curriculum_name,	
					'support_vc_edu'=>$cur->support_vc_edu=='Y'?$check:'',
					'support_hvc_edu'=>$cur->support_hvc_edu=='Y'?$check:'',
					'support_btech_edu'=>$cur->support_btech_edu=='Y'?$check:'',
					'support_short_course'=>$cur->support_short_course=='Y'?$check:'',
					'support_no_specific'=>$cur->support_no_specific=='Y'?$check:'',	
					'Skill_Gap'=>$cur->skill_gap,			
					'scurve'=>$KG,			
					'curriculum_hour'=>$cur->curriculum_hour,			
					'curriculum_target'=>$cur->curriculum_target,	
					'training_amount'=>$cur->training_amount,
					'note'=>'',
				);
			}

			$mouArr=array(
					'caption'=>$caption,
					'thead'=>$resultHead,
					'tbody'=>$resultRows,
			);
			$result=genTable($mouArr,$export=true,$noFoot=true);
		}else{

			$result='โปรดกดปุม "ตกลง" เพื่อดูรายงาน';
		}
		$data=array(
			'form'=>$form,
			'result'=>$result,
		);
		if($print==false){
		$data=array(
			'title'=>$title,
			'mainMenu'=>view('_menu'),
            'content'=>view('reportView',$data),
			'notification'=>'',
			'task'=>'',
		);
		}else{
			$result.=$signBox;
			error_reporting(0);
			helper('mpdf');
			//return $result;
			$pdf_data=array(
				'html'=>$result,
				'size'=>"A4-L",
				'fontsize'=>16,
				'marginL'=>20,
				'marginR'=>10,
				'marginT'=>10,
				'marginB'=>15,
				'header'=>'',
				'wartermark'=>'',
				'wartermarkimage'=>'',
				'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' สำนักความร่วมมือ สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
				'header'=>'<div style="text-align: right; font-weight: normal;"><b>แบบฟอร์มที่ 3</b> <br> หน้า {PAGENO}/{nbpg}</div>'
			);
			$location=FCPATH.'/pdf/';
			$fname=$_POST['org_id'].'_school_01.pdf';
			$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
			//return '';
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
		}
		return view('_main',$data);
	}

	//////// Report 3
	
	public function school_03($title,$print=false)
	{	
		if(!isset($title))$title=$_POST['title'];
		helper('report');
		helper('table');
		helper('user');
		helper('org');
		helper('thai');
		
		$org_code=isset($_POST['org_id'])?$_POST['org_id']:current_user('org_code');
		if($org_code=='all'){
			$org_name="สถานศึกษาทุกแห่งในสังกัด".org_name(current_user('org_code'));
			$org_id=$_SESSION['subORG'];
		}else if(mb_substr($org_code,0,1)=='p'){
			$province_code=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในจังหวัด".provinceName($province_code);
			$org_id=schoolInProvince($province_code);
		}else if(mb_substr($org_code,0,1)=='z'){
			$zone_id=mb_substr($org_code,1,mb_strlen($org_code));
			$org_name="สถานศึกษาทุกแห่งในภาค".zoneName($zone_id);
			$org_id=schoolInZone($zone_id);
		}else{
			$org_name=isset($_POST['org_id'])?org_name($_POST['org_id']):org_name(current_user('org_code'));
			$org_id=$org_code;
		}
		$data=array(
			'org_code'=>$org_code=='all'||!is_numeric($org_code)?current_user('org_code'):$org_code,
			'org_name'=>$org_code=='all'||!is_numeric($org_code)?org_name(current_user('org_code')):$org_name,
		);
		$org_type_name=org_type_name($data);
		$signBox=signBox($data);

		if(mb_strlen($org_code)<10){
			$org_type_name=' อ.กรอ.อศ. ';
			$signData=array(
				'positionP1'=>'ผู้จัดทำข้อมูล',
				'positionP2'=>'อนุกรรมการและผู้ช่วยเลขานุการ อ.กรอ.อศ. <br>'.$org_name,
				'positionP3'=>'อนุกรรมการและเลขานุการ อ.กรอ.อศ.  <br>'.$org_name,
			);
		}else{
			$org_type_name='สถานศึกษา';
			$signData=array(
				'positionP1'=>'หัวหน้างานความร่วมมือ',
				'positionP2'=>'รองผู้อำนวยการฝ่ายแผนงานและความร่วมมือ<br>&nbsp;',
				'positionP3'=>'ผู้อำนวยการ'.$org_name.'<br>&nbsp;',
			);
		}

		
		$title='รายงานผลสัมฤทธิ์ของการร่วมมือระหว่าง '.$org_type_name.' ร่วมกับสถานประกอบการ';
		$data=array(
			'title'=>$title,
			'label'=>'ปีที่เกิดผลสัมฤทธิ์',
			'org_ids'=>org_ids(),
		);
		$form=orgYearFilter($data);
		$result='';
		$resultHead=array(
			'ที่',
			'สถานประกอบการ',
			'สาขาที่รับ<br>นร.นศ. ฝึกงาน/ฝึกอาชีพ',
			'รับนร.นศ.<br> ฝึกงาน/ฝึกอาชีพ (คน)',
			'สาขาที่รับ<br>ผู้สำเร็จการศึกษา เข้าทำงาน',
			'รับ<br>ผู้สำเร็จการศึกษา เข้าทำงาน (คน)',
			'การสนับสนุน<br>การศึกษา',
			'มูลค่าการสนับสนุน',
			'การสนับสนุน<br>การศึกษาด้านอื่นๆ',
			'หมายเหตุ',
		);
		if(isset($_POST['year'])){

			$caption='<b>'.$title.' ปี '.($_POST['year']+543).' </b><br>'.$org_name;

			$mouModel = model('App\Models\MouModel');
			$resultData=$mouModel->resultGet(['result_year'=>$_POST['year'],
											'school_id'=>$org_id]);
			
			//$school=$resultData['school'];
			$business=$resultData['business'];
			//$gov=$resultData['gov'];
			$resultRows=array();
			$i=0;
			foreach ($resultData['result'] as $res){
				//$cur = get_object_vars($curriculum);
				$i++;

				$resultRows[]=array(
					$i,
					'business_id'=>$business[$res->business_id]['business_name'],
					'trainee_majors'=>$res->trainee_majors,	
					'trainee_amount'=>$res->trainee_amount,
					'employee_majors'=>$res->employee_majors,
					'employee_amount'=>$res->employee_amount,
					'donate_detail'=>$res->donate_detail,
					'donate_value'=>'<div style="text-align:right;">'.number_format($res->donate_value,0,'.',',').($res->donate_value>0?' บาท':'').'</div>',
					'donate_other'=>$res->donate_other,
					'note'=>'',
				);
			}

			$mouArr=array(
					'caption'=>$caption,
					'thead'=>$resultHead,
					'tbody'=>$resultRows,
			);
			$result=genTable($mouArr,$export=true,$noFoot=true);
		}else{

			$result='โปรดกดปุม "ตกลง" เพื่อดูรายงาน';
		}
		$data=array(
			'form'=>$form,
			'result'=>$result,
		);
		if($print==false){
		$data=array(
			'title'=>$title,
			'mainMenu'=>view('_menu'),
            'content'=>view('reportView',$data),
			'notification'=>'',
			'task'=>'',
		);
		}else{
			$result.=$signBox;
			error_reporting(0);
			helper('mpdf');
			//return $result;
			$pdf_data=array(
				'html'=>$result,
				'size'=>"A4-L",
				'fontsize'=>16,
				'marginL'=>20,
				'marginR'=>10,
				'marginT'=>10,
				'marginB'=>15,
				'header'=>'',
				'wartermark'=>'',
				'wartermarkimage'=>'',
				'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' สำนักความร่วมมือ สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
				'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
			);
			$location=FCPATH.'/pdf/';
			$fname=$_POST['org_id'].'_school_01.pdf';
			$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
			//return '';
			return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
		}
		return view('_main',$data);
	}
}