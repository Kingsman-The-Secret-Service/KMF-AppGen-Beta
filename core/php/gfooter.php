<?php

$footer_file = ProjectDIR.$PROJECT.'/layouts/footer.php';
$footer_file_handle = fopen($footer_file,'w') or die('Cannot Open File: '.$footer_file);
    
$footer_code = '<?php
 
//Start of Footer
    echo \'
    <div class="row well well-small">
        <center><p style="text-transform:capitalize;">\'.date("Y").\' &copy; \'.FrameWorkName.\'</p></center>
    </div>\';
//End of Footer

//Start of Script
echo \'
    <script src="\'.JqueryDIR.\'js/jquery-1.9.1.js"></script>
    <script src="\'.JqueryDIR.\'js/jquery-ui-1.10.1.custom.js"></script>
    <script src="forms/js/jquery.validate.js"></script>
    <script src="forms/js/general.js"></script>
    <script src="\'.BootStrapDIR.\'js/bootstrap.js"></script>\';
//End of Script

echo \'
</div>
</body>\';
//End of Body

echo \'</html>\';
//End of Html
?>';

fwrite($footer_file_handle,$footer_code);
fclose($footer_file_handle);


?>

    
