<?php
ob_start();
session_start();

sleep(2);

if($_SESSION['doc_data']->type=='doc'){
    $cmd='PDFtoPrinter.exe '.'doc_file/' . $_SESSION['doc_data']->name;
    
}else{
    $cmd='mspaint /p '.'doc_file/' . $_SESSION['doc_data']->name;
}

$print=exec($cmd);

print "สั่งพิมพ์สำเร็จ";