<?php
    //print_r($schoolData);
    helper('form');
    $data=array(array(
        'label'=>'รหัสสถานศึกษา',
        'type'=>'text',
        'id'=>'school_id',
        'def'=>$schoolData->school_id,
        'disabled'=>true,
         ),
         array(
            'type'=>'hidden',
            'id'=>'school_id',
            'def'=>$schoolData->school_id,
             ),
         array(
            'label'=>'ชื่อสถานศึกษา',
            'type'=>'text',
            'id'=>'school_name',
            'def'=>$schoolData->school_name,
            'disabled'=>true,
             ),
         array(
            'label'=>'เลขที่',
            'type'=>'text',
            'id'=>'address_no',
            'def'=>$schoolData->address_no,
            'required'=>true,
             ),
         array(
            'label'=>'แขวง/ตำบล',
            'type'=>'select',
            'id'=>'subdistrict_id',
            'items'=>$subdistrictData,
            'def'=>$schoolData->subdistrict_id,
             ),
         array(
            'label'=>'เขต/อำเภอ',
            'type'=>'select',
            'id'=>'district_id',
            'items'=>$districtData,
            'def'=>$schoolData->district_id,
             ),
         array(
            'label'=>'จังหวัด',
            'type'=>'select',
            'id'=>'province_id',
            'items'=>$provinceData,
            'def'=>$schoolData->province_id,
             ),
         array(
            'label'=>'อีเมล',
            'type'=>'text',
            'id'=>'email',
            'def'=>$schoolData->email,
            'required'=>true,
             ),
         array(
            'label'=>'หมายเลขโทรศัพท์',
            'type'=>'text',
            'id'=>'phone',
            'def'=>$schoolData->phone,
            'required'=>true,
             ),
         array(
            'label'=>'โทรสาร',
            'type'=>'text',
            'id'=>'fax',
            'def'=>$schoolData->fax,
            'required'=>true,
             ),
         array(
            'label'=>'ชื่อผู้อำนวยการ',
            'type'=>'text',
            'id'=>'director_name',
            'def'=>$schoolData->director_name,
            'required'=>true,
             ),
         array(
            'label'=>'รองฯ ฝ่ายวิชาการ',
            'type'=>'text',
            'id'=>'deputy_academic_name',
            'def'=>$schoolData->deputy_academic_name,
            'required'=>true,
             ),
         array(
            'label'=>'รองฯ ฝ่ายพัฒนากิจการนักเรียนนักศึกษา',
            'type'=>'text',
            'id'=>'deputy_activity_name',
            'def'=>$schoolData->deputy_activity_name,
            'required'=>true,
             ),
         array(
            'label'=>'รองฯ ฝ่ายบริหารทรัพยากร',
            'type'=>'text',
            'id'=>'deputy_resources_name',
            'def'=>$schoolData->deputy_resources_name,
            'required'=>true,
             ),
         array(
            'label'=>'รองฯ ฝ่ายแผนงานและความร่วมมือ',
            'type'=>'text',
            'id'=>'deputy_planning_name',
            'def'=>$schoolData->deputy_planning_name,
            'required'=>true,
             ),
         array(
            'label'=>'หัวหน้างานศูนย์บ่มเพาะฯ',
            'type'=>'text',
            'id'=>'bic_supervisor_name',
            'def'=>isset($schoolData->bic_supervisor_name)?$schoolData->bic_supervisor_name:'',
            'required'=>true,
             ),
             
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'formName'=>'ข้อมูลสถานศึกษา',
        'inputs'=>$data,
        'action'=>site_url('public/school/saveSchool'),
        'method'=>'post',
        'enctype'=>'multipart/form-data',
    );
    
    print genForm($form);

