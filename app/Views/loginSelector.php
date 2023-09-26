<body class="loginSelector-page" style="font-family: 'Kanit', sans-serif;">
<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header" style="text-align:center">
                            <h2>
                                <?php print SYSTEMNAME; ?>   
                            </h2>
                    </div>
                    <div class="body">
                       <div style="text-align:center"> <h4>โปรดเลือกประเภทผู้ใช้</h4></div>
                       <br>
                    <div class="input-group">
<?php
helper('widget');
$data=array(
    /*'newUser'=>array(
        'color'=>'blue-grey',
        'text'=>'ลงทะเบียน<br>(ครั้งแรกเท่านั้น)',
        'number'=>'5',
        'icon'=>'person_add',
        'url'=>site_url('public/user/registerNewUser'),
        'class'=>'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    ),*/
    'school'=>array(
        'color'=>'green',
        'text'=>'สถานศึกษา ',
        'number'=>'5',
        'icon'=>'school',
        'url'=>site_url('public/user/login/school'),
        'class'=>'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    ),
    'committee'=>array(
        'color'=>'blue',
        'text'=>'กรรมการ',
        'number'=>'5',
        'icon'=>'people',
        'url'=>site_url('public/user/login/committee'),
        'class'=>'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    ),
    'admin'=>array(
        'color'=>'pink',
        'text'=>'ผู้ดูแลระบบ',
        'number'=>'5',
        'icon'=>'account_balance',
        'url'=>site_url('public/user/login/admin'),
        'class'=>'col-lg-6 col-md-12 col-sm-12 col-xs-12',
    ),
);

print genWidget($data);
?>
</div>
&copy; <?php print date('Y'); ?> วิทยาลัยพณิชยการบางนา
</div>
</div>
</div>
</div>
</body>