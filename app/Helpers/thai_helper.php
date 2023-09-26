<?php


function thailand_autocomplete_init(){
    return '<script type="text/javascript" src="'.site_url("js/thailand/jquery.Thailand.js/dependencies/JQL.min.js",true).'"></script>
    <script type="text/javascript" src="'.site_url("js/thailand/jquery.Thailand.js/dependencies/typeahead.bundle.js",true).'"></script>
    <link rel="stylesheet" href="'.site_url("js/thailand/jquery.Thailand.js/dist/jquery.Thailand.min.css",true).'">
    <script type="text/javascript" src="'.site_url("js/thailand/jquery.Thailand.js/dist/jquery.Thailand.min.js",true).'"></script>
';
}

function thailand_autocomplete($inputData){
    global $systemFoot;
	$ret='';
	static $TAInit=false;
	if(!$TAInit){
		$systemFoot.=thailand_autocomplete_init();
    }
    $systemFoot.='
    <script>
    $.Thailand({ 
        database: \''.site_url("js/thailand/jquery.Thailand.js/database/db.json",true).'\', // path หรือ url ไปยัง database
        $district: $(\'#'.$inputData['subdistrict_id'].'\'), // input ของตำบล
        $amphoe: $(\'#'.$inputData['district_id'].'\'), // input ของอำเภอ
        $province: $(\'#'.$inputData['province_id'].'\'), // input ของจังหวัด
        $zipcode: $(\'#'.$inputData['postcode_id'].'\'), // input ของรหัสไปรษณีย์
    });
    </script>
    ';
}

function dateThai($strDate,$fullM=false,$thNum=false,$fullY=false){
    $strMonthFull = array("","มกราคม",
"กุมภาพันธ์",
"มีนาคม",
"เมษายน",
"พฤษภาคม",
"มิถุนายน",
"กรกฎาคม",
"สิงหาคม",
"กันยายน",
"ตุลาคม",
"พฤศจิกายน",
"ธันวาคม");

         $strYear = date("Y",strtotime($strDate))+543;
         $strMonth= date("n",strtotime($strDate));
         $strDay= date("j",strtotime($strDate));
         $strHour= date("H",strtotime($strDate));
         //$strMinute= date("i",strtotime($strDate));
         //$strSeconds= date("s",strtotime($strDate));
         $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
         
                              if($fullM){
                                 
         $strMonthThai=$strMonthFull[$strMonth];
                              }else{
         $strMonthThai=$strMonthCut[$strMonth];
                              }
                              if($fullY){
                               ;  
                              }else{
         $strYear=mb_substr($strYear,2,2);
                              }
         $ret= "$strDay $strMonthThai $strYear";//, $strHour:$strMinute";
       if($thNum)$ret=thaiNum($ret);
       return $ret;
     }
     function thaiNum($str){
        $thNum=array(
           '0'=>'๐',
           '1'=>'๑',
           '2'=>'๒',
           '3'=>'๓',
           '4'=>'๔',
           '5'=>'๕',
           '6'=>'๖',
           '7'=>'๗',
           '8'=>'๘',
           '9'=>'๙',);
        return strtr($str,$thNum);
     }