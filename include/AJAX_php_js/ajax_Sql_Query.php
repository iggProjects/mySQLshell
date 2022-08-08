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

if ( $_REQUEST['page'] ) {
    $page = $_REQUEST['page']; 
}

if ( $_REQUEST['num_rec_init'] ) {
    $num_rec_init = $_REQUEST['num_rec_init']; 
} else {
    $num_rec_init = 0;
}

if ( $_REQUEST['totRecords'] ) {
    $totRecords = $_REQUEST['totRecords']; 
} else {
    $totRecords = 0;
}

$dbuser  = $cfg_s['Servers'][$host_numb]['user'];
$dbpass = $cfg_s['Servers'][$host_numb]['password'];
$dbcharset = 'utf8mb4';

$msg = 'FROM Sql_Query --> First sql_query: ' . $_REQUEST['sql_query'] . ' | ' . ' HOST number: ' . $_REQUEST['host_numb'];
$msg .= ' | hostName: ' . $_REQUEST['hostName'] .  ' | user: ' . $dbuser . ' | pass: ' . $dbpass . ' | page: ' . $page  . ' | ' . $num_rec_init . ' | ' . $totRecords;

My_Log_Message ($msg,$log_comments_path);

# connection to DB using $db_parameters
$conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "MySql error was found";
$divHtml = "";
$thead_titles = [];
$jump = 15;

if( ( str_contains($sql_query, 'SELECT') || str_contains($sql_query, 'select') ) &&  str_contains($sql_query, 'limit')  ) {    
    $sql_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
}    

$msg .= " | extract select: " . $sql_query;

if ( gettype($conex_db) === 'object' ) {

    // calculate record number from page selected    
    if( $totRecords == 0 && ( str_contains($sql_query, 'SELECT') || str_contains($sql_query, 'select') ) ) {    
        // $sql_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
        $msg .= " | second sql query: " . $sql_query;
        // $count_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
        
        // $msg .= " | \$count_query: " . $count_query;

        My_Log_Message ($msg,$log_comments_path);

        $records = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$sql_query,$log_queries_path); 

        if (  gettype($records) === 'object' || gettype($records) === 'array') {
            //$totRecords = $records[0]['numb'];  
            $totRecords = count($records); 
            $route = "display_data";    
            
        } else {
            $route = "display_error";
            $error_msg = "???????? MySql error: select in '$dbtable' query FAILED !<br>Contact Admin.";
        }
    }

    $msg .= " | \$totRecords: " . $totRecords .  " | route: " . $route;

    if ( $totRecords > 0 ) {  // queries type SELECT or select    

        if ( str_contains($sql_query, 'SELECT') || str_contains($sql_query, 'select') ) {
            // $sql_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
            $select_query = $sql_query . " limit $num_rec_init,$jump ";
        } else {
            $select_query = $sql_query;
        }
        $msg .= " | third query, sql_query: " . $sql_query . " | select_query: " . $select_query ;

        My_Log_Message ($msg,$log_comments_path);

        //$select_query = "SELECT * FROM $dbtable limit $num_rec_init,$jump";
        $resultado = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$select_query,$log_queries_path);
        // $resultado = SELECT_try_catch($conex_db,$dbname,$dbuser,$dbtable,$select_query,$log_queries_path); 

        if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  
            $route = "display_data";        
        } else {
            $route = "display_error";
            $error_msg = "MySql error: select query FAILED !<br>Contact Admin.";
        }    

    } elseif ($totRecords == 0 ) {  // queries distinct to SELECT or select

        $select_query = $sql_query;
        
        $msg .= " | fourth sql_query: " . $select_query;

        My_Log_Message ($msg,$log_comments_path);

        //$select_query = "SELECT * FROM $dbtable limit $num_rec_init,$jump";
        $resultado = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$select_query,$log_queries_path);
        // $resultado = SELECT_try_catch($conex_db,$dbname,$dbuser,$dbtable,$select_query,$log_queries_path); 

        if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  
            $route = "display_data";        
        } else {
            $route = "display_error";
            $error_msg = "MySql error: select query FAILED !<br>Contact Admin.";
        }

    } else {
        $route = "display_error";
        $error_msg = "new msg here .... MySql error: select in '$dbtable' query FAILED !<br>Contact Admin.";
    }

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to  $dbname FAILED !<br>Contact Admin.<br>";
    $error_msg .= "connection PDO error: " . $conex_db; 
}

My_Log_Message ($msg,$log_comments_path);
/*
if ( gettype($conex_db) === 'object' ) {

    // calculate record number from page selected
    
    $count_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
    $num_records = count(Sql_Query_try_catch($conex_db,$dbname,$dbuser,$count_query,$log_queries_path));   

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
*/

# HTML DATA FOR DIV
if ($route == 'display_data') { # display html data   

    if ( str_contains($sql_query, 'SELECT') || str_contains($sql_query, 'select') ) {   
        $thead_titles['page'] = $page;   
        $thead_titles['num_rec_init'] = $num_rec_init;
        $thead_titles['jump']  = $jump;    
        $thead_titles['totRecords'] = $totRecords;
    } 
     
    $divHtml = displayTable($sql_query,90,$thead_titles,$resultado);
    // $divHtml = displayTable($select_query,90,$thead_titles,$resultado);
    return $divHtml;

} else { # display error msg    
       
    echo "<br><br><br>" . $error_msg;     

}



?>

