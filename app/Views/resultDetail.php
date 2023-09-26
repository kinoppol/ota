<?php

helper('tab');
helper('user');
    //print_r($schoolData);
    $years=array();
    for($i=date('Y')+1;$i>(date('Y')-5);$i--){
        $years[$i]=$i+543;
    }
    $businessData=array();
    foreach($mouData['business'] as $k=>$v){
        $businessData[$k]=$v['business_name'];
    }
    helper('form');
    $data1=array(array(
        'label'=>'ชื่อสถานประกอบการ',
        'type'=>'select',
        'items'=>$businessData,
        'class'=>'show-tick',
        'noneLabel'=>'โปรดเลือกสถานประกอบการ',
        'id'=>'business_id',
        'def'=>isset($resultData)?$resultData->business_id:'',
        'required'=>true,
         ),  
         array(
            'type'=>'hidden',
            'id'=>'id',
            'def'=>isset($resultData->id)?$resultData->id:'',
            'disabled'=>isset($resultData->id)?false:true,
            ),
         array(
            'type'=>'hidden',
            'id'=>'school_id',
            'def'=>current_user('org_code'),
            ),
         array(
            'label'=>'ปีที่เกิดผลสัมฤทธิ์ (ปีปฏิทิน)',
            'type'=>'select',
            'id'=>'result_year',
            'items'=>$years,
            'def'=>isset($resultData)?$resultData->result_year:date('Y'),
            'required'=>true,
             ),   
            ); 
        
             $data2=array(
         array(
            'label'=>'สาขาที่รับนักศึกษาฝึกงาน/ฝึกอาชีพ',
            'type'=>'text',
            'id'=>'trainee_majors',
            'def'=>isset($resultData)?$resultData->trainee_majors:'',
            'placeholder'=>'เช่น ช่างไฟฟ้า,ช่างอิเล็กทรอนิกส์ ขั้นแต่ละสาขาด้วยเครื่องหมายจุลภาค (,)',
             ),   
         array(
            'label'=>'จำนวนนักศึกษาฝึกงาน/ฝึกอาชีพ (จำนวนรวม)',
            'type'=>'number',
            'id'=>'trainee_amount',
            'def'=>isset($resultData)?$resultData->trainee_amount:'',
             ),    
            );
            $data3=array(
        array(
            'label'=>'สาขาที่รับผู้สำเร็จการศึกษาเข้าเป็นพนักงาน',
            'type'=>'text',
            'id'=>'employee_majors',
            'def'=>isset($resultData)?$resultData->employee_majors:'',
            'placeholder'=>'เช่น ช่างไฟฟ้า,ช่างอิเล็กทรอนิกส์ ขั้นแต่ละสาขาด้วยเครื่องหมายจุลภาค (,)',
             ),   
         array(
            'label'=>'จำนวนการรับผู้สำเร็จการศึกษาเข้าเป็นพนักงาน (จำนวนรวม)',
            'type'=>'number',
            'id'=>'employee_amount',
            'def'=>isset($resultData)?$resultData->employee_amount:'',
             ),    
            );
            $data4=array(
         array(
            'label'=>'การสนับสนุนการจัดการศึกษาด้วยการบริจาค (หากมีการบริจาคหลายรายการให้บันทึกข้อมูลสัมฤทธิ์แยกรายการ)',
            'type'=>'text',
            'id'=>'donate_detail',
            'def'=>isset($resultData)?$resultData->donate_detail:'',
            'placeholder'=>'เช่น บริจาครถกระบะสี่ประตู',
             ),    
         array(
            'label'=>'มูลค่าการสนับสนุนการจัดการศึกษา (บาท)',
            'type'=>'number',
            'id'=>'donate_value',
            'placeholder'=>'900,000 บาท',
            'def'=>isset($resultData)?$resultData->donate_value:'',
             ),    
            
         array(
            'label'=>'การสนับสนุนการศึกษารูปแบบอื่นๆ',
            'type'=>'textarea',
            'id'=>'donate_other',
            'def'=>isset($resultData)?$resultData->donate_other:'',
            'placeholder'=>'เช่น
1) การจัดแข่งขั้นทักษะ
2) การ',
             ),    
            );
            $data5=array(
                array(
                   
                array(
                   'label'=>'โปรดระบุรายละเอียดของกิจกรรมที่ทำ',
                   'type'=>'textarea',
                   'id'=>'other_activity',
                   'def'=>isset($resultData->other_activity)?$resultData->other_activity:'',
                   'placeholder'=>'เช่น
การนำนักเรียนนักศึกษาจัดกิจกรรมปลูกป่า, การนำนักเรียนนักศึกษาและครูจัดนิทรรศการ'
                    ),    
                array(
                    'label'=>'จำนวนนักเรียนนักศึกษาที่เข้าร่วมกิจกรรม',
                    'type'=>'number',
                    'id'=>'activity_student',
                    'def'=>isset($resultData->activity_student)?$resultData->activity_student:'0',
                ),
                array(
                    'label'=>'จำนวนครู, บุคลากรทางการศึกษา และผู้บริหารที่เข้าร่วมกิจกรรม',
                    'type'=>'number',
                    'id'=>'activity_teacher',
                    'def'=>isset($resultData->activity_teacher)?$resultData->activity_teacher:'0',
                ),
                array(
                    'label'=>'แนบไฟล์รายงานสรุปโครงการ (สแกนเป็น PDF ไฟล์)',
                    'type'=>'file',
                    'id'=>'attach_file',
                    'accept'=>'application/pdf',
                    'def'=>'',
                ),
                array(
                    'label'=>'แนบไฟล์รูปภาพ (อย่างน้อย 2 รูป)',
                    'type'=>'file',
                    'id'=>'attach_picture',
                    'accept'=>'image/jpeg',
                    'def'=>'',
                ),
                ),
                   );
            $data6=array(
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );
/*
    $form=array(
        'formName'=>'ข้อมูลผลสัมฤทธิ์',
        'inputs'=>$data,
        'action'=>site_url('public/mou/saveResult'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
  */  
    //print genForm($form);

    $tab=array(
        'training'=>array(
            'title'=>'การรับนักศึกษาเข้าฝึกงานฝึกอาชีพ',
            'content'=>genInput($data2),
        ),
        'hr'=>array(
            'title'=>'การรับผู้สำเร็จเข้าทำงาน',
            'content'=>genInput($data3),
        ),
        'domate'=>array(
            'title'=>'การสนับสนุนการจัดการศึกษา',
            'content'=>genInput($data4),
        ),
        'activity'=>array(
            'title'=>'กิจกรรมความร่วมมืออื่นๆ',
            'content'=>genInput($data5),
        ),
    );
    ?>
<div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                        <form action="<?php print site_url('public/mou/resultSave'); ?>" method="post">
    <?php
    print genInput($data1).gen_tab($tab).genInput($data6);
    ?>
    </form>
    </div>
    </div>
    </div>