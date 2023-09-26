<?php

namespace App\Models;

use CodeIgniter\Model;

class BocModel extends Model
{
    public function bocData(){
        $db = \Config\Database::connect();
        $builder=$db->table('boc_data');
        $builder->where('org_id','1300000000');
        $result = $builder->get()->getResult();
        return $result[0];
    }

    public function bocUpdate($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('boc_data');
        $builder->where('org_id',$id);
        $result=$builder->update($data);
        return $result;
    }
}