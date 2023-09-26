<?php
    //print_r($users);
    //exit();
    helper('table');
    helper('user');
    $userRows=array();
    if($user_status=='unregister'){
    $userRegData=array();
            foreach($registerData as $row){
                $userRegData[$row->user_id]=array(
                    'user_type'=>$row->user_type,
                    'register_status'=>$row->register_status,
                    'ref_number'=>isset($row->ref_number)?$row->ref_number:'',
                );
            }
            
        }

    foreach($users as $user){
        $user = get_object_vars($user);
        $editLink='<a href="'.site_url('public/admin/editUser/'.$user['user_id']).'" class="btn btn-xs btn-warning waves-effect"><i class="material-icons">edit</i></a>';
        $deleteLink=' <a href="'.site_url('public/admin/deleteUser/'.$user['user_id']).'" class="btn btn-xs btn-danger waves-effect" onclick="return confirm(\'ลบข้อมูลผู้ใช้งาน\')"><i class="material-icons">delete</i></a>';
        if($user_status=='registered'){
            array_push($user,$editLink.$deleteLink);
            $user['user_type']=user_type($user['user_type']);
        }
        else if($user_status=='unregister'){
            

            if(isset($userRegData[$user['user_id']]['register_status'])&&$userRegData[$user['user_id']]['register_status']=='request'){
                array_push($user,'<a href="'.site_url('public/admin/approveUser/'.$user['user_id']).'" class="btn btn-xs btn-success waves-effect"><i class="material-icons">check</i> อนุมัติ</a>
                                                             <a href="'.site_url('public/admin/disapproveUser/'.$user['user_id']).'" onClick="return confirm(\'ยืนยันการปฏิเสธการลงทะเบียน\')" class="btn btn-xs btn-danger waves-effect"><i class="material-icons">close</i> ปฏิเสธ</a> '.$editLink);
            }else{
                
                array_push($user,'<button class="btn btn-default">ผู้ใช้ยังไม่ลงทะเบียน</button><br>'.$editLink.$deleteLink);
            }
                                                             $user['user_type']=isset($userRegData[$user['user_id']]['user_type'])?user_type($userRegData[$user['user_id']]['user_type']):false;                                     
            }
            $userRow=array(
                'id'=>$user['user_id'],
                'username'=>$user['username'],
                'name'=>$user['name'],
                'surname'=>$user['surname'],
                'email'=>$user['email'],
                'user_type'=>$user['user_type'],
                'ref_number'=>$user['ref_number'],
                $user['user_type']!='กรรมการ'?'':'<a href="'.site_url('public/committee/viewAllSummary/5/'.$user['user_id']).'" title="ใบสรุปผล" class="btn btn-danger"><i class="material-icons">picture_as_pdf</i></a>',
                'manage'=>$editLink.$deleteLink,
            );
        $userRows[]=$userRow;
    }
    $userArr=array('thead'=>array(
                            'ID',
                            'ชื่อผู้ใช้',
                            'ชื่อ',
                            'สกุล',
                            'อีเมล',
                            'ประเภทผู้ใช้',
                            '#',
                            'ใบสรุป',
                            'จัดการ<br>แก้ไข/ลบ',
                    ),
                    'tbody'=>$userRows,
    );
?>
<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                            <h2>
                                <?php print $title; ?>   
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#" id="addUserBtn">เพิ่มผู้ใช้งาน</a></li>
                                        <li><a href="javascript:void(0);">เพิ่มผู้ใช้งานแบบกลุ่ม</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                        <div class="table-responsive">
                             <?php
                                print genTable($userArr);
                             ?>
                            </div>
                    </div>
                            </div>
                            </div>
                    </div>
                    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">เพิ่มผู้ใช้งานระบบ</h4>
                        </div>
                        <div class="modal-body">
                            โปรดรอสักครู่..
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
            