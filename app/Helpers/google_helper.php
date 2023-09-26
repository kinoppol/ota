<?php
//print_r($_POST);
function checkToken($data){
    $curl = curl_init();
    $API_URL="https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$data['token'];
    curl_setopt($curl, CURLOPT_URL,$API_URL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $result=curl_exec ($curl);
    $data=json_decode($result,true);
    curl_close ($curl);
//$data=json_decode(file_get_contents($API_URL),true);

    if($data['email']==$data['email']){
        $message=array(
            'status'=>'ok',
            'text'=>'Token is correct',
            'data'=>$data
        );
    }else{
        $message=array(
            'status'=>'false',
            'text'=>'Token is invalid',
        );
    }
    return $message;
}