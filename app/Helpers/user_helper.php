<?php

function current_user($key){
    $userData=unserialize($_COOKIE['current_user']);
    return $userData[0]->$key;
}

function user_type($type){
    $userType=array(
        'user'=>'ผู้ใช้งานยังไม่ลงทะเบียน',
        'admin'=>'ผู้ดูแลระบบ',
        'board'=>'ผู้บริหาร สอศ.',
        'committee'=>'กรรมการ',
        'boc'=>'สำนักความร่วมมือ',
        'gov'=>'อ.กรอ.อศ',
        'institute'=>'สถาบันการอาชีวศึกษา',
        'school'=>'สถานศึกษา',
    );
    return $userType[$type];
}
