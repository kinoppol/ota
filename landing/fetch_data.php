<?php
ob_start();
session_start();

sleep(2);

$json_data=file_get_contents($_SESSION['last_code']);

$doc_data=json_decode($json_data);
$_SESSION['doc_data']=$doc_data;
print "ดึงข้อมูลสำเร็จ!<br> กำลังโหลดเอกสาร ".$doc_data->name;