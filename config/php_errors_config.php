<?php

# 
#  php errors to log file php_errors.log in asstes folder
# 

$php_errors_log = $_SERVER['DOCUMENT_ROOT'] . "/lanbide2022/gaztelu/curso-backend-areafor-server/assets/log-files/php_errors.log";
error_reporting(E_ALL);
ini_set('ignore_repeated_errors',TRUE);
ini_set('display_errors', FALSE);
ini_set("log_errors",TRUE);
ini_set('error_log',$php_errors_log);

?>
