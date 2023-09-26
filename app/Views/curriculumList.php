<?php
        helper('table');
        helper('modal');
        $check='<img src="'.site_url('images/check.jpg').'" width="16">';
        $curRows=array();
        $business=$curriculum['business'];
        foreach($curriculum['curriculum'] as $row){
            $curRows[]=array(
                'business_id'=>isset($row->business_id)&&$row->business_id!=0?$business[$row->business_id]['business_name']:'',
                'curriculum_name'=>isset($row->curriculum_name)?$row->curriculum_name:'',/*
                'support_vc_edu'=>$row->support_vc_edu=='Y'?$check:'',
                'support_hvc_edu'=>$row->support_hvc_edu=='Y'?$check:'',
                'support_btech_edu'=>$row->support_btech_edu=='Y'?$check:'',
                'support_short_course'=>$row->support_short_course=='Y'?$check:'',
                'support_no_specific'=>$row->support_no_specific=='Y'?$check:'',*/
                'curriculum_hour'=>$row->curriculum_hour,
                'manage'=>'
                <a href="'.site_url('public/mou/curriculumDetail/'.$row->id).'" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i>แก้ไข</a>
                <a href="'.site_url('public/mou/curriculumDelete/'.$row->id).'" class="btn btn-xs btn-danger" onclick="return confirm(\'ยืนยันการลบหลักสูตร '.$row->curriculum_name.'\');"><i class="material-icons">delete</i> ลบ</a>',
            );
        }
        $curArr=array('thead'=>array(
                                'ชื่อสถานประกอบการ',
                                'ชื่อหลักสูตร',/*
                                'ระดับ ปวช.',
                                'ระดับ ปวส.',
                                'ระดับ ทล.บ.',
                                'ระดับ ระยะสั้น',
                                'ไม่ระบุ ระดับ',*/
                                'จำนวนชั่วโมง',
                                'จัดการ',
                        ),
                        'tbody'=>$curRows,
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
                                                <a  href="<?php print site_url('public/mou/curriculumAdd'); ?>" class="btn btn-warning" id="addCurriculum"><i class="material-icons">add</i> เพิ่มข้อมูลหลักสูตร</a>
                                        </div>
                                    </div>
                                </div>
                               </form>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($curArr);
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