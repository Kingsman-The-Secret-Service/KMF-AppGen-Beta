<?php

$form_file = ProjectDIR.$PROJECT.'/forms/'.$TBNAME.'.php';
$form_file_handle = fopen($form_file, 'w') or die('Cannot Open File:  '.$form_file); 

$form_code  = '';

foreach ($table_columns as $val => $key) {

switch ($_POST[$val]['inputtype']){
    
case "text":
$form_code .= '
    <div>
        <div class="input-prepend">            
            <div class="add-on" >'.$val.'</div>
            <input type="text" name="'.$val.'" id="'.$val.'" value="<?php if(isset($'.$val.')){ echo $'.$val.'; }else{ echo "";} ?>" '.($_POST[$val]['date'] == 'yes'? 'data-datepicker=\'{ "dateFormat": "dd-mm-yy"}\'': NULL).'  data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please enter '.$val.'" placeholder="Enter '.$val.'" />
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "password":
$form_code .= '
    <div>
        <div class="input-prepend">            
            <div class="add-on" >'.$val.'</div>
            <input type="password" name="'.$val.'" id="'.$val.'" value="<?php if(isset($'.$val.')){ echo $'.$val.'; }else{ echo "";} ?>" data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please enter '.$val.'" placeholder="Enter '.$val.'" />
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "textarea":
$form_code .= '
    <div>
        <div class="input-prepend">            
            <div class="add-on" >'.$val.'</div>
            <textarea rows="3" name="'.$val.'" id="'.$val.'"  data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please enter '.$val.'" placeholder="Enter '.$val.'" ><?php if(isset($'.$val.')){ echo $'.$val.'; }else{ echo "";} ?></textarea>
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "dropdown":
$form_code .= '
    <div>
        <div class="input-prepend">            
            <div class="add-on" >'.$val.'</div>
            <select id="'.$val.'" name="'.$val.'"  data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please select '.$val.'" >
                <option value="">Please select value</option>
                <option value="'.$_POST[$val]['value'][0].'" <?php if(isset($'.$val.') && ($'.$val.') == "'.$_POST[$val]['value'][0].'"){ echo \'selected="selected"\'; }else{ echo "";} ?>>'.$_POST[$val]['option'][0].'</option>
            </select>
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "checkbox":
$form_code .= '
    <div>
        <div class="input-prepend">
            <label class="checkbox">
                <input type="checkbox" name="'.$val.'" id="'.$val.'" value="'.$_POST[$val]['value'][0].'" <?php if(isset($'.$val.') && $'.$val.' == "'.$_POST[$val]['value'][0].'"){ echo \'checked="checked"\'; }else{ echo "";} ?> data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please check '.$val.'" placeholder="Enter '.$val.'" />
                '.$_POST[$val]['option'][0].'
            </label>                    
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "radio":
$form_code .= '
    <div>
        <div class="input-prepend">
            <label class="radio">
                <input type="radio" name="'.$val.'" id="'.$val.'" value="'.$_POST[$val]['value'][0].'" <?php if(isset($'.$val.') && $'.$val.' == "'.$_POST[$val]['value'][0].'"){ echo \'checked="checked"\'; }else{ echo "";} ?> data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please select '.$val.'" placeholder="Enter '.$val.'" />
                '.$_POST[$val]['option'][0].'
            </label>                    
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "file":
$form_code .= '
    <div>
        <div class="input-prepend">            
            <label>'.$val.'
                <input type="file" name="'.$val.'" id="'.$val.'" data-rule-required="'.($_POST[$val]['required'] == "yes"? "true": "false" ).'" data-msg-required="Please browse a file '.$val.'" placeholder="Select '.$val.'" />
            </label>
        </div>
        <span class="help-inline"></span>
    </div>
';
break;

case "hidden":
$form_code .= '
    <input type="hidden" name="'.$val.'" id="'.$val.'" value="'.$_POST[$val.'-value'].'" />
';
break;

default:
}
}

unset($table_columns);
    
fwrite($form_file_handle,$form_code);
fclose($form_file_handle);

?>