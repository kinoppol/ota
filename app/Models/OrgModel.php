<?php

namespace App\Models;

use CodeIgniter\Model;

class OrgModel extends Model
{
    public function getSchool($data=array()){
        $db = \Config\Database::connect();
        $builder = $db->table('school');
        if(isset($data['province_id']))$builder->where('province_id',$data['province_id']);
        if(isset($data['zone_id']))$builder->where('zone',$data['zone_id']);
        $data=$builder->get()->getResult();
            $datas=array();
            foreach($data as $row){
                $datas[$row->school_id]=$row->school_name;
            }
        return $datas;
    }
    public function updateSchool($school_id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('school');
        $builder->where('school_id', $school_id);
        $result=$builder->update($data);
        return $result;
    }
    public function schoolData($school_id){
        if(trim($school_id)=='')return false;
        $db = \Config\Database::connect();
        $builder = $db->table('school');
        $builder->where('school_id',$school_id);
        $data=$builder->get()->getResult();
            return $data[0];

    }

    public function getZone(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_zone');
        $data=$builder->get()->getResult();
        $ret=array();
        foreach($data as $row){
            $ret[$row->zone_id]=$row->zone_name;
        }
            return $ret;

    }

    public function getProvince(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_province');
        $data=$builder->get()->getResult();
        $ret=array();
        foreach($data as $row){
            $ret[$row->province_code]=$row->province_name;
        }
            return $ret;

    }

    public function getDistrict($province_code){
        $db = \Config\Database::connect();
        $builder = $db->table('data_district');
        $builder->where('province_code',$province_code);
        $builder->select('district_code,district_name');
        $data=$builder->get()->getResult();
        $ret=array();
        foreach($data as $row){
            $ret[]=array(
                'district_code'=>$row->district_code,
                'district_name'=>$row->district_name,
            );
        }
        return $ret;

    }


    public function getSubDistrict($district_code){
        $db = \Config\Database::connect();
        $builder = $db->table('data_subdistrict');
        $builder->where('district_code',$district_code);
        $builder->select('subdistrict_code,subdistrict_name');
        $data=$builder->get()->getResult();
        $ret=array();
        foreach($data as $row){
            $ret[]=array(
                'subdistrict_code'=>$row->subdistrict_code,
                'subdistrict_name'=>$row->subdistrict_name,
            );
        }
        return $ret;

    }

    
    public function getInstitute(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_institute');
        $data=$builder->get()->getResult();
            $datas=array();
            foreach($data as $row){
                $datas[$row->institute_id]=$row->institute_name;
            }
        return $datas;
    }

}
