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


if ( $_REQUEST['host_numb'] ) {
    $host_numb = $_REQUEST['host_number']; 
} else {}


if ( $_REQUEST['hostName'] ) {
    $hostName = $_REQUEST['hostName']; 
} else {}

/*
if ( $_REQUEST['hostUser'] ) {
    $hostUser = $_REQUEST['hostUser']; 
} else {}

if ( $_REQUEST['hostPassw'] ) {
    $hostPassw = $_REQUEST['hostPassw']; 
} else {}

if ( $_REQUEST['dbCharset'] ) {
    $dbcharset = $_REQUEST['dbCharset']; 
} else {}
*/

if ( $hostName == 'POAPMYSQL119.dns-servicio.com:3306' ) {
    $hostUser = "inaki2022";
    $hostPassw = "Inaki@2022";
    $dbcharset = 'utf8mb4';
    $h=1;
} elseif ( $hostName == '127.0.0.1' ) {
    $hostUser = "root";    
    $hostPassw = "@mysql@";
    $dbcharset = 'utf8mb4';
    $h=2;
} else {
    // upssssss msg
}

$host_pointer = $h;   
$db_pointer = 1;
$array_pointer= 0;        
// $host_db_array = [ 1 => [] ];          

$conex_host = try_catch_connect_host($hostName,$hostUser,$hostPassw,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "";

if ( gettype($conex_host) === 'object' ) {

    # SELECT query for display info of distintc DB tables in SERVER
    $select_query = "SELECT TABLE_SCHEMA, TABLE_NAME, TABLE_TYPE, TABLE_ROWS, TABLE_COLLATION FROM information_schema.tables;";
    $result = SELECT_try_catch($conex_host,'',$hostUser,'information_schema.tables',$select_query,$log_queries_path);

    if ( gettype($result) === 'object' || gettype($result) === 'array' ) {  
        $route = "display_data";    
    } else {
        $route = "display_error";
        $error_msg = "MySql error: describe '$dbtable' query FAILED !<br>Contact Admin.";
    }    

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to $dbname FAILED !<br>Contact Admin.";
}

# HTML DATA FOR DIV WHICH CONTENT IS HOST-DB-TABLES TREE
if ($route == 'display_data') { # display html data   

    $divHtml  = "<p style='color:#cc8800; font-size='9px;''>(Click on + to see tables)</p>";     
    // $divHtml  = "<p style='color:red; font-size='11px;' onclick='openTree()'>(Click on + to see tables)</p>";     

    $divHtml .= "<ul id='myUL'>";
        $db_bf = $result[0]['TABLE_SCHEMA'];                        
        $divHtml .= "<li host_numb=" . $host_pointer . "  host=" . $hostName . " db = " . $result[0]['TABLE_SCHEMA'] . "><span class='caret'>" . $result[0]['TABLE_SCHEMA'] . "</span>";
        $divHtml .= "<ul class='nested'>";
        foreach ( $result as $row ) {     

            if ( $row['TABLE_SCHEMA'] == $db_bf ) {           
                if( $row['TABLE_ROWS']==null ) { $num_rows = 0; } else { $num_rows = $row['TABLE_ROWS']; }
                $divHtml .= "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host_numb='" . $host_pointer . "' db='" . $row['TABLE_SCHEMA']  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span></li>";  
                // $divHtml .= "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host='" . $host_pointer . "' db='" . $db_pointer  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span></li>";  
                // array_push($host_db_array[$host_pointer],[$host_serv[1],$db_bf,$row['TABLE_NAME']]);
                // TABLE_TYPE, TABLE_ROWS, TABLE_COLLATION

            } else {

                $db_bf = $row['TABLE_SCHEMA'];                            
                $db_pointer++;
                $divHtml .= "</ul>";
                $divHtml .= "<li host_numb=" . $host_pointer . " host=" . $hostName . " db=" . $row['TABLE_SCHEMA'] . "><span class='caret'>" . $row['TABLE_SCHEMA'] . "</span>";
                $divHtml .= "<ul class='nested'>";
                if( $row['TABLE_ROWS']==null ) { $num_rows = 0; } else { $num_rows = $row['TABLE_ROWS']; }
                $divHtml .= "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host_numb='" . $host_pointer . "' db='" . $row['TABLE_SCHEMA']  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span>";  
                // $divHtml .= "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host='" . $host_pointer . "' db='" . $db_pointer  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span>";  
                // array_push($host_db_array[$host_pointer],[$host_serv[1],$db_bf,$row['TABLE_NAME']]);

            }
            $array_pointer++;
        
        }

    $divHtml .= "</ul>";  

} else { # display error msg
    $divHtml = $error_msg;  
}

// return $divHtml;
echo $divHtml;

?>

