<?php
helper('form');
helper('user');
//print_r($registerData);
$vec=array(
    '1300000000'=>'สำนักงานคณะกรรมการอาชีวศึกษา',
    //'1300000001'=>'สำนักความร่วมมือ',
);
$orgs=$vec;
$orgSchools=array();
foreach($schools as $k=>$v){
    $orgSchools[$k]=$v;
    $orgs[$k]=$v;
}

$orgInstitutes=array();
foreach($institutes as $k=>$v){
    $orgInstitutes[$k]=$v;
    $orgs[$k]=$v;
}
//print_r($orgData);
$orgData=array(
    'สอศ.'=>$vec,
    'สถานศึกษา'=>$orgSchools,
    //'สถาบันการอาชีวศึกษา'=>$orgInstitutes,
);

$userType=array(
    'school'=>'สถานศึกษา',
    'committee'=>'กรรมการ',
    //'institute'=>'สถาบันการอาชีวศึกษา',
    //'board'=>'ผู้บริหารสำนักงานคณะกรรมการอาชีวศึกษา',
    //'admin'=>'ผู้ดูแลระบบ',
);

$data=array(array(
                    'label'=>'ชื่อ',
                    'type'=>'text',
                    'id'=>'name',
                    'def'=>current_user('name'),
                    'required'=>true,
                ),
                array(
                    'label'=>'นามสกุล',
                    'type'=>'text',
                    'id'=>'surname',
                    'def'=>current_user('surname'),
                    'required'=>true,
                ),
                array(
                    'label'=>'ตำแหน่ง',
                    'type'=>'text',
                    'id'=>'position',
                    'required'=>true,
                    'def'=>isset($registerData->position)?$registerData->position:false,
                ),
                array(
                    'label'=>'หมายเลขโทรศัพท์',
                    'type'=>'text',
                    'id'=>'tel',
                    'required'=>true,
                ),
                array(
                    'label'=>'อีเมล',
                    'type'=>'email',
                    'id'=>'email',
                    'def'=>current_user('email'),
                    'required'=>true,
                ),
                array(
                'label'=>'ประเภทผู้ใช้งาน',
                'type'=>'select',
                'id'=>'user_type',
                'class'=>'show-tick',
                'search'=>'true',
                'items'=>$userType,
                'noneLabel'=>'โปรดเลือกประเภทผู้ใช้งาน',
                'required'=>true,
                'def'=>isset($registerData->user_type)?$registerData->user_type:false,
            ),
            array(
                'label'=>'ต้นสังกัด/สถานศึกษา',
                'type'=>'select',
                'id'=>'org_code',
                'class'=>'show-tick',
                'search'=>'true',
                'items'=>$orgData,
                'noneLabel'=>'โปรดเลือกต้นสังกัด/สถานศึกษา',
                'required'=>true,
                'def'=>isset($registerData->org_code)?$registerData->org_code:false,
            ),
            array(
                'label'=>'ลงทะเบียนผู้ใช้งาน',
                'type'=>'submit',
            ),
        );
$form=array(
    'formName'=>'ลงทะเบียนผู้ใช้งานใหม่/แก้ไขการลงทะเบียน',
    'inputs'=>$data,
    'action'=>site_url('public/user/register'),
    'method'=>'post',
);
?>
<div class="card">
    <div class="header">
        <h2>
            ข้อมูลการลงทะเบียน
        </h2>
        <div class="body">
        <?php
            if(!isset($registerData->user_type)){
                print "คุณยังไม่ได้ลงทะเบียน กรุณาดำเนินการลงทะเบียนด้วยแบบฟอร์มด้านล่าง";
            }else{
                print "คุณได้ทำการลงทะเบียนในฐานะ <b>";
                print user_type($registerData->user_type);
                print "</b>";
                print " สังกัด ".$orgs[$registerData->org_code];
                print " สถานะ ";
            }
            $status=empty($registerData->register_status)?'null':$registerData->register_status;
            switch($status){
                case 'request' : print '<button class="btn btn-primary">รอการอนุมัติ</button>'; break;
                case 'disapproval' : print '<button class="btn btn-danger">ปฏิเสธการลงทะเบียน</button> โปรดทำการลงทะเบียนใหม่'; break;
                case 'banned' : print '<button class="btn btn-default">ห้ามลงทะเบียน</button>'; break;
                case 'approved' : print '<a href="'.site_url('public/user/logout').'" class="btn btn-success">อนุมัติแล้ว</a> คลิกที่ปุ่มเพื่อเข้าสู่ระบบใหม่'; break;
                default : print ' '; break;
            }
        ?>
        </div>
    </div>
</div>
<?php
if($status!='banned'&&$status!='approved')
print genForm($form);
?>