<?php

function is_marray($array){
    if(!is_array($array))return false;
    if (count($array) == count($array, COUNT_RECURSIVE)){
        return false;
    }
    else{
        return true;
    }
}