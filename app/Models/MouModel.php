<?php

namespace App\Models;

use CodeIgniter\Model;

class MouModel extends Model
{
    public function getMouCount($data=false){
        $db = \Config\Database::connect();
        $builder=$db->table('mou');
        if(isset($data['org_code']))$builder->where('school_id',$data['org_code']);
        $mou = $builder->get()->getResult();
        $mouCount=count($mou);
        return $mouCount;
    }
    public function getMouData($id){
        $db = \Config\Database::connect();
        $builder=$db->table('mou');
        $builder->where('mou_id',$id);
        $mou = $builder->get()->getResult();
        return $mou[0];
    }
    public function getMou($data){
        //print_r($data);
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        if(isset($data['mou_id']))$builder->where('mou_id',$data['mou_id']);
        if(isset($data['school_id'])&&!is_array($data['school_id'])&&$data['school_id']!='*'){
            $builder->where('school_id',$data['school_id']);
        }else if(isset($data['school_id'])&&is_array($data['school_id'])){
            $builder->where('school_id in ('.implode(',',$data['school_id']).')');
        }
        if(isset($data['year']))$builder->like('mou_date',$data['year'],'after');
        $mou=$builder->get()->getResult();
        //print $db->getLastQuery();
        
        $business_ids=array();
        foreach($mou as $row){
            array_push($business_ids,$row->business_id);
        }
        //print_r($business_ids);
        $builder = $db->table('school');
        $schools=$builder->get()->getResult();
            $school=array();
            foreach($schools as $row){
                $school[$row->school_id]=$row->school_name;
            }
        $builder = $db->table('business');
        if(is_array($business_ids)&&count($business_ids)>0){
            $builder->where('business_id in ('.implode(',',$business_ids).')');
            $businesss=$builder->get()->getResult();
            $business=array();
            foreach($businesss as $row){
                $business[$row->business_id]=array('business_name'=>$row->business_name,
                                                'job_description'=>$row->job_description,
                                                    );
            }
        }else if(is_array($business_ids)&&count($business_ids)==0){
            $business=array();
        }
        
        $builder = $db->table('govdata');
        $govs=$builder->get()->getResult();
        $gov=array();
        foreach($govs as $row){
            $gov[$row->gov_id]=$row->gov_name;
        }
        $result=array(
            'mou'=>$mou,
            'school'=>$school,
            'business'=>$business,
            'gov'=>$gov,
        );
        //print $db->getLastQuery();
        return $result;
    }
    public function getMouYearCount($data){
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        if(isset($data['org_code']))$builder->where('school_id',$data['org_code']);
        $builder->like('mou_date',$data['year'],'after');
        $mou=$builder->get()->getResult();
        $mouCount=count($mou);
        return $mouCount;
    }
    public function getBusinessCount($data=false){
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        $builder->select('business_id');
        if(isset($data['org_code']))$builder->where('school_id',$data['org_code']);
        $builder->distinct();
        $business=$builder->get()->getResult();
        $businessCount=count($business);
        return $businessCount;
    }
    public function addMou($data){
		//print_r($data);
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        $result=$builder->insert($data);
        //print $db->getLastQuery();
        return $db->insertID();
    }
    
    public function updateMou($mou_id,$data){
		//print_r($data);
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        $builder->where('mou_id',$mou_id);
        $result=$builder->update($data);
        //print $db->getLastQuery();
        return $result?$mou_id:false;
    }
    public function deleteMou($id){
        $db = \Config\Database::connect();
        $builder = $db->table('mou');
        $builder->where('mou_id',$id);
        $result=$builder->delete();
        return $result;
    }

    public function curriculumAdd($data){
        $db = \Config\Database::connect();
        $builder = $db->table('curriculum');
        $result=$builder->insert($data);
        return $result;
    }

    public function curriculumUpdate($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('curriculum');
        $builder->where('id',$id);
        $result=$builder->update($data);
        return $result;
    }
    public function curriculumDelete($id){
        $db = \Config\Database::connect();
        $builder = $db->table('curriculum');
        $builder->where('id',$id);
        $result=$builder->delete();
        return $result;
    }
    
    public function curriculumGet($data){
        $db = \Config\Database::connect();
        $builder = $db->table('curriculum');
        if(isset($data['id']))$builder->where('id',$data['id']);
        if(isset($data['curriculum_year']))$builder->where('curriculum_year',$data['curriculum_year']);
        if(isset($data['school_id'])&&!is_array($data['school_id'])&&$data['school_id']!='*'){
            $builder->where('school_id',$data['school_id']);
        }else if(isset($data['school_id'])&&is_array($data['school_id'])){
                $builder->where('school_id in ('.implode(',',$data['school_id']).')');
            }
        $builder->orderBy('business_id');
        $curriculum=$builder->get()->getResult();
        //print $db->getLastQuery();
        if(count($curriculum)<1){
            return $data=array('curriculum'=>array(),
            'business'=>array());
        }
        $business_ids=array();
        foreach($curriculum as $row){            
            array_push($business_ids,$row->business_id);
        }

        $builder = $db->table('business');
        $builder->where('business_id in ('.implode(',',$business_ids).')');
        $businesss=$builder->get()->getResult();
        $business=array();
        
        foreach($businesss as $row){
            $business[$row->business_id]=array('business_name'=>$row->business_name,
                                             'job_description'=>$row->job_description,
                                                );
        }

        $data=array('curriculum'=>$curriculum,
        'business'=>$business);
        return $data;
    }
    public function resultAdd($data){
        $db = \Config\Database::connect();
        $builder = $db->table('mou_result');
        $result=$builder->insert($data);
        //print $db->getLastQuery();
        return $result;
    }
    public function resultUpdate($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('mou_result');
        $builder->where('id',$id);
        $result=$builder->update($data);
        //print $db->getLastQuery();
        return $result;
    }

    public function resultGet($data){
        $db = \Config\Database::connect();
        $builder = $db->table('mou_result');
        if(isset($data['id']))$builder->where('id',$data['id']);
        if(isset($data['result_year']))$builder->where('result_year',$data['result_year']);
        if(isset($data['school_id'])&&!is_array($data['school_id'])&&$data['school_id']!='*'){
            $builder->where('school_id',$data['school_id']);
        }else if(isset($data['school_id'])&&is_array($data['school_id'])){
                $builder->where('school_id in ('.implode(',',$data['school_id']).')');
            }
        $builder->orderBy('business_id');
        $result=$builder->get()->getResult();
        //print $db->getLastQuery();
        if(count($result)<1){
            return $data=array('result'=>array(),
            'business'=>array());
        }
        $business_ids=array();
        foreach($result as $row){            
            array_push($business_ids,$row->business_id);
        }

        $builder = $db->table('business');
        $builder->where('business_id in ('.implode(',',$business_ids).')');
        $businesss=$builder->get()->getResult();
        $business=array();
        
        foreach($businesss as $row){
            $business[$row->business_id]=array('business_name'=>$row->business_name,
                                             'job_description'=>$row->job_description,
                                                );
        }

        $data=array('result'=>$result,
        'business'=>$business);
        return $data;
    }
    public function resultDelete($id){
        $db = \Config\Database::connect();
        $builder = $db->table('mou_result');
        $builder->where('id',$id);
        $result=$builder->delete();
        return $result;
    }
}