<?php

include_once "./include/php_general_funct/navegacion_servers.php";
include_once "./include/php_general_funct/my_PHP_functions.php";
include_once "./include/sql_funct/my_SQL_functions_servers.php";
include_once "./config/config.servers.php";
// include_once "../../config.servers.php";

// pass connection to ajax query in js
// https://www.php.net/manual/es/pdo.connections.php
// https://stackoverflow.com/questions/50999862/reuse-database-connection-pdo-in-php-file-sent-by-ajax
// https://stackoverflow.com/questions/4171593/how-to-use-persistent-connection-of-pdo

# my log files for queries and comments 
$log_comments_path = "./assets/log-files/log_comments.log";
$log_queries_path = "./assets/log-files/log_queries.log";

# my configuration for redirect errors.log 
$php_errors_log =  "./assets/log-files/php_errors.log";
error_reporting(E_ALL);
ini_set('ignore_repeated_errors',TRUE);
ini_set('display_errors', FALSE);
ini_set("log_errors",TRUE);
ini_set('error_log',$php_errors_log);
// ini_set('display_errors', 1);

$conex = ""; # variable global de conexión a la servidor seleccionado

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/myLQSadmin.css">
    <script type='text/javascript' src='./include/AJAX_php_js/my_AJAX_functions.js'></script>
  <style></style>
</head>
<body>

<?php

echo "    
    <div class='div-DB-view disp-row-center'>
        <div class='div-header-text'>
            <h2>my LQS admin</h2>  
        </div>";

        echo "<div id='div-DB-info' class='DB-info' style='display:flex;'>";
            echo "<div id='div_nav_izq' class='nav-izq'>";  
                echo "<p><span style='color:#990000;'>USER: </span></p>"; 
                
                echo "<select class='servers_List' name='servers_List' id='serverList'>";                
                    echo "<option class='serverOpt' value='' selected>Select Server</option>"; 
                    for ( $k=0; $k < $i_serv; $k++ ) {                         
                        echo "<option class='serverOpt'  value='" . $host_serv[$k+1] . "' >" . $host_serv_ShortName[$k+1] . "</option>"; 
                    }
                echo "</select>"; 

                echo "<p id='hostNavIzq' style='margin-top:0px; color:gray; font-size:12px;'><b></b></p>";     
                
                echo "<div id='html_div_nav_izq' style='width:98%;'></div>";

            echo "</div>";

            echo "<div class='div-der disp-row-center'>";

                    echo "<div class='nav-btns disp-col-center'>";
                        echo "<button id='btn-desc' class='nav-btn'>Desc<br>Table</button>";
                        echo "<button id='btn-view' class='nav-btn'>View<br>Table</button>";
                        echo "<button id='btn-sql' class='nav-btn'>Make<br>Query</button>";
                        echo "<button id='btn-export' class='nav-btn'>Export</button>";
                        echo "<button id='btn-import' class='nav-btn'>Import</button>";
                        echo "<button id='btn-privil' class='nav-btn'>Privileges</button>";
                        echo "<button id='btn-bakcup' class='nav-btn'>Backup</button>";
                        echo "<button id='btn-restore' class='nav-btn'>Restore</button>";
                    echo "</div>";

                    echo "<div class='der-console disp-row-center' >";

                        echo "<div id='display_result'>
                            <div class='display-result-nav'><p id='display-result-nav-title'></p></div>
                            <div id='display_sql_result'></div>
                        </div>";
                        echo "<div id='left_aside'>
                            <div class='display_left_aside-comment'><p>TABLE INFO</p></div>
                            <div id='display_left_aside'></div>
                        </div>";

                    echo "</div>";
                    
            echo "</div>";
        echo "</div>";
    
    echo "</div>";

?>

<script>

    /*
     *  Listeners  
    */
    
    // Listener to select HOST and Display TREE of DB and Tbl's
    var hostSelected = document.getElementById("serverList");
    hostSelected.addEventListener("click", () => {
        hostSelected.addEventListener("change", () => {            
            document.getElementById('hostNavIzq').innerHTML = hostSelected.value; 
            if (hostSelected.value != 0 ) {
                // call ajax function to display DB-info area in div_nav_izq
                php_sql_url = './include/AJAX_php_js/ajax_Display_div_nav_izq.php?hostName='+hostSelected.value;
                console.log('ajax php=> ' + php_sql_url); 
                var host_array = <?php echo json_encode($host_serv); ?>;            
                Display_div_nav_izq('html_div_nav_izq',host_array,php_sql_url);
            } else {
                document.getElementById('html_div_nav_izq').innerHTML = ""; 
                document.getElementById('display-result-nav-title').innerHTML = ""; 
                document.getElementById('display_left_aside').innerHTML = ""; 
            }
        })
    });

    // Listeners for buttons of class "nav-btn"

    // considerar un listener para display-result-nav-title de manera de tener los parámetros
    //      cada vez que cambie la tabla 

    function doButtonAction(){

        var table_param = document.getElementById('display-result-nav-title');
        var _tag = 'display_sql_result';
        document.getElementById(_tag).innerHTML = "";

        switch (this.id) {

            case 'btn-desc':                
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                break;

            case 'btn-view':                
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_ViewTbl.php?hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));
                break;    

            default:    
                alert('button selected has not method associated !');

        }
       
    } 

    var buttonSelected = document.getElementsByClassName('nav-btn');

    for (var i = 0; i < buttonSelected.length; i++) {
        buttonSelected[i].addEventListener('click', doButtonAction, false);
    }


    
    

</script>

</body>
</html>
