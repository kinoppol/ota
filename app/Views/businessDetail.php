<?php
    //print_r($schoolData);
    helper('form');
    $data=array(array(
        'label'=>'ชื่อสถานประกอบการ',
        'type'=>'text',
        'id'=>'business_name',
        'def'=>isset($businessData->business_name)?$businessData->business_name:'',
        'required'=>true,
         ),
         array(
            'type'=>'hidden',
            'id'=>'business_id',
            'def'=>isset($businessData->business_id)?$businessData->business_id:false,
            'disabled'=>isset($businessData->business_id)?false:true,
             ),
         array(
            'label'=>'หมายเลขประจำตัวผู้เสียภาษี',
            'type'=>'text',
            'id'=>'vat_id',
            'def'=>isset($businessData->vat_id)?$businessData->vat_id:'',
             ),
         array(
            'label'=>'จังหวัด',
            'type'=>'select',
            'id'=>'province_id',
            'items'=>$province,
            'noneLabel'=>'โปรดเลือกจังหวัด',
            'def'=>isset($businessData->province_id)?$businessData->province_id:'',
            'required'=>true,
             ),
         array(
            'label'=>'อำเภอ/เขต',
            'type'=>'select',
            'id'=>'district_id',
            'items'=>isset($district)?$district:array(),
            'noneLabel'=>'โปรดเลือกอำเภอ/เขต',
            'def'=>isset($businessData->district_id)?$businessData->district_id:'',
            'required'=>true,
             ),
         array(
            'label'=>'ตำบล/แขวง',
            'type'=>'select',
            'id'=>'subdistrict_id',
            'items'=>isset($subdistrict)?$subdistrict:array(),
            'noneLabel'=>'โปรดเลือกตำบล/แขวง',
            'def'=>isset($businessData->subdistrict_id)?$businessData->subdistrict_id:'',
            'required'=>true,
             ),
         array(
            'label'=>'ถนน',
            'type'=>'text',
            'id'=>'road',
            'def'=>isset($businessData->road)?$businessData->road:'',
            'required'=>false,
             ),
         array(
            'label'=>'เลขที่',
            'type'=>'text',
            'id'=>'address_no',
            'def'=>isset($businessData->address_no)?$businessData->address_no:'',
            'required'=>true,
             ),
         array(
            'label'=>'ลักษณะของกิจการ',
            'type'=>'text',
            'id'=>'job_description',
            'def'=>isset($businessData->job_description)?$businessData->job_description:'',
            'required'=>true,
            'placeholder'=>'เช่น ค้าปลีก,บริการหลังการขาย',
             ),
         array(
            'label'=>'จำนวนพนักงาน',
            'type'=>'number',
            'id'=>'amount_emp',
            'def'=>isset($businessData->amount_emp)?$businessData->amount_emp:'',
            'required'=>true,
             ),
         array(
            'label'=>'อีเมล',
            'type'=>'email',
            'id'=>'email',
            'def'=>isset($businessData->email)?$businessData->email:'',
             ),
         array(
            'label'=>'สิทธิ์ลดหย่อนภาษี',
            'type'=>'check_group',
            'id'=>'tax_break',
            'def'=>'',
            'items'=>array(
                'tax_break'=>array(
                    'text'=>'ใช้สิทธิ์ลดหย่อนภาษี',
                    'value'=>'Y',
                    'checked'=>isset($businessData->tax_break)&&$businessData->tax_break=='ใช้สิทธิ์'?true:false,
                                )
            ),
            'required'=>true,
             ),
         array(
            'label'=>'ประเทศที่ตั้งของสถานประกอบการ',
            'type'=>'text',
            'id'=>'country',
            'def'=>isset($businessData->country)&&$businessData->country!=''?$businessData->country:'ประเทศไทย',
            'required'=>true,
             ),
         array(
            'label'=>'พิกัดที่ตั้ง <a href="'.site_url('images/map.jpg').'" target="_blank">คลิกเพื่อดูวิธีทำ</a> (เข้า GoogleMap คลิกขวาที่ตั้งสถานประกอบการแล้วคัดลอกพิกัดที่ตั้งมาวาง) ',
            'type'=>'text',
            'id'=>'location',
            'placeholder'=>'เช่น 13.60502042693827, 100.5964253312417',
            'def'=>isset($businessData->location)?$businessData->location:'',
             ),
             
         array(
            'label'=>'ภาพถ่ายหน้าสถานประกอบการ',
            'type'=>'file',
            'id'=>'picture',
            'multiple'=>true,
            'def'=>isset($businessData->picture)?$businessData->picture:'',
             ),
         array(
             'label'=>'บันทึกข้อมูล',
             'type'=>'submit',
         ),
    );

    $form=array(
        'id'=>'business_form',
        'formName'=>'ข้อมูลสถานประกอบการ',
        'inputs'=>$data,
        'action'=>site_url('public/business/saveBusiness'),
        'method'=>'post',
        'onSubmit'=>'return chk_dup();',
        'enctype'=>'multipart/form-data',
    );
    
    $_SESSION['FOOTSCRIPT']='

var last_check=false;
function chk_dup(){
  if(last_check==false){
    $.post("'.site_url('public/business/check_duplicate').'",
    {
      businessName: $("#business_name").val(),
      vat_id: $("#vat_id").val(),
      province_id: $("#province_id").val(),
      district_id: $("#district_id").val(),
      subdistrict_id: $("#subdistrict_id").val(),
    },
    function(data, status){
      var response=JSON.parse(data);
        if(parseInt(response["percent"])<85){
          last_check=true;
          $("#business_form").submit();
          last_check=false;
        }else{
          alert("555");
        }
      });
    return false;
  }else{
    return true;
  }
}
    $("#province_id").change(function(){
        var p_code=$(this).val();
        $("#subdistrict_id").html("<option value=\"\">โปรดเลือกตำบล/แขวง</option>");
        $("#district_id").html("<option value=\"\">โปรดเลือกอำเภอ/เขต</option>");
    
        $.get("'.site_url('public/business/districtInProvince/').'"+p_code,function(data){


            var result=JSON.parse(data);
            $.each(result,function(index,item){
                $("#district_id").append(
                    $("<option></option>").val(item.district_code).html(item.district_name)
                );
            });
    
        })
    });
    
    $("#district_id").change(function(){
        var d_code=$(this).val();
        $("#subdistrict_id").html("<option value=\"\">โปรดเลือกตำบล/แขวง</option>");
    
        $.get("'.site_url('public/business/subdistrictInDistrict/').'"+d_code,function(data){
            var result=JSON.parse(data);
            $.each(result,function(index,item){
                $("#subdistrict_id").append(
                    
                    $("<option></option>").val(item.subdistrict_code).html(item.subdistrict_name)
                );
            });
    
        })
    });
    ';

    print genForm($form);