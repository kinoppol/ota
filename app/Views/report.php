<?php
        helper('table');
        helper('modal');
        helper('user');

        $reports=array(array(
            'title'=>'รายงานการลงนามความร่วมมือ',
            'file'=>'reportOrg/school_01',
            'cond'=>current_user('user_type')=='school'||current_user('user_type')=='gov'||current_user('user_type')=='institute'||current_user('user_type')=='boc',
            ),
            array(
            'title'=>'รายงานการพัฒนาหลักสูตรร่วมกับสถานประกอบการ',
            'file'=>'reportOrg/school_02',
            'cond'=>current_user('user_type')=='school'||current_user('user_type')=='gov'||current_user('user_type')=='institute'||current_user('user_type')=='boc',
            ),
            array(
            'title'=>'รายงานผลสัมฤทธิ์ของการร่วมมือกับสถานประกอบการ',
            'file'=>'reportOrg/school_03',
            'cond'=>current_user('user_type')=='school'||current_user('user_type')=='gov'||current_user('user_type')=='institute'||current_user('user_type')=='boc',
            ),

            array(
                'title'=>'สรุปรายการการประชุม อ.กรอ.อศ.',
                'file'=>'reportGov/gov_01',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),/*
            array(
                'title'=>'รายงานการพัฒนาหลักสูตรร่วมกับสถานประกอบการ',
                'file'=>'reportGov/gov_03',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานการลงนามความร่วมมือ',
                'file'=>'reportGov/gov_04',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),*/
            array(
                'title'=>'รายงานการวิจัยความพึงพอใจของสถานประกอบการที่มีต่อผู้สำเร็จการศึกษา',
                'file'=>'reportGov/gov_05',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานการพัฒนาครูฝึกในสถานประกอบการ',
                'file'=>'reportGov/gov_06',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานการประชาสัมพันธ์เพิ่มผู้เรียนในกลุ่ม อ.กรอ.อศ.',
                'file'=>'reportGov/gov_07',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานการพัฒนาครูผู้สอนในสถานศึกษา',
                'file'=>'reportGov/gov_08',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานการพัฒนาผู้เรียน',
                'file'=>'reportGov/gov_09',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'รายงานดำเนินโครงการอื่น ๆ',
                'file'=>'reportGov/gov_10',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc',
                ),
            array(
                'title'=>'การลงนามความร่วมมือจำแนกตามสถานประกอบการ',
                'file'=>'reportMou/mou_01',
                'cond'=>current_user('user_type')=='gov'||current_user('user_type')=='boc'||current_user('user_type')=='bord',
                ),
        );


        $reportRows=array();
        $i=0;
        foreach($reports as $row){
            if(!$row['cond'])continue;
            $i++;
            $reportRows[]=array(
                'i'=>$i,
                'reportName'=>$row['title'],
                'manage'=>'<a href="'.site_url('public/'.$row['file']).'/'.$row['title'].'" class="btn btn-primary"> <i class="material-icons">search</i> ดูรายงาน</a>'
            );
        }
        $reportArr=array('thead'=>array(
                                'ที่',
                                'ชื่อรายงาน',
                                'จัดการ',
                        ),
                        'tbody'=>$reportRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                               <h3>รายงาน</h3>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($reportArr);
                             ?>
                            </div>
                    </div>
                            </div>
                            </div>
                    </div>
                    <script>
                    </script>
                    
                    
                    <?php
                    $data=array(
                        'id'=>'addBusinessModal',
                        'title'=>'เพิ่มข้อมูลสถานประกอบการ',
                        'content'=>'โปรดรอสักครู่...',
                        //'size'=>'modal-lg',
                    );
                    print genModal($data);
                    $_SESSION['FOOTSCRIPT'].='
                    $("#addBusiness").click(function(){
                        $("#addBusinessModal").modal("show");
                    });';
                    ?>