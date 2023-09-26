<?php

function uploadPDF($inputName,$filePath,$filename=false){
    $hFiles=array();
		$hFiles[$inputName]=array();
        $i=0;
		foreach($_FILES[$inputName] as $k=>$v){
			foreach($v as $sk=>$sv){
				$hFiles[$inputName][$sk][$k]=$sv;
			}
            $i++;
		}
        $files=array();
		$i=0;
        //print_r($hFiles);
		foreach($hFiles[$inputName] as $file){
			if($file['type']!='application/pdf')continue;
			$i++;
			$pdf_name=!$filename?uniqid().'_'.$i.'.pdf':$filename;
			$pdf_file=$filePath.$pdf_name;
			$files[]=array(
				'name'=>$file['name'],
				'file'=>$pdf_name
			);
			move_uploaded_file($file['tmp_name'],$pdf_file);
            //print "UPLOAD ".$pic_name;
		}
        return $files;
}