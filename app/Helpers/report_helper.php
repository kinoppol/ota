<?php
function yearFilter($data){
    $ret='
		<div class="row clearfix">
		<form method="post">
		<input type="hidden" name="title" value="'.$data['title'].'">
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-3">
		'.$data['label'].'
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-3">
		<div class="form-group">
		<div class="form-line">'.filterSelectYear('year',false,false,(isset($_POST['year'])?$_POST['year']:date('Y'))).'
		</div>
		</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-3">
		<div class="form-group">
		<div class="form-line">
		<button class="btn btn-primary form-control"><i class="material-icons">search</i> ตกลง</button>
		</div>
		</div>
		</div>
		<div class="col-lg-2 col-md-6 col-sm-6 col-xs-3">
		<div class="form-group">
		<div class="form-line">
		<button name="export" formaction="'.$data['title'].'/print" formtarget="_blank" class="btn btn-danger form-control"><i class="material-icons">picture_as_pdf</i> พิมพ์รายงาน</button>
		</div>
		</div>
		</div>
		</form>
		</div>';
    return $ret;
}

function orgYearFilter($data){
    helper('form');
    helper('org');
    $orgSelect=array(
        'id'=>"org_id",
        'label'=>"หน่วยงาน",
        'search'=>true,
        'items'=>orgArr(isset($data['org_ids'])?$data['org_ids']:false),
        'def'=>(isset($_POST['org_id']))?$_POST['org_id']:current_user('org_code'),
    );
    $yearSelect=array(
        'id'=>'year',
        'label'=>$data['label'],
        'items'=>filterOptionYear(false,false),
        'def'=>(isset($_POST['year'])?$_POST['year']:date('Y')),
    );
    $ret='
		<div class="row clearfix">
		<form method="post">
		<input type="hidden" name="title" value="'.$data['title'].'">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.genInput_select($yearSelect).'
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.genInput_select($orgSelect).'
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"">
		<div class="form-group">
		<div class="form-line">
		<button class="btn btn-primary form-control"><i class="material-icons">search</i> ตกลง</button>
		</div>
		</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"">
		<div class="form-group">
		<div class="form-line">
		<button name="export" formaction="'.$data['title'].'/print" formtarget="_blank" class="btn btn-danger form-control"><i class="material-icons">picture_as_pdf</i> พิมพ์รายงาน</button>
		</div>
		</div>
		</div>
		</form>
		</div>';
    return $ret;
}


function govYearFilter($data){
    helper('form');
    helper('org');
    $orgSelect=array(
        'id'=>"org_id",
        'label'=>"หน่วยงาน",
        'search'=>true,
        'items'=>govArr(isset($data['org_ids'])?$data['org_ids']:false),
        'def'=>(isset($_POST['org_id']))?$_POST['org_id']:current_user('org_code'),
    );
    $yearSelect=array(
        'id'=>'year',
        'label'=>$data['label'],
        'items'=>filterOptionYear(false,false),
        'def'=>(isset($_POST['year'])?$_POST['year']:date('Y')),
    );
    $ret='
		<div class="row clearfix">
		<form method="post">
		<input type="hidden" name="title" value="'.$data['title'].'">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.genInput_select($yearSelect).'
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">'.genInput_select($orgSelect).'
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"">
		<div class="form-group">
		<div class="form-line">
		<button class="btn btn-primary form-control"><i class="material-icons">search</i> ตกลง</button>
		</div>
		</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"">
		<div class="form-group">
		<div class="form-line">
		<button name="export" formaction="'.$data['title'].'/print" formtarget="_blank" class="btn btn-danger form-control"><i class="material-icons">picture_as_pdf</i> พิมพ์รายงาน</button>
		</div>
		</div>
		</div>
		</form>
		</div>';
    return $ret;
}

