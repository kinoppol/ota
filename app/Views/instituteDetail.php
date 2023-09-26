<?php

helper('org');
helper('minor');
helper('tab');
		
?>
<div class="row clearfix">
                <div class="col-xs-12 col-sm-4">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <div class="profile-body">
                            <div class="image-area">
                                <img src="<?php print site_url('public/images/vec_logo.jpg'); ?>" alt="AdminBSB - Profile Image" width="128"/>
                            </div>
                            <div class="content-area">
                                <h3>ข้อมูลสถาบันการอาชีวศึกษา</h3>
                                <p><?php print '#'.current_user('org_code'); ?></p>
                                <p><?php print org_name(current_user('org_code')); ?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span>นักเรียนนักศึกษาทั้งหมด</span>
                                    <span><?php print number_format($totalStudent,0,".",","); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบปกติ</span>
                                    <span><?php print number_format($totalStudent-$totalDVEStudent,0,".",","); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบทวิภาคี</span>
                                    <span><?php print number_format($totalDVEStudent,0,".",","); ?> คน</span>
                                </li><li>
                                    <span>ระยะสั้น</span>
                                    <span><?php print number_format(0,0,".",","); ?> คน</span>
                                </li>
                            </ul>
                            <!-- <button class="btn btn-primary btn-lg waves-effect btn-block">ประสานข้อมูลจากระบบ ศธ. ๐๒ ออนไลน์</button> -->
                        </div>
                    </div>
                </div>
            <!-- ////////////////////////////// -->
            <div class="col-xs-12 col-sm-8">
                    <div class="card">
                        <div class="body">
                            <div>

                            <?php 
                                $in_school='';
                                $i=0;
                                //print_r($student_school);
                                foreach($in_school_id as $school){
                                    $i++;
                                    if($in_school!=''){
                                            $in_school.='<br> ';
                                    }
                                    $in_school.='&nbsp;&nbsp;&nbsp;&nbsp;'.$i.'.) '.org_name($school).' ('.number_format((isset($student_school[$school]->count_val)?$student_school[$school]->count_val:'0'),0,".",",").' คน)';
                                }
                            $data='
                            <b>ผู้อำนวยการสถาบันการอาชีวศึกษา </b> '.$institute_data->director_name.'<br>
                            <b>รองผู้อำนวยการสถาบันการอาชีวศึกษา </b> '.$institute_data->institute_name.'<br>
                            <b>สถานศึกษาในสังกัดสถาบันการอาชีวศึกษา'.$institute_data->institute_name.'</b><br> '.$in_school.'<br>
                            ';

                            $tab=array(
                                'detail'=>array(
                                    'title'=>'ข้อมูลทั่วไป',
                                    'content'=>$data,
                                ),
                                'form'=>array(
                                    'title'=>'แก้ไขข้อมูล',
                                    'content'=>$editForm,
                                ),
                            );
                            print gen_tab($tab);
                            ?>
                            </div>
                            </div>
                        </div>
                    </div>