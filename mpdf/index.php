<?php
error_reporting(0);
	$pdf_data=array(
        'html'=>$html,
        'size'=>"A4",
        'fontsize'=>18,
        'marginL'=>20,
        'marginR'=>10,
        'marginT'=>10,
        'marginB'=>10,
        'header'=>'',
        'wartermark'=>'',
        'wartermarkimage'=>'',
        'footer'=>'This document was created by printStation system of information centre at bangna commercial college. '.date('Y-m-d H:i:s'),
        //'header'=>'<div style="text-align: right; font-weight: normal;">หน้า {PAGENO}/{nbpg}</div>'
    );
    //print $html;
    genPdf($pdf_data,$pageNo=NULL,$location='c:\pdf\\',$fname='mou.pdf');
	//print 555;
	function genPdf($data,$pageNo=NULL,$location=NULL,$fname=NULL){
	   $html=$data['html'];
	   $size=$data['size'];
	   $header=$data['header'];
	   $footer=$data['footer'];
	   $marginL=$data['marginL']?$data['marginL']:10;
	   $marginR=$data['marginR']?$data['marginR']:10;
	   $marginT=$data['marginT']?$data['marginT']:5;
	   $marginB=$data['marginB']?$data['marginB']:0;
	   $fontsize=$data['fontsize'];
	   $wartermark=$data['wartermark'];
	   $wartermarkimage=$data['wartermarkimage'];
            //error_reporting(0);
            global $app;
           //$html.="<hr>";
            $path="mpdf.php";
                //print $path;
		include_once($path);
		$pdf = new mPDF('th',$size, $fontsize, 'norasi',$left=$marginL,$right=$marginR,$top=$marginT,$bottom=$marginB); 
		if(isset($wartermark)&&$wartermark!=""){
		   $pdf->SetWatermarkText(thai($wartermark),0.4);
		   $pdf->showWatermarkText = true;
		}
		if(isset($wartermarkimage)&&$wartermarkimage!==""){
         $pdf->SetWatermarkImage($wartermarkimage,0.3);
         $pdf->showWatermarkImage = true;
		   
		}
		
		$pdf->format=array(100,100);
		$pdf->showImageErrors = true;
		//$pdf->use_kwt = false;
		
		//$pdf->SetAutoFont();
		//$pdf->AddPage('L','','','','',25,25,55,45,18,12);
		$pdf->SetDisplayMode('fullpage');
		if($pageNo){
                $pdf->SetHTMLHeader('<div style="text-align: right; font-weight: normal;">'.thai($pageNo).'</div>');
		}
		if($header){
                $pdf->SetHTMLHeader(thai($header));
		}
		if($footer){
                $pdf->SetFooter(thai($footer));
		}
		$pdf->WriteHTML(thai($html), 2);
		//$pdf->WriteHTML($html, 2);
		if(!$fname)$fname=time().".pdf";
		if(isset($location)){
		$pf=$location.$fname;
		$pdf->Output($pf);
		}else{
		$pdf->Output();
		}
                //print $foutput;
		if(file_exists($pf)) return $fname;
                else return 0;
	}
	
	function thai($x) { //แก้ไขวรรณยุกต์ลอย
	$back = array(
		"\xE0\xB9\x88" => "\xEF\x9C\x8A", //ไม้เอก
		"\xE0\xB9\x89" => "\xEF\x9C\x8B", //ไม้โท
		"\xE0\xB9\x8A" => "\xEF\x9C\x8C", //ไม้ตรี
		"\xE0\xB9\x8B" => "\xEF\x9C\x8D", //ไม้จัตวา
		"\xE0\xB9\x8C" => "\xEF\x9C\x8E"  //ไม้ทัณฑฆาต
	);
	$cross = array();
	$j=0;
	foreach (array("\xe0\xb8\xb1","\xe0\xb8\xb3","\xE0\xB8\xB4", "\xE0\xB8\xB5", "\xE0\xB8\xB6", "\xE0\xB8\xB7") as $p) { // ั ำ  ิ  ี ึ ื
		for ($i = 0x8A; $i <= 0x8E; $i ++) { //0x85 - 0x89 วรรณยุกต์เคลื่อนไปข้างหน้าเกินไปไม่สวย จึงใช้ 0x8A - 0x8E แทน
		  if($j==1) { // ำ สระอำวางหลังวรรณยุกต์
		   $from = "\xEF\x9C" . chr($i).$p;
		   $to   = "\xE0\xB9" . chr($i - 2).$p; //0x85 - 0x89 = +3 , 0x8A - 0x8E = -2
		  }else{
			$from = $p . "\xEF\x9C" . chr($i);
			$to   = $p . "\xE0\xB9" . chr($i - 2); //0x85 - 0x89 = +3 , 0x8A - 0x8E = -2
		  }
			$cross[$from] = $to;
		}
		$j++;
	}
	//หางยาว
	$front =array();
	foreach (array("\xE0\xB8\x9B","\xE0\xB8\x9D", "\xE0\xB8\x9F", "\xE0\xB8\xAC") as $p) { // ป ฝ ฟ ฬ พยัญชนะ หางยาว ต้องเลื่อนสระไปข้างหน้า
		for ($i = 0xB4; $i <= 0xB7; $i ++) {//  ิ  ี ึ ื บนพยัญชนะหางยาว
			$from = $p . "\xE0\xB8" . chr($i);
			$to   = $p . "\xEF\x9C" . chr($i-51); 

			$front[$from] = $to;
		}
		for ($i = 0x8A; $i <= 0x8E; $i ++) {// วรรณยุกต์บน พยัญชนะหางยาว
			$from = $p . "\xEF\x9C" . chr($i);
			$to   = $p . "\xEF\x9C" . chr($i-5); 

			$front[$from] = $to;
		}
	}
	
	$crossFront =array();
	$j=0;
	foreach (array("\xEF\x9C\x81","\xEF\x9C\x82","\xEF\x9C\x83", "\xEF\x9C\x84") as $p) { //  ิ  ี ึ ื บนพยัญชนะหางยาว เอามาใส่วรรณยุกต์
		for ($i = 0x88; $i <= 0x8C; $i ++) {

			$from = $p . "\xE0\xB9" . chr($i);
			$to   = $p . "\xef\x9c" . chr($i+11); //0x85 - 0x89 = +3 , 0x8A - 0x8E = -2

			$crossFront[$from] = $to;
		}
		$j++;
	}
	
	$x = strtr($x, $back);
	$x = strtr($x, $cross);
	$x = strtr($x, $front);
	$x = strtr($x, $crossFront);
	return $x;
}
