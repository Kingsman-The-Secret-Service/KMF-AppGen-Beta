<?php

$view_file = ProjectDIR.$PROJECT.'/views/'.$TBNAME.'.php';
$view_file_handle = fopen($view_file, 'w') or die('Cannot Open File:  '.$view_file); 

$view_code  = '<?php 

$tableColumns = KMF_CRUD::tableColumns("'.$TBNAME.'");
$pk = KMF_CRUD::primaryKey("'.$TBNAME.'");

if(isset($_GET[\'del\']) && isset($_GET[\'del\'][\''.$TBNAME.'\'])  && !empty($_GET[\'del\'][\''.$TBNAME.'\'])){
        
    KMF_CRUD::deleteFormData("'.$TBNAME.'",$_GET[\'del\'][\''.$TBNAME.'\']);
    header("Location:?views='.$TBNAME.'&msgd");
}

elseif(isset($_GET[\'edit\']) && isset($_GET[\'edit\'][\''.$TBNAME.'\']) && !empty($_GET[\'edit\'][\''.$TBNAME.'\'])){
        
        $tableEditData = '.$TBNAME.'::find($_GET[\'edit\'][\''.$TBNAME.'\']);
                
        foreach($tableColumns as $val => $key){	
                    $$val = $tableEditData->$val;
            }
    
       if(!empty($_POST) && isset($_POST[\''.$TBNAME.'\'])){
           
            foreach($_POST as $val => $key){	
                    $$val = $key;
            }

            $invalid = KMF_CRUD::updateFormData("'.$TBNAME.'",$_POST,$_GET[\'edit\'][\''.$TBNAME.'\']);
            echo KMF_CleanUp::fail($invalid);
        } 
        
        echo \'<form action="?views='.$TBNAME.'&edit['.$TBNAME.']=\'.$_GET["edit"]["'.$TBNAME.'"].\'" method="post"> \';

        require_once \'forms/'.$TBNAME.'.php\';

        echo \'
            <div class="form-actions">
                <button type="reset" name="reset" id="reset" value="reset" class="btn btn-medium">Reset</button>
                <button type="submit" name="'.$TBNAME.'" id="'.$TBNAME.'" value="'.$TBNAME.'" class="btn btn-medium btn-success">Update</button>
            </div> 
        </form>\';  
}
elseif(isset($_GET[\'view\']) && isset($_GET[\'view\'][\''.$TBNAME.'\'])){

    $tableViewData = KMF_CRUD::readFormData("'.$TBNAME.'",$_GET[\'view\'][\''.$TBNAME.'\']);

    echo \'
    <table class="table table-hover table-bordered table-striped">
    <caption><h5>'.strtoupper($TBNAME).'</h5></caption>
    <thead>
    <tr>
    <th>Fields</th>
    <th>Data</th>
    </tr>
    </thead>
    <tbody>\';

    foreach($tableColumns as $tbfval => $tbfkey){
        echo \'<tr><td>\'.$tbfval.\'</td><td>\'.$tableViewData->$tbfval.\'</td></tr>\';
    }
    
    echo \'</tbody>
    </table>\';

    echo \'
    <center>
    <div class="btn-group">
    <a href="?views='.$TBNAME.'" class="pull-left btn btn-medium"><i class="icon-chevron-left icon-white"></i> Back</a>
    <a href="index.php?views='.$TBNAME.'&edit['.$TBNAME.']=\'.$tableViewData->$pk.\'" onclick="return confirm(\\\'Really Edit?\\\');" class="btn btn-warning"><i class="icon-pencil icon-white"></i> Modify </a>
    <a href="index.php?views='.$TBNAME.'&del['.$TBNAME.']=\'.$tableViewData->$pk.\'" onclick="return confirm(\\\'Really Delete?\\\');" class="btn btn-danger"><i class="icon-trash  icon-white"></i> Remove </a>
    </div>
    </center>
    \';

}
else{

$tableViewsData = KMF_CRUD::readFormData("'.$TBNAME.'","all");

echo \'
<table class="table table-hover table-bordered table-striped">
<caption><h5>'.strtoupper($TBNAME).'</h5></caption>
<thead>
<tr>\';


foreach(array_slice($tableColumns,1,4) as $tbfval => $tbfkey){

    echo \'<th>\'.$tbfval.\'</th>\';
}

echo \'<th>View</th><th>Edit</th><th>Delete</th></tr>
</thead>
<tbody>\';

foreach($tableViewsData as $tbdval => $tbdkey){

    echo \'<tr>\';

    foreach(array_slice($tableColumns,1,4) as $tbfval => $tbfkey){
        echo \'<td>\'.$tbdkey->$tbfval.\'</td>\';
    }


    echo \'
    <td><a href="index.php?views='.$TBNAME.'&view['.$TBNAME.']=\'.$tbdkey->$pk.\'" class="btn btn-success"><i class="icon-search icon-white"></i> </a></td>
    <td><a href="index.php?views='.$TBNAME.'&edit['.$TBNAME.']=\'.$tbdkey->$pk.\'" onclick="return confirm(\\\'Really Edit?\\\');" class="btn btn-warning"><i class="icon-pencil icon-white"></i> </a></td>
    <td><a href="index.php?views='.$TBNAME.'&del['.$TBNAME.']=\'.$tbdkey->$pk.\'" onclick="return confirm(\\\'Really Delete?\\\');" class="btn btn-danger"><i class="icon-trash  icon-white"></i> </a></td>
    </tr>\';
}

echo \'</tbody>
</table>\';

if(empty($tableViewsData)){
    echo \'<center><h5>No Record Found</h5></center>\';
}
echo \'<hr/>\';    

}

?>';
    
fwrite($view_file_handle,$view_code);
fclose($view_file_handle);
    

?>