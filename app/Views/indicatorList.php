<?php
        helper('table');
        helper('modal');
        helper('thai');
        $tableRows=array();
        $i=0;
        foreach($indicators as $row){
            $i++;
            $org_name='';
            $tableRows[]=array(
                $i,
                $row->subject,
                $row->max_point,
                '<a href="'.site_url('public/mission/indicatorList/'.$mission->id.'/'.$row->id).'" title="ตัวบ่งชี้ย่อย" class="btn btn-xs btn-primary waves-effect"><i class="material-icons">list</i></a>
                <a href="'.site_url('public/mission/indicatorEdit/'.$mission->id.'/'.$row->id).'" title="แก้ไข" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i></a>
                <a href="'.site_url('public/mission/indicatorDelete/'.$row->id).'" title="ลบ" class="btn btn-xs btn-danger waves-effect" onClick="return confirm(\'ลบข้อมูลภารกิจ\');"><i class="material-icons">delete</i></a>',
            );
        }
        $tableArr=array('thead'=>array(
                                'ที่',
                                'ชื่อตัวบ่งชี้/เกณฑ์การประเมิน',
                                'คะแนน',
                                'จัดการ<br>ตัวบ่งชี้ย่อย/แก้ไข/ลบ',
                        ),
                        'tbody'=>$tableRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="row clearfix">

                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-0">
                    <?php
                        if($indicatorData)print '<a href="'.site_url('public/mission/indicatorList/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'">'.$indicatorData->subject.'</a>';
                    ?>
                    </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="form-group">
                                        <a href="<?php print site_url('public/mission/indicatorAdd/'.$mission->id.'/'.(isset($indicatorData->id)?$indicatorData->id:'')); ?>" class="btn btn-primary" id="addMou"><i class="material-icons">add</i> เพิ่มข้อมูลตัวบ่งชี้</a>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                        <div class="table-responsive">
                        <?php
                                print genTable($tableArr);
                             ?>
                            </div>
                    </div>
                            </div>
                            </div>
                    </div>
                    <script>
                    </script>
                    
                    <?php
                    $_SESSION['FOOTSCRIPT'].='
                    $("#selectYear").on("change", function() {
                        window.location.replace("'.site_url().'public/mission/list/"+this.value);
                    });';
                    ?>