<?php

namespace App\Models;

use CodeIgniter\Model;

class ScoreModel extends Model
{
    public function getScoreData($data){
        $db = \Config\Database::connect();
        $builder=$db->table('score');
        if(isset($data['school_id']))$builder->where('school_id',$data['school_id']);
        if(isset($data['committee_id']))$builder->where('committee_id',$data['committee_id']);
        if(isset($data['indicator_id']))$builder->where('indicator_id',$data['indicator_id']);
        $result = $builder->get()->getResult();
        if(count($result)<1){
            return false;
        }else if(count($result)==1){
            return $result[0];
        }else{
            return $result;
        }
    }
    public function addScore($data){
        $db = \Config\Database::connect();
        $builder = $db->table('score');
        $result=$builder->insert($data);
        return $result;
    }
    
    public function updateScore($school_id,$committee_id,$indicator_id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('score');
        $builder->where('school_id',$school_id);
        $builder->where('committee_id',$committee_id);
        $builder->where('indicator_id',$indicator_id);
        $result=$builder->update($data);
        return $result;
    }
}