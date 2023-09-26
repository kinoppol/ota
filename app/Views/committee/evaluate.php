<?php
list($l,$table)=treetotable(0,$tree);
//print_r($tree);
//print_r($table);
helper('evaluate');
helper('table');
helper('modal');
helper('thai');
helper('string');
$tableRows=array();
$i=0;
foreach($table as $row){
    $i++;
    $org_name='';

    $checked='';
    $label='ไม่ผ่าน';
    if(isset($scoreData[$row['id']])&&$scoreData[$row['id']]==1){
        $checked=' checked';
        $label='ผ่าน';
    }

    $tableRows[]=array(
        $i,
        strlim($row['subject'],100),
        isset($row['eva'])?'<a href="'.site_url('public/attach/file/'.$row['id'].'/'.$school_id).'" class="btn btn-warning waves-effect attachView" onClick="return false;"><i class="material-icons">source</i></a>':'',
        isset($row['eva'])?'<div class="form-group">
        <div class="form-line"><input type="checkbox" class="filled-in chk-col-green check_eva" id="'.$row['id'].'" name="'.$row['id'].'" value="'.$school_id.'_'.$row['id'].'"'.$checked.'/>
        <label id="label_'.$school_id.'_'.$row['id'].'" for="'.$row['id'].'">'.$label.'</label></div>':'',
    );
}
$tableArr=array('thead'=>array(
                        'ที่',
                        'ส่วน/ตัวบ่งชี้',
                        'หลักฐาน',
                        'ประเมิน',
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
                    <h3>สถานศึกษาที่รับการประเมิน <?php
                    print $school_name;
                    ?>
                    </h3>
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

            <?php
            $_SESSION['FOOTSCRIPT'].='
            $(".attachView").click(function(){
                var $this = $(this);
                var fileName=$this.attr("fileName");
                //alert("Hello");
                $("#viewAttach").modal("show");
                $("#fileViewer").html("");
                $("#fileViewer").load($this.attr("href"));
            });
            $(".chk_btn").click(function(){
                $(this).html("<i class=\'material-icons\'>check_box</i>");
            });

            $(".check_eva").change(function(){
                var eva_data=$(this).val();
                var send_data="";
                var element=$(this);
                $("#label_"+eva_data).text("รอสักครู่..");
                if($(this).is(":checked")){
                    send_data=eva_data+"_pass";
                    element.prop("checked",false);
                }else{
                    send_data=eva_data+"_none";
                    element.prop("checked",true);
                }
                
                    $.get("'.site_url('public/committee/save_eva/').'"+send_data,function(data){
                        //alert(data);
                        if(data=="pass"){
                            $("#label_"+eva_data).text("ผ่าน");
                            element.prop("checked",true);
                        }else{
                            $("#label_"+eva_data).text("ไม่ผ่าน");
                            element.prop("checked",false);
                        }
                    })
            });
    ';
$data=array(
    'id'=>'viewAttach',
    'size'=>'modal-lg',
    'title'=>'ดูหลักฐาน',
    'content'=>'<div id="fileViewer">โปรดรอสักครู่..</div>',
);
print genModal($data);

            ?>