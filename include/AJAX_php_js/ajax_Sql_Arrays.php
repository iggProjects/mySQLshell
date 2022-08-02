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
    $tblname = $_REQUEST['tblName']; 
}

/*
if ( $_REQUEST['sql_query'] ) {
    $sql_query = $_REQUEST['sql_query']; 
}
*/


$dbuser  = $cfg_s['Servers'][$host_numb]['user'];
$dbpass = $cfg_s['Servers'][$host_numb]['password'];
$dbcharset = 'utf8mb4';

//$msg = 'HOST param: ' . $_REQUEST['host_numb'] . '-'. $hostName . '-' . $dbuser . '-' . $dbpass;
//My_Log_Message ($msg,$log_comments_path);


# connection to DB using $db_parameters
$conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "MySql error was found";
$divHtml = "";

if ( gettype($conex_db) === 'object' ) {    

    $right_query = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_COLUMN_NAME REF_COL, REFERENCED_TABLE_NAME REF_TBL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = '" . $dbname . "' AND TABLE_NAME = '" . $tblname . "'";
    $left_query = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_COLUMN_NAME REF_COL, REFERENCED_TABLE_NAME REF_TBL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = '" . $dbname . "' AND REFERENCED_TABLE_NAME = '" . $tblname . "'";         
    $table_fields = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, ORDINAL_POSITION REF_COL, DATA_TYPE REF_TBL FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $tblname . "'";
    //select TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION, DATA_TYPE  from COLUMNS where TABLE_NAME='tbl_persona'
    $sql_query = $table_fields . ' UNION ' . $left_query . ' UNION '. $right_query;
    // $sql_query = $left_query . ' UNION ' . $right_query;
    
    $resultado = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$sql_query,$log_queries_path);
    if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  
        $route = "display_data";        
    } else {
        $route = "display_error";
        echo "<script>alert('display error')</script>";
        $error_msg = "MySql error: sql query " . $sql_query . "FAILED !<br>Contact Admin.";
    }    

    
    // TESTING MERGE ARRAY OPTION   
    $right_query  = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_COLUMN_NAME REF_COL, REFERENCED_TABLE_NAME REF_TBL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = '" . $dbname . "' AND TABLE_NAME = '" . $tblname . "'";
    $left_query   = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, REFERENCED_COLUMN_NAME REF_COL, REFERENCED_TABLE_NAME REF_TBL FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_SCHEMA = '" . $dbname . "' AND REFERENCED_TABLE_NAME = '" . $tblname . "'";         
    $table_query = "SELECT TABLE_NAME TBL,COLUMN_NAME COL, ORDINAL_POSITION REF_COL, DATA_TYPE REF_TBL FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $tblname . "'";

    $table_result = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$table_query,$log_queries_path);

    if( gettype($table_result) === 'object' || gettype($table_result) === 'array' ) { 
        $rigth_result = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$right_query,$log_queries_path);
        if( gettype($rigth_result) === 'object' || gettype($rigth_result) === 'array' ) {
            $left_result  = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$left_query,$log_queries_path);
        }
    }

    $arrays_union = ['table' => $table_result, 'left' => $left_result, 'right' => $rigth_result];
/*
    My_Log_Message ('--------',$log_comments_path);      
    My_Log_Message ('TABLE--> ' . json_encode($arrays_union['table']),$log_comments_path); 
    My_Log_Message ('-------',$log_comments_path);      
    My_Log_Message ('LEFT--> ' . json_encode($arrays_union['left']),$log_comments_path); 
    My_Log_Message ('-------',$log_comments_path); 
    My_Log_Message ('RIGHT--> ' . json_encode($arrays_union['right']),$log_comments_path);          
    My_Log_Message ('-------',$log_comments_path); 
*/    
} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to $dbhost and $dbname FAILED !<br>Contact Admin.";
}

# DATA ARRAY OR ERROR ARRAY
if ($route == 'display_data') {  

    My_Log_Message ('$arrays_union: ',$log_comments_path);    
    My_Log_Message ('----------> ' . json_encode($arrays_union),$log_comments_path);    
    echo json_encode($arrays_union);

    //My_Log_Message ('$resultado',$log_comments_path);    
    //My_Log_Message ('----------> ' . json_encode($resultado),$log_comments_path);    
    //echo json_encode($resultado);
    //       versus
    // echo $resultado;

} else {

    echo json_encode(["error sql ",$error_msg]);    

}

?>

