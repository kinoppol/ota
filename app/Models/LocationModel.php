<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    public function getProvince(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_province');
        $result = $builder->get()->getResult();
        $province=array();
        foreach($result as $row){
            $province[$row->province_code]=$row->province_name;
        }

        return $province;
    }

    public function getDistrict(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_district');
        $result = $builder->get()->getResult();
        $district=array();
        foreach($result as $row){
            $district[$row->district_code]=$row->district_name;
        }

        return $district;
    }

    public function getSubdistrict(){
        $db = \Config\Database::connect();
        $builder = $db->table('data_subdistrict');
        $result = $builder->get()->getResult();
        $subdistrict=array();
        foreach($result as $row){
            $subdistrict[$row->subdistrict_code]=$row->subdistrict_name;
        }

        return $subdistrict;
    }
}