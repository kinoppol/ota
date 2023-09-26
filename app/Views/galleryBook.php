<?php
    helper('modal');
    helper('string');
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
                            if(count($files)<1){
                                print "ขออภัยไม่พบข้อมูลเอกสาร";
                            }
                                foreach($files as $file){
                                    print pdf_widget($file);
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<?php
$delBtn=$deleteLink?'<a href=\"'.$deleteLink.'"+fileName+"\" class=\"btn btn-danger\" onClick=\"return confirm(\'ลบไฟล์?\');\"><i class=\"material-icons\">delete</i> ลบ</a>':'';
$_SESSION['FOOTSCRIPT'].='
        $(".fileView").click(function(){
            var $this = $(this);
            var fileName=$this.attr("fileName");
            //alert("Hello");
            $("#viewPic").modal("show");
            $("#fileViewer").html("<iframe id=\"iframepdf\" src=\""+$this.attr("href")+"\" width=\"100%\" height=\"600\"></iframe><br><br><div style=\"text-align:center;\">'.$delBtn.'</div>");
        });
';

$data=array(
    'id'=>'viewPic',
    'title'=>'ดูไฟล์',
    'content'=>'<div id="fileViewer">โปรดรอสักครู่..</div>',
);
print genModal($data);