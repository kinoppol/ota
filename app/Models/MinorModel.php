<?php

namespace App\Models;

use CodeIgniter\Model;

class MinorModel extends Model
{
    public function getMinor($minor_code=false){
        $db = \Config\Database::connect();
        $builder=$db->table('data_minor');
        if($minor_code){
            $builder->where('minor_code',$minor_code);            
            $data = $builder->get()->getResult();
            return $data[0];
        }
        $data = $builder->get()->getResult();
        $datas=array();
        foreach($data as $row){
            $datas[$row->minor_code]=$row->minor_name_th;
        }
        return $datas;
    }
}