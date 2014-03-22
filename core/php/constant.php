<?php

define("FrameWorkName", "Keep Moving Forward");
define("HomeDIR","");
define("ActiveRecordDIR",HomeDIR."ActiveRecord/");
define("BootStrapDIR",HomeDIR . "BootStrap/");
define("JqueryDIR",HomeDIR . "Jquery/");
define("ProjectDIR",HomeDIR . "Project/");

class KMF_Core{
    
    public static function zip_download($downloaddir){
    
        if(file_exists(ProjectDIR.$downloaddir) && extension_loaded('zip')){

            $project_folder = ProjectDIR.$downloaddir."";

            $zip = new ZipArchive();
            $zip_name = $downloaddir.".zip";

            if($zip->open($zip_name, ZIPARCHIVE::CREATE) === TRUE){

                $it = new RecursiveDirectoryIterator($project_folder);

                foreach(new RecursiveIteratorIterator($it) as $file) {

                    $zip->addFile($file);
                }

                $zip->close();

                if(file_exists($zip_name)){

                    rrmdir($project_folder);

                    header('Content-type: application/zip');
                    header('Content-Disposition: attachment; filename="'.$zip_name.'"');

                    readfile($zip_name);                
                    unlink($zip_name);
                }
            }
        }
    }

}

function rrmdir($dir) {
    
    if (is_dir($dir)) {
        $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        rrmdir($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
        reset($objects);
        rmdir($dir);
    }
}

function zip_download($downloaddir){
    
    if(file_exists(ProjectDIR.$downloaddir) && extension_loaded('zip')){
        
        $project_folder = ProjectDIR.$downloaddir."";
            
        $zip = new ZipArchive();
        $zip_name = $downloaddir.".zip";
            
        if($zip->open($zip_name, ZIPARCHIVE::CREATE) === TRUE){
               
            $it = new RecursiveDirectoryIterator($project_folder);

            foreach(new RecursiveIteratorIterator($it) as $file) {
                
                $zip->addFile($file);
            }

            $zip->close();
                
            if(file_exists($zip_name)){
                
                rrmdir($project_folder);
                
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="'.$zip_name.'"');
                
                readfile($zip_name);                
                unlink($zip_name);
            }
        }
    }
}

class KMF_CRUD{
    
    public static function connection($DBTYPE,$USERNAME,$PASSWORD,$HOST,$DATABASE,$CHARSET){
        
        require_once ActiveRecordDIR."/ActiveRecord.php";
        
        $connections = array("development" =>"".$DBTYPE."://".$USERNAME.":".$PASSWORD."@".$HOST."/".$DATABASE.";charset=".$CHARSET);
        ActiveRecord\Config::initialize(function($cfg) use ($connections){
            $cfg->set_connections($connections);
        });
    }


    public static function tableColumns($tableName){
        try{
            require_once 'models/connection.php';
            require_once 'models/'.$tableName.'.php';
            $tableColumns = $tableName::connection()->columns($tableName);
            return $tableColumns;
        }
        catch (Exception $e){
            return FALSE;
        }
    }
    
    public static function primaryKey($tableName){
        try{
            require_once 'models/connection.php';
            require_once 'models/'.$tableName.'.php';
            $primaryKey = $tableName::table()->pk;
            return $primaryKey[0];
        }
        catch (Exception $e){
            return FALSE;
        }
    }

    public static function createFormData($tableName,$post){
    
        try{
            require_once 'models/connection.php';    
            require_once 'models/'.$tableName.'.php';
            $createFormData = new $tableName();            
            $tableColumns = $tableName::connection()->columns($tableName);
            
            $pk = self::primaryKey($tableName);
            unset($tableColumns[$pk]);
            
            foreach($tableColumns as $key => $val){
                    $createFormData->$key = $post[$key]; 
            }
            $createFormData->save();

            if($createFormData->is_valid()){
                header("Location:?forms&msgs");
            }
            elseif($createFormData->is_invalid()){
                
                echo KMF_CleanUp::fail($createFormData->errors->full_messages());
            }
        }
        catch(Exception $e){
            return FALSE;
        }

    }
    
    public static function readFormData($tableName,$rowId){
    
        try{
            require_once 'models/connection.php';
            require_once 'models/'.$tableName.'.php';
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
            require_once 'models/connection.php';
            require_once 'models/'.$tableName.'.php';
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
                
                echo KMF_CleanUp::fail($updateFormData->errors->full_messages());
            }
        }
        catch(Exception $e){
            return FALSE;
        }
    }

    public static function deleteFormData($tableName,$rowId){

        try{
            require_once 'models/connection.php';
            require_once 'models/'.$tableName.'.php';
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

    public static function serverValidation($filename,$post){

        require 'core/php/validations.php';
        $dataRuleReq = file_get_html($filename);
        $invalid = NULL;
        
        foreach($dataRuleReq->find('[data-rule-required="true"]') as $element){
            if(empty($post[$element->name])){            
                $invalid[] = "Please fill the ".$element->name." field";
            }
        }

        return $invalid;
    }
    
    public static function fail($fail_val){

        $fail = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>    
        <h4>Ooops Error!</h4>
        <ol>
        ';

        if(is_array($fail_val)){
            
            $fail .= '<ol>';
            foreach($fail_val as $val){
                $fail .= '<li>'.$val.'</li>';
            }
            $fail .= '</ol>';
        }
        else{
            $fail .= '<ul><li>'.$fail_val.'</li></ul>';
        }
        
        $fail .= '
        </ol>
        </div>
        '; 

        return $fail;
    }

    public static function success($success_val){

        $success = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Congrats!</h4>
        ';
        
        if(is_array($success_val)){
            
            $success .= '<ol>';
            foreach($success_val as $val){
                $success .= '<li>'.$val.'</li>';
            }
            $success .= '</ol>';
        }
        else{
            $success .= '<ul><li>'.$success_val.'</li></ul>';
        }
        
        $success .= '
        </ol>
        </div>
        ';

        return $success;
    }
}

include_once 'core/php/validations.php';
?>