<?php
    //print_r($schoolData);
    helper('form');
    $data=array(
         array(
            'type'=>'hidden',
            'id'=>'school_id',
            'def'=>current_user('org_code'),
             ),
         array(
            'type'=>'hidden',
            'id'=>'indicator_id',
            'def'=>$indicator_id,
             ),
         array(
            'label'=>'ไฟล์แนบ (PDF)',
            'type'=>'file',
            'id'=>'attach_file',
            'accept'=>'application/pdf',
            'multiple'=>true,
             ),
         array(
            'label'=>'ภาพประกอบ (JPG/PNG)',
            'type'=>'file',
            'id'=>'picture',
            'accept'=>'image/jpeg,image/png',
            'multiple'=>true,
             ),
        array(
            'label'=>'คำอธิบายเพิ่มเติม',
            'type'=>'textarea',
            'id'=>'comment',
            'placeholder'=>'หากมีข้อมูลเพิ่มเติมที่ต้องการแจ้งให้กรรมการทราบโปรดระบุ',
            'def'=>isset($submissionData->comment)?$submissionData->comment:'',
            ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'id'=>'submit_form',
        'formName'=>$indicatorData->subject,
        'inputs'=>$data,
        'action'=>site_url('public/evaluate/submission'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    print '<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'" class="btn btn-xs btn-primary"><i class="material-icons">arrow_left</i> กลับ</a>';
    print genForm($form);