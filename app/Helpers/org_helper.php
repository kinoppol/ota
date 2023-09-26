<?php

function org_name($org_id=false){
    if(!$org_id) return false;
    $orgModel = model('App\Models\OrgModel');

        if(!isset($_SESSION['ORG'])){
            $schools=$orgModel->getSchool();
            $institute=$orgModel->getInstitute();
            $_SESSION['ORG']=$schools+$institute;
        }
        $_SESSION['ORG']['1300000000']='สำนักงานคณะกรรมการการอาชีวศึกษา';
        //print_r($_SESSION['ORG']);
        return $_SESSION['ORG'][$org_id];
}

function orgArr($orgIds=array()){
    $orgModel = model('App\Models\OrgModel');

        if(!isset($_SESSION['ORG'])){

            $_SESSION['ORG']=array();
            $_SESSION['ORG']['1300000000']='สำนักงานคณะกรรมการการอาชีวศึกษา';
            $schools=$orgModel->getSchool();
            $institute=$orgModel->getInstitute();
            $_SESSION['ORG']+=$institute+$schools;
        }
        if(is_array($orgIds)&&count($orgIds)>0){
            $org=array();
            if(count($orgIds)>1){
                $org['all']='ทุกหน่วยงานในสังกัด '.org_name(current_user('org_code'));
                $_SESSION['subORG']=$orgIds;
            }else{

                $_SESSION['subORG']=array();
            }
            foreach($orgIds as $id){
                $org[$id]=$_SESSION['ORG'][$id];
            }
            return $org;
        }else{

            $org['all']='ทุกหน่วยงานในสังกัด '.org_name(current_user('org_code'));
            $_SESSION['subORG']='*';
            if(current_user('org_code')=='1300000000'){//สำนักความร่วมมือให้เพิ่มจังหวัดและภาค
                $province=$orgModel->getProvince();
                $zone=$orgModel->getZone();
                $provinceData=array();
                $zoneData=array();
                foreach($province as $k=>$v){
                    $provinceData['p'.$k]='สถานศึกษาในจังหวัด'.$v;
                }

                foreach($zone as $k=>$v){
                    $zoneData['z'.$k]='สถานศึกษาในภาค'.$v;
                }

                return $org+=$_SESSION['ORG']+$provinceData+$zoneData;
            }else{
                return $org+=$_SESSION['ORG'];
            }
        }

        return $_SESSION['ORG'];
}

function govArr($gov_ids=false){
    $orgModel = model('App\Models\OrgModel');

    $govs=$orgModel->getGov();
        if(!$gov_ids){
            return $govs;
        }else{
            $gov=array();
            foreach($gov_ids as $id){
                $gov[$id]=$govs[$id];
            }
        }
        return $gov;
}

function org_ids($org_id=false){
    if(!$org_id)$org_id=current_user('org_code');
    $org_ids=array();
    if(mb_strlen($org_id)<10){
        //$org_type_name=' อ.กรอ.อศ. ';
        $org_ids[]=$org_id;

		$govModel = model('App\Models\GovModel');
		$govData=$govModel->getGovData($org_id);
        $gov_school=$govData->gov_school_id;
        $gov_school=explode(',',$gov_school);
        $org_ids+=$gov_school;

    }else if(mb_substr($org_id,2,1)!=0){
        //$org_type_name=' สถานศึกษา ';
        $org_ids[]=$org_id;
    }else if($org_id=='1300000000'){
        //$org_type_name=' สอศ. ';
        $org_ids=false;
    }else{
        //$org_type_name='สถาบันการอาชีวศึกษา';
        $org_ids[]=$org_id;
        $instituteModel = model('App\Models\InstituteModel');
		$school_id=$instituteModel->getSchool($org_id);
        $org_ids+=$school_id;
    }
    return $org_ids;
}

function gov_ids($org_id=false){
    if(!$org_id)$org_id=current_user('org_code');
    $org_ids=array();
    if(mb_strlen($org_id)<10){
        //$org_type_name=' อ.กรอ.อศ. ';
        $org_ids[]=$org_id;


    }else if(mb_substr($org_id,2,1)!=0){
        //$org_type_name=' สถานศึกษา ';
    }else if($org_id=='1300000000'){
        //$org_type_name=' สอศ. ';
        $org_ids=false;
    }else{
        //$org_type_name='สถาบันการอาชีวศึกษา';
    }
    return $org_ids;
}


function provinceName($provinceCode){
    if(!isset($_SESSION['province'])){
    $orgModel = model('App\Models\OrgModel');
    $province=$orgModel->getProvince();
    foreach($province as $k=>$v){
        $provinceData[$k]=$v;
    }
    $_SESSION['province']=$provinceData;
    }
        return $_SESSION['province'][$provinceCode];
}
function zoneName($zone_id){
    if(!isset($_SESSION['zone'])){
    $orgModel = model('App\Models\OrgModel');
    $zone=$orgModel->getZone();
    foreach($zone as $k=>$v){
        $zoneData[$k]=$v;
    }
    $_SESSION['zone']=$zoneData;
    }
        return $_SESSION['zone'][$zone_id];
}

function schoolInProvince($provinceCode){

    $orgModel = model('App\Models\OrgModel');
    $data=array(
        'province_id'=>$provinceCode
    );
    $schoolData=$orgModel->getSchool($data);
    $data=array();
    foreach($schoolData as $k=>$v){
        array_push($data,$k);
    }
    return $data;
}
function schoolInZone($zone_id){

    $orgModel = model('App\Models\OrgModel');
    $data=array(
        'zone_id'=>$zone_id,
    );
    $schoolData=$orgModel->getSchool($data);
    $data=array();
    foreach($schoolData as $k=>$v){
        array_push($data,$k);
    }
    return $data;
}
