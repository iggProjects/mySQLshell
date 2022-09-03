<?php

include_once "../php_general_funct/my_PHP_functions.php";
include_once "../sql_funct/my_SQL_functions_servers.php";
include_once "../../config/config.servers.php";

$log_comments_path = "../../assets/log-files/log_comments.log";
$log_queries_path = "../../assets/log-files/log_queries.log";

# my configuration for redirect errors.log 
$php_errors_log =  "../../assets/log-files/php_errors.log";
error_reporting(E_ALL);
ini_set('ignore_repeated_errors',TRUE);
ini_set('display_errors', FALSE);
ini_set("log_errors",TRUE);
ini_set('error_log',$php_errors_log);

if ( $_REQUEST['host_numb'] ) {
    $host_numb = $_REQUEST['host_numb']; 
} else {}

if ( $_REQUEST['hostName'] ) {
    $dbhost = $_REQUEST['hostName']; 
}

if ( $_REQUEST['dbName'] ) {
    $dbname = $_REQUEST['dbName']; 
}

if ( $_REQUEST['sql_query'] ) {
    $sql_query = $_REQUEST['sql_query']; 
}


/* ONLY WORKING IN LOCALHOST IN 'my_lqs_admin' DB */
$dbuser  = $cfg_s['Servers'][1]['user'];
$dbpass = $cfg_s['Servers'][1]['password'];
$dbcharset = 'utf8mb4';

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
        $error_msg = "MySql error: sql query " . $sql_query . "FAILED !<br>Contact Admin.";
    }    

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to $dbhost and $dbname FAILED !<br>Contact Admin.";
}

# HTML DATA FOR DIV
if ($route == 'display_data') { # display html data   

    //$divHtml  = "<p>\$conex_db is: " . gettype($conex_db) . " | var_dump(\$conex_db)</p>";
    //$divHtml .= "<pre>" . var_dump($conex_db) . "</pre>";   
            
    $query = "<span style='color:black;'>QUERY<br></span> \"" . $sql_query . "\"";       
    My_Log_Message ("queries options data -> " . print_r($data_array),$log_comments_path);
    $divHtml .= displaySelect($resultado);

} else { # display error msq

    // $divHtml .= displayTable($query,90,'',$resultado);
    $divHtml .= "error sql " . $error_msg;    

}

return $divHtml;

?>

