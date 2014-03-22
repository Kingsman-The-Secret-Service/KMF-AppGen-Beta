<?php

$constant_file = ProjectDIR.$PROJECT.'/layouts/constant.php';

$constant_file_handle = fopen($constant_file,'w') or die('Cannot Open File: '.$constant_file);
    
    $constant_code = '<?php '.PHP_EOL.''.PHP_EOL;

    $constant_code .= 'define("FrameWorkName", "'.$PROJECT.'");'.PHP_EOL;
    $constant_code .= 'define("HomeDIR","../../");'.PHP_EOL;
    $constant_code .= 'define("ActiveRecordDIR",HomeDIR."ActiveRecord/");'.PHP_EOL;
    $constant_code .= 'define("BootStrapDIR",HomeDIR . "BootStrap/");'.PHP_EOL;
    $constant_code .= 'define("JqueryDIR",HomeDIR . "Jquery/");'.PHP_EOL.''.PHP_EOL;
    
    $constant_code .='class KMF_CRUD{
           
    public static function tableColumns($tableName){
        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $tableColumns = $tableName::connection()->columns($tableName);
            return $tableColumns;
        }
        catch (Exception $e){
            return FALSE;
        }
    }
    
    public static function tableColumnsNoPk($tableName){
        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $tableColumns = $tableName::connection()->columns($tableName);
            
            $pk = self::primaryKey($tableName);
            unset($tableColumns[$pk]);
            
            return $tableColumns;
        }
        catch (Exception $e){
            return FALSE;
        }
    }
    
    public static function primaryKey($tableName){
        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $primaryKey = $tableName::table()->pk;
            return $primaryKey[0];
        }
        catch (Exception $e){
            return FALSE;
        }
    }

    public static function createFormData($tableName,$post){
    
        try{
            require_once \'models/connection.php\';    
            require_once \'models/\'.$tableName.\'.php\';
            $createFormData = new $tableName();            
            $tableColumns = $tableName::connection()->columns($tableName);
            
            $pk = self::primaryKey($tableName);
            unset($tableColumns[$pk]);
            
            foreach($tableColumns as $key => $val){
                    $createFormData->$key = $post[$key]; 
            }
            $createFormData->save();

            if($createFormData->is_valid()){
                return;
            }
            elseif($createFormData->is_invalid()){
                
                return $createFormData->errors->full_messages();
            }
        }
        catch(Exception $e){
            return FALSE;
        }

    }
    
    public static function readFormData($tableName,$rowId){
    
        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $readFormData = new $tableName();
            $readFormData = $tableName::find($rowId);
            
            return $readFormData;
        }
        catch(Exception $e){
            return FALSE;
        }

    }

    public static function updateFormData($tableName,$post,$rowId){

        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $updateFormData = $tableName::find($rowId);
            $tableColumns = $tableName::connection()->columns($tableName);
            
            $pk = self::primaryKey($tableName);
            unset($tableColumns[$pk]);

            foreach($tableColumns as $key => $val){
                    $updateFormData->$key = $post[$key]; 
            }
            $updateFormData->save();

            if($updateFormData->is_valid()){
                header("Location:?views=$tableName&view[$tableName]=".$rowId."&msge");
            }
            elseif($updateFormData->is_invalid()){
                
                return $updateFormData->errors->full_messages();
            }
        }
        catch(Exception $e){
            return FALSE;
        }
    }

    public static function deleteFormData($tableName,$rowId){

        try{
            require_once \'models/connection.php\';
            require_once \'models/\'.$tableName.\'.php\';
            $deleteFormData = $tableName::find($rowId);
            $deleteFormData->delete();

            return TRUE;
        }
        catch(Exception $e){
            return FALSE;
        }
    }

}

class KMF_CleanUp{

    public static function fail($fail_val){

        $fail = \'<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>    
        <h4>Ooops Error!</h4>
        <ol>
        \';

        if(is_array($fail_val)){
            
            $fail .= \'<ol>\';
            foreach($fail_val as $val){
                $fail .= \'<li>\'.$val.\'</li>\';
            }
            $fail .= \'</ol>\';
        }
        else{
            $fail .= \'<ul><li>\'.$fail_val.\'</li></ul>\';
        }
        
        $fail .= \'
        </ol>
        </div>
        \'; 

        return $fail;
    }

    public static function success($success_val){

        $success = \'<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Congrats!</h4>
        \';
        
        if(is_array($success_val)){
            
            $success .= \'<ol>\';
            foreach($success_val as $val){
                $success .= \'<li>\'.$val.\'</li>\';
            }
            $success .= \'</ol>\';
        }
        else{
            $success .= \'<ul><li>\'.$success_val.\'</li></ul>\';
        }
        
        $success .= \'
        </ol>
        </div>
        \';

        return $success;
    }
}';
    
    $constant_code .= '?>'.PHP_EOL;

fwrite($constant_file_handle,$constant_code);
fclose($constant_file_handle);

?>
