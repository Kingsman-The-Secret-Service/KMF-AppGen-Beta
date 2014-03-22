<?php
include_once 'core/php/constant.php';
include_once 'core/php/header.php';

    echo '
    <!-- Start of Breadcrumb -->
    <div class="row">
        <div class=" btn-group">
            <a href="index.php" class="btn btn-large span2 btn-info" ><i class="icon-home icon-large icon-white"></i> Home</a> 
            <a class="btn btn-large span3 btn-warning" disabled><i class="icon-wrench icon-large icon-white"></i> Back-End Configuration</a>             
            <a class="btn btn-large span3 btn-success" disabled><i class="icon-cog icon-large icon-white"></i> Front-End Configuration</a>
            <a class="btn btn-large span3 btn-primary" disabled><i class="icon-download-alt icon-large icon-white"></i> Demo & Download</a>
        </div>
    </div>
    <hr/>
    <!-- End of Breadcrumb -->
    ';

    echo '
    <!-- Start of Content -->
    <div class="row">
        <div class="span6 offset3 well well-transparent">
           <a href="config.php" class="btn btn-block btn-large">Start Generator &nbsp;&nbsp;&nbsp; <i class="icon-cogs icon-large icon-white"></i></a>
           <a href="about.php" class="btn btn-block btn-large">About '.FrameWorkName.' &nbsp;&nbsp; <i class="icon-info-sign icon-large icon-white"></i> </a>
        </div>
    </div>
    <!-- End of Content -->
    ';  

include_once 'core/php/footer.php';
?>