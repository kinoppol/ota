<?php
function genMainMenu($data,$def=''){
    $ret='';

    $ret='<ul class="list">
    <li class="header">เมนูหลัก</li>'.(is_array($data)?genMenu($data,$def):'')
    .'   
    </li>
    </ul>
    ';
    return $ret;
}

function genMenu($data,$def){
    $ret='';
    //print $def;
    foreach($data as $row){
        if(!$row['cond']) continue;
        $active='';

        if(isset($row['items'])&&is_array($row['items'])){ 
            if(searchForUrl($def,$row['items']))$active=' class="active"';
            $ret.='<li'.$active.'>
            <a href="javascript:void(0)" class="menu-toggle">
                <i class="material-icons">'.$row['bullet'].'</i>
                <span>'.$row['text'].'</span>
            </a>
            '.genSubMenu($row['items'],$def).'
            </li>';
        }else{
            if($row['url']==$def)$active=' class="active"';
        $ret.='<li'.$active.'>
                <a href="'.$row['url'].'">
                    <i class="material-icons">'.$row['bullet'].'</i>
                    <span>'.$row['text'].'</span>
                </a>
            </li>';
        }
    }
    return $ret;
}

function genSubMenu($data,$def=''){
    $ret='<ul class="ml-menu">';
    $active='';
    foreach($data as $row){
        $active='';
        if(!$row['cond']) return '';
        if(isset($row['items'])&&is_array($row['items'])){
            if(searchForUrl($def,$row['items']))$active=' class="active"';
        $ret.='
            <li'.$active.'>
                <a href="javascript:void(0);" class="menu-toggle">
                    <span>'.$row['text'].'<span>
                </a>
                '.genSubMenu($row['items']).'
            </li>
            ';            
        }else{
            if($row['url']==$def)$active=' class="active"';
        $ret.='
            <li'.$active.'>
                <a href="'.$row['url'].'">'.$row['text'].'</a>
            </li>
            ';
        }
    }
    $ret.='</ul>';
    return $ret;
}

function searchForUrl($url='',$arr=array()){
    foreach($arr as $row){
        if(isset($row['url'])&&$row['url']==$url)return true;
        if(isset($row['items'])&&is_array($row['items'])) return searchForUrl($url,$row['items']);
    }
    return false;
}