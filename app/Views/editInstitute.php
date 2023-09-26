<?php
    //print_r($schoolData);
    helper('form');
    $data=array(array(
        'label'=>'ชื่อผู้อำนวยการสถาบันการอาชีวศึกษา',
        'type'=>'text',
        'id'=>'director_name',
        'def'=>$institute_data->director_name,
        'required'=>true,
         ),
         array(
        'label'=>'ชื่อรองผู้อำนวยการสถาบันการอาชีวศึกษา',
        'type'=>'text',
        'id'=>'deputy_name',
        'def'=>$institute_data->deputy_name,
        'required'=>true,
         ),
         array(
             'label'=>'ชื่อผู้จัดทำข้อมูล',
             'type'=>'text',
             'id'=>'supervisor_name',
             'def'=>$institute_data->supervisor_name,
             'required'=>true,
              ),
         array(
        'type'=>'hidden',
        'id'=>'institute_id',
        'def'=>$institute_data->institute_id,
         ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'formName'=>'ข้อมูลสถาบันการอาชีวศึกษา',
        'inputs'=>$data,
        'action'=>site_url('public/institute/saveInstitute'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    print genForm($form);

