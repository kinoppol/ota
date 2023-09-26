<?php

namespace App\Controllers;

class Evaluate extends BaseController
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
			'title'=>'การประเมินศูนย์บ่มเพาะ',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('evaluateList',$data),
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

    public function assessmentItem($id=false,$indicatorId=0)
	{
		helper('user');
		$missionModel = model('App\Models\MissionModel');
    	$missionData=$missionModel->getMissionData($id);
        $indicatorModel = model('App\Models\IndicatorModel');
		$evaModel = model('App\Models\EvaluateModel');

        $data=array(
            'mission_id'=>$id,
            'parent_id'=>$indicatorId,
                );
        if($indicatorId){
		    $indicatorData=$indicatorModel->getIndicatorData($indicatorId);
        }

		$indicators=$indicatorModel->getIndicator($data);

		$ind_subm=array();
		foreach($indicators as $ind){
		$data=array(
			'indicator_id'=>$ind->id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);
		$ind_subm[$ind->id]=$submissionData;
		}
		//print_r($ind_subm);
        $data=array(
            'mission'=>$missionData,
            'indicators'=>$indicators,
			'ind_subm'=>$ind_subm,
            'indicatorData'=>isset($indicatorData)?$indicatorData:false,
        );
		$data=array(
			'title'=>'การประเมิน <b>'.$missionData->subject.'</b>',
			'task'=>'',
			'notification'=>'',
			'mainMenu'=>view('_menu'),
			'content'=>view('assessmentItem',$data),
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
	public function submitForm($mission_id,$indicator_id){
		helper('user');
		$missionModel = model('App\Models\MissionModel');
    	$missionData=$missionModel->getMissionData($mission_id);
		$indicatorModel = model('App\Models\IndicatorModel');	
		$indicatorData=$indicatorModel->getIndicatorData($indicator_id);
		$evaModel = model('App\Models\EvaluateModel');
		$data=array(
			'indicator_id'=>$indicator_id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);

		$data=array(
			'mission_id'=>$mission_id,
			'mission'=>$missionData,
			'indicator_id'=>$indicator_id,
			'indicatorData'=>$indicatorData,
			'submissionData'=>$submissionData,
		);

		$data=array(
			'title'=>'ส่งข้อมูล/แนบไฟล์',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>view('evaluateSubmitForm',$data),
		);
		return view('_main',$data);
	}

	public function submission(){
		$evaModel = model('App\Models\EvaluateModel');	
		$indicatorModel = model('App\Models\IndicatorModel');
		
        helper('image');
        helper('pdf');
        helper('user');
		foreach($_POST as $k=>$v){
            $data[$k]=$v;
        }

		$evaModel = model('App\Models\EvaluateModel');
		$data2=array(
			'indicator_id'=>$data['indicator_id'],
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data2);
		$data['picture']=isset($submissionData->picture)?$submissionData->picture:'';
		$data['attach_file']=isset($submissionData->attach_file)&&$submissionData->attach_file!='NULL'?json_decode($submissionData->attach_file,true):array();
		if(!is_array($data['attach_file']))$data['attach_file']=array();

		if(isset($_FILES['picture'])){
            $path=FCPATH.'../images/evaluate/';
            $picture=uploadPic('picture',$path);
            $data['picture'].=($data['picture']!=''&&count($picture)>0?',':'').implode(',',$picture);
        }

		if(isset($_FILES['attach_file'])){
            $path=FCPATH.'../docs/evaluate/';
            $PDF=uploadPDF('attach_file',$path);
            $data['attach_file']=array_merge($data['attach_file'],$PDF);
        }
		$data['attach_file']=json_encode($data['attach_file']);
		if(isset($submissionData->id)){
			$result=$evaModel->updateSubmission($submissionData->id,$data);
			//print "UPDATE";
		}else{
			$result=$evaModel->addSubmission($data);
			//print "ADD";
		}


        $indicatorData = $indicatorModel->getIndicatorData($data['indicator_id']);

		$data=array(
			'title'=>'บันทึกข้อมูลไฟล์ประกอบตัวบ่งชี้',
			'mainMenu'=>view('_menu'),
			'notification'=>'',
			'task'=>'',
			'content'=>$result?'บันทึกข้อมูลสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'">':'บันทึกข้อมูลไม่สำเร็จ',
		);
		return view('_main',$data);

	}

	public function picture($indicator_id){
		helper('user');
		$indicatorModel = model('App\Models\IndicatorModel');
		$indicatorData = $indicatorModel->getIndicatorData($indicator_id);
		$evaModel = model('App\Models\EvaluateModel');

		$missionModel = model('App\Models\MissionModel');
    	$missionData=$missionModel->getMissionData($indicatorData->mission_id);
		//print $missionData->end_date;
		$expire=strtotime($missionData->end_date.' 23:00:59')>strtotime(date('Y-m-d H:i:s'))?false:true;

		$data=array(
			'indicator_id'=>$indicator_id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);
		$pics=isset($submissionData->picture)?$submissionData->picture:'';
		$pics=explode(',',$pics);
		$pictures=array();
		foreach($pics as $pic){
			if($pic=='')continue;
			$pictures[]['url']=site_url('/images/evaluate/'.$pic);
		}
		$data=array(
			'galleryName'=>'ภาพประกอบหัวข้อ '.$indicatorData->subject,
			'pictures'=>$pictures,
			'deleteLink'=>$expire?false:site_url('public/evaluate/delPicture/'.$indicator_id.'/'),
		);
		$data=array(
			'title'=>'ภาพประกอบการประเมิน',
			'mainMenu'=>view('_menu'),
			'content'=>'<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'" class="btn btn-xs btn-primary"><i class="material-icons">arrow_left</i> กลับ</a>'.view('gallery',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);

	}

	public function delPicture($indicator_id,$pictureName){
		helper('user');
		$indicatorModel = model('App\Models\IndicatorModel');
		$indicatorData = $indicatorModel->getIndicatorData($indicator_id);
		$evaModel = model('App\Models\EvaluateModel');
		$data=array(
			'indicator_id'=>$indicator_id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);
		$pics=$submissionData->picture;
		$pics=explode(',',$pics);
		
        chdir(FCPATH);
        $picPath=realpath('../images/evaluate').'/'.$pictureName;
        //print $picPath;
        if(file_exists($picPath)){
            unlink($picPath);
        }
        unset($pics[(array_search($pictureName,$pics))]);

        $data=array(
            'picture'=>implode(',',$pics),
        );
        
        $result=$evaModel->updateSubmission($submissionData->id,$data);

		$data=array(
			'title'=>'ลบรูป',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบรูปภาพสำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/evaluate/picture/'.$indicator_id).'">':'ลบรูปภาพไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
    }

	public function attach_file($indicator_id){
		helper('user');
		$indicatorModel = model('App\Models\IndicatorModel');
		$indicatorData = $indicatorModel->getIndicatorData($indicator_id);
		$evaModel = model('App\Models\EvaluateModel');

		$missionModel = model('App\Models\MissionModel');
    	$missionData=$missionModel->getMissionData($indicatorData->mission_id);
		//print $missionData->end_date;
		$expire=strtotime($missionData->end_date.' 23:00:59')>strtotime(date('Y-m-d H:i:s'))?false:true;

		$data=array(
			'indicator_id'=>$indicator_id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);
		$filesData=isset($submissionData->attach_file)&&($submissionData->attach_file!='NULL'||$submissionData->attach_file!='')?json_decode($submissionData->attach_file,true):array();
		if(!is_array($filesData))$filesData=array();
		//print_r($filesData);
		$files=array();
		foreach($filesData as $file){
			if(!is_array($file))continue;
			$files[]=array(
							'name'=>$file['name'],
							'file'=>$file['file'],
							'url'=>site_url('/docs/evaluate/'.$file['file']),
						);
		}
		$data=array(
			'galleryName'=>'เอกสารประกอบหัวข้อ '.$indicatorData->subject,
			'files'=>$files,
			'deleteLink'=>$expire?false:site_url('public/evaluate/delPDF/'.$indicator_id.'/'),
		);
		$data=array(
			'title'=>'เอกสารประกอบการประเมิน',
			'mainMenu'=>view('_menu'),
			'content'=>'<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'" class="btn btn-xs btn-primary"><i class="material-icons">arrow_left</i> กลับ</a>'.view('galleryBook',$data),
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);

	}

	public function tracking($mission_id){
		helper('user');
		helper('evaluate');
		$tree=ind_tree($mission_id,current_user('org_code'));
		$data=array(
			'title'=>'ติดตามการดำเนินงาน',
			'mainMenu'=>view('_menu'),
			'content'=>'<div class="col-xs-12 col-sm-12">
			<div class="card">
				<div class="body">'.draw_tree(0,$tree).'</div></div></div>',
			'notification'=>'',
			'task'=>'',
		);

		return view('_main',$data);

	}
	public function delPDF($indicator_id,$fileName){
		helper('user');
		$indicatorModel = model('App\Models\IndicatorModel');
		$indicatorData = $indicatorModel->getIndicatorData($indicator_id);
		$evaModel = model('App\Models\EvaluateModel');
		$data=array(
			'indicator_id'=>$indicator_id,
			'school_id'=>current_user('org_code'),
		);	
		$submissionData=$evaModel->getSubmissionData($data);
		$file=$submissionData->attach_file;
		$file=json_decode($file,true);
		
        
		foreach($file as $k=>$v){
			if($v['file']==$fileName){
				unset($file[$k]);

				chdir(FCPATH);
				$filePath=realpath('../docs/evaluate').'/'.$v['file'];
				print $filePath;
				if(file_exists($filePath)){
					unlink($filePath);
				}
			}
		}
        

        $data=array(
            'attach_file'=>json_encode($file),
        );
        
        $result=$evaModel->updateSubmission($submissionData->id,$data);

		$data=array(
			'title'=>'ลบไฟล์',
			'mainMenu'=>view('_menu'),
            'content'=>$result?'ลบไฟล์สำเร็จ <meta http-equiv="refresh" content="2;url='.site_url('public/evaluate/attach_file/'.$indicator_id).'">':'ลบไฟล์ไม่สำเร็จ',
			'notification'=>'',
			'task'=>'',
		);      
		return view('_main',$data);
    }
}
