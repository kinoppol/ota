<?php
helper('user');
helper('modal');
helper('tab');
$debug=false;

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php print strip_tags($title) ;?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php print site_url();?>favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Kanit', sans-serif;
        }
    </style>
    <!-- Bootstrap Core Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- JQuery DataTable Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php print site_url();?>template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php print site_url();?>template/adminbsb/css/style.css?lo=th" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php print site_url();?>template/adminbsb/css/themes/all-themes.css" rel="stylesheet" />
    
    <!-- Select 2 CSS-
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        -->
</head>

<body class="theme-green" style="font-family: 'Kanit', sans-serif;">
<?php
if(!$debug){
?>
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>โปรดรอสักครู่...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <?php
    }
    ?>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <form action="<?php print site_url('public/search/result'); ?>" method="POST">
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="พิมพ์คำค้น...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
</form>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php print site_url();?>">
                        <?php print SYSTEMNAME.' : '.user_type(current_user('user_type')); ?></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <!-- <span class="label-count">7</span> -->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">แจ้งเตือน</li>
                            <li class="body">
                                <?php print empty($notification)?'':$notification; ?>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <!-- <span class="label-count">9</span> -->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                
                        <?php print empty($task)?'':$task; ?>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php print current_user('picture')!=''?site_url(current_user('picture')):site_url('template/adminbsb/images/user.png'); ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php print current_user('name').' '.current_user('surname'); ?></div>
                    <div class="email"><?php print current_user('email'); ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php print site_url('public/user/profile'); ?>"><i class="material-icons">person</i>โปรไฟล์</a></li>
                            <!-- <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>-->
                            <li><a href="https://drive.google.com/file/d/10S8yLYT7V7ObZl7Ws70QMQGcl0zb1eLK/view?usp=sharing" target="_blank"><i class="material-icons">book</i>คู่มือ</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#aboutSystem"><i class="material-icons">info</i>เกี่ยวกับระบบ</a></li>-->
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php print site_url('public/user/logout'); ?>"><i class="material-icons">input</i>ออกจากระบบ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <?php print $mainMenu;?>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                <b>Version: </b> <?php print VERSION; ?> &copy; <?php print date('Y'); ?> <a href="http://www.rvc.ac.th" target="_blank"><br>วิทยาลัยอาชีวศึกษาร้อยเอ็ด</a>
                </div>
                <div class="version">
                <a href="http://www.vec.go.th" target="_blank">สำนักงานคณะกรรมการการอาชีวศึกษา</a> 
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <?php

                        function genColorBar($def='red'){
                            $ret='';
                            $color=array(   'red'=>'Red',
                                            'pink'=>'Pink',
                                            'purple'=>'Purple',
                                            'indigo'=>'Indigo',
                                            'blue'=>'Blue',
                                            'light-blue'=>'Light Blue',
                                            'cyan'=>'Cyan',
                                            'teal'=>'Teal',
                                            'green'=>'Green',
                                            'light-green'=>'Light Green',
                                            'lime'=>'Lime',
                                            'yellow'=>'Yellow',
                                            'amber'=>'amber',
                                            'orange'=>'Orange',
                                            'brown'=>'Brown',
                                            'grey'=>'Grey',
                                            'blue-grey'=>'Blue Grey',
                                            'black'=>'Black'
                                        );
                            foreach($color as $k=>$v){
                                $active='';
                                if($k==$def)$active=' class="active"';
                                $ret.='
                                <li data-theme="'.$k.'"'.$active.'>
                                    <div class="'.$k.'"></div>
                                    <span>'.$v.'</span>
                                </li>
                                ';
                            }
                            return $ret;
                        }
                        
                        print genColorBar($def='green');
                        ?>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-align:left;float:left;"><?php print $title;?></h2><h2 style="text-align:right;float:right;"><?php /* print $_SERVER['PATH_INFO']; */ ?></h2>
                <hr style="clear:both;"/>
            </div>
                        
            <?php print $content; ?>
    </section>
    <?php
                    $tab=array(
                        'about'=>array(
                            'title'=>'เกี่ยวกับระบบ',
                            'content'=>'<h4>'.SYSTEMNAME.'</h4>
                            Version: '.VERSION.' &copy;'.date('Y').' วิทยาลัยอาชีวศึกษาร้อยเอ็ด สำนักงานคณะกรรมการการอาชีวศึกษา
                            <br><br>
                            อำนวยการพัฒนาโดย <b>วิทยาลัยอาชีวศึกษาร้อยเอ็ด</b> <a href="https://www.bncc.ac.th/">http://www.rvc.ac.th</a><br>
                            ',
                        ),
                        'developer'=>array(
                            'title'=>'ผู้พัฒนาระบบ',
                            'content'=>'<h4>'.SYSTEMNAME.'</h4>
                            พัฒนาระบบโดย <b>นายนพพล อินศร</b> ครูวิทยาลัยอาชีวศึกษาร้อยเอ็ด<br>
                            <a href="mailto:noppol.ins@bncc.ac.th">noppol.ins@bncc.ac.th</a><br>
                            โทร <a href="tel:+66919968266">09-1996-8266</a>',
                        ),
                    );
                    $data=array(
                        'id'=>'aboutSystem',
                        'title'=>'เกี่ยวกับระบบ',
                        'content'=>gen_tab($tab),
                    );
                    print genModal($data);
                    ?>
    <!-- Jquery Core Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/node-waves/waves.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="<?php print site_url();?>template/adminbsb/js/admin.js"></script>
    <script src="<?php print site_url();?>template/adminbsb/js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="<?php print site_url();?>template/adminbsb/js/demo.js"></script>

    <!-- Select2 js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php print site_url('font/vfs_fonts.js'); ?>"></script>
    <script>
        pdfMake.fonts = {
   THSarabun: {
     normal: 'THSarabun.ttf',
     bold: 'THSarabun-Bold.ttf',
     italics: 'THSarabun-Italic.ttf',
     bolditalics: 'THSarabun-BoldItalic.ttf'
   }
}
        $('.count-to').countTo({
        formatter: function (value, options) {
            return value.toFixed(options.decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
    $(function () {
    //$('.js-example-basic-single').select2();
    $('.js-basic-example').DataTable( {
                    "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ รายการ ต่อหน้า",
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                    "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "sSearch": "<i class=\"material-icons\">filter_list</i> กรอง :"
                                  }
                } );

    //Exportable table
    $('.js-exportable').DataTable({
        "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ รายการ ต่อหน้า",
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                    "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "sSearch": "<i class=\"material-icons\">filter_list</i> กรอง :",
                                  },
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
             'excel', { // กำหนดพิเศษเฉพาะปุ่ม pdf
                "extend": 'pdf', // ปุ่มสร้าง pdf ไฟล์
                "text": 'PDF', // ข้อความที่แสดง
                "pageSize": 'A4',   // ขนาดหน้ากระดาษเป็น A4           
                "pageOrientation": 'landscape', 
                "customize":function(doc){ // ส่วนกำหนดเพิ่มเติม ส่วนนี้จะใช้จัดการกับ pdfmake
                    // กำหนด style หลัก
                    doc.defaultStyle = {
                        font:'THSarabun',
                        fontSize:16                                 
                    };
                }
            }, // สิ้นสุดกำหนดพิเศษปุ่ม pdf
             'print'
        ]
    });
});


                $('#addUserBtn').click(function(){
                    $('#newUserModal').modal('show');
                });

                $('#selectYearMou').on('change', function() {
                    window.location.replace("<?php print site_url().'public/mou/list/'; ?>"+this.value);
                });
                <?php print $_SESSION['FOOTSCRIPT']; ?>
            </script>
            <?php print $_SESSION['FOOTSYSTEM']; ?>
</body>
</html>
