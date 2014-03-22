<?php

include_once 'core/php/constant.php';
ob_start();
include_once 'core/php/header.php';

    echo '
    <!-- Start of Breadcrumb -->
    <div class="row">
        <div class=" btn-group">
            <a href="index.php" class="btn btn-large span2 btn-info"><i class="icon-home icon-large icon-white"></i> Home</a> 
            <a class="btn btn-large span3 btn-warning"><i class="icon-wrench icon-large icon-white"></i> Back-End Configuration</a>             
            <a class="btn btn-large span3 btn-success"><i class="icon-cog icon-large icon-white"></i> Front-End Configuration</a>
            <a class="btn btn-large span3 btn-primary" disabled><i class="icon-download-alt icon-large icon-white"></i> Demo & Download</a>
        </div>
    </div>
    <hr/>
    <!-- End of Breadcrumb -->
    ';
    
    echo '
    <!-- Start of Content -->
    <div class="row">
    ';

/************************************************************************************************************/ 
if(empty($_POST) && !isset($_POST['CONFIG'])){
    
    $error_val = array("Something went wrong!","Don\'t be panic, start from the begining!");
    echo KMF_CleanUp::fail($error_val);
}
else{
    
    $invalid = FALSE;
    $invalid_data_rule = file_get_html($_SERVER["HTTP_REFERER"]);
        
    foreach($invalid_data_rule->find('[data-rule-required="true"]') as $element){
        
        if(empty($_POST[$element->name])){
            
            $invalid_val[] = "Please fill the ".$element->name." field";
            $invalid = TRUE;
        }
    }

    if($invalid == FALSE){
        
        $PROJECT = $_POST['PROJECT'];
        $DBTYPE = $_POST['DBTYPE'];
        $HOST = $_POST['HOST'];
        $DATABASE = $_POST['DATABASE'];
        $USERNAME = $_POST['USERNAME'];
        $PASSWORD = $_POST['PASSWORD'];
        $TBNAME = $_POST['TBNAME'];
        $CHARSET = $_POST['CHARSET'];
        $CONFIG = $_POST['CONFIG'];
        
        KMF_CRUD::connection($DBTYPE, $USERNAME, $PASSWORD, $HOST, $DATABASE, $CHARSET);
      
//echo '<pre>';
//print_r($_POST['TBNAME']);
//echo '</pre>';       
              
        echo '
            <form method="post" action="result.php">';      
             
        foreach($TBNAME as $key => $table_name){
                            
            eval("class ".$table_name." extends ActiveRecord\Model{
            static \$table_name= '".$table_name."';
            }");

        $table_fields = $table_name::connection()->columns($table_name);
        $form = '';
                       
//echo '<pre>';
//print_r($table_fields);
//echo '</pre>';  
       
        foreach($table_fields as $table_fields_key => $table_fields_val ){
            
            switch ($table_fields_val->raw_type) {
                case "int":
                    $raw_input_type = 'text';
                    break;
                
                case "varchar":
                    $raw_input_type = 'text';
                    break;
                
                case "text":
                    $raw_input_type = 'textarea';
                    break;
                
                case "mediumtext":
                    $raw_input_type = 'textarea';
                    break;
                
                case "date":
                    $raw_input_type = 'text';
                    break;

                default:
                    break;
            }
            
            if($table_fields_val->pk == 1){
                
                echo '
                <div class="well">
                <fieldset>
                <legend>
                <div class="btn-group">
                    <a href="#" class="btn btn-inverse span4">'.ucfirst($table_name).' &raquo; '.ucfirst("Primary Key").'</a>
                    <a href="#" class="btn btn-inverse dropdown-toggle span* right" data-toggle="dropdown">
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    <li><a tabindex="-1">Raw Type &raquo; '.$table_fields_val->raw_type.'</a></li>
                    <li><a tabindex="-1">Length &raquo; '.$table_fields_val->length.'</a></li>
                    </ul>
                </div>                
                </legend>
                <div>                
                    <div class="input-prepend input-append">                       
                        <div class="add-on">Input Type &nbsp;<i class="icon-caret-right "></i></div>                        
                        <div class="span2 uneditable-input">DB Primary Key</div>
                        <div class="add-on">Validation &nbsp; <i class="icon-caret-right "></i></div>
                        <div class="span2 uneditable-input">No</div>                        
                        <div class="add-on"></div>
                        <input name="TBNAME[]" id="TBNAME" value="'.$table_name.'" type="hidden" data-rule-required="false" />
                    </div>                
                </div>
                 </fieldset>
                 </div>
                ';
                
            }
            else{
            
                echo '
                <div class="well well-transparent">
                <fieldset>
                <legend>
                <div class="btn-group">
                    <a href="#" class="btn btn-inverse span4 text-left"><strong>'.ucfirst($table_name).' &raquo; '.ucfirst($table_fields_val->name).'</strong></a>
                    <a href="#" class="btn btn-inverse dropdown-toggle span*" data-toggle="dropdown">
                    <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                    <li><a tabindex="-1">Raw Type &raquo; '.$table_fields_val->raw_type.'</a></li>
                    <li><a tabindex="-1">Length &raquo; '.$table_fields_val->length.'</a></li>
                    </ul>
                </div>
                </legend>
                
                <div id="'.$table_fields_val->name.'-parent-custom">                
                    <div class="input-prepend input-append">                    
                        <div class="add-on">Input Type &nbsp;<i class="icon-caret-right "></i></div>                        
                        <select name="'.$table_fields_val->name.'[inputtype]" id="'.$table_fields_val->name.'" table-group="'.$table_name.'" class="inputtype span2" data-rule-required="true" data-msg-required=" Please select input type of '.$table_fields_val->name.'">
                        <option value="">-----</option>
                        <option value="text"'.($raw_input_type == "text" ?  'selected="selected"' : NULL ).'>Text</option>
                        <option value="password">Password</option>
                        <option value="dropdown">Drop Down</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="file">File</option>
                        <option value="textarea" '.($raw_input_type == "textarea" ?  'selected="selected"' : NULL ).'>Text Area</option>
                        <option value="hidden">Hidden</option>
                        <option value="NA">Not Needed</option>
                        </select>
                        
                        <input name="'.$table_fields_val->name.'[length]" id="'.$table_fields_val->name.'-length" value="'.$table_fields_val->length.'" type="hidden" data-rule-required="false" />

                        <div class="add-on">Validation &nbsp;<i class="icon-caret-right "></i></div> 
                        <select name="'.$table_fields_val->name.'[required]" id="'.$table_fields_val->name.'-required" class="span2">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                        </select>
                        
                        <div class="add-on"></div>
                    </div>                    
                    <span class="help-inline text-error"></span>                
                </div>
                
                <div id="'.$table_fields_val->name.'-custom"></div>
                </fieldset>
                </div>
                ';
            }
            
        }

        }
        echo '
            <input name="PROJECT" id="PROJECT" value="'.$PROJECT.'" type="hidden" data-rule-required="false" />
            <input name="DBTYPE" id="DBTYPE" value="'.$DBTYPE.'" type="hidden" data-rule-required="false" />
            <input name="HOST" id="HOST" value="'.$HOST.'" type="hidden" data-rule-required="false" />
            <input name="DATABASE" id="DATABASE" value="'.$DATABASE.'" type="hidden" data-rule-required="false" />
            <input name="USERNAME" id="USERNAME" value="'.$USERNAME.'" type="hidden" data-rule-required="false" />
            <input name="PASSWORD" id="PASSWORD" value="'.$PASSWORD.'" type="hidden" data-rule-required="false" />
            <input name="CHARSET" id="CHARSET" value="'.$CHARSET.'" type="hidden" data-rule-required="false" />
            
            <div class="form-actions">
                <a href="javascript:history.go(-1)" class="pull-left btn btn-medium">
                     <i class="icon-chevron-left icon-white"></i> Back
                </a>
                <button type="submit" name="GENERATE" id="GENERATE" value="GENERATE" class="pull-right btn btn-medium btn-inverse">
                    Please Generate <i class="icon-chevron-right icon-white"></i>
                </button>            
            </div>
            </form>'.PHP_EOL;
    }
    else{
        echo KMF_CleanUp::fail($invalid_val);
    }    
}

/************************************************************************************************************/ 
    echo '
    </div>
    <!-- End of Content -->
    ';

include_once 'core/php/footer.php';

file_put_contents('tmp/generate.html', ob_get_contents());
?>