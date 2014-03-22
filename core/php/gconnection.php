<?php

$connection_file = ProjectDIR.$PROJECT.'/models/connection.php';

$connection_file_handle = fopen($connection_file,'w') or die('Cannot Open File: '.$connection_file);
    
    $connection_code = '<?php '.PHP_EOL.''.PHP_EOL;
    
    $connection_code .= 'require_once ActiveRecordDIR."/ActiveRecord.php";'.PHP_EOL.''.PHP_EOL;
    
    $connection_code .= 'ActiveRecord\Config::initialize(function($cfg){'.PHP_EOL.''.PHP_EOL;
    
    $connection_code .= '$DBTYPE = "'.$DBTYPE.'";'.PHP_EOL;
    $connection_code .= '$HOST = "'.$HOST.'";'.PHP_EOL;
    $connection_code .= '$DATABASE = "'.$DATABASE.'";'.PHP_EOL;
    $connection_code .= '$USERNAME = "'.$USERNAME.'";'.PHP_EOL;
    $connection_code .= '$PASSWORD = "'.$PASSWORD.'";'.PHP_EOL;
    $connection_code .= '$CHARSET = "'.$CHARSET.'";'.PHP_EOL.''.PHP_EOL;
    
    $connection_code .= '$cfg->set_model_directory("models");'.PHP_EOL;
    $connection_code .= '$connections = array("development" =>"".$DBTYPE."://".$USERNAME.":".$PASSWORD."@".$HOST."/".$DATABASE.";charset=".$CHARSET);'.PHP_EOL;
    $connection_code .= '$cfg->set_connections($connections);'.PHP_EOL.''.PHP_EOL;
    $connection_code .= '});'.PHP_EOL.''.PHP_EOL;
    
    $connection_code .= '?>'.PHP_EOL;

fwrite($connection_file_handle,$connection_code);
fclose($connection_file_handle);

?>