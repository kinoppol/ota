<?php

namespace App\Controllers;

class Mission extends BaseController
{
	public function list($year=false)
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
			'title'=>'ภารกิจการประเมิน',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('missionList',$data),
		);
		return view('_main',$data);
	}
    
    public function add()
	{
		$data=array(
			'title'=>'ข้อมูลภารกิจการประเมิน',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('missionDetail'),
		);
		return view('_main',$data);
	}


    public function edit($id)
	{

		$missionModel = model('App\Models\MissionModel');
        $missionData = $missionModel->getMissionData($id);
		$data=array(
			'title'=>'ข้อมูลภารกิจการประเมิน',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('missionDetail',['mission'=>$missionData]),
		);
		return view('_main',$data);
	}

    public function save()
    {
		$missionModel = model('App\Models\MissionModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$missionModel->updateMission($data['id'],$data);
		}else{
			$result=$missionModel->addMission($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลภารกิจการประเมิน',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mission/list').'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
    }

    public function delete($id)
    {
		$missionModel = model('App\Models\MissionModel');	
		$result=$missionModel->deleteMission($id);

		$data=array(
			'title'=>'ลบข้อมูลภารกิจการประเมิน',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mission/list').'">':'ลบข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
    }

    public function indicatorList($id=false,$indicatorId=0)
	{
		$missionModel = model('App\Models\MissionModel');
    	$missionData=$missionModel->getMissionData($id);
        $indicatorModel = model('App\Models\IndicatorModel');

        $data=array(
            'mission_id'=>$id,
            'parent_id'=>$indicatorId,
                );
        if($indicatorId){
		    $indicatorData=$indicatorModel->getIndicatorData($indicatorId);
        }
		$indicators=$indicatorModel->getIndicator($data);

        $data=array(
            'mission'=>$missionData,
            'indicators'=>$indicators,
            'indicatorData'=>isset($indicatorData)?$indicatorData:false,
        );
		$data=array(
			'title'=>'ภารกิจการประเมิน <b>'.$missionData->subject.'</b>',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('indicatorList',$data),
		);
		return view('_main',$data);
	}

    public function indicatorAdd($missionId,$indicatorId=false)
	{
        $data=array(
            'mission_id'=>$missionId,
        );
        if($indicatorId)$data['parent_id']=$indicatorId;
		$data=array(
			'title'=>'ข้อมูลตัวบ่งชี้',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('indicatorDetail',$data),
		);
		return view('_main',$data);
	}

    public function indicatorEdit($missionId,$indicatorId)
	{
        $indicatorModel = model('App\Models\IndicatorModel');
        $indicatorData = $indicatorModel->getIndicatorData($indicatorId);
        $data=array(
            'mission_id'=>$missionId,
            'indicator'=>$indicatorData,
        );
		$data=array(
			'title'=>'ข้อมูลตัวบ่งชี้',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('indicatorDetail',$data),
		);
		return view('_main',$data);
	}

    public function indicatorSave()
    {
		$indicatorModel = model('App\Models\IndicatorModel');
		$data=array();
		foreach($_POST as $k=>$v){
				$data[$k]=$v;
		}
		if(isset($data['id'])&&$data['id']!=''){			
			$result=$indicatorModel->updateIndicator($data['id'],$data);
		}else{
			$result=$indicatorModel->addIndicator($data);
		}

		$data=array(
			'title'=>'บันทึกข้อมูลตัวบ่งชี้',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลตัวบ่งชี้สำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mission/indicatorList/'.$data['mission_id'].'/'.(isset($data['parent_id'])?$data['parent_id']:'')).'">':'บันทึกข้อมูลตัวบ่งชี้ไม่สำเร็จ',
		);
		return view('_main',$data);
    }
    public function indicatorDelete($id)
    {
		$indicatorModel = model('App\Models\IndicatorModel');	
		$indicatorData=$indicatorModel->getIndicatorData($id);
		$result=$indicatorModel->deleteIndicator($id);

		$data=array(
			'title'=>'ลบข้อมูลตัวบ่งชี้/เกณฑ์',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'ลบข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/mission/indicatorList/'.$indicatorData->mission_id.'/'.(($indicatorData->parent_id)?$indicatorData->parent_id:'')).'">':'ลบข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);
    }

	public function export($mission_id){
		error_reporting(0);
		helper('mpdf');
		helper('user');
		helper('evaluate');
		helper('thai');
		helper('string');


		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=".$mission_id.'_'.date('Y-m-d_His').".xls");  //File name extension was wrong
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);

			$reportSize='A4-L';
			$fullSubject=false;
			$fontsize='12';
		

		$userModel = model('App\Models\UserModel');
		$orgModel = model('App\Models\OrgModel');
		$missionModel = model('App\Models\MissionModel');
		$evaluateModel = model('App\Models\EvaluateModel');


		$schools=$evaluateModel->schoolList();
		$num_of_school=count($schools);

		$committees=$missionModel->getCommittee($mission_id);
		$count_committee=count($committees);
		//$committeeData=$userModel->getUser($committee_id);


		$html='';
		$html.='<table width="100%">
	</table>';

		$html.='<table width="100%" border="1" cellspacing="0" style="overflow: wrap; border-collapse: collapse; ">
			<thead>
				<tr>';
		

		$tree=ind_tree($mission_id,$school_id);

		list($l,$table)=treetotable(0,$tree);
		$sum_score=0;
		$sum_give_score=array();
		$head='';
		$html.='<th rowspan="3" align="center">ที่</th><th align="center">ตัวบ่งชี้</th>';
		$committeeHead='';
		$sumMaxScore=0;
		$fullScore=0;
		$scoreHead='';
		foreach($table as $row){
			if($row['subject']){
				if($row['eva']){/*
					$html.='<tr>
						<td>'.$row['subject'].'</td><td></td>
					</tr>';*/
				}else{
					if(isset($row['eva_child'])&&$row['eva_child']>0){
						
						$html.='<th colspan="'.($count_committee+2).'">'.$head.($fullSubject?$row['subject']:subSubjectName($row['subject'])).'</th>';
						$fullScore+=$row['eva_child'];
						foreach($committees as $cm){
							$committeeHead.='<th>';
							$committeeHead.=$cm->ref_number;
							$committeeHead.='</th>';
							$scoreHead.='<th>';
							$scoreHead.=$row['eva_child'];
							$scoreHead.='</th>';
							$sumMaxScore+=$row['eva_child'];
						}
							$committeeHead.='<th rowspan="2">รวม</th><th rowspan="2">เฉลี่ย</th>';
							//$scoreHead.='<th>'.$sumMaxScore.'</th><th>'.$row['eva_child'].'</th>';
					}else{
						$head=subSubjectName($row['subject']).' - ';
					}

				}
			}
		}
		$html.='<th rowspan="2">คะแนน<br>รวม</th><th rowspan="2">เฉลี่ย<br>รวม</th><th rowspan="2">ร้อยละ</th>';
		$html.='
		</tr>';

		$html.='<tr>
		<th align="center">กรรมการคนที่</th>';
		$html.=$committeeHead;
		$html.='
		</tr>';
		$html.='<tr>
		<th align="center">คะแนนเต็ม</th>';
		$html.=$scoreHead.'<td align="right">'./*number_format($sumMaxScore,0)*/''.'</td><td align="right">'.$fullScore.'</td><td align="right">100.00</td>';
		$html.='
		</tr>';
		$html.='
	</thead>';

$html.='<tbody>';
$i=0;
foreach($schools as $sc){
$i++;
	$html.='<tr>';
	$committee_ids=$userModel->getCommitteeSchool($sc->org_code);
		$html.='<td>'.$i.'</td>';
		$html.='<td>'.$sc->school_name.'</td>';
		$all_sum=0;
		foreach($table as $row){
			if($row['subject']){
				if($row['eva']){
				}else{
					if(isset($row['eva_child'])&&$row['eva_child']>0){
						$secsion_sum=0;
						foreach($committees as $coms){
							$data=array(
								'committee_id'=>$coms->user_id,
								'school_id'=>$sc->org_code,
								'parent_id'=>$row['id'],
							);
							$give_score=$evaluateModel->sumChildScore($data);
							$secsion_sum+=$give_score;
							$html.='<td align="right">'.$give_score.'</td>';
						}
						$all_sum+=$secsion_sum;
						$html.='<td align="right">'.number_format($secsion_sum,0).'</td><td align="right" bgcolor="#FFFFAA">'.number_format($secsion_sum/(count($committee_ids)),2).'</td>';
					}
				}
			}
		}
		$avg_score=number_format($all_sum/(count($committee_ids)),2);
		$html.='<td align="right">'.number_format($all_sum).'</td><td align="right">'.$avg_score.'</td><td align="right" bgcolor="#AAFFFF">'.number_format($avg_score/$fullScore*100,2).'</td>';

	$html.='</tr>';

}
		$html.='
		</tbody>
		</table>';
		$html.='เอกสารนี้ออกโดย'.SYSTEMNAME.' วิทยาลัยพณิชยการบางนา สำนักงานคณะกรรมการการอาชีวศึกษา '.date('Y-m-d H:i:s');


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
		print $html;
		//$filePdf=genPdf($pdf_data,$pageNo=NULL,$location,$fname);
		//return '<meta http-equiv="refresh" content="0;url='.site_url('public/pdf/'.$filePdf).'?'.time().'">';
	}
}
