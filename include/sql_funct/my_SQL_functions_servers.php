<?php

# 
#    my SQL basic functions 
#

function try_catch_connect_host($db_host,$db_user,$db_pass,$db_charset,$log_comments) {


    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    try {

        $conex = new PDO("mysql:host=$db_host;charset=$db_charset", $db_user, $db_pass);
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conex->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        # mail to inform
        $subject1 = "Connection to host '$db_host' OK | ";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user connect succesfully to '$db_host'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);
        # Log file updated
        My_Log_Message ($cuerpo1, $log_comments );
        
        return $conex;	

    } catch (PDOException $e) {

        $conex=null;
        # mail to inform
        $subject1 = "$db_user, connection to host '$db_host' FAIL ! ";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user CONNECT host '$db_host' FAIL !" . $e->getMessage();
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);
        # Log file updated
        My_Log_Message($cuerpo1 . $e->getMessage(), $log_comments);        
        return $e->getMessage();

    }

}

/*
* 
*/

function try_catch_connect_host_db($db_host,$db_name,$db_user,$db_pass,$db_charset,$log_comments) {

    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    try {

        $conex = new PDO("mysql:host=$db_host;dbname=$db_name;charset=$db_charset", $db_user, $db_pass);
        $conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conex->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        # mail to inform
        $subject1 = "Connection to '$db_name' DB OK | ";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user connect succesfully to '$db_name'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);
        # Log file updated
        My_Log_Message($cuerpo1, $log_comments);
        return $conex;	

    } catch (PDOException $e) {

        $conex=null;
        # mail to inform
        $subject1 = "$db_user, connection to '$db_name' DB FAIL | ";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user CONNECT DB '$db_name' FAIL !" . $e->getMessage();
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);
        # Log file updated
        My_Log_Message($cuerpo1, $log_comments);        
        // My_Log_Message("CONNECT DB '$db_name' FAIL !<br>" . $e->getMessage(), $log_comments);        
        return $e->getMessage();

    }

}

/*
* 
*/

function INSERT_try_catch($conn_active,$db_name,$db_user,$db_table,$insert_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$insert_query for email and log file
    $insert_query_trim = implode(' ',array_filter(explode(' ',$insert_query))); 
    $insert_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $insert_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        //$consulta = "INSERT INTO `tbl_users` VALUES (1,'2022-05-26 15:51:36','iggAdmin','iggAdmin59','igg.git.h@gmail.com','admin',NULL,0),(2,'2022-05-26 20:56:57','invitado1','1234abcde','invit@gmail.com','invitado',NULL,0),(3,'2022-05-27 10:50:15','invitado2','invitado2','invitado2@gmail.com','invitado',NULL,1),(4,'2022-05-27 11:02:54','invitado3','invitado3','invitado3@gmail.com','invitado',NULL,1);";
        $stmt = $conn_active->prepare($insert_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Insert Query succesfully executed in $db_name";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully insert query in $db_name" . "\r\n" . "Query: '$insert_query_trim'";
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, insert query in $db_table FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | insert query FAILED " . "\r\n" . " '$insert_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}

/*
* 
*/

function SELECT_try_catch($conn_active,$db_name,$db_user,$db_table,$select_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$select_query for email and log file
    $select_query_trim = implode(' ',array_filter(explode(' ',$select_query))); 
    $select_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $select_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($select_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Select Query succesfully executed in $db_table";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully Select query in $db_name" . "\r\n" . " '$select_query_trim'";
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, select query in $db_table FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | select query in $db_name FAILED " . "\r\n" . " '$select_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}


/*
* 
*/

function Show_DB_try_catch($conn_active,$db_user,$showDB_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$showDB_query for email and log file
    $show_DB_query_trim = implode(' ',array_filter(explode(' ',$showDB_query))); 
    $show_DB_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $show_DB_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($show_DB_query_trim);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Show tables query succesfully executed in tbl_users";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully show tables query" . "\r\n" . " '$show_DB_query_trim'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, Show Tables query  FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | show tables query FAILED " . "\r\n" . " '$show_DB_query_trim' " . $e->getMessage();
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}



/*
* 
*/

function ShowTables_try_catch($conn_active,$db_name,$db_user,$showtables_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$showtables_query for email and log file
    $showtables_query_trim = implode(' ',array_filter(explode(' ',$showtables_query))); 
    $showtables_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $showtables_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($showtables_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Show tables query succesfully executed in tbl_users";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully show tables query" . "\r\n" . " '$showtables_query_trim'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, Show Tables query in $db_name FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | show tables query FAILED " . "\r\n" . " '$showtables_query_trim' " . $e->getMessage();
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}

/*
* 
*/

function DescribeTables_try_catch($conn_active,$db_name,$db_user,$describetables_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$describetables_query for email and log file
    $describetables_query_trim = implode(' ',array_filter(explode(' ',$describetables_query))); 
    $describetables_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $describetables_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($describetables_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Show tables query succesfully executed in tbl_users";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully show tables query" . "\r\n" . " '$describetables_query_trim'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, Show Tables query in $db_name FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | show tables query FAILED " . "\r\n" . " '$describetables_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}

function Sql_Query_try_catch($conn_active,$db_name,$db_user,$sql_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$select_query for email and log file
    $sql_query_trim = implode(' ',array_filter(explode(' ',$sql_query))); 
    $sql_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $sql_query_trim);    

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($sql_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);           

        # mail param's
        $subject1 = "$db_user: Sql Query succesfully executed in DB: $db_name !";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully Sql Query in DB: $db_name" . "\r\n" . " '$sql_query_trim'";
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, Sql query in DB: $db_name FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | Sql_Query_try_catch: query in $db_name FAILED !" . "\r\n" . " '$sql_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);    
       //  $result = $e->getMessage();  
        $error_msg = "<br>MySql error 😌<br><br>[Date: " . date('Y-m-d H:i:s') . "]<br><br>";
        $error_msg .= "QUERY:<br>\"<span style='color:#990000;'> $sql_query_trim </span>\"<br><br>";
        $error_msg .= "Error executing query in function \"Sql_Query_try_catch\" in DB \"$db_name\"";
        $error_msg .= "<br><br><span style='color:#990000;'>" . $e->getMessage() . "</span>";  
        echo $error_msg;
        echo "<br><br>";
        echo '<a href='. getURIGoogle($e->getMessage()) .' target="_blank">Search "error info" in Google</a>';
    }

}

function DROP_try_catch($conn_active,$db_name,$db_user,$db_table,$droptables_query,$log_comments) {

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$droptables_query for email and log file
    $droptables_query_trim = implode(' ',array_filter(explode(' ',$droptables_query))); 
    $droptables_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $droptables_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($droptables_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   
/*
        echo "<br>---- var_dump \$stmt ----<br>";
        echo "<pre style='margin-left:20px; font-size:10px;'>";   
            echo var_dump($stmt);
        echo "</pre>"; 

        echo "<br>---- var_dump \$resultado ----<br>";
        echo "<pre style='margin-left:20px;font-size:10px;'>";   
            echo var_dump($result);
        echo "</pre>";  
*/
        # mail param's
        $subject1 = "$db_user: drop tables query succesfully executed in $db_table";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully drop table query" . "\r\n" . " '$droptables_query_trim'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, Drop Tables query in $db_name FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user drop table query FAILED " . "\r\n" . " '$droptables_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}


/*
* 
*/

function restoreTable_try_catch($conn_active,$db_name,$db_user,$db_table,$restoreTable_query,$log_comments){

    # mail parameters
    $mailto='igg.git.h@gmail.com';
    // $mailto='igg.git.h@gmail.com,albertomozodocente@gmail.com;';
    $cabeceras = 'From: igg.git.h@gmail.com' . "\r\n" . 
    'Reply-To: igg.git.h@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    # clean spaces in \$droptables_query for email and log file
    $restoreTable_query_trim = implode(' ',array_filter(explode(' ',$restoreTable_query))); 
    $restoreTable_query_trim = preg_replace("/\r\n+|\r+|\n+|\t+/i", " ", $restoreTable_query_trim);

    try {

        $conn_active->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn_active->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        $stmt = $conn_active->prepare($restoreTable_query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   

        # mail param's
        $subject1 = "$db_user: restore table  query succesfully executed in ";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user execute succesfully restore table '$db_table' query in $db_name" . "\r\n" . " '$restoreTable_query_trim'";
        // mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message ($cuerpo1, $log_comments);

        # return data
        return $result;	

    } catch (PDOException $e) {

        // $conn_active=null;
        # mail param's
        $subject1 = "$db_user, restore table query FAILED";
        $cuerpo1 = "Date: " . date('Y-m-d H:i:s') . " | $db_user restore table '$db_table' query FAILED " . "\r\n" . " '$restoreTable_query_trim' " . $e->getMessage();
        //mail($mailto,$subject1,$cuerpo1,$cabeceras);

        # print in Log File
        My_Log_Message($cuerpo1, $log_comments);        
        return $e->getMessage();

    }

}




?>

