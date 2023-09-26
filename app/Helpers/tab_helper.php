<?php
function gen_tab($data=array(),$def=false){
    $ret='<ul class="nav nav-tabs" role="tablist">';
    $tab='';
    $tabArea='';
    $ti=0;
    foreach($data as $k=>$v){
        $active='';
        if($def==$k||(!$def&&$ti==0)){
            $active=' active';
        }
        $ti++;
        $tab.='<li role="presentation"  class="'.$active.'"><a href="#'.$k.'" aria-controls="'.$k.'" role="tab" data-toggle="tab">'.$v['title'].'</a></li>';
        $tabArea.='<div role="tabpanel" class="tab-pane fade in'.$active.'" id="'.$k.'">
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <div class="media">
                '.$v['content'].'
                </div>
            </div>
        </div>
        </div>
                    ';
    }
    $ret.=$tab.'</ul><div class="tab-content">'.$tabArea.'</div>';
    return $ret;
}