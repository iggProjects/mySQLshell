<?php
# connection to DB using $db_parameters
$conn = try_catch_connect($dbhost,$dbname,$dbuser,$dbpass,$dbcharset,$log_queries_path);

$route = "";
$error_msg = "MySql error was found";
$dbtable='tbl_users';

if ( gettype($conn) === 'object' ) {

    $route = "display_data";

    $restoreTableQuery = "CREATE TABLE `tbl_users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `date_in` timestamp NOT NULL DEFAULT current_timestamp(),
      `usuario` varchar(20) NOT NULL,
      `clave` varchar(255) NOT NULL,
      `email` varchar(100) NOT NULL,
      `rol` varchar(20) NOT NULL DEFAULT 'invitado',
      `user_token` varchar(50) DEFAULT NULL,
      `blocked` tinyint(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE KEY `usuario` (`usuario`)
      ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;";
    
    $resultado = restoreTable_try_catch($conn,$dbname,$dbuser,$dbtable,$restoreTableQuery,$log_queries_path);

    if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) {  

        $route1 = "display_data";    
        $restoreTableElemQuery = "INSERT INTO `tbl_users` VALUES (1,'2022-05-26 15:51:36','iggAdmin','iggAdmin59','igg.git.h@gmail.com','admin',NULL,0),(2,'2022-05-26 20:56:57','invitado','invitado','igg.git.h@gmail.com','invitado',NULL,0),(3,'2022-05-27 10:50:15','invitado2','invitado2','invitado2@gmail.com','invitado',NULL,1),(4,'2022-05-27 11:02:54','invitado3','invitado3','invitado3@gmail.com','invitado',NULL,1);";  
        $resultado = INSERT_try_catch($conn,$dbname,$dbuser,$dbtable,$restoreTableElemQuery,$log_queries_path); 

        if ( gettype($resultado) === 'object' || gettype($resultado) === 'array' ) { 
          $route2 = "display_data";
        } else { 
          $route2 = "display_error";
          $error_msg = "MySql error: Insert elements in '$dbtable' query FAILED !<br>Contact Admin.<br>";
        }       

      } else {
        $route1 = "display_error";
        $error_msg = "MySql error: Create '$dbtable' query FAILED !<br>Contact Admin.<br>";
    }    

} else {    
    $route = "display_error";
    $error_msg = "MySql error: Connection to $dbname FAILED !<br>Contact Admin.<br>";
}

