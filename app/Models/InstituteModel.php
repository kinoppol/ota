<?php

namespace App\Models;

use CodeIgniter\Model;

class InstituteModel extends Model
{
    public function getSchool($institute_id){
        $db = \Config\Database::connect();
        $builder=$db->table('school');
        $builder->where('institute_id',$institute_id);
        $result = $builder->get()->getResult();
        $data=array();
        foreach($result as $row){
            $data[]=$row->school_id;
        }
        return $data;
    }
    public function getInstituteData($institute_id){
        $db = \Config\Database::connect();
        $builder=$db->table('data_institute');
        $builder->where('institute_id',$institute_id);
        $result = $builder->get()->getResult();
        return $result[0];
    }

    public function instituteUpdate($id,$data){
        $db = \Config\Database::connect();
        $builder = $db->table('data_institute');
        $builder->where('institute_id',$id);
        $result=$builder->update($data);
        return $result;
    }
}