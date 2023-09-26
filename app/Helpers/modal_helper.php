<?php
function genModal($data){
    $size='';
    if(!isset($data['dismissBtn'])){
    $dismissBtn='<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ปิด</button>';
    }else{
        $dismissBtn=$data['dismissBtn'];
    }
    if(isset($data['size']))$size=' '.$data['size'];
    else $size=' ';
    $ret='<div class="modal fade" id="'.$data['id'].'" tabindex="-1" role="dialog">
    <div class="modal-dialog'.$size.'" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">'.$data['title'].'</h4>
            </div>
            <div class="modal-body">
                '.$data['content'].'
            </div>
            <div class="modal-footer">
            '.$dismissBtn.'
            </div>
        </div>
        </div>
        </div>';

    return $ret;
}