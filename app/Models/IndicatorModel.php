<?php

namespace App\Models;

use CodeIgniter\Model;

class IndicatorModel extends Model
{
    public function getIndicatorData($id){
        $db = \Config\Database::connect();
        $builder=$db->table('indicator');
        $builder->where('id',$id);
        $result = $builder->get()->getResult();
        return $result[0];
    }
    public function getIndicator($data=array()){
        $db = \Config\Database::connect();
        $builder=$db->table('indicator');
        if(is_array($data)&&count($data)>0){
            foreach($data as $k=>$v){
                    $builder->where($k,$v);
            }
        }
        $result = $builder->get()->getResult();
        //print $db->getLastQuery();
        return $result;
    }
    public function addIndicator($data){
        $db = \Config\Database::connect();
        $builder = $db->table('indicator');
        $result=$builder->insert($data);
        return $db->insertID();
    }
    
    public function updateIndicator($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('indicator');
        $builder->where('id',$id);
        $result=$builder->update($data);
        return $result?$id:false;
    }
    public function deleteIndicator($id){
        $db = \Config\Database::connect();
        $builder = $db->table('indicator');
        $builder->where('id',$id);
        $result=$builder->delete();
        return $result;
    }
}