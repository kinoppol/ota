<?php print $title; ?>
<div class="row clearfix">
<?php
helper('widget');
$data=array(
    'mou'=>array(
        'color'=>'red',
        'text'=>'ข้อมูล MOU',
        'number'=>$mouCount,
        'icon'=>'description',
        'url'=>site_url('public/mou/list'),
    ),
    'business'=>array(
        'color'=>'amber',
        'text'=>'สถานประกอบการ',
        'number'=>$businessCount,
        'icon'=>'account_balance',
        'url'=>site_url('public/business/list'),
    ),
    'mouLastYear'=>array(
        'color'=>'blue',
        'text'=>'ข้อมูล MOU ปี '.($year+543-1),
        'number'=>$mouLastYearCount,
        'icon'=>'folder',
        'url'=>site_url('public/mou/list/'.($year-1)),
    ),
    'mouYear'=>array(
        'color'=>'green',
        'text'=>'ข้อมูล MOU ปี '.($year+543),
        'number'=>$mouYearCount,
        'icon'=>'create_new_folder',
        'url'=>site_url('public/mou/list/'.$year),
    ),
);

print genWidget($data);
?>
</div>