<?php

helper('org');
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
                                <h3>ข้อมูลสถานศึกษา</h3>
                                <p><?php print current_user('org_code'); ?></p>
                                <p><?php print org_name(current_user('org_code')); ?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span>นักเรียนนักศึกษา</span>
                                    <span><?php print number_format($totalStudent,0,",","."); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบปกติ</span>
                                    <span><?php print number_format($totalStudent-$totalDVEStudent,0,",","."); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบทวิภาคี</span>
                                    <span><?php print number_format($totalDVEStudent,0,",","."); ?> คน</span>
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
                            $address=' เลขที่ '.($schoolData->address_no!=''?$schoolData->address_no:'-').
                            ' ถนน'.($schoolData->road!=''?$schoolData->road:'-').
                            ' ตำบล'.$subdistrict[$schoolData->subdistrict_id].
                            ' อำเภอ'.$district[$schoolData->district_id].
                            ' จังหวัด'.$province[$schoolData->province_id];
                            $school_data='
                            <b>รหัสสถานศึกษา</b> '.$schoolData->school_id.'
                            <b>ชื่อสถานศึกษา</b> '.$schoolData->school_name.'<br>
                            <b>ที่อยู่</b> '.$address.'<br>
                            <b>อีเมล</b> '.$schoolData->email.'
                            <b>โทรศัพท์</b> '.$schoolData->phone.'
                            <b>โทรสาร</b> '.$schoolData->fax.'<br>
                            <b>ผู้อำนวยการ</b> '.$schoolData->director_name.'<br>
                            <b>รองฯ ฝ่ายวิชาการ</b> '.$schoolData->deputy_academic_name.'<br>
                            <b>รองฯ ฝ่ายพัฒนากิจการนักเรียนนักศึกษา</b> '.$schoolData->deputy_activity_name.'<br>
                            <b>รองฯ ฝ่ายบริหารทรัพยากร</b> '.$schoolData->deputy_resources_name.'<br>
                            <b>รองฯ ฝ่ายแผนงานและความร่วมมือ</b> '.$schoolData->deputy_planning_name.'<br>
                            ';

                            $tab=array(
                                'detail'=>array(
                                    'title'=>'ข้อมูลทั่วไป',
                                    'content'=>$school_data,
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