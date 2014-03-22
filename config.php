<?php
include_once 'core/php/constant.php';
include_once 'core/php/header.php';
require_once ActiveRecordDIR."/ActiveRecord.php";
 
$status = NULL;
if(isset($_POST['TESTCON'])){
    
    $PROJECT = $_POST['PROJECT'];
    $DBTYPE = $_POST['DBTYPE'];
    $HOST = $_POST['HOST'];
    $DATABASE = $_POST['DATABASE'];
    $USERNAME = $_POST['USERNAME'];
    $PASSWORD = $_POST['PASSWORD'];
    $CHARSET = $_POST['CHARSET'];

    try{
        KMF_CRUD::connection($DBTYPE, $USERNAME, $PASSWORD, $HOST, $DATABASE, $CHARSET);
        $status = "SUCCESS";

    }
    catch (Exception $e){

        $status = "ERROR";
    }
}

    echo '
     <!-- Start of Breadcrumb -->
    <div class="row">
        <div class=" btn-group">
            <a href="index.php" class="btn btn-large span2 btn-info" ><i class="icon-home icon-large icon-white"></i> Home</a> 
            <a class="btn btn-large span3 btn-warning" ><i class="icon-wrench icon-large icon-white"></i> Back-End Configuration</a>             
            <a class="btn btn-large span3 btn-success" disabled><i class="icon-cog icon-large icon-white"></i> Front-End Configuration</a>
            <a class="btn btn-large span3 btn-primary" disabled><i class="icon-download-alt icon-large icon-white"></i> Demo & Download</a>
        </div>
    </div>
    <hr/>
     <!-- End of Breadcrumb -->
     
     <!-- Start of Content -->';

        $form = '
        <div class="row">
                
            <div class="span7 offset2 well well-transparent">';
        
        if($status == "SUCCESS"){
            $form .= '<form action="generate.php" method="post">';
        }
        else{
            $form .= '<form action="" method="post">';
        }
        
            
        $form .= '<div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">Project Name</div>
            <input type="text" name="PROJECT" id="PROJECT" value="'.(isset($_POST['PROJECT'])? $_POST['PROJECT'] : NULL).'" data-rule-required="true" data-msg-required="Please enter project name" placeholder="Enter Project Name" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>
            
            <div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">DB Type</div>                      
            <select name="DBTYPE" id="DBTYPE" data-rule-required="true" data-msg-required="Please select DB Type" '.($status == "SUCCESS" ? "readonly" : NULL).'>
            <option value="">-----</option>
            <option value="mysql" '.((isset($_POST['DBTYPE']) && $_POST['DBTYPE'] == "mysql")? "selected=\"selected\"" : NULL).'>MySql</option>
            <option value="oci" '.((isset($_POST['DBTYPE']) && $_POST['DBTYPE'] == "oci")? "selected=\"selected\"" : NULL).'>Oci</option>
            <option value="pgsql" '.((isset($_POST['DBTYPE']) && $_POST['DBTYPE'] == "pgsql")? "selected=\"selected\"" : NULL).'>PgSql</option>
            <option value="sqlite" '.((isset($_POST['DBTYPE']) && $_POST['DBTYPE'] == "sqlite")? "selected=\"selected\"" : NULL).'>Sqlite</option>
            </select>
            </div>
            <span class="help-inline"></span>
            </div>

            <div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">Host</div>
            <input name="HOST" id="HOST" type="text" value="'.(isset($_POST['HOST'])? $_POST['HOST'] : NULL).'" data-rule-required="true" data-msg-required="Please enter host"  placeholder="Enter Host Name" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>
            
            <div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">Database</div>
            <input name="DATABASE" id="DATABASE" type="text" value="'.(isset($_POST['DATABASE'])? $_POST['DATABASE'] : NULL).'" data-rule-required="true" data-msg-required="Please enter DB name"  placeholder="Enter Database Name" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>
           
            <div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">User Name</div>
            <input name="USERNAME" id="USERNAME" type="text" value="'.(isset($_POST['USERNAME'])? $_POST['USERNAME'] : NULL).'" data-rule-required="true" data-msg-required="Please enter DB user name"  placeholder="Enter Username" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>
           
            <div>
            <div class="input-prepend">            
            <div class="add-on" style="width:80px;">Password</div>
            <input name="PASSWORD" id="PASSWORD" type="text" value="'.(isset($_POST['PASSWORD'])? $_POST['PASSWORD'] : NULL).'" data-rule-required="false" data-msg-required="Please enter database password"  placeholder="Enter Password" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>
           
            <div>            
            <div class="input-prepend">            
            <span class="add-on" style="width:80px;">Charset</span>
            <input name="CHARSET" id="CHARSET" type="text" value="'.(isset($_POST['CHARSET'])? $_POST['CHARSET'] : "utf8" ).'" data-rule-required="true" data-msg-required="Please enter Charset" placeholder="Enter Charset" '.($status == "SUCCESS" ? "readonly" : NULL).' />
            </div>
            <span class="help-inline"></span>
            </div>';
               
        if($status == "SUCCESS"){
            
            $success_val = array('Connection success','<span class="label label-warning">Select the tables below which should be merged into one form</span>');
            
            $form .= KMF_CleanUp::success($success_val);
            
            $tables = ActiveRecord\Connection::instance()->query("SHOW TABLES");
            $tables = $tables->fetchAll();
            
            
            
            foreach($tables as $val => $key){

                foreach ($key as $v => $k){
                $form .='<div>
                <div class="input-prepend">
                    <label class="checkbox">
                        <input type="checkbox" name="TBNAME[]" id="'.$k.'" value="'.$k.'"  />
                        '.$k.'
                    </label>                    
                    </div>
                    <span class="help-inline"></span>
                </div>';
                }
            }
        }
        elseif($status == "ERROR"){
            $form .= '<div class="alert alert-error"><center><b class="text-error">Connection failed</b></center></div>';
        }
        else{
            $form .= "";
        }
                
        $form .= '<div class="form-actions well well-transparent">
                <button type="submit" name="TESTCON" id="TESTCON" '.($status == "SUCCESS" ? "disabled": NULL).' class=" pull-left btn btn-medium btn-inverse">
                    Test Connection &nbsp;'.($status == "SUCCESS" ? "<i class=\"icon-check\"></i> " : "<i class=\"icon-question-sign\"></i> ").'
                </button>
                <button type="submit" name="CONFIG" id="CONFIG"'.($status != "SUCCESS" ? "disabled": NULL).' class="pull-right btn btn-medium btn-inverse">
                    DB Config <i class="icon-chevron-right icon-white"></i> 
                </button>
            </div>
        
            </form>
            </div>
        </div>
        <!-- End of Content -->
        ';
        
        echo $form;

include_once 'core/php/footer.php';
?>
