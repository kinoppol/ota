<?php
        helper('table');
        helper('modal');
        helper('thai');
        $tableRows=array();
        $i=0;
        foreach($mission as $row){
            $i++;
            $org_name='';
            $eva_link='<a href="'.site_url('public/committee/schoolList/'.$row->id).'" title="ตัวบ่งชี้" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">task_alt</i></a>';
            if(strtotime($row->eva_start_date)>strtotime(date('Y-m-d'))||strtotime($row->eva_end_date)<strtotime(date('Y-m-d'))||!is_numeric(current_user('ref_number'))){
                $eva_link='<a href="javascript:alert(\'ไม่สามารถดำเนินการได้ในขณะนี้\')" title="ตัวบ่งชี้" class="btn btn-xs btn-default waves-effect"><i class="material-icons">task_alt</i></a>';    
            }
            $summaryLink='<a href="'.site_url('public/committee/allSummary/'.current_user('user_id').'/'.$row->id).'" target="_blank" title="สรุปการประเมิน" class="btn btn-xs btn-danger waves-effect"><i class="material-icons">picture_as_pdf</i></a>';
            $tableRows[]=array(
                $i,
                $row->subject,
                dateThai($row->eva_start_date),
                dateThai($row->eva_end_date),
                '<a href="'.site_url('public/committee/viewAllSummary/'.$row->id.'/'.current_user('user_id')).'" title="ใบสรุปผล" class="btn btn-danger"><i class="material-icons">picture_as_pdf</i></a>
                <a href="'.site_url('public/committee/uploadAllSummary/'.$row->id).'"  title="อัพโหลดใบสรุปผล" class="btn btn-primary waves-effect"><i class="material-icons">upload</i></a>',
                $eva_link.' '.$summaryLink,
            );
        }
        $tableArr=array('thead'=>array(
                                'ที่',
                                'ชื่อการประเมิน',
                                'วันที่เริ่มประเมิน',
                                'วันที่สิ้นสุดการประเมิน',
                                'ใบสรุปผล<br>ดู/อัพโหลด',
                                'ประเมิน/สรุปผล',
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
                        window.location.replace("'.site_url().'public/committee/missionList/"+this.value);
                    });';
                    ?>