<?php

include_once "../php_general_funct/my_PHP_functions.php";
include_once "../sql_funct/my_SQL_functions_servers.php";

$log_comments_path = "../../assets/log-files/log_comments.log";
$log_queries_path = "../../assets/log-files/log_queries.log";


# my configuration for redirect errors.log 
$php_errors_log =  "../../assets/log-files/php_errors.log";
error_reporting(E_ALL);
ini_set('ignore_repeated_errors',TRUE);
ini_set('display_errors', FALSE);
ini_set("log_errors",TRUE);
ini_set('error_log',$php_errors_log);

if ( $_REQUEST['hostName'] ) {
    $dbhost = $_REQUEST['hostName']; 
}

if ( $_REQUEST['dbName'] ) {
    $dbname = $_REQUEST['dbName']; 
}

if ( $_REQUEST['sql_query'] ) {
    $sql_query = $_REQUEST['sql_query']; 
}


if ( $dbhost == 'POAPMYSQL119.dns-servicio.com:3306' ) {
    $dbuser = "inaki2022";
    $dbpass = "Inaki@2022";
    $dbcharset = 'utf8mb4';
    $h=1;
} elseif ( $dbhost == '127.0.0.1' ) {
    $dbuser = "root";
    $dbpass = "@mysql@";
    $dbcharset = 'utf8mb4';
    $h=2;
} else {
    // upssssss msg
}

# connection to DB using $db_parameters
$conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "MySql error was found";
$divHtml = "";

if ( gettype($conex_db) === 'object' ) {    
    
    $resultado = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$sql_query,$log_queries_path);
    if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  
        $route = "display_data";        
    } else {
        $route = "display_error";
        echo "<script>alert('display error')</script>";
        $error_msg = "MySql error: sql query " . $sql_query . "FAILED !<br>Contact Admin.";
    }    

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to $dbhost and $dbname FAILED !<br>Contact Admin.";
}

# DATA ARRAY OR ERROR ARRAY
if ($route == 'display_data') {  

    My_Log_Message (json_encode($resultado),$log_comments_path);
    echo json_encode($resultado);

} else {

    echo json_encode(["error sql ",$error_msg]);    

}

?>

