<?php

$header_file = ProjectDIR.$PROJECT.'/layouts/header.php';
$header_file_handle = fopen($header_file,'w') or die('Cannot Open File: '.$header_file);
    
$header_code = '<?php 

//Start of HTML
echo \'<!DOCTYPE html>\';
echo \'<html>\';

//Start of Head
echo \'
<head>
    <title>\'.FrameWorkName.\'</title>\';
        //Start of CSS
            echo \'
            <link href="\'.BootStrapDIR.\'css/bootstrap.css" rel="stylesheet">
            <link href="\'.BootStrapDIR.\'css/font-awesome.css" rel="stylesheet">
            <link href="\'.JqueryDIR.\'css/flick/jquery-ui-1.10.1.custom.css" rel="stylesheet">\';
        //End of CSS
echo \'
</head>\';
//End of Head

//Start of Body
echo \'
<body>
    <div class="container">\';
        
    //Start of Header
        echo \'
        <div class="row well well-small">        
            <h3 style="text-transform:capitalize;"><center>\'.FrameWorkName.\'</center></h3>
        </div>\';
    //End of Header
?>';

fwrite($header_file_handle,$header_code);
fclose($header_file_handle);


?>