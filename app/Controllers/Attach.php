<?php

namespace App\Controllers;

class attach extends BaseController
{
	public function file($indecator_id,$school_id)
	{

		helper('gallery');
		helper('modal');
		$evaModel = model('App\Models\EvaluateModel');

		$data=array(
			'indicator_id'=>$indecator_id,
			'school_id'=>$school_id,
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
		$pdf='<h4>ไฟล์ PDF</h4><br><div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="body">
					<div id="aniimated-thumbnials" class="list-unstyled row clearfix">';
		foreach($files as $file){
			$pdf.=pdf_link($file);
		}
		$pdf.='</div></div></div></div></div>';

		if(count($files)<1){
			$pdf='';
		}
		$pics=isset($submissionData->picture)?$submissionData->picture:'';
		$pics=explode(',',$pics);
		$pictures=array();
		foreach($pics as $pic){
			if($pic=='')continue;
			$pictures[]['url']=site_url('/images/evaluate/'.$pic);
		}
		$picture='<h4>รูปภาพ</h4><br><div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="body">
					<div id="aniimated-thumbnials" class="list-unstyled row clearfix">';
		foreach($pictures as $pic){
			$picture.=pic_link($pic);
		 }
		 $picture.='</div></div></div></div></div>';
		 if(count($pictures)<1){
			$picture='';
		}
		//$comment=$submissionData->comment;
	if(count($filesData)<1||count($pics)<1){ print 'ไม่มีไฟล์แนบ'; /*return 0;*/}

		$comment=isset($submissionData->comment)&&trim($submissionData->comment)!=''?'<h4>ข้อความอธิบายเพิ่มเติม</h4><br><div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="body">
					<div id="aniimated-thumbnials" class="list-unstyled row clearfix">'.strlink(trim($submissionData->comment)).'</div></div></div></div></div>':'';
	
		return '
		<style>
			.gallery_image{
				object-fit: cover;
			}
		</style>'.$picture.$pdf.$comment;
	}
}





