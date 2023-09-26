<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    public function getBusiness($business_id=false){
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        if($business_id)$builder->where('business_id',$business_id);
        $data=$builder->get()->getResult();
        if($business_id) return $data[0];
            $datas=array();
            foreach($data as $row){
                $datas[$row->business_id]=array(
                    'business_id'=>$row->business_id,
                    'business_name'=>$row->business_name,
                    'job_description'=>$row->job_description,
                    'province_id'=>$row->province_id,
                    'district_id'=>$row->district_id,
                    'subdistrict_id'=>$row->subdistrict_id,
                    'road'=>$row->road,
                    'address_no'=>$row->address_no,
                    'location'=>$row->location,
                    'picture'=>$row->picture,
                );
            }
        return $datas;
    }
    public function searchBusiness($data){
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        if(isset($data['province_id']))$builder->where('province_id', $data['province_id']);
        if(isset($data['q']))$builder->like('business_name', $data['q'], 'both');
        $data=$builder->get()->getResult();
            $datas=array();
            foreach($data as $row){
                $datas[$row->business_id]=array(
                    'business_id'=>$row->business_id,
                    'business_name'=>$row->business_name,
                    'province_id'=>$row->province_id,
                    'district_id'=>$row->district_id,
                    'subdistrict_id'=>$row->subdistrict_id,
                    'road'=>$row->road,
                    'address_no'=>$row->address_no,
                    'location'=>$row->location,
                    'picture'=>$row->picture,
                );
            }
        return $datas;
    }
    public function businessAdd($data){
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        $result=$builder->insert($data);
        //print $db->getLastQuery();
        return $result;
    }
    public function businessUpdate($business_id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('business');
        $builder->where('business_id',$business_id);
        $result=$builder->update($data);
        //print $db->getLastQuery();
        return $result;
    }
}