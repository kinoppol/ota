<?php
    //print_r($schoolData);
    helper('form');
    $data=array(array(
        'label'=>'ชื่อประธาน อ.กรอ.อศ.',
        'type'=>'text',
        'id'=>'president_name',
        'def'=>$govData->president_name,
        'required'=>true,
         ),
         array(
        'type'=>'hidden',
        'id'=>'gov_id',
        'def'=>$govData->gov_id,
         ),
        array(
        'label'=>'สถานศึกษาเลขานุการ อ.กรอ.อศ.',
        'type'=>'select',
        'id'=>'secretary_school_id',
        'class'=>'show-tick',
        'items'=>$schools,
        'noneLabel'=>'โปรดเลือกสถานศึกษาที่ทำหน้าที่เลขานุการฯ',
        'def'=>$govData->secretary_school_id,
        'required'=>true,
        ),
        array(
        'label'=>'เลขานุการ อ.กรอ.อศ.',
        'type'=>'select',
        'id'=>'secretary_position',
        'class'=>'show-tick',
        'items'=>array(
            'director'=>'ผู้อำนวยการวิทยาลัย',
            'deputy_academic'=>'รองฯ ฝ่ายวิชาการ',
            'deputy_activity'=>'รองฯ ฝ่ายพัฒนากิจการนักเรียนนักศึกษา',
            'deputy_resources'=>'รองฯ ฝ่ายบริหารทรัพยากร',
            'deputy_planning'=>'รองฯ ฝ่ายแผนงานและความร่วมมือ',
        ),
        'def'=>$govData->secretary_position,
        'required'=>true,
        ),
        array(
        'label'=>'ผู้ช่วยเลขานุการ อ.กรอ.อศ.',
        'type'=>'select',
        'id'=>'assistant_secretary_position',
        'class'=>'show-tick',
        'items'=>array(
            'deputy_academic'=>'รองฯ ฝ่ายวิชาการ',
            'deputy_activity'=>'รองฯ ฝ่ายพัฒนากิจการนักเรียนนักศึกษา',
            'deputy_resources'=>'รองฯ ฝ่ายบริหารทรัพยากร',
            'deputy_planning'=>'รองฯ ฝ่ายแผนงานและความร่วมมือ',
        ),
        'def'=>isset($govData->assistant_secretary_position)&&$govData->assistant_secretary_position!=''?$govData->assistant_secretary_position:'deputy_planning',
        'required'=>true,
        ),
        array(
        'label'=>'ชื่อผู้จัดทำข้อมูล อ.กรอ.อศ./ผู้ได้รับมอบหมาย',
        'type'=>'text',
        'id'=>'supervisor_name',
        'def'=>isset($govData->supervisor_name)?$govData->supervisor_name:'',
        'required'=>true,
         ),
        array(
        'label'=>'สถานศึกษาใน อ.กรอ.อศ. (เลือกสถานศึกษาภายใต้กลุ่ม อ.กรอ.อศ. ให้ครบทุกสถานศึกษา)',
        'type'=>'select',
        'id'=>'gov_school_id[]',
        'class'=>'show-tick',
        'items'=>$schools,
        'noneLabel'=>'โปรดเลือกสถานศึกษาที่อยู่ใน อ.กรอ.อศ.',
        'def'=>explode(',',$govData->gov_school_id),
        'multiple'=>true,
        'required'=>true,
        ),
        
        array(
            'label'=>'สาขางาน',
            'type'=>'select',
            'id'=>'gov_minor[]',
            'class'=>'show-tick',
            'items'=>$minors,
            'noneLabel'=>'โปรดเลือกสาขางานของผู้เรียนที่อยู่ใน อ.กรอ.อศ.',
            'def'=>isset($govData->gov_minor)?explode(',',$govData->gov_minor):'',
            'multiple'=>true,
            'required'=>true,
            ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'formName'=>'ข้อมูล อ.กรอ.อศ.',
        'inputs'=>$data,
        'action'=>site_url('public/gov/saveGov'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    print genForm($form);

