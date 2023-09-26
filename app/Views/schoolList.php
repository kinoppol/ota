<?php
        helper('table');
        helper('modal');
        helper('thai');
        helper('user');
        $tableRows=array();
        $i=0;
        //$schoolEva[10]='555';
        //print_r($schoolEva);
        foreach($school as $row){
            //print_r($row);
            //print array_search($row['school_id'],$schoolEva);
            //print '<br>';
            if(!is_numeric(array_search($row['school_id'],$schoolEva)))continue;
            $elink=site_url('public/committee/evaluate/'.$mission_id.'/'.$row['school_id']);
            $plink=site_url('public/committee/summary/'.$mission_id.'/'.$row['school_id']);

            $evaLink=' <a href="'.$elink.'" title="ประเมิน" class="btn btn-warning waves-effect"><i class="material-icons">task_alt</i></a>';
            $printLink=' <a href="'.$plink.'" target="_blank" title="สรุป" class="btn btn-danger waves-effect"><i class="material-icons">picture_as_pdf</i></a>';
 
            if($row['school_id']==current_user('org_code')){
                
                $evaLink=' <a href="#" title="ประเมิน" class="btn btn-default waves-effect" disabled><i class="material-icons">task_alt</i></a>';
                $printLink=' <a href="#" title="สรุป" class="btn btn-default waves-effect" disabled><i class="material-icons">picture_as_pdf</i></a>';
 
            }
            $i++;
            
            $color='default';
            if($row['sumGiveScore']!=0){
                $color='warning';
            }

            $tableRows[]=array(
                $i,
                $row['school_id'],
                $row['school_name'],
                '<button class="btn btn-'.$color.'" title="สถานะการประเมิน"><i class="material-icons">task_alt</i></button>
                <a href="'.site_url('public/committee/viewSummary/'.$mission_id.'/'.$row['school_id'].'/'.current_user('user_id')).'" title="ใบสรุปผล" class="btn btn-danger"><i class="material-icons">picture_as_pdf</i></a>
                <a href="'.site_url('public/committee/uploadSummary/'.$mission_id.'/'.$row['school_id']).'"  title="อัพโหลดใบสรุปผล" class="btn btn-primary waves-effect"><i class="material-icons">upload</i></a>',
                $evaLink.$printLink,
            );
        }
        $tableArr=array('thead'=>array(
                                'ที่',
                                'รหัสสถานศึกษา',
                                'ชื่อสถานศึกษา',
                                'สถานะ<br>ให้คะแนน/ดูใบสรุปคะแนน/อัพโหลดใบสรุปผล',
                                'ดำเนินการ<br>ประเมิน/สรุปผล',
                        ),
                        'tbody'=>$tableRows,
        );
    ?>

<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="row clearfix">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php
                        //if($indicatorData)print '<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'">'.$indicatorData->subject.'</a>';
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