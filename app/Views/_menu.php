<?php
helper('menu');
helper('user');

$data=array(
    'dashboard'=>array(
        'text'=>'ภาพรวม',
        'url'=>site_url('public/home/dashboard'),
        'bullet'=>'dashboard',
        'cond'=>true,/*
        'items'=>array(
            'dashboard'=>array(
                'text'=>'ภาพรวม',
                'url'=>site_url(),
                'bullet'=>'book',
                'cond'=>true,
                'items'=>array(
                    'dashboard'=>array(
                        'text'=>'อีกๆ',
                        'url'=>site_url(),
                        'bullet'=>'book',
                        'cond'=>true,
                        ),
                    ),
                ),
            ),*/
        ),        
    'register'=>array(
        'text'=>'ลงทะเบียนประเภทผู้ใช้งาน',
        'url'=>site_url('public/user/register'),
        'bullet'=>'portrait',
        'cond'=>current_user('user_type')=='user',
    ),
    'school'=>array(
        'text'=>'ข้อมูลสถานศึกษา',
        'url'=>site_url('public/school/detail'),
        'bullet'=>'school',
        'cond'=>current_user('user_type')=='school',

    ),/*
    'committeeBasic'=>array(
        'text'=>'ข้อมูลพื้นฐานของกรรมการ',
        'url'=>site_url('public/committee/detail'),
        'bullet'=>'people',
        'cond'=>current_user('user_type')=='committee',

    ),*/
    'schoolList'=>array(
        'text'=>'ดำเนินการประเมิน',
        'url'=>site_url('public/committee/missionList'),
        'bullet'=>'assessment',
        'cond'=>current_user('user_type')=='committee',

    ),
    'mission'=>array(
        'text'=>'ภารกิจการประเมิน',
        'url'=>site_url('public/mission/list'),
        'bullet'=>'receipt_long',
        'cond'=>current_user('user_type')=='admin',
    ),
    'evaluate'=>array(
        'text'=>'การประเมินศูนย์บ่มเพาะ',
        'url'=>site_url('public/evaluate/list'),
        'bullet'=>'receipt_long',
        'cond'=>current_user('user_type')=='school',
    ),


    'manage'=>array(
        'text'=>'จัดการ',
        'url'=>site_url(),
        'bullet'=>'engineering',
        'cond'=>current_user('user_type')=='admin',
        'items'=>array(
            'systemManage'=>array(
                'text'=>'ตั้งค่าระบบ',
                'url'=>site_url('public/admin/systemSetting'),
                'cond'=>true,
                ),
            'userManage'=>array(
                'text'=>'จัดการผู้ใช้',
                'url'=>site_url('public/admin/userManage'),
                'cond'=>true,
                ),
            ),
        ),
            'report'=>array(
                'text'=>'สรุปผลรายงาน',
                'url'=>site_url('public/report/list'),
                'bullet'=>'assessment',
                'cond'=>current_user('user_type')=='admin',
                ),
);


print genMainMenu($data,$def=site_url('/public'.$_SERVER['PATH_INFO']));