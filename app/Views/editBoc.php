<?php
    //print_r($schoolData);
    helper('form');
    $data=array(array(
        'label'=>'ชื่อผู้อำนวยการสำนักความร่วมมือ',
        'type'=>'text',
        'id'=>'director_name',
        'def'=>$bocData->director_name,
        'required'=>true,
         ),
         array(
        'label'=>'ชื่อผู้อำนวยการกลุ่ม',
        'type'=>'text',
        'id'=>'director_group_name',
        'def'=>$bocData->director_group_name,
        'required'=>true,
         ),
         array(
             'label'=>'ชื่อผู้จัดทำข้อมูล',
             'type'=>'text',
             'id'=>'supervisor_name',
             'def'=>$bocData->supervisor_name,
             'required'=>true,
              ),
         array(
        'type'=>'hidden',
        'id'=>'org_id',
        'def'=>$bocData->org_id,
         ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'formName'=>'ข้อมูลสถาบันการอาชีวศึกษา',
        'inputs'=>$data,
        'action'=>site_url('public/boc/saveBoc'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    print genForm($form);

