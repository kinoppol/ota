<?php
function resize($image_name,$new_width,$new_height,$new_thumb_loc,$outputExt=false)
{
    $path = $image_name;

    $mime = getimagesize($path);

    if($mime['mime']=='image/png') { 
        $src_img = imagecreatefrompng($path);
    }else if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg') {
        $src_img = imagecreatefromjpeg($path);
    }else{
        return 'noimg';
    }   

    $old_x          =   imageSX($src_img);
    $old_y          =   imageSY($src_img);

    $dif_x          =   $old_x/$new_height;
    $dif_y          =   $old_y/$new_width;

    if($old_x<$new_height&&$old_y<$new_width){
        $thumb_w=$old_x;
        $thumb_h=$old_y;
    }else{

        if($dif_x > $dif_y) 
        {
            $thumb_w    =   $old_x/$dif_x;
            $thumb_h    =   $old_y/$dif_x;
        }

        if($dif_x < $dif_y) 
        {
            $thumb_w    =   $old_x/$dif_y;
            $thumb_h    =   $old_y/$dif_y;
        }

        if($dif_x == $dif_y) 
        {
            $thumb_w    =   $old_x/$dif_x;
            $thumb_h    =   $old_y/$dif_y;
        }
    }

    $dst_img        =   ImageCreateTrueColor($thumb_w,$thumb_h);

    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


    if($mime['mime']=='image/png'&&!$outputExt||$outputExt=='png') {
        $result = imagepng($dst_img,$new_thumb_loc,8);
    }
    if($mime['mime']=='image/jpg' || $mime['mime']=='image/jpeg' || $mime['mime']=='image/pjpeg'||$outputExt=='jpg') {
        $result = imagejpeg($dst_img,$new_thumb_loc,80);
    }

    imagedestroy($dst_img); 
    imagedestroy($src_img);

    return $result;
}

function uploadPic($inputName,$filePath){
    $hFiles=array();
		$hFiles[$inputName]=array();
        $i=0;
		foreach($_FILES[$inputName] as $k=>$v){
			foreach($v as $sk=>$sv){
				$hFiles[$inputName][$sk][$k]=$sv;
			}
            $i++;
		}
        $pictures=array();
		$i=0;
        //print_r($hFiles);
		foreach($hFiles[$inputName] as $pic){
			if($pic['type']!='image/jpeg'&&$pic['type']!='image/png')continue;
			$i++;
			$pic_name=uniqid().'_'.$i.'.jpg';
			$picture=$filePath.$pic_name;
			$pictures[]=$pic_name;
			//move_uploaded_file($pic['tmp_name'],$picture);
            //print "UPLOAD ".$pic_name;
            resize($pic['tmp_name'],2480,3508,$picture);
		}
        return $pictures;
}