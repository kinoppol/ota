<?php
helper('form');
helper('user');
//print_r($mou_data);
$data=array(array(
                    'label'=>'ชื่อสถานประกอบการ',
                    'type'=>'text',
                    'id'=>'business_name',
                    'def'=>$business_data->business_name,
                    'disabled'=>true,
                ),
                array(
                    'type'=>'hidden',
                    'id'=>'mou_id',
                    'def'=>isset($mou_data)?$mou_data->mou_id:'',
                ),
                array(
                    'type'=>'hidden',
                    'id'=>'business_id',
                    'def'=>$business_data->business_id,
                ),
                array(
                    'type'=>'hidden',
                    'id'=>'org_id',
                    'def'=>current_user('org_code'),
                ),
                array(
                    'label'=>'ที่อยู่',
                    'type'=>'text',
                    'id'=>'address',
                    'def'=>'เลขที่ '.($business_data->address_no!=''?$business_data->address_no:'-').' ถนน'.($business_data->road!=''?$business_data->road:'-').' ตำบล'.$subdistrict[$business_data->subdistrict_id].' อำเภอ'.$district[$business_data->district_id].'จังหวัด'.$province[$business_data->province_id],
                    'disabled'=>true,
                ),
                array(
                    'label'=>'ระดับของความร่วมมือ',
                    'type'=>'select',
                    'id'=>'level',
                    'items'=>array(
                        '1'=>'ระดับ 1 : เกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น)',
                        '2'=>'ระดับ 2 : เกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น) และการจัดการเรียนการสอนทวิภาคี',
                        '3'=>'ระดับ 3 : เกี่ยวกับ CSR การฝึกงาน กิจกรรมเฉพาะกิจ (รวมระยะสั้น) และการจัดการเรียนการสอนทวิภาคี และมีการร่วมลงทุนระหว่างสถานประกอบการและสถานศึกษา',
                    ),
                    'def'=>isset($mou_data)?$mou_data->level:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'การลงทุนร่วมกับสถานศึกษา',
                    'type'=>'text',
                    'id'=>'investment',
                    'placeholder'=>'หากเลือกระดับความร่วมมือ ระดับ 3 โปรดระบุรายละเอียดและมูลค่าการลงทุนรวม',
                    'def'=>isset($mou_data->investment)?$mou_data->investment:'',
                ),        
                array(
                    'label'=>'กลุ่มเป้าหมายของความร่วมมือ',
                    'type'=>'check_group',
                    'id'=>'eduSup',
                    'items'=>array(
                        'educationalSupport'=>array('text'=>'นักเรียนนักศึกษา',
                                                'value'=>'Y',
                                                'checked'=>isset($mou_data->educationalSupport)?$mou_data->educationalSupport=='Y'?true:false:false,
                                                ),
                        'personalSupport'=>array('text'=>'ครูและบุคลากรทางการศึกษา',
                                                'value'=>'Y',
                                                'checked'=>isset($mou_data->personalSupport)?$mou_data->personalSupport=='Y'?true:false:false,
                                                ),
                        'executiveSupport'=>array('text'=>'ผู้บริหาร',
                                                'value'=>'Y',
                                                'checked'=>isset($mou_data->executiveSupport)?$mou_data->executiveSupport=='Y'?true:false:false,
                                                ),
                                            ),
                ),
                array(
                    'type'=>'div',
                    'id'=>'education_support',
                    'items'=>array(        
                    array(
                        'label'=>'ระดับการศึกษาที่ร่วมมือ',
                        'type'=>'check_group',
                        'id'=>'support_edu',
                        'items'=>array(
                            'support_vc_edu'=>array('text'=>'ปวช.',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_vc_edu=='Y'?true:false:false,
                                                    ),
                            'support_hvc_edu'=>array('text'=>'ปวส.',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_hvc_edu=='Y'?true:false:false,
                                                    ),
                            'support_btech_edu'=>array('text'=>'ทล.บ.',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_btech_edu=='Y'?true:false:false,
                                                    ),
                            'support_short_course'=>array('text'=>'ระยะสั้น',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_short_course=='Y'?true:false:false,
                                                    ),/*
                            'support_no_specific'=>array('text'=>'อื่นๆ',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_no_specific=='Y'?true:false:false,
                                                    ),*/
                        ),
                        'required'=>true,
                    ),
                    array(
                        'label'=>'สาขาวิชาที่ลงนาม',
                        'type'=>'text',
                        'id'=>'major',
                        'placeholder'=>'เช่น ช่างไฟฟ้ากำลัง,ช่างอิเล็กทรอนิกส์ โดยขั้นแต่ละสาขาด้วยจุลภาค (,)',
                        'def'=>isset($mou_data)?$mou_data->major:'',
                        'required'=>false,
                    ),
                    array(
                        'label'=>'เป้าหมายการรับนักศึกษาฝึกงาน/ฝึกอาชีพ (ระบุจำนวนคนรวมทุกสาขา)',
                        'type'=>'number',
                        'id'=>'dve_target',
                        'def'=>isset($mou_data)?$mou_data->dve_target:'',
                        //'required'=>true,
                    ),
                    array(
                        'label'=>'รูปแบบการจัดการศึกษา',
                        'type'=>'check_group',
                        'id'=>'dve',
                        'items'=>array(
                            'support_normal'=>array('text'=>'ระบบปกติ',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_normal=='Y'?true:false:false,
                                                    ),
                            'support_dve'=>array('text'=>'ระบบทวิภาคี',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_dve=='Y'?true:false:false,
                                                    ),
                            'support_shortcourse'=>array('text'=>'หลักสูตรวิชาชีพระยะสั้น',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_short_course=='Y'?true:false:false,
                                                    ),
                            'support_dual'=>array('text'=>'ระบบทวิศึกษา',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_dual=='Y'?true:false:false,
                                                    ),
                                                ),
                        //'required'=>true,
                    ),
                    array(
                        'label'=>'การฝึกงานในประเทศ/ต่างประเทศ',
                        'type'=>'check_group',
                        'id'=>'oversea',
                        'items'=>array(
                            'support_local_training'=>array('text'=>'มีการฝึกงานในประเทศ',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_local_training=='Y'?true:false:false,
                                                    ),
                            'support_oversea_training'=>array('text'=>'มีการฝึกงานในต่างประเทศ',
                                                    'value'=>'Y',
                                                    'checked'=>isset($mou_data)?$mou_data->support_oversea_training=='Y'?true:false:false,
                                                    ),
                                                ),
                        //'required'=>true,
                    ),
                    array(
                        'label'=>'ค่าตอบแทนการฝึกงาน/ฝึกอาชีพโดยประมาณ',
                        'type'=>'select',
                        'id'=>'wage',
                        'items'=>array(
                            '-'=>'0. ไม่ระบุค่าตอบแทน',
                            '0'=>'1. ไม่ให้ค่าตอบแทนเป็นเงิน',
                            '1'=>'2. ต่ำกว่า 150 บาท/วัน',
                            '2'=>'3. 150 - 300 บาท/วัน',
                            '3'=>'4. มากกว่า 300 บาท/วัน',
                            '4'=>'5. น้อยกว่า 6,000 บาท/เดือน',
                            '5'=>'6. 6,000 - 10,000 บาท/เดือน',
                            '6'=>'7. มากกว่า 10,000 บาท/เดือน',
                        ),
                        'def'=>isset($mou_data)?$mou_data->wage:'-',
                        'required'=>true,
                    ),
                    array(
                        'label'=>'สิทธิประโยชน์อื่นนอกจากค่าตอบแทน',
                        'type'=>'text',
                        'id'=>'benefits',
                        'placeholder'=>'เช่น ค่าที่พัก ค่าเดินทาง ค่ารถ ประกันชีวิต ทุนการศึกษา',
                        'def'=>isset($mou_data)?$mou_data->benefits:'',
                        'required'=>false,
                    ),array(
                        'label'=>'ข้อผูกมัด,พันธผูกพันกับผู้เรียน',
                        'type'=>'text',
                        'id'=>'obligation',
                        'placeholder'=>'เช่น เมื่อสำเร็จการศึกษา จะต้องทำงานชดใช้ทุน 2 ปี',
                        'def'=>isset($mou_data)?$mou_data->obligation:'',
                        'required'=>false,
                    ),
                    ),
                ),
                array(
                    'label'=>'ชื่อผู้บริหารภาครัฐที่ลงนาม',
                    'type'=>'text',
                    'id'=>'govSignName',
                    'def'=>isset($mou_data)?$mou_data->director_name:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'ตำแหน่งผู้บริหารภาครัฐ',
                    'type'=>'text',
                    'id'=>'govSignNamePosition',
                    'def'=>isset($mou_data)?$mou_data->director_type:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'ชื่อผู้บริหารสถานประกอบการ/ตัวแทนที่ลงนาม',
                    'type'=>'text',
                    'id'=>'businessSignName',
                    'def'=>isset($mou_data)?$mou_data->ceo_name:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'ตำแหน่งผู้บริหารสถานประกอบการ/ตัวแทน',
                    'type'=>'text',
                    'id'=>'businessSignNamePosition',
                    'def'=>isset($mou_data)?$mou_data->ceo_type:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'วันที่ลงนามความร่วมมือ',
                    'type'=>'date',
                    'id'=>'mou_date',
                    'def'=>isset($mou_data->mou_date)?$mou_data->mou_date:date('Y-m-d'),
                    'max'=>date(('Y-m-d'),strtotime(' + 365 day')),
                    'min'=>date(('Y-m-d'),strtotime(' - 100 year')),
                    'required'=>true,
                ),
                array(
                    'label'=>'วันที่เริ่มความร่วมมือ',
                    'type'=>'date',
                    'id'=>'mou_start_date',
                    'def'=>isset($mou_data->mou_start_date)?$mou_data->mou_start_date:date('Y-m-d'),
                    'max'=>date(('Y-m-d'),strtotime(' + 365 day')),
                    'min'=>date(('Y-m-d'),strtotime(' - 100 year')),
                    'required'=>true,
                ),
                array(
                    'label'=>'วันที่สิ้นสุดความร่วมมือ',
                    'type'=>'date',
                    'id'=>'mou_end_date',
                    'def'=>isset($mou_data->mou_end_date)?$mou_data->mou_end_date:date('Y-m-d',strtotime(' + 3 year')),
                    'max'=>date(('Y-m-d'),strtotime(' + 10 year')),
                    'min'=>date(('Y-m-d'),strtotime(' - 100 year')),
                    'required'=>true,
                ),
                array(
                    'label'=>'สถานที่ลงนาม',
                    'type'=>'text',
                    'id'=>'mou_sign_place',
                    'def'=>isset($mou_data)?$mou_data->mou_sign_place:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'วัตถุประสงค์ในการทำ MOU',
                    'type'=>'textarea',
                    'id'=>'object',
                    'placeholder'=>'เช่น
1) เพื่อพัฒนาการศึกษาระบบทวิภาคี
2) เพื่อเพิ่มทักษะของผู้เรียนอาชีวศึกษา
                    ',
                    'def'=>isset($mou_data)?$mou_data->object:'',
                    'required'=>true,
                ),
                array(
                    'label'=>'แนบไฟล์ MOU (สแกนไฟล์เอกสาร MOU ทุกหน้าเป็นไฟล์ .PDF)',
                    'type'=>'file',
                    'id'=>'mou_file',
                    'accept'=>'application/pdf',
                    'required'=>false,
                ),
                array(
                    'label'=>'แนบไฟล์ภาพถ่ายขณะลงนาม อย่างน้อย 2 ภาพ (.JPG)',
                    'type'=>'file',
                    'id'=>'mou_picture',
                    'accept'=>'image/gif, image/jpeg, image/png',
                    'required'=>false,
                    'multiple'=>true,
                ),
            array(
                'label'=>'บันทึกข้อมูล',
                'type'=>'submit',
            ),
        );
$form=array(
    'formName'=>'ข้อมูลการทำความร่วมมือ',
    'inputs'=>$data,
    'action'=>site_url('public/mou/save'),
    'method'=>'post',
    'enctype'=>'multipart/form-data',
);

$_SESSION['FOOTSYSTEM'].='
<script>
$(function(){
    
    if($("#educationalSupport").prop("checked") == true){
        $("#education_support").show();
    }else{
        $("#education_support").hide();
    }

});

    $("#educationalSupport").click(function(){
        if($("#educationalSupport").prop("checked") == true){
            $("#education_support").slideDown();
            //$("#dve_target").removeAttr("required");​​​​​
        }else{
            $("#education_support").slideUp();
            //$("#dve_target").addAttr("required");​​​​​
        }
        });
</script>
';

print genForm($form);
