<?php
        helper('table');
        helper('modal');
        helper('form');
        helper('string');
        $buninessRows=array();
        foreach($business as $k=>$v){
            if($v['district_id']==0)continue;

            $disdric_label='อำเภอ';
            $subdisdric_label='ตำบล';

            if($v['province_id']==10){
                $disdric_label='';
                $subdisdric_label='แขวง';
            }
            $buninessRows[]=array(
                'business_name'=>strlim($v['business_name'],20),
                'address'=>/*'จังหวัด'.$province[$v['province_id']].

                            ' '.*/strlim($disdric_label.$district[$v['district_id']].
                            ' '.$subdisdric_label.(isset($v['subdistrict_id'])&&$v['subdistrict_id']!='0'?$subdistrict[$v['subdistrict_id']]:"").
                            ($v['road']!=''?" ถนน".$v['road']:'').
                            ' เลขที่ '.($v['address_no']!=''?$v['address_no']:'-'),100),
                (isset($v['location'])&&$v['location']!==''?'<a href="https://www.google.com/maps/place/'.$v['location'].'" target="_blank" class="btn btn-xs btn-success waves-effect"><i class="material-icons">location_on</i></a> ':'<a href="#" class="btn btn-xs btn-default"><i class="material-icons">location_on</i></a> ').
                (isset($v['picture'])&&$v['picture']!==''?'<a href="'.site_url('public/business/picture/'.$v['business_id']).'" class="btn btn-xs btn-primary waves-effect"><i class="material-icons">image</i></a>':'<a href="#" class="btn btn-xs btn-default"><i class="material-icons">image</i></a> ')
                ,'
                <a href="'.site_url('public/business/detail/'.$v['business_id']).'" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i></a>
                <a href="'.site_url('public/mou/add/'.$v['business_id']).'" class="btn btn-xs btn-success waves-effect"><i class="material-icons">history_edu</i></a>',
            );
        }
        $businessArr=array('thead'=>array(
                                'สถานประกอบการ',
                                'ที่อยู่',
                                'พิกัด/ภาพถ่าย',
                                'จัดการ<br>แก้ไข/ทำ MOU',
                        ),
                        'tbody'=>$buninessRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                               <form action="<?php print site_url('public/'.$_SERVER['PATH_INFO']); ?>" method="post">
                                    <div class="row clearfix">
                                      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="province_id" id="province_id" class="form-control">
                                                    <?php
                                                        print genOption($province,isset($_POST['province_id'])?$_POST['province_id']:'10');
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><div class="row clearfix">
                                      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-3">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="q" placeholder="ชื่อสถานประกอบการบางส่วน.." value="<?php print isset($_POST['q'])?$_POST['q']:''; ?>">
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
                                                <!-- <button  type="button" class="btn btn-warning" id="addBusiness"><i class="material-icons">add</i> เพิ่มข้อมูลสถานประกอบการ</button> -->
                                                <a  href="<?php print site_url('public/business/add'); ?>" class="btn btn-warning" id="addBusiness"><i class="material-icons">add</i> เพิ่มข้อมูลสถานประกอบการ</a>
                                        </div>
                                    </div>
                                </div>
                               </form>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($businessArr);
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