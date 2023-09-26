<?php
        helper('table');
        helper('modal');
        helper('thai');
        $mouRows=array();
        //print_r($data['school']);
        $school=$data['school'];
        $business=$data['business'];
        $gov=$data['gov'];
        foreach($data['mou'] as $mou){
            $mou = get_object_vars($mou);

            $org_name='';
            if(isset($school[$mou['school_id']]))$org_name=$school[$mou['school_id']];
            else if(isset($gov[$mou['school_id']]))$org_name=$gov[$mou['school_id']];

            if(!isset($business[$mou['business_id']]))continue;
            $mouRows[]=array(
                'business_id'=>$business[$mou['business_id']]['business_name'],
                /*'school_id'=>$org_name,*/
                'mou_date'=>dateThai($mou['mou_date']),
                'end_date'=>dateThai($mou['mou_end_date']),
                /*'mou_sign_place'=>$mou['mou_sign_place'],*/
                'attach'=>'
                <a href="'.site_url('public/mou/viewMOU/'.$mou['mou_id']).'" class="btn btn-xs btn-danger waves-effect"><i class="material-icons">picture_as_pdf</i></a>
                <a href="'.site_url('public/mou/viewPicture/'.$mou['mou_id']).'" class="btn btn-xs btn-success waves-effect"><i class="material-icons">image</i></a>',
                
                '<a href="'.site_url('public/mou/edit/'.$mou['mou_id']).'" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i></a>
                <a href="'.site_url('public/mou/delete/'.$mou['mou_id']).'" class="btn btn-xs btn-danger waves-effect" onClick="return confirm(\'ลบข้อมูล MOU\');"><i class="material-icons">delete</i></a>',
            );
        }
        $mouArr=array('thead'=>array(
                                'สถานประกอบการ',
                                /*'หน่วยงานภาครัฐ',*/
                                'วันที่ลงนาม',
                                'วันที่สิ้นสุด<br>ความร่วมมือ',
                                'ไฟล์แนบ<br>(เอกสาร/รูปภาพ)',
                                /*'สถานที่ลงนาม',*/
                                'จัดการ<br>แก้ไข/ลบ',
                        ),
                        'tbody'=>$mouRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="form-group" style="text-align:right;">
                                แสดงรายชื่อ MOU ที่ลงนามในปี
                            </div>
                        </div>
                            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <select id="selectYearMou" class="form-control">
                                <?php
                                $option='';
                                    for($i=date('Y');$i>date('Y')-10;$i--){
                                        $select='';
                                        if($year==$i)$select=' selected';
                                        $option.='<option value="'.$i.'"'.$select.'>'.($i+543).'</option>
                                        ';
                                    }
                                    print $option;
                                ?>
                                </select>  
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                <div class="form-group">
                                        <a href="<?php print site_url('public/mou/searchBusiness'); ?>" class="btn btn-primary" id="addMou"><i class="material-icons">add</i> เพิ่มข้อมูล MOU</a>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($mouArr);
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
                        'id'=>'addMouModal',
                        'title'=>'เพิ่มข้อมูล MOU',
                        'content'=>'โปรดรอสักครู่...',
                        'size'=>'modal-lg',
                    );
                    print genModal($data);
                    $_SESSION['FOOTSCRIPT'].='
                    $("#addMou").click(function(){
                        $("#addMouModal").modal("show");
                    });';
                    ?>