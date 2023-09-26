<?php

function pic_widget($pic){
    $ret='';
    $picData=explode('/',$pic['url']);
    $picName=end($picData);
    
            $ret='<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="'.$pic['url'].'" class="picView" picName="'.$picName.'" onClick="return false;">
                    <img class="gallery_image" width="200" height="200" class="img-responsive thumbnail" src="'.$pic['url'].'">
                </a>
            </div>';
    return $ret;
}

function pic_link($pic){
    $ret='';
    $picData=explode('/',$pic['url']);
    $picName=end($picData);
    
            $ret='<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <a href="'.$pic['url'].'" class="picView" picName="'.$picName.'" onClick="return false;">
                    <a href="'.$pic['url'].'" target="_blank"><img class="gallery_image" width="200" height="200" class="img-responsive thumbnail" src="'.$pic['url'].'"></a>
                </a>
            </div>';
    return $ret;
}

function pdf_widget($file){
    helper('string');
    $ret='
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="text-align:center;">
                                                <a href="'.$file['url'].'" class="fileView" fileName="'.$file['file'].'" onClick="return false;">
                                                    <img class="gallery_image" width="50" height="pdf" class="img-responsive thumbnail" src="'.site_url('images/pdf-icon.png').'"><br>
                                                    '.strlim($file['name'],30,'...'.mb_substr($file['name'],mb_strlen($file['name'])-10,10)).'
                                                </a>
                                            </div>
    ';
    return $ret;
}



function pdf_link($file){
    helper('string');
    $ret='
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="text-align:center;">
                                                <a href="'.$file['url'].'" target="_blank" class="fileView" fileName="'.$file['file'].'">
                                                    <img class="gallery_image" width="50" height="pdf" class="img-responsive thumbnail" src="'.site_url('images/pdf-icon.png').'"><br>
                                                    '.strlim($file['name'],30,'...'.mb_substr($file['name'],mb_strlen($file['name'])-10,10)).'
                                                </a>
                                            </div>
    ';
    return $ret;
}

function strlink($str){
    $html_links = preg_replace('"\b(https?://\S+)"', '<a href="$1" target="_blank">$1</a>', $str);
    return $html_links;
}