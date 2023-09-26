<?php
helper('array');

function genForm($data){
    $enctype='';
    $onSubmit='';
    if(isset($data['enctype']))$enctype=' enctype="multipart/form-data"';
    if(isset($data['onSubmit']))$onSubmit=' onSubmit="'.$data['onSubmit'].'"';
    $ret='<div class="card">
    <div class="header">
        <h2>
            '.$data['formName'].'
        </h2>
        <div class="body">
                            <form id="'.(isset($data['id'])?$data['id']:'form_data').'" action="'.$data['action'].'" method="'.$data['method'].'"'.$enctype.$onSubmit.'>'.
                            genInput($data['inputs'])
                            .'</form>
                            </div>
                            </div>';

    return $ret;
}

function genInput($data){
    $ret='';
    if(is_marray($data)&&!isset($data['type'])){
        foreach($data as $row){
            $ret.=genInput($row);
        }
    }else{
        if(!isset($data['type']))return '';
            if(is_numeric(array_search($data['type'],array('text','password','email','date','time','number','file')))){
                $ret.=genInput_textbox($data);
            }else if(is_numeric(array_search($data['type'],array('select')))){
                $ret.=genInput_select($data);
            }else if(is_numeric(array_search($data['type'],array('submit')))){
                $ret.=genInput_submit($data);
            }else if(is_numeric(array_search($data['type'],array('hidden')))){
                $ret.=genInput_hidden($data);
            }else if(is_numeric(array_search($data['type'],array('check_group')))){
                $ret.=genInput_check_group($data);
            }else if(is_numeric(array_search($data['type'],array('textarea')))){
                $ret.=genInput_textarea($data);
            }else if(is_numeric(array_search($data['type'],array('div')))){
                $ret.='<div class="form-line" id="'.$data['id'].'">'.genInput($data['items']).'</div>';
            }

        }
    
    return $ret;
}

function genInput_textbox($data){
    $min='';
    $max='';
    $accept='';
    $multiple='';
    if(isset($data['min']))$min=' min="'.$data['min'].'"';
    if(isset($data['max']))$max=' max="'.$data['max'].'"';
    if(isset($data['accept']))$accept=' accept="'.$data['accept'].'"';
    if(isset($data['multiple'])){
        if(mb_substr($data['id'],mb_strlen($data['id'])-2,2)!='[]'){
            $data['id'].='[]';
        }
        $multiple=' multiple';
    }
    $ret='<label for="'.$data['id'].'">'.$data['label'].(isset($data['required'])&&$data['required']?'<span style="color:red;">*</span>':'').'</label>
            <div class="form-group">
                <div class="form-line">
                    <input type="'.$data['type'].'" name="'.$data['id'].'" id="'.$data['id'].'" class="form-control '.
                        (isset($data['class'])?$data['class']:'').
                        '" placeholder="'.(isset($data['placeholder'])?$data['placeholder']:'').
                        '" value="'.(isset($data['def'])?$data['def']:'').
                        '" '.$min.$max.$accept.$multiple.(isset($data['required'])&&$data['required']?' required':'').
                        ''.(isset($data['disabled'])&&$data['disabled']?'disabled':'').
                        ''.(isset($data['autocomplete'])?' autocomplete="'.$data['autocomplete'].'"':'').'/>
                    </div>
                </div>';
        return $ret;
}

function genInput_textarea($data){
    $min='';
    $max='';
    $accept='';
    $multiple='';
    if(isset($data['min']))$min=' min="'.$data['min'].'"';
    if(isset($data['max']))$max=' max="'.$data['max'].'"';
    if(isset($data['accept']))$accept=' accept="'.$data['accept'].'"';
    if(isset($data['multiple']))$multiple=' multiple';
    $ret='<label for="'.$data['id'].'">'.$data['label'].(isset($data['required'])&&$data['required']?'<span style="color:red;">*</span>':'').'</label>
            <div class="form-group">
                <div class="form-line">
                    <textarea name="'.$data['id'].'" id="'.$data['id'].'" class="form-control '.
                        (isset($data['class'])?$data['class']:'').
                        '" placeholder="'.(isset($data['placeholder'])?$data['placeholder']:'').
                        '">'.(isset($data['def'])?$data['def']:'').'</textarea>
                    </div>
                </div>';
        return $ret;
}

function genInput_hidden($data){

    $ret='<input type="hidden" name="'.$data['id'].'" id="'.$data['id'].'" value="'.$data['def'].'" '.(isset($data['disabled'])&&$data['disabled']?'disabled':'').'/>';
        return $ret;
}

function genInput_check_group($data){
    $ret='<label for="'.$data['id'].'">'.$data['label'].'</label>
            <div class="form-group">
                <div class="form-line">';
               foreach($data['items'] as $k=>$v){
                    $ret.='<input type="checkbox" class="filled-in chk-col-orange" id="'.$k.'" name="'.$k.'" value="'.$v['value'].'"'.($v['checked']?' checked':'').' />
                    <label for="'.$k.'">'.$v['text'].'</label>';
               }                         
        $ret.='</div>
            </div>';
        return $ret;
}

function genInput_select($data){
    $multiple='';
    $search='';
    if(isset($data['multiple'])&&$data['multiple'])$multiple=' multiple';
    if(isset($data['search'])&&$data['search']==true){
        $search='data-live-search="true"';
        if(!isset($_SESSION['SEARCHLIB'])){
            //constant $=true;
            $_SESSION['FOOTSYSTEM'].='
            <!-- Select Plugin Js -->
            <script src="'.site_url().'template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>';
        }
    }
    $ret='<label for="'.$data['id'].'">'.$data['label'].(isset($data['required'])&&$data['required']?'<span style="color:red;">*</span>':'').'</label>
            <div class="form-group">
                <div class="form-line">
                    <select name="'.$data['id'].'" id="'.$data['id'].'" class="form-control '.(isset($data['class'])?$data['class']:'').'" '.(isset($data['required'])&&$data['required']?'required':'').''.(isset($data['disabled'])&&$data['disabled']?'disabled':'').' '.$multiple.$search.'/>
                    '.genOption($data['items'],$data['def'],(isset($data['noneLabel'])?$data['noneLabel']:false)).'
                    </select>
                </div>
            </div>';
        return $ret;
}

function genOption($data,$def=false,$noneSelectLable=false){
    $ret='';
    if(!is_array($data)) return $ret;
    
    if(isset($noneSelectLable)&&$noneSelectLable!="")$ret.='<option value="" style="padding:0px 40px">'.$noneSelectLable.'</option>';

    if(is_marray($data)){
        foreach($data as $k=>$v){
            $ret.='<optgroup label="'.$k.'" style="padding:0px 40px">';
            $ret.=genOption($v,$def);
            $ret.='</optgroup>
            ';
        }
        return $ret;
    }
    foreach($data as $k=>$v){
        $selected='';
        if(is_array($def)){
            if(is_numeric(array_search($k,$def)))$selected='selected';
        }else{
            if($k==$def)$selected='selected';
        }
        $ret.='<option  style="padding:0px 50px" value="'.$k.'"'.$selected.'>'.$v.'</option>';
    }
    return $ret;
}

function genInput_submit($data){
    $ret='<button type="'.$data['type'].'" class="btn btn-'.(isset($data['color'])?$data['color']:'primary').' m-t-15 waves-effect">'.(isset($data['label'])?$data['label']:'บันทึก').'</button>';
    return $ret;
}
