<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluateModel extends Model
{
    public function addSubmission($data){
        $db = \Config\Database::connect();
        $builder=$db->table('submission');
        $result=$builder->insert($data);
        return $db->insertID();
    }
    public function updateSubmission($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('submission');
        $builder->where('id',$id);
        $result=$builder->update($data);
        //print $db->getLastQuery();
        return $result?$id:false;
    }
    public function getSubmissionData($data){
        $db = \Config\Database::connect();
        $builder=$db->table('submission');
        $builder->where('school_id',$data['school_id']);
        $builder->where('indicator_id',$data['indicator_id']);
        $result = $builder->get()->getResult();
        return isset($result[0])?$result[0]:false;
    }
    public function schoolList(){
        $db = \Config\Database::connect();
        $builder=$db->table('userdata');
        $builder->select('org_code,school_name');
        $builder->join('school','userdata.org_code=school.school_id');
        $builder->where(['user_type'=>'school']);
        $builder->distinct();
        $result=$builder->get()->getResult();
        //print $db->getLastQuery();
        return $result;
        
    }

    public function schoolEvaList($mission_id,$ref_no){
        $db = \Config\Database::connect();
        $builder=$db->table('committee_group');
        $builder->select('school_id');
        $builder->where(['member_no'=>$ref_no]);
        $builder->orLike('member_no',$ref_no.',','after');
        $builder->orLike('member_no',','.$ref_no,'before');
        $builder->orLike('member_no',','.$ref_no.',','both');
        $result=$builder->get()->getResult();
        //print $db->getLastQuery();
        $a=explode(',',$result[0]->school_id);
        $b=array();
        foreach($a as $k=>$v){
            $b[$k]=trim($v);
        }
        return $b;
        
    }

    public function sumChildScore($data){
        $db = \Config\Database::connect();
        $builder=$db->table('indicator');
        $builder->where('parent_id',$data['parent_id']);
        $result = $builder->get()->getResult();
        $ind_id=array();
        foreach($result as $row){
            $ind_id[]=$row->id;
        }

        $builder=$db->table('score');
        $builder->where('school_id',$data['school_id']);
        $builder->where('committee_id',$data['committee_id']);
        $builder->whereIn('indicator_id',$ind_id);
        $result = $builder->get()->getResult();
        $sum=0;
        //print $db->getLastQuery();
        foreach($result as $row){
            $sum+=$row->score;
        }
        return $sum;
    }
    public function sumGiveScore($data){
        $db = \Config\Database::connect();
        $builder=$db->table('indicator');
        $builder->where('mission_id',$data['mission_id']);
        $result = $builder->get()->getResult();
        $ind_id=array();
        foreach($result as $row){
            $ind_id[]=$row->id;
        }

        $builder=$db->table('score');
        $builder->where('school_id',$data['school_id']);
        $builder->where('committee_id',$data['committee_id']);
        $builder->whereIn('indicator_id',$ind_id);
        $result = $builder->get()->getResult();
        $sum=0;
        //print $db->getLastQuery();
        foreach($result as $row){
            $sum+=$row->score;
        }
        return $sum;
    }
}