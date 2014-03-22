<?php

$index_file = ProjectDIR.$PROJECT.'/index.php';
$index_file_handle = fopen($index_file,'w') or die('Cannot Open File: '.$index_file);
    
$index_code = '<?php

$indexStatus = NULL;
$indexStatusVal = NULL;

if(isset($_GET[\'forms\'])){	
    $indexStatus = "forms";
}
elseif(isset($_GET[\'views\']) && !empty ($_GET[\'views\'])){	
    $indexStatus = "views";
    $indexStatusVal = $_GET[\'views\'];
}

include_once \'layouts/constant.php\';
include_once \'layouts/header.php\';

//Start of Breadcrumb
    echo \'
    <div class="row">
        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav">
                <li \'.($indexStatus == NULL? \'class="active"\':NULL).\'><a href="index.php" ><i class="icon-home"></i> Home</a></li>
                <li \'.($indexStatus == "forms"? \'class="active"\':NULL).\'><a href="?forms" style="text-transform:capitalize;"><i class=" icon-edit"></i> Form</a></li>
                <li class="dropdown \'.($indexStatus == "views"? \'active\':NULL).\'"  role="menu" ><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class=" icon-wrench"></i> View <b class="caret"></b></a>
                    <ul class="dropdown-menu">
';
foreach($TABLENAMES as $key => $table_name){
$index_code .='                   
                    <li \'.($indexStatusVal == "'.$table_name.'"? \'class="active"\':NULL).\'><a tabindex="-1" href="?views='.$table_name.'">'.strtoupper($table_name).'</a></li>
';
}
$index_code .='
                    </ul>
                </li>
                </ul>
            </div>
        </div>
    </div>\';
//End of Breadcrumb

//Start of Content
echo \'
<div class="row well">\';
    
if(empty($indexStatus)){
    echo \'<h1>Welcome to '.$PROJECT.'</h1>\';
}

################################################################################
################################################################################
################################################################################

/********** Start of Form ************/
elseif($indexStatus == "forms"){
   
if(!empty($_POST) && isset($_POST[\''.$PROJECT.'\'])){
    
    foreach($_POST as $val => $key){	
            $$val = $key;
    }
    
$invalid = array_merge(';

$i = 0;
$len = count($TABLENAMES);

foreach($TABLENAMES as $key => $table_name){
$index_code .='
    (array)KMF_CRUD::createFormData("'.$table_name.'",$_POST)';
if($i != $len-1){
    $index_code .=','; 
}
$i++;
}


$index_code .='
    );
    
    if(empty($invalid)){
        header("Location:?forms&msgs");
    }
    else{
        echo KMF_CleanUp::fail($invalid);
    }
    
}

if(isset($_GET[\'msgs\'])){     
    echo KMF_CleanUp::success("Your data has been successfully saved");
}

echo \'
<form action="?forms" method="post"> \';
';

foreach($TABLENAMES as $key => $table_name){                
$index_code .= '
        require_once \'forms/'.$table_name.'.php\';
';
}

$index_code .= '
echo \'
    <div class="form-actions">
        <button type="reset" name="reset" id="reset" value="reset" class="btn btn-medium">Reset</button>
        <button type="submit" name="'.$PROJECT.'" id="'.$PROJECT.'" value="'.$PROJECT.'" class="btn btn-medium btn-success">Submit</button>
    </div> 
</form>\';   
}
/********** End of Form ************/

################################################################################
################################################################################
################################################################################

/********** Start of View ************/
elseif($indexStatus == \'views\'){';

$index_code .= '
    if(isset($_GET[\'msgd\'])){
        echo KMF_CleanUp::success("Your data has been successfully Deleted");
    }
    
    if(isset($_GET[\'msge\'])){     
        echo KMF_CleanUp::success("Your data has been successfully Updated");
    }

    require_once \'views/\'.$_GET[\'views\'].\'.php\';
';

$index_code .=' 
}
/********** End of View ************/ 

echo \'
</div>\';	
//End of Content

include_once \'layouts/footer.php\';

?>';

fwrite($index_file_handle,$index_code);
fclose($index_file_handle);

?>