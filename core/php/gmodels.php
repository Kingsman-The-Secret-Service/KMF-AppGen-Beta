<?php

$model_file = ProjectDIR.$PROJECT.'/models/'.$TBNAME.'.php';
$model_file_handle = fopen($model_file, 'w') or die('Cannot Open File:  '.$model_file); 

$model_code  = '
<?php 
class '.$TBNAME.' extends ActiveRecord\Model{
    static $table_name = "'.$TBNAME.'";
    static $primary_key = "'.$table_pk.'";
    
    static $validates_presence_of = array(';
$i = 0;
$len = count($table_columns);
foreach ($table_columns as $key => $val) {
    
    if($_POST[$val->name]['required'] == 'yes'){
 
    $model_code .= '
        array("'.$val->name.'")';
   
    if($i != $len-1){
        $model_code .= ',';
    }
    
    }
    $i++;
}

$model_code  .= '
    );
    
    static $validates_size_of = array(';
$i = 0;
$len = count($table_columns);
foreach ($table_columns as $key => $val) {
    
    if(!empty($_POST[$val->name]['length']) && ($val->raw_type == 'varchar' || $val->raw_type == 'int')){
    $model_code .= '
        array("'.$val->name.'", "maximum" => '.$_POST[$val->name]['length'].', "too_long" =>  "should be short and sweet")';
        
    if($i != $len-1){
        $model_code .= ',';
    }
    
    }
    $i++;
}

$model_code  .= '
    );
}
?>
';
    
fwrite($model_file_handle,$model_code);
fclose($model_file_handle);

?>