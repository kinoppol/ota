<?php

function minor_name($minor_code=false){
    if(!$minor_code) return false;
    $minorModel = model('App\Models\MinorModel');
    $result=$minorModel->getMinor($minor_code);
        return $result->minor_name_th;
}