<?php
        helper('table');
        helper('modal');
        $check='<img src="'.site_url('images/check.jpg').'" width="16">';
        $resRows=array();
        $business=$result['business'];
        foreach($result['result'] as $row){
            $resRows[]=array(
                'business_id'=>$business[$row->business_id]['business_name'],
                'result_year'=>($row->result_year+543),
                'trainee_majors'=>$row->trainee_majors,
                'trainee_amount'=>$row->employee_amount,
                'employee_majors'=>$row->employee_majors,
                'employee_amount'=>$row->employee_amount,
                'donate_detail'=>$row->donate_detail,
                'donate_value'=>number_format($row->donate_value,0,'.',','),
                'donate_other'=>$row->donate_other,
                'manage'=>'
                <a href="'.site_url('public/mou/resultDetail/'.$row->id).'" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i>แก้ไข</a>
                <a href="'.site_url('public/mou/resultDelete/'.$row->id).'" class="btn btn-xs btn-danger" onclick="return confirm(\'ยืนยันการลบข้อมูล\');"><i class="material-icons">delete</i> ลบ</a>',
            );
        }
        $reArr=array('thead'=>array(
                                'ชื่อสถานประกอบการ',
                                'ปี',
                                'สาขาที่รับ<br>เข้าฝึกงาน',
                                'รับ นร./นศ.<br>เข้าฝึกงาน',
                                'สาขาที่รับ<br>เข้าทำงาน',
                                'รับผู้สำเร็จฯ<br>เข้าทำงาน',
                                'การสนับสนุนการศึกษา',
                                'มูลค่า<br>(บาท)',
                                'การสนับสนุนการศึกษารูปแบบอื่นๆ',
                                'จัดการ',
                        ),
                        'tbody'=>$resRows,
        );
    ?>


<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                               <form action="<?php print site_url('public/'.$_SERVER['PATH_INFO']); ?>" method="post">
                                    <div class="row clearfix"><div class="row clearfix">
                                      <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="q" placeholder="คำค้น.." value="<?php print isset($_POST['q'])?$_POST['q']:''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-3">
                                        <div class="form-group">
                                                <button class="btn btn-primary"><i class="material-icons">search</i> ค้นหา</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group">
                                                <!--<button  type="button" class="btn btn-warning" id="addBusiness"><i class="material-icons">add</i> เพิ่มรายงานการประชุม</button>-->
                                                <a  href="<?php print site_url('public/mou/resultAdd'); ?>" class="btn btn-warning" id="addCurriculum"><i class="material-icons">add</i> เพิ่มข้อมูลผลสัมฤทธิ์</a>
                                        </div>
                                    </div>
                                </div>
                               </form>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($reArr);
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