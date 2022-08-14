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

$dbuser  = $cfg_s['Servers'][$host_numb]['user'];
$dbpass = $cfg_s['Servers'][$host_numb]['password'];
$dbcharset = 'utf8mb4';

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

$msg = 'FROM TABLE to CSV --> First sql_query: ' . $_REQUEST['sql_query'] . ' | ' . ' HOST number: ' . $_REQUEST['host_numb'];
$msg .= ' | hostName: ' . $_REQUEST['hostName'] .  ' | user: ' . $dbuser . ' | pass: ' . $dbpass;

My_Log_Message ($msg,$log_comments_path);

# Cabeceras de página/archivo para que el navegador solicite guardar en vez de presentar
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=ListaAsociados.csv');

# Puntero de archivo para la salida a guardar
$salida = fopen('php://output', 'w');

$conex_db = try_catch_connect_host_db($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

if ( gettype($conex_db) === 'object' ) {

    # Ejecuta consulta y construyo el CSV
    //$lines = $conexion->query($query)->fetchAll(PDO::FETCH_ASSOC);

    $lines = Sql_Query_try_catch($conex_db,$dbname,$dbuser,$sql_query,$log_queries_path);

    if (  gettype($lines) === 'object' || gettype($lines) === 'array') {

        // $first = true;
        // fputcsv($salida, $lines[0][$key]);
        
        for ( $i=0; $i<count($lines); $i++ ) {
            fputcsv($salida, $lines[$i]);
        }

    /*
        foreach($lines as $line) {
            fputcsv($salida, $line);
        }
    */

        $route = "display_data";
        $msg .= " | query OK ";
        
    } else {
        $route = "display_error";        
    }

} else {
    $route = "display_error";
    $error_msg = "MySql error: Connection to  $dbname FAILED !<br>Contact Admin.<br>";
    $error_msg .= "connection PDO error: " . $conex_db;     
}

# HTML DATA FOR DIV
if ($route == 'display_data') { # display html data   
    My_Log_Message ($msg,$log_comments_path);
} else { # display error msg        
    echo "<br><br><br>" . $error_msg;     
}


?>
