<?php

function strlim($str,$limit=100,$tail='..'){
    $ret='';
    if(mb_strlen($str)<$limit)return $str;
    $ret=mb_substr($str,0,$limit-mb_strlen($tail));
    return $ret.$tail;
}