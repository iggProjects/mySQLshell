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

if ( $_REQUEST['tblName'] ) {
    $dbtable = $_REQUEST['tblName']; 
}

if ( $_REQUEST['page'] ) {
    $page = $_REQUEST['page']; 
}

$dbuser  = $cfg_s['Servers'][$host_numb]['user'];
$dbpass = $cfg_s['Servers'][$host_numb]['password'];
$dbcharset = 'utf8mb4';

$msg = 'HOST param: ' . $_REQUEST['host_numb'] . '-'. $hostName . '-' . $dbuser . '-' . $dbpass;
My_Log_Message ($msg,$log_comments_path);

# connection to DB using $db_parameters
$conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "MySql error was found";
$divHtml = "";
$thead_titles = [];
$rec_numb = 0;

if ( gettype($conex_db) === 'object' ) {

    // calculate record number from page selected

    //$count_query = substr($select_query, 0, strpos($select_query, 'limit'));
    $count_query = "select count(*) as numb from $dbtable";  
    $records = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$count_query,$log_queries_path);
    $num_records = $records[0]['numb'];

    // $num_records = count(Sql_Query_try_catch($conex_db,$dbname,$dbuser,$count_query,$log_queries_path));

    $select_query = "SELECT * FROM $dbtable limit $rec_numb,10;";

    $resultado = SELECT_try_catch($conex_db,$dbname,$dbuser,$dbtable,$select_query,$log_queries_path);      

    if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  
        $route = "display_data";        
    } else {
        $route = "display_error";
        $error_msg = "MySql error: describe '$dbtable' query FAILED !<br>Contact Admin.";
    }    

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to host and $dbname FAILED !<br>Contact Admin.";
}

# HTML DATA FOR DIV
if ($route == 'display_data') { # display html data   

    $thead_titles['page'] = $page;        
    $thead_titles['totRecords'] = $num_records;

    // $query = "<span style='color:black;'>query: </span>" . $select_query . "";   
    $divHtml .= displayTable($select_query,90,$thead_titles,$resultado);

} else { # display error msq

    $divHtml = $error_msg;    

}

return $divHtml;

?>