function signBox($data=array()){
    if(mb_strlen($data['org_code'])<10){
		$orgModel = model('App\Models\OrgModel');
		$govModel = model('App\Models\GovModel');
		$govData=$govModel->getGovData($data['org_code']);
        if($govData->secretary_school_id==''){
            $data=array(
                'org_name'=>$data['org_name'],
            );
            $signBox=govSignBox($data);
            return $signBox;
        }
		$schoolData=$orgModel->schoolData($govData->secretary_school_id);

        $assistant_secretary_position=isset($govData)?$govData->assistant_secretary_position.'_name':false;
        $secretary_position=isset($govData)?$govData->secretary_position.'_name':false;
        $data=array(
            'org_name'=>$data['org_name'],
            'nameP1'=>isset($govData->supervisor_name)?$govData->supervisor_name:false,
            'nameP2'=>isset($schoolData)?$schoolData->$assistant_secretary_position:false,
            'nameP3'=>isset($schoolData)?$schoolData->$secretary_position:false,
        );
        $signBox=govSignBox($data);
    }else if(mb_substr($data['org_code'],2,1)!=0){

		$orgModel = model('App\Models\OrgModel');
		$schoolData=$orgModel->schoolData($data['org_code']);
        $data=array(
            'org_name'=>$data['org_name'],
            'nameP1'=>$schoolData->co_supervisor_name,
            'nameP2'=>$schoolData->deputy_planning_name,
            'nameP3'=>$schoolData->director_name,
        );
        $signBox=schoolSignBox($data);
    }else if($data['org_code']=='1300000000'){

		$bocModel = model('App\Models\BocModel');
        $bocData=$bocModel->bocData();
        $data=array(
            'org_name'=>$data['org_name'],
            'nameP1'=>$bocData->supervisor_name,
            'nameP2'=>$bocData->director_group_name,
            'nameP3'=>$bocData->director_name,
        );
        $signBox=bocSignBox($data);

    }else{

    $instituteModel = model('App\Models\InstituteModel');
    $insitute_data=$instituteModel->getInstituteData($data['org_code']);

        $data=array(
            'org_name'=>$data['org_name'],
            'nameP1'=>$insitute_data->supervisor_name,
            'nameP2'=>$insitute_data->deputy_name,
            'nameP3'=>$insitute_data->director_name,
        );
        $signBox=instituteSignBox($data);
    }
    return $signBox;
}
function org_type_name($data=array()){

    if(mb_strlen($data['org_code'])<10){
        $org_type_name=' อ.กรอ.อศ. ';
    }else if(mb_substr($data['org_code'],2,1)!=0){
        $org_type_name='สถานศึกษา';
    }else if($data['org_code']=='1300000000'){
        $org_type_name='สำนักงานคณะกรรมการการอาชีวศึกษา';
    }else{
        $org_type_name='สถาบันการอาชีวศึกษา';
    }
    return $org_type_name;
}
function schoolSignBox($data=array()){

        $signData=array(
            'nameP1'=>isset($data['nameP1'])?$data['nameP1']:false,
            'nameP2'=>isset($data['nameP2'])?$data['nameP2']:false,
            'nameP3'=>isset($data['nameP3'])?$data['nameP3']:false,
            'positionP1'=>'หัวหน้างานความร่วมมือ<br>&nbsp;',
            'positionP2'=>'รองฯ ฝ่ายแผนงานและความร่วมมือ <br>'.(isset($data['org_name'])?$data['org_name']:''),
            'positionP3'=>'ผู้อำนวยการวิทยาลัย <br>'.(isset($data['org_name'])?$data['org_name']:''),
        );
        return genSignBox($signData);
}

function instituteSignBox($data=array()){

    $signData=array(
            'nameP1'=>isset($data['nameP1'])?$data['nameP1']:false,
            'nameP2'=>isset($data['nameP2'])?$data['nameP2']:false,
            'nameP3'=>isset($data['nameP3'])?$data['nameP3']:false,
        'positionP1'=>'ผู้จัดทำข้อมูล<br>&nbsp;',
        'positionP2'=>'รองผู้อำนวยการ'.(isset($data['org_name'])?$data['org_name']:'').'<br>&nbsp;',
        'positionP3'=>'ผู้อำนวยการ'.(isset($data['org_name'])?$data['org_name']:'').'<br>&nbsp;',
    );
    return genSignBox($signData);
}

