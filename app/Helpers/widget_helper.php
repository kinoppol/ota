<?php
helper('array');
function genWidget($data){
    $ret='';
    if(is_marray($data)){
        foreach($data as $row){
            $ret.=genWidget($row);
        }
    }else{
        if(!isset($data['class'])){
            $class='col-lg-3 col-md-3 col-sm-6 col-xs-12';
        }else{
            $class=$data['class'];
        }
    $ret='<div class="'.$class.'">
                    <div style="cursor:pointer;" class="info-box hover-zoom-effect bg-'.($data['color']==''?'blue':$data['color']).' hover-expand-effect">
                    <div class="icon">
                            <i class="material-icons">'.$data['icon'].'</i>
                        </div>
                        <div class="content">
                            <div class="text">'.$data['text'].'</div>
                            <div class="number count-to" data-from="0" data-to="'.$data['number'].'" data-speed="2000" data-fresh-interval="1"></div>
                        </div>
                    </div>
                </div>';
    }
    if(isset($data['url']))$ret='<a href="'.$data['url'].'">'.$ret.'</a>';
    return $ret;
}
