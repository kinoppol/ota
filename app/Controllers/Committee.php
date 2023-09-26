<?php

namespace App\Controllers;

class committee extends BaseController
{
	public function missionList($year=false)
	{
		$missionModel = model('App\Models\MissionModel');
        $year=isset($year)&&$year!=''?$year:date('Y');
        $data=array(
            'year'=>$year,
        );
		$missionData=$missionModel->getMission($data);
        $data=array(
            'mission'=>$missionData,
            'year'=>$year,
        );
		$data=array(
			'title'=>'การประเมินศูนย์บ่มเพาะ',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('committee/evaluateList',$data),
		);
		return view('_main',$data);
	}
	public function schoolList($mission_id)
	{
        helper('system');
		helper('user');
		$evaluateModel = model('App\Models\EvaluateModel');
		$schools=$evaluateModel->schoolList();
		$schoolsEva=$evaluateModel->schoolEvaList($mission_id,current_user('ref_number'));
		$sc=array();
		foreach($schools as $school){

			$data=array(
				'school_id'=>$school->org_code,
				'mission_id'=>$mission_id,
				'committee_id'=>current_user('user_id'),
			);

			$sumGiveScore=$evaluateModel->sumGiveScore($data);
			$sc[]=array(
				'school_id'=>$school->org_code,
				'school_name'=>$school->school_name,
				'sumGiveScore'=>$sumGiveScore,
			);
		}
        $data=array(            
            'school'=>$sc,
			'schoolEva'=>$schoolsEva,
			'mission_id'=>$mission_id,
        );
		$data=array(
			'title'=>'รายชื่อสถานศึกษาที่เข้ารับการประเมิน',
			'mainMenu'=>view('_menu'),
            'content'=>view('schoolList',$data),
			'notification'=>'',
			'task'=>'',
		);        

		return view('_main',$data);
	}

	public function evaluate($mission_id,$school_id){
		helper('user');
		helper('evaluate');
		if(current_user('org_code')==$school_id){

			$data=array(
				'title'=>'ข้อผิดพลาด',
				'mainMenu'=>view('_menu'),
				'content'=>'Error ไม่สามารถประเมินสถานศึกษาของกรรมการได้',
				'notification'=>'',
				'task'=>'',
			);        

			return view('_main',$data);
		}
		$missionModel = model('App\Models\MissionModel');
		$orgModel = model('App\Models\OrgModel');
		$scoreModel = model('App\Models\ScoreModel');
		$committee_id=current_user('user_id');
		$data=array(
			'school_id'=>$school_id,
			'committee_id'=>$committee_id,
		);
		$score_data=$scoreModel->getScoreData($data);
		$scoreData=array();
		if(is_array($score_data))foreach($score_data as $row){
			$scoreData[$row->indicator_id]=$row->score;
		}
		$missionData=$missionModel->getMissionData($mission_id);
		$tree=ind_tree($mission_id,$school_id);
		$schoolData=$orgModel->schoolData($school_id);
		$data=array(
			'tree'=>$tree,
			'scoreData'=>$scoreData,
			'school_id'=>$school_id,
			'school_name'=>$schoolData->school_name,
		);
		$data=array(
			'title'=>$missionData->subject,
			'mainMenu'=>view('_menu'),
			'content'=>view('committee/evaluate',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);

	}

	public function save_eva($data){
		helper('user');
		$committee_id=current_user('user_id');
		list($school_id,$indicator_id,$eva_result)=explode('_',$data);
		$scoreModel = model('App\Models\ScoreModel');
		$data=array(
			'school_id'=>$school_id,
			'committee_id'=>$committee_id,
			'indicator_id'=>$indicator_id,
		);
		$score_data=$scoreModel->getScoreData($data);
		$data=array(
			'school_id'=>$school_id,
			'indicator_id'=>$indicator_id,
			'committee_id'=>$committee_id,
			'score'=>$eva_result=='pass'?1:0,
		);
		if(isset($score_data->score)){
			$result=$scoreModel->updateScore($school_id,$committee_id,$indicator_id,$data);
		}else{
			$result=$scoreModel->addScore($data);
		}
		return $result?$eva_result:'error';
	}

	public function summary($mission_id,$school_id=false){
		error_reporting(0);
		helper('mpdf');
		helper('user');
		helper('evaluate');
		helper('thai');

		if($school_id){
			$reportSize='A4';
			$fullSubject=true;
			$fontsize='14';
		}else{
			$reportSize='A4-L';
			$fullSubject=false;
			$fontsize='12';
		}

		$orgModel = model('App\Models\OrgModel');
		$missionModel = model('App\Models\MissionModel');
		$evaluateModel = model('App\Models\EvaluateModel');
		$schoolData = $orgModel->schoolData($school_id);
		$provinceData = $orgModel->getProvince();
		

		$html='<table width="100%">
			<tr>
				<td align="center"><h3>แบบลงคะแนน<br>
				การประเมินศูนย์บ่มเพาะผู้ประกอบการอาชีวศึกษา <u>ระดับจังหวัด</u></h3>
				</td>
			</tr>
			<tr>
				<td align="center">วิทยาลัย'.$schoolData->school_name.' จังหวัด '.$provinceData[$schoolData->province_id].'
				</td>
			</tr>
		</table>';

		$html.='<table width="100%">
		<tr>
			<td align="center">&nbsp;
			</td>
			<td align="right">
				กรรมการคนที่'.(current_user('ref_number')!=''?' <b>'.current_user('ref_number').'</b>':'........................').'
			</td>
		</tr>
	</table>';

		$html.='<table width="100%" border="1" cellspacing="0" style="overflow: wrap; border-collapse: collapse; ">
			<thead>
				<tr>
					<th rowspan="2" width="80%">รายการ</th>
					<th colspan="2" width="20%">คะแนน</th>
				</tr>
				<tr>
					<th width="10%">เต็ม</th>
					<th width="10%">ได้</th>
				</tr>
			</thead>';

		$html.='<tbody>';

		$tree=ind_tree($mission_id,$school_id);

		list($l,$table)=treetotable(0,$tree);
		$sum_score=0;
		$sum_give_score=0;
		foreach($table as $row){
			if($row['subject']){
				if($row['eva']){/*
					$html.='<tr>
						<td>'.$row['subject'].'</td><td></td>
					</tr>';*/
				}else{
					if(isset($row['eva_child'])&&$row['eva_child']>0){
						$data=array(
							'committee_id'=>current_user('user_id'),
							'school_id'=>$school_id,
							'parent_id'=>$row['id'],
						);
						$give_score=$evaluateModel->sumChildScore($data);
						$sum_give_score+=$give_score;
						$sum_score+=$row['eva_child'];
					$html.='<tr>
						<td>'.($fullSubject?$row['subject']:subSubjectName($row['subject'])).'</td>
						<td align="right">'.$row['eva_child'].'</td>
						<td align="right">'.$give_score.'</td>
					</tr>';
					}else{
					$html.='<tr>
						<td colspan="3">'.$row['subject'].'</td>
					</tr>';
					}

				}
			}
		}

		$html.='<tr>
			<td align="center"><b>รวมคะแนน</b></td>
			<td align="right"><b>'.$sum_score.'</b></td>
			<td align="right"><b>'.$sum_give_score.'</b></td>
		</tr>';

		$html.='
		</tbody>
		</table>';



		$html.='<table width="100%">
		<tr>
			<td align="center" width="50%">&nbsp;
			</td>
			<td align="center" width="50%">
			<br>
			<br>
				ลงชื่อ...................................................<br>
				('.current_user('name').' '.current_user('surname').')<br>
				วันที่ '.dateThai(date('Y-m-d'),true,false,true).'
			</td>
		</tr>
	</table>';

		$pdf_data=array(
			'html'=>$html,
			'size'=>$reportSize,
			'fontsize'=>$fontsize,
			'marginL'=>25,
			'marginR'=>20,
			'marginT'=>10,
			'marginB'=>20,
			'header'=>'',
			'wartermark'=>'',
			'wartermarkimage'=>'',
			'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' วิทยาลัยพณิชยการบางนา สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
			'header'=>'',//'<div style="text-align: right; font-weight: normal;"><br> หน้า{PAGENO}/{nbpg}</div>',
		);
		$location=FCPATH.'/pdf/';
		$fname=current_user('user_id').'_'.$school_id.'.pdf';
		$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
		return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
	}


	public function allSummary($committee_id,$mission_id){
		error_reporting(0);
		helper('mpdf');
		helper('user');
		helper('evaluate');
		helper('thai');
		helper('string');

			$reportSize='A4-L';
			$fullSubject=true;
			$fontsize='12';
		

		$userModel = model('App\Models\UserModel');
		$orgModel = model('App\Models\OrgModel');
		$missionModel = model('App\Models\MissionModel');
		$evaluateModel = model('App\Models\EvaluateModel');

		$committeeData=$userModel->getUser($committee_id);

		$schools=$evaluateModel->schoolList();
		$num_of_school=count($schools);
		/*foreach($schools as $sc){
			print $sc->school_name;
		}*/

		$schoolData = $orgModel->schoolData($school_id);
		$provinceData = $orgModel->getProvince();
		

		$html='<table width="100%">
			<tr>
				<td align="center"><h3>แบบสรุปการลงคะแนน<br>
				การประเมินศูนย์บ่มเพาะผู้ประกอบการอาชีวศึกษา <u>ระดับจังหวัด</u></h3>
				</td>
			</tr>
		</table>';

		$html.='<table width="100%">
	</table>';

		$html.='<table width="100%" border="1" cellspacing="0" style="overflow: wrap; border-collapse: collapse; ">
			<thead>
				<tr>
					<th rowspan="2" width="80%">รายการ</th>
					<th colspan="'.($num_of_school+1).'" width="20">คะแนน</th>
				</tr>
				<tr>
					<th width="2%" text-rotate="90" >คะแนนเต็ม</th>';
					foreach($schools as $sc){
						$html.='<th text-rotate="90" width="2%" style="vertical-align:bottom;">'.strlim($sc->school_name,25).'</th>';
						
					}
		$html.='
				</tr>
			</thead>';

		$html.='<tbody>';

		$tree=ind_tree($mission_id,$school_id);

		list($l,$table)=treetotable(0,$tree);
		$sum_score=0;
		$sum_give_score=array();
		foreach($table as $row){
			if($row['subject']){
				if($row['eva']){/*
					$html.='<tr>
						<td>'.$row['subject'].'</td><td></td>
					</tr>';*/
				}else{
					if(isset($row['eva_child'])&&$row['eva_child']>0){
						$html.='<tr>
								<td>'.($fullSubject?$row['subject']:subSubjectName($row['subject'])).'</td>
								<td align="right">'.$row['eva_child'].'</td>';

							$sum_score+=$row['eva_child'];
						foreach($schools as $sc){
							$data=array(
								'committee_id'=>$committee_id,
								'school_id'=>$sc->org_code,
								'parent_id'=>$row['id'],
							);
							$give_score=$evaluateModel->sumChildScore($data);
							$sum_give_score[$sc->org_code]+=$give_score;
							$html.='
								<td align="right">'.$give_score.'</td>';

						}
						$html.='</tr>';
					}else{
					$html.='<tr>
						<td colspan="'.($num_of_school+2).'">'.$row['subject'].'</td>
					</tr>';
					}

				}
			}
		}

		$html.='<tr>
			<td align="center"><b>รวมคะแนน</b></td>
			<td align="right"><b>'.$sum_score.'</b></td>';

			foreach($schools as $sc){
				$html.='<td align="right"><b>'.$sum_give_score[$sc->org_code].'</b></td>';
			}
		$html.='</tr>';

		$html.='
		</tbody>
		</table>';



		$html.='<table width="100%">
		<tr>
			<td align="center" width="50%">&nbsp;
			</td>
			<td align="center" width="50%">
			<br>
				ลงชื่อ...................................................<br>
				('.$committeeData->name.' '.$committeeData->surname.')<br>
				วันที่ '.dateThai(date('Y-m-d'),true,false,true).'
			</td>
		</tr>
	</table>';

		$pdf_data=array(
			'html'=>$html,
			'size'=>$reportSize,
			'fontsize'=>$fontsize,
			'marginL'=>25,
			'marginR'=>20,
			'marginT'=>5,
			'marginB'=>5,
			'header'=>'',
			'wartermark'=>'',
			'wartermarkimage'=>'',
			'footer'=>'เอกสารนี้ออกโดย'.SYSTEMNAME.' วิทยาลัยพณิชยการบางนา สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s'),
			'header'=>'<div style="text-align: right; font-weight: normal;">กรรมการคนที่'.($committeeData->ref_number!=''?' <b>'.$committeeData->ref_number.'</b>':'........................').'</div>',
		);
		$location=FCPATH.'/pdf/';
		$fname=$committee_id.'_'.$mission_id.'.pdf';
		//print $html;
		$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
		return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
	}

	public function uploadSummary($missionId,$school_id)
	{
		$data=array(
			'mission_id'=>$missionId,
			'school_id'=>$school_id,
			'submitURL'=>site_url('public/committee/saveSummary'),
		);
		$data=array(
			'title'=>'อัพโหลดไฟล์สรุปผลการประเมิน',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('committee/uploadForm',$data),
		);
		return view('_main',$data);
	}

	public function viewSummary($mission_id,$school_id,$committee_id){		
		$filename=$mission_id.'_'.$school_id.'_'.$committee_id.'.pdf';
		$filepath=realpath(FCPATH.'../docs/summary');
		$file_location=$filepath.'/'.$filename;
		//print $file_location;
		if(file_exists($file_location)){
			$file_exists=true;
		}else{
			$file_exists=false;
		}
		//print $file_exists;

		$pdfUrl=site_url('/docs/summary/'.$filename);
		$data=array(
			'title'=>'ไฟล์สรุปผล',
			'mainMenu'=>view('_menu'),
			'content'=>!$file_exists?'ขออภัยไม่พบไฟล์ที่ระบุ':'<iframe id="iframepdf" src="'.$pdfUrl.'?'.time().'" width="100%" height="600"></iframe>',
		  'notification'=>'',
		  'task'=>'',
		);
		return view('_main',$data);
	}
	public function saveSummary(){
        helper('pdf');
		$PDF=false;
		if(isset($_FILES['attach_file'])){
            $path=FCPATH.'../docs/summary/';
			$filename=$_POST['mission_id'].'_'.$_POST['school_id'].'_'.$_POST['committee_id'].'.pdf';
            $PDF=uploadPDF('attach_file',$path,$filename);
		}
		$data=array(
			'title'=>'บันทึกข้อมูลไฟล์สรุปผลการประเมิน',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$PDF?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/committee/schoolList/'.$_POST['mission_id']).'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	} 

	public function uploadAllSummary($missionId)
	{
		$data=array(
			'mission_id'=>$missionId,
			'submitURL'=>site_url('public/committee/saveAllSummary'),
		);
		$data=array(
			'title'=>'อัพโหลดไฟล์สรุปผลการประเมินทุกสถานศึกษา',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('committee/uploadForm',$data),
		);
		return view('_main',$data);
	}


	public function saveAllSummary(){
        helper('pdf');
		$PDF=false;
		if(isset($_FILES['attach_file'])){
            $path=FCPATH.'../docs/summary/';
			$filename=$_POST['mission_id'].'_'.$_POST['committee_id'].'.pdf';
            $PDF=uploadPDF('attach_file',$path,$filename);
		}
		$data=array(
			'title'=>'บันทึกข้อมูลไฟล์สรุปผลการประเมิน',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$PDF?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/committee/missionList/').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
	} 
	public function viewAllSummary($mission_id,$committee_id){		
		$filename=$mission_id.'_'.$committee_id.'.pdf';
		$filepath=realpath(FCPATH.'../docs/summary');
		$file_location=$filepath.'/'.$filename;
		//print $file_location;
		if(file_exists($file_location)){
			$file_exists=true;
		}else{
			$file_exists=false;
		}
		//print $file_exists;

		$pdfUrl=site_url('/docs/summary/'.$filename);
		$data=array(
			'title'=>'ไฟล์สรุปผล',
			'mainMenu'=>view('_menu'),
			'content'=>!$file_exists?'ขออภัยไม่พบไฟล์ที่ระบุ':'<iframe id="iframepdf" src="'.$pdfUrl.'?'.time().'" width="100%" height="600"></iframe>',
		  'notification'=>'',
		  'task'=>'',
		);
		return view('_main',$data);
	}
}