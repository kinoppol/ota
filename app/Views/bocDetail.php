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
                                <h3>ข้อมูลสำนักความร่วมมือ</h3>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li>
                                    <span>นักเรียนนักศึกษา</span>
                                    <span><?php print number_format($totalStudent,0,".",","); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบปกติ</span>
                                    <span><?php print number_format($totalStudent-$totalDVEStudent,0,".",","); ?> คน</span>
                                </li>
                                <li>
                                    <span>ระบบทวิภาคี</span>
                                    <span><?php print number_format($totalDVEStudent,0,".",","); ?> คน</span>
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
                            $boc_detail='
                            <b>ผู้อำนวยการสำนักความร่วมมือ</b> '.$bocData->director_name.'<br>
                            <b>ผู้อำนวยการกลุ่ม...</b> '.$bocData->director_group_name.'<br>
                            <b>ผู้จัดทำข้อมูล</b> '.$bocData->supervisor_name.'<br>
                            ';

                            $tab=array(
                                'detail'=>array(
                                    'title'=>'ข้อมูลทั่วไป',
                                    'content'=>$boc_detail,
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