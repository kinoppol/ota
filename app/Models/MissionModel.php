<?php

namespace App\Models;

use CodeIgniter\Model;

class MissionModel extends Model
{
    public function getMissionData($id){
        $db = \Config\Database::connect();
        $builder=$db->table('mission');
        $builder->where('id',$id);
        $result = $builder->get()->getResult();
        return $result[0];
    }
    public function getMission($data=array()){
        $db = \Config\Database::connect();
        $builder=$db->table('mission');
        if(is_array($data)&&count($data)>0){
            foreach($data as $k=>$v){
                if($k=='year'){
                    $builder->like('start_date',$v,'after');
                }else{
                    $builder->where($k,$v);
                }
            }
        }
        $result = $builder->get()->getResult();
        return $result;
    }
    public function addMission($data){
        $db = \Config\Database::connect();
        $builder = $db->table('mission');
        $result=$builder->insert($data);
        return $db->insertID();
    }
    
    public function updateMission($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('mission');
        $builder->where('id',$id);
        $result=$builder->update($data);
        return $result?$id:false;
    }
    public function deleteMission($id){
        $db = \Config\Database::connect();
        $builder = $db->table('mission');
        $builder->where('id',$id);
        $result=$builder->delete();
        return $result;
    }

    public function getCommittee($mission_id){
        $db = \Config\Database::connect();
        $builder = $db->table('userdata');
        $builder->where('user_active','Y');
        $builder->where('user_type','committee');
        $builder->where('ref_number !=','');
        $builder->orderBy('cast(ref_number as unsigned)');
        $result = $builder->get()->getResult();
        return $result;
    }
}