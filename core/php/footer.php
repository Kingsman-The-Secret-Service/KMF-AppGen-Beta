<?php

    echo '
    <!-- Start of Footer -->
    <div class="row well well-small well-transparent">
        <center><p style="text-transform:capitalize;">'.date("Y").' &copy; '.FrameWorkName.'</p></center>
    </div>
    <!-- End of Footer -->
    ';

    

echo '
    <!-- Start of Script -->
    <script src="'.JqueryDIR.'js/jquery-1.9.1.js"></script>
    <script src="'.JqueryDIR.'js/jquery-ui-1.10.1.custom.js"></script>
    <script src="core/js/jquery.validate.js"></script>
    <script src="core/js/general.js"></script>';
if(basename($_SERVER['PHP_SELF']) == 'generate.php'){
echo '
    <script src="core/js/generate.js"></script>';
}
echo '
    <script src="'.BootStrapDIR.'js/bootstrap.js"></script>
    <!-- End of Script -->
    ';

echo '
</div>
 <!-- End of Container -->
 
</body>
 <!-- End of Body -->
';

echo '</html>
<!-- End of HTML -->
';
