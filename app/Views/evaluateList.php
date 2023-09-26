<?php
        helper('table');
        helper('modal');
        helper('thai');
        $tableRows=array();
        $i=0;
        foreach($mission as $row){
            $i++;
            $org_name='';

            $tableRows[]=array(
                $i,
                $row->subject,
                dateThai($row->start_date),
                dateThai($row->end_date),
                '<a href="'.site_url('public/evaluate/assessmentItem/'.$row->id).'" title="ตัวบ่งชี้" class="btn btn-xs btn-primary waves-effect"><i class="material-icons">list</i></a>
                <a href="'.site_url('public/evaluate/tracking/'.$row->id).'" title="ติดตามความคืบหน้า" class="btn btn-xs btn-success waves-effect"><i class="material-icons">timeline</i></a>
                ',
            );
        }
        $tableArr=array('thead'=>array(
                                'ที่',
                                'ชื่อการประเมิน',
                                'วันที่เริ่มดำเนินการ',
                                'วันที่สิ้นสุดภารกิจ',
                                'จัดการ<br>ตัวบ่งชี้/ติดตาม',
                        ),
                        'tbody'=>$tableRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="row clearfix">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <div class="form-group" style="text-align:right;">
                                การประเมินในปี
                            </div>
                        </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4">
                                <div class="form-group">
                                    <div class="form-line">
                                <select id="selectYear" class="form-control">
                                <?php
                                $option='';
                                    for($i=date('Y')+1;$i>date('Y')-6;$i--){
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
                            <?php
                            if(current_user('user_type')=='admin'){
                            ?>
                                <div class="form-group">
                                        <a href="<?php print site_url('public/mission/add'); ?>" class="btn btn-primary" id="addMou"><i class="material-icons">add</i> เพิ่มข้อมูลภารกิจ</a>
                                </div>
                                <?php
                            }
                                ?>
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