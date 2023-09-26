<?php

function ind_tree($mission_id,$school_id){
    $tree=array();
		$indicatorModel = model('App\Models\IndicatorModel');
		$evaModel = model('App\Models\EvaluateModel');

            $tree=sub_tree($mission_id,0,$school_id); 

    return $tree;
}

function sub_tree($mission_id,$indicator_id,$school_id){
    $sTree=array();
    $indicatorModel = model('App\Models\IndicatorModel');
    $evaModel = model('App\Models\EvaluateModel');
    $data=array(
        'mission_id'=>$mission_id,
        'parent_id'=>$indicator_id,
    );
    $indicators=$indicatorModel->getIndicator($data);
    if($indicators){
        foreach($indicators as $ind){
        $sTree[$ind->id]=array(
            'subject'=>$ind->subject,
            'item'=>sub_tree($mission_id,$ind->id,$school_id),
        );
        }
    }else{
            $sTree=eva_tree($indicator_id,$school_id);
    }
    return $sTree;
}

function eva_tree($indicator_id,$school_id){
    $evaModel = model('App\Models\EvaluateModel');
    $data=array(
        'indicator_id'=>$indicator_id,
        'school_id'=>$school_id,
    );	
    $submissionData=$evaModel->getSubmissionData($data);
    if(!$submissionData)return array('file'=>false,'pic'=>false);
    $file=json_decode($submissionData->attach_file,true);
    $tree=array(
        'file'=>count($file),
        'pic'=>$submissionData->picture!=''?1:0,
        'comment'=>$submissionData->comment!=''?1:0,
    );
    return $tree;
}
function draw_tree($l=0,$tree,$indicator_id=false){
if($indicator_id){
    $indicatorModel = model('App\Models\IndicatorModel');

    $indicator=$indicatorModel->getIndicatorData($indicator_id);


$PIC=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-success"><i class="material-icons">image</i></a>';
$PDF=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-danger"><i class="material-icons">picture_as_pdf</i></a>';
$COM=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-primary"><i class="material-icons">comment</i></a>';
$noPIC=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-default"><i class="material-icons">image</i></a>';
$noPDF=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-default"><i class="material-icons">picture_as_pdf</i></a>';
$noCOM=' <a href="'.site_url('public/evaluate/submitForm/'.$indicator->mission_id.'/'.$indicator_id).'" class="btn btn-xs btn-default"><i class="material-icons">comment</i></a>';
  }
    helper('string');
    $l++;
    $res='';
    if(isset($tree['pic'])||isset($tree['file'])){
        $res.='<br>';
        for($i=1;$i<$l;$i++){
            $res.='- ';
        }
    if(isset($tree['pic'])&&$tree['pic']==true){$res.=$PIC;}else{$res.=$noPIC;}
    if(isset($tree['pic'])&&$tree['file']==true){$res.=$PDF;}else{$res.=$noPDF;}
    if(isset($tree['pic'])&&$tree['comment']==true){$res.=$COM;}else{$res.=$noCOM;}
    }else{
    foreach($tree as $k=>$b){
        $res.='<br>';
    for($i=1;$i<$l;$i++){
        $res.='- ';
    }
    //print_r($b);
        $res.=isset($b['subject'])&&is_array($b)?strlim($b['subject'],100):'';
        $res.=isset($b['item'])&&is_array($b['item'])?draw_tree($l,$b['item'],$k):'';
    }
    }
    return $res;
}

function treetotable($l=0,$tree,$arr=array(),$indicator_id=false){
    foreach($tree as $k=>$t){

        //$l++;
        if(!isset($t['subject'])||$t['subject']==''){
            $arr[$l]['eva']=true;
            continue;
        }
        $l++;
        $arr[$l]['subject']=is_array($t)?$t['subject']:'';
        $arr[$l]['child']=count($t['item']);
        $arr[$l]['eva_child']=count_eva_child($t['item']);
        $arr[$l]['id']=$k;
        if(isset($t['item'])&&is_array($t['item'])){
            list($l,$arr)=treetotable($l,$t['item'],$arr,$k);
        }
    }
    return array($l,$arr);
}

function count_eva_child($arr){
    $c=0;
    //print_r($arr);
    //print "XX<br>";
    foreach($arr as $row){
        //print_r($row);
        //print "<br>";
        if(isset($row['item']['comment'])||isset($row['item']['pic'])||isset($row['item']['file'])){
                $c++;
                //print "+<br>";
        }
    }
    //print '['.$c.']<br>';
    return $c;

}

function subSubjectName($str){
    $arr=explode(' ',$str);
    $typeName=$arr[0];
    $subject=$arr[1];
    return $typeName.' '.$subject;
}