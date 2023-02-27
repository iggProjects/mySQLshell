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

if ( $_REQUEST['table'] ) {
    $table = $_REQUEST['table']; 
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

/*
if ( $_REQUEST['comment'] ) {
    $comment = $_REQUEST['comment']; 
}

if ( $_REQUEST['btn_name'] ) {
    $btn_name = $_REQUEST['btn_name']; 
}
*/

// 'Processing query, please wait a bit,<br><br>' + post_string;  

$dbuser  = $cfg_s['Servers'][$host_numb]['user'];
$dbpass = $cfg_s['Servers'][$host_numb]['password'];
$dbcharset = 'utf8mb4';

My_Log_Message ('=== ajaxSql_Query ====',$log_comments_path);

// IF to separate 'process' from 'sql' code
if ( strpos($sql_query,'process') ) { 
#if ( strpos($sql_query,'process') >= 0 ) {     

    if ( $_REQUEST['process'] ) { 
        $process = $_REQUEST['process'];
    }      

    My_Log_Message ('=== FROM ajaxSql_Query.php: I am in process option',$log_comments_path);
    
    switch ($process) {
        case 'backup':

            echo "<br><br>process: $process | hostName: $dbhost | dbName: $dbname | process: $process | tableList: " . $_REQUEST['tableList'];

            if ( $_REQUEST['tableList'] ) { 
                $tableList = $_REQUEST['tableList'];
            } else {
                $tableList = "";
            }
        
            define("BACKUP_PATH", "../../backup_area/");
            $date_string = date("Ymd_His");
            $cmd = "mysqldump --default-character-set=utf8mb4 -h{$dbhost} -u{$dbuser} -p{$dbpass} {$dbname} {$tableList} > " . BACKUP_PATH . "{$dbname}_{$date_string}.sql";
            $cmd_screen = "mysqldump --default-character-set=utf8mb4 -h{$dbhost} -u{$dbuser} -p{********} {$dbname} > " . BACKUP_PATH . "{$dbname}_{$date_string}.sql";
            echo "<br><br>Backup Statement for php execution<br><br>exec(<span style='color:#990000; font-size: 18px;'>" . $cmd_screen . ")</span>";
            exec($cmd);
        
            $file_path = BACKUP_PATH . "{$dbname}_{$date_string}.sql";
            if ( file_exists($file_path) && filesize($file_path) != 0 ) { 
                echo "<br><br><span style='color: black; font-size:18px;'><b>Backup procees was succesfully executed !</span><br><span style='font-size:15px;'>Check 'backup_area directory.'</b></span>"; } 
            else { 
                echo "<br><br><span style='color: red; font-size:20px;'><b>Backup process failed !</b></span>"; 
            }

            break;

            case 'restore':
                
                define("RESTORE_PATH", "../../backup_area/");
                if ( $_REQUEST['backup_file'] ) { 
                    $backup_file = RESTORE_PATH . $_REQUEST['backup_file'];
                } else {
                    $backup_file = "";
                }            

                echo "<br><br>process: $process | hostName: $dbhost | dbName: $dbname | backup_file: " . $backup_file;
                
                $date_string = date("Ymd_His");

                $cmd = "mysql -h{$dbhost} -u{$dbuser} -p{$dbpass} {$dbname} < $backup_file";                
                $cmd_screen = "mysql -h{$dbhost} -u{$dbuser} -p********* {$dbname} < $backup_file";
                echo "<br><br>Restore Statement for php execution<br><br>exec(<span style='color:#990000; font-size: 18px;'>" . $cmd_screen . ")</span>";
                
                $out_array = [];
                exec($cmd,$out_array,$return_val);

                if ( $return_val == 0 ) {
                    echo "<br><br><span style='color: black; font-size:18px;'><b>Restore process was succesfully executed !</span>"; 
                } else { 
                    echo "<br><br><span style='color: black; font-size:18px;'><b>Restore process failed !</span>";
                }
                
                My_Log_Message ('out_array: ' . json_encode($out_array),$log_comments_path);

                break;

    }
  

} else {
    
    $msg = 'FROM ajax_Sql_Query.php --> First sql_query: ' . $_REQUEST['sql_query'] . ' | ' . ' HOST number: ' . $_REQUEST['host_numb'];
    $msg .= ' | hostName: ' . $_REQUEST['hostName'] .  ' | user: ' . $dbuser . ' | pass: ***** | page: ' . $page  . ' | ' . $num_rec_init . ' | ' . $totRecords;

    My_Log_Message ($msg,$log_comments_path);

    # connection to DB using $db_parameters
    $conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

    $route = "";
    $error_msg = "";
    $divHtml = "";
    $thead_titles = [];
    $jump = 15;

    if( ( strpos($sql_query, 'SELECT') >=0 || strpos($sql_query, 'select') >= 0 ) &&  strpos($sql_query, 'limit') >= 0  ) {    
        $sql_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
    }    

    $msg .= " | extract limit in select: " . $sql_query;

    if ( gettype($conex_db) === 'object' ) {

        // calculate record number from page selected    
        if( $totRecords == 0 && ( strpos($sql_query, 'SELECT') >= 0 || strpos($sql_query, 'select') >= 0 ) ) {    
            // $sql_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
            $msg .= " | second sql query: " . $sql_query;
            // $count_query = substr($sql_query, 0, strpos($sql_query, 'limit'));
            
            // $msg .= " | \$count_query: " . $count_query;

            My_Log_Message ($msg,$log_comments_path);            
           
            //$records = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$sql_query,$log_queries_path); 

            // Check if table exists and calculate records via SELECT COUNT
            if ( $table != '' ) { $count_query = "SELECT COUNT(*) AS numRec FROM $table"; } else { $count_query = $sql_query; }
            $records = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$count_query,$log_queries_path); 

            if (  gettype($records) === 'object' || gettype($records) === 'array') {
                //$totRecords = $records[0]['numRec'];  
                $totRecords = $records[0]['numRec']; 
                // $totRecords = count($records); 
                $route = "display_data";    
                
            } else {
                $route = "display_error";
                // $error_msg = "???????? MySql error: select in '$dbtable' query FAILED !<br>Contact Admin.";
            }
        }

        $msg .= " | \$totRecords: " . $totRecords .  " | route: " . $route;

        if ( $totRecords > 0 ) {  // queries type SELECT or select    

            if ( strpos($sql_query, 'SELECT') >= 0 || strpos($sql_query, 'select') >= 0 ) {    
            #if ( strpos($sql_query, 'SELECT') || strpos($sql_query, 'select') ) {
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
                // $error_msg = "MySql error: select query FAILED !<br>Contact Admin.";
            }    

        } elseif ($totRecords == 0 && $route != 'display_error' ) {  // queries distinct to SELECT or select

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
                // $error_msg = "MySql error: select query FAILED !<br>Contact Admin.";
            }

        } else {
            $route = "display_error";
            //$error_msg = "new msg here .... MySql error: select in '$dbtable' query FAILED !<br>Contact Admin.";
        }

    } else {    
        $route = "display_error";
        $error_msg = "MySql error: Connection to  $dbname FAILED !<br>Contact Admin.<br>";
        $error_msg .= "connection PDO error: " . $conex_db; 
    }

    My_Log_Message ($msg,$log_comments_path);

    # HTML DATA FOR DIV
    if ($route == 'display_data') { # display html data   

        if ( strpos($sql_query, 'SELECT') >= 0 || strpos($sql_query, 'select') >= 0 ) {   
            $thead_titles['page'] = $page;   
            $thead_titles['num_rec_init'] = $num_rec_init;
            $thead_titles['jump']  = $jump;    
            $thead_titles['totRecords'] = $totRecords;
        } 
        
        $divHtml .= displayTable($sql_query,90,$thead_titles,$resultado);
        // $divHtml = displayTable($select_query,90,$thead_titles,$resultado);
        return $divHtml;

    } else { # display error msg    
        
        echo "<br><br><br>" . $error_msg;     

    }

}

?>