function govSignBox($data=array()){

    $signData=array(
            'nameP1'=>isset($data['nameP1'])?$data['nameP1']:false,
            'nameP2'=>isset($data['nameP2'])?$data['nameP2']:false,
            'nameP3'=>isset($data['nameP3'])?$data['nameP3']:false,
        'positionP1'=>'ผู้จัดทำข้อมูล<br>&nbsp;',
        'positionP2'=>'อนุกรรมการและผู้ช่วยเลขานุการ อ.กรอ.อศ. <br>'.(isset($data['org_name'])?$data['org_name']:''),
        'positionP3'=>'อนุกรรมการและเลขานุการ อ.กรอ.อศ. <br>'.(isset($data['org_name'])?$data['org_name']:''),
    );
    return genSignBox($signData);
}

function bocSignBox($data=array()){

    $signData=array(
            'nameP1'=>isset($data['nameP1'])?$data['nameP1']:false,
            'nameP2'=>isset($data['nameP2'])?$data['nameP2']:false,
            'nameP3'=>isset($data['nameP3'])?$data['nameP3']:false,
        'positionP1'=>'ผู้จัดทำข้อมูล<br>&nbsp;',
        'positionP2'=>'ผู้อำนวยการกลุ่ม...<br>&nbsp;',
        'positionP3'=>'ผู้อำนวยการสำนักความร่วมมือ<br>&nbsp;',
    );
    return genSignBox($signData);
}


function filterSelectYear($id,$MAXY=false,$MINY=false,$def=false){
    if(!$MAXY)$MAXY=date('Y')+1;
    if(!$MINY)$MINY=date('Y')-5;
    $ret='<select id="'.$id.'" name="'.$id.'" class="form-control">';

$option='';
    for($i=$MAXY;$i>$MINY;$i--){
        $select='';
        if($def==$i)$select=' selected';
        $option.='<option value="'.$i.'"'.$select.'>'.($i+543).'</option>
        ';
    }
    

$ret.=$option.'</select>  ';

return $ret;
}

function filterOptionYear($MAXY=false,$MINY=false){
    if(!$MAXY)$MAXY=date('Y')+1;
    if(!$MINY)$MINY=date('Y')-5;
$option=array();
    for($i=$MAXY;$i>$MINY;$i--){
        $option[$i]=$i+543;
    }

return $option;
}

function genSignBox($data=array()){
    $signLine='.......................................';
    $nameP1=$nameP2=$nameP3='.......................................';
    $positionP1=$positionP2=$positionP3='.......................................';
    if(isset($data['nameP1'])&&$data['nameP1']!='')$nameP1=$data['nameP1'];
    if(isset($data['nameP2'])&&$data['nameP2']!='')$nameP2=$data['nameP2'];
    if(isset($data['nameP3'])&&$data['nameP3']!='')$nameP3=$data['nameP3'];
    
    if(isset($data['positionP1'])&&$data['positionP1']!='')$positionP1=$data['positionP1'];
    if(isset($data['positionP2'])&&$data['positionP2']!='')$positionP2=$data['positionP2'];
    if(isset($data['positionP3'])&&$data['positionP3']!='')$positionP3=$data['positionP3'];

    $ret='<table width="100%">
    <tr>
        <td style="text-align:center;" vlign="top">
        <br>
        '.$signLine.'<br>
        ('.$nameP1.')<br>
        '.$positionP1.'<br>
        </td>
        <td style="text-align:center;" vlign="top">
        <br>
        '.$signLine.'<br>
        ('.$nameP2.')<br>
        '.$positionP2.'<br>
        </td>
        <td style="text-align:center;" vlign="top">
        <br>
        '.$signLine.'<br>
        ('.$nameP3.')<br>
        '.$positionP3.'<br>
        </td>
    </tr>
    </table>';

    return $ret;
}