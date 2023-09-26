<?php
    helper('modal');
    helper('gallery');
?>
<style>
    .gallery_image{
        object-fit: cover;
    }
</style>
<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header"><?php
                           print $galleryName;
                        ?>
                        </div>
                        <div class="body">
                                        <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            <?php
                            if(count($pictures)<1){
                                print "ขออภัยไม่พบข้อมูลรูปภาพ";
                            }
                                foreach($pictures as $pic){
                                   print pic_widget($pic);
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<?php
$delBtn=$deleteLink?'<a href=\"'.$deleteLink.'"+imageName+"\" class=\"btn btn-danger\" onClick=\"return confirm(\'ลบรูป?\');\"><i class=\"material-icons\">delete</i> ลบ</a>':'X';
$_SESSION['FOOTSCRIPT'].='
        $(".picView").click(function(){
            var $this = $(this);
            var imageName=$this.attr("picName");
            //alert("Hello");
            $("#viewPic").modal("show");
            $("#picViewer").html("<img src=\""+$this.attr("href")+"\" width=\"100%\"><br><br><div style=\"text-align:center;\">'.$delBtn.'</div>");
        });
';

$data=array(
    'id'=>'viewPic',
    'title'=>'ดูรูป',
    'content'=>'<div id="picViewer">โปรดรอสักครู่..</div>',
);
print genModal($data);