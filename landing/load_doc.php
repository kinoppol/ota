<?php
ob_start();
session_start();

$server_url='https://print.bncc.ac.th/printStation';

sleep(2);

$file_url=$server_url.'/'.$_SESSION['doc_data']->file_location;

$file_data=file_get_contents($file_url);

file_put_contents("doc_file/" . $_SESSION['doc_data']->name,$file_data);

print "โหลดเอกสารสำเร็จ! ".$file_url."<br> กำลังสั่งพิมพ์...";