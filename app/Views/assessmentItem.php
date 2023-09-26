<?php
        helper('table');
        helper('modal');
        helper('thai');
        $tableRows=array();
        $i=0;
        
        foreach($indicators as $row){
            $subm=$ind_subm[$row->id];
            //print_r($subm);
            $i++;
            $listLink='';
            $submitLink='';
            $view_button='';
            $pic=isset($subm->picture)?$subm->picture:'';
            $file=isset($subm->attach_file)?json_decode($subm->attach_file,true):array();
            if($row->score_type=='null')$listLink='<a href="'.site_url('public/evaluate/assessmentItem/'.$mission->id.'/'.$row->id).'" title="ตัวบ่งชี้ย่อย" class="btn btn-xs btn-primary waves-effect"><i class="material-icons">list</i></a>';
            if($row->score_type!='null'){
                $submitLink=' <a href="'.site_url('public/evaluate/submitForm/'.$mission->id.'/'.$row->id).'" title="ส่งข้อมูล/แนบไฟล์" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">file_present</i></a>';
                $view_button='<a href="'.site_url('public/evaluate/attach_file/'.$row->id).'" class="btn btn-xs btn-'.(count($file)>0?'danger':'default').'"><i class="material-icons">picture_as_pdf</i></a>
                <a href="'.site_url('public/evaluate/picture/'.$row->id).'" class="btn btn-xs btn-'.($pic!=''?'success':'default').'"><i class="material-icons">image</i></a>
                ';

            if(strtotime($mission->end_date.' 23:00:59')<strtotime(date('Y-m-d H:i:s'))){
                $submitLink=' <a href="javascript:alert(\'ไม่สามารถดำเนินการได้ในขณะนี้\')" title="ส่งข้อมูล/แนบไฟล์" class="btn btn-xs btn-defalut waves-effect"><i class="material-icons">file_present</i></a>';
            }
            }
            $tableRows[]=array(
                $i,
                $row->subject,
                $view_button,
                $listLink.$submitLink,
            );
        }
        $tableArr=array('thead'=>array(
                                'ที่',
                                'ชื่อตัวบ่งชี้/เกณฑ์การประเมิน',
                                'ไฟล์แนบ/รูปภาพ',
                                'จัดการ<br>ตัวบ่งชี้ย่อย/แนบไฟล์',
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
                        if($indicatorData)print '<a href="'.site_url('public/evaluate/assessmentItem/'.$indicatorData->mission_id.'/'.$indicatorData->parent_id).'">'.$indicatorData->subject.'</a>';
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