<?php
include_once 'core/php/constant.php';
include_once 'core/php/header.php';


    echo '
    <!-- Start of Breadcrumb -->
    <div class="row">
        <div class=" btn-group">
            <a href="index.php" class="btn btn-large span2 btn-info" ><i class="icon-home icon-large icon-white"></i> Home</a> 
            <a class="btn btn-large span3 btn-warning"><i class="icon-wrench icon-large icon-white"></i> Back-End Configuration</a>             
            <a class="btn btn-large span3 btn-success"><i class="icon-cog icon-large icon-white"></i> Front-End Configuration</a>
            <a class="btn btn-large span3 btn-primary"><i class="icon-download-alt icon-large icon-white"></i> Demo & Download</a>
        </div>
    </div>
    <hr/>
    <!-- End of Breadcrumb -->
    ';
    
    echo '
    <!-- Start of Content -->
    <div class="row well well-small well-transparent">
    ';
        
/************************************************************************************************************/

if(isset($_GET['project']) && file_exists(ProjectDIR.$_GET['project'])){
    
    $PROJECT = $_GET['project'];    
    
    echo '
    <div class="span*">
    ';
    
    $success_val = array(
    'Your project '.$PROJECT.' has been successfully generated',
    'Thanks for using '.FrameWorkName.' Framework',
    '<span class="label label-warning">Once Project is Downloaded, it will be removed Permanently </span>'
    );
    
    echo KMF_CleanUp::success($success_val);
    
    echo'
    </div>
    <div class="span6">
        <a '.((isset($_GET['download']))? 'href="#" disabled' : 'href="'.ProjectDIR.$PROJECT.'/index.php" target="_blank"').'  class="btn btn-large btn-block ">Demo &nbsp; <i class="icon-eye-open icon-2x"></i></a>
        <a '.((isset($_GET['download']))? 'href="#" disabled' : 'href="result.php?project='.$PROJECT.'&download=1"').'  class="btn btn-large btn-block btn-inverse">Download &nbsp; <i class="icon-download-alt icon-2x"></i></a>
    </div>
    ';
    
    if(isset($_GET['download'])){
        KMF_Core::zip_download($_GET['project']);
    }

}
elseif(!empty($_POST) && isset($_POST['GENERATE'])){
    
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
    
    $invalid = FALSE;
    $invalid_data_rule = file_get_html('tmp/generate.html');

    foreach($invalid_data_rule->find('[data-rule-required="true"]') as $element){
        
        $id = $element->id;
        
        if(is_array($_POST[$id])){
            
            if(empty($_POST[$id]['inputtype'])){
                $invalid_val[] = "Please fill the ".$id." field";
                $invalid = TRUE;
            }
        }
        else {
            
            if(empty($_POST[$id])){
                $invalid_val[] = "Please fill the ".$id." field";
                $invalid = TRUE;
            }
        }
    }
        
    if($invalid == FALSE){
        
        $PROJECT = $_POST['PROJECT'];
        $DBTYPE = $_POST['DBTYPE'];
        $HOST = $_POST['HOST'];
        $DATABASE = $_POST['DATABASE'];
        $USERNAME = $_POST['USERNAME'];
        $PASSWORD = $_POST['PASSWORD'];
        $TABLENAMES = $_POST['TBNAME'];
        $CHARSET = $_POST['CHARSET'];
        
        echo '<pre>';
        print_r($_POST);
        echo '</pre>';
        
        /********************************************************* START OF GENERATIONS *****************************************************/            
            
        if(!file_exists(ProjectDIR.$PROJECT) && !file_exists(ProjectDIR.$PROJECT.'/layouts/') && !file_exists(ProjectDIR.$PROJECT.'/forms/') && !file_exists(ProjectDIR.$PROJECT.'/views/')){
            
            KMF_CRUD::connection($DBTYPE, $USERNAME, $PASSWORD, $HOST, $DATABASE, $CHARSET);
            
            /*** Project Generations ***/

            mkdir(ProjectDIR.$PROJECT);
            mkdir(ProjectDIR.$PROJECT.'/views/');
            mkdir(ProjectDIR.$PROJECT.'/models/');
            mkdir(ProjectDIR.$PROJECT.'/layouts/');
            mkdir(ProjectDIR.$PROJECT.'/forms/');
            mkdir(ProjectDIR.$PROJECT.'/forms/js/');
            copy('core/js/general.js',ProjectDIR.$PROJECT.'/forms/js/general.js');
            copy('core/js/jquery.validate.js',ProjectDIR.$PROJECT.'/forms/js/jquery.validate.js');
             
            require_once 'core/php/gconnection.php';
            
            foreach($TABLENAMES as $key => $table_name){
                $TBNAME = $table_name;
                
                eval("class ".$TBNAME." extends ActiveRecord\Model{
                            static \$table_name= '".$TBNAME."';
                    }"
                );
                
                $table_columns = $TBNAME::connection()->columns($TBNAME);
                
                foreach ($table_columns as $key => $val){
                    if($val->pk == 1){
                        $table_pk = $val->name;
                        unset($table_columns[$key]);
                    }
                }
                
                require 'core/php/gmodels.php';   
                require 'core/php/gviews.php';
                require 'core/php/gforms.php';
            }
            
            require_once 'core/php/gconstant.php';
            require_once 'core/php/gheader.php';
            require_once 'core/php/gindex.php';
            require_once 'core/php/gfooter.php';
            
            /*** admin ***/

        /****************************************************** END OF GENERATIONS ********************************************************/
           
        header("Location:result.php?project=".$PROJECT);
        }
        else{
            echo KMF_CleanUp::fail(array("Something went wrong!","Don\'t be panic, start from the begining!"));    
        }
    }
    else{
      echo KMF_CleanUp::fail($invalid_val);
    }   
}
else{
    echo KMF_CleanUp::fail(array("Something went wrong!","Don\'t be panic, start from the begining!"));
}

/************************************************************************************************************/             
    echo '   
    </div>
    <!-- End of Content -->
    ';

include_once 'core/php/footer.php';
?>
