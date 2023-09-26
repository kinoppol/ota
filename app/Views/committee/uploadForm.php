<?php
    //print_r($schoolData);
    helper('form');
    $data=array(
         array(
            'type'=>'hidden',
            'id'=>'committee_id',
            'def'=>current_user('user_id'),
             ),
         array(
            'type'=>'hidden',
            'id'=>'school_id',
            'def'=>isset($school_id)?$school_id:'',
             ),
         array(
            'type'=>'hidden',
            'id'=>'mission_id',
            'def'=>$mission_id,
             ),
         array(
            'label'=>'ไฟล์แนบ (PDF)',
            'type'=>'file',
            'id'=>'attach_file',
            'accept'=>'application/pdf',
            'multiple'=>false,
             ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'id'=>'submit_form',
        'formName'=>'ลงนามในแบบลงคะแนนแล้วสแกนเป็นไฟล์ PDF',
        'inputs'=>$data,
        'action'=>$submitURL,
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    //print '<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'" class="btn btn-xs btn-primary"><i class="material-icons">arrow_left</i> กลับ</a>';
    print genForm($form);