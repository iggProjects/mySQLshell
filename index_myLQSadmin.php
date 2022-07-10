<?php

include_once "./include/php_funct/navegacion_servers.php";
include_once "./include/php_funct/my_PHP_functions.php";
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

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/myLQSadmin.css">
    <script type='text/javascript' src='./include/js_funct/my_AJAX_functions.js'></script>
  <style></style>
</head>
<body>

<?php

echo "    
    <div class='div-DB-view disp-row-center'>
        <div class='div-header-text'>
            <h2>my SQL admin</h2>  
        </div>";

        echo "<div id='div-DB-info' class='DB-info' style='display:flex;'>";
            echo "<div id='div_nav_izq' class='nav-izq'>";  
                echo "<p><span style='color:#990000;'>SERVER AREA</span></p>"; 
                
                echo "<select class='servers_List' name='servers_List' id='serverList'>";                
                    echo "<option class='serverOpt' value='' selected>Select Server</option>"; 
                    for ( $k=0; $k < $i_serv; $k++ ) {                         
                        echo "<option class='serverOpt'  value='" . $host_serv[$k+1] . "'>" . $host_serv_ShortName[$k+1] . "</option>"; 
                    }
                echo "</select>"; 

                echo "<p id='hostNavIzq' style='margin-top:0px; color:gray; font-size:12px;'><b></b></p>";     
                
                echo "<div id='html_div_nav_izq' style='width:98%;'></div>";

            echo "</div>";

            echo "<div class='div-der'>";
                    echo "<div class='nav-btns disp-col-center'>";
                        echo "<button>Desc<br>Table</button>";
                        echo "<button>View<br>Table</button>";
                        echo "<button>Make<br>Query</button>";
                        echo "<button>Export</button>";
                        echo "<button>Import</button>";
                        echo "<button>Privileges</button>";
                        echo "<button>Backup</button>";
                        echo "<button>Restore</button>";
                    echo "</div>";

                    echo "<div class='der-console disp-row-center'>";
                        echo "<div id='display_sql_result'></div>";
                    echo "</div>";
                    
            echo "</div>";
        echo "</div>";
    
    echo "</div>";

?>

<script>
    
    var hostSelected = document.getElementById("serverList");
    /*
        if ( $hostName == 'POAPMYSQL119.dns-servicio.com:3306' ) {
        $dbuser = "inaki2022";
        $dbpass = "Inaki@2022";
        $dbcharset = 'utf8mb4';
        $h=1;
    } elseif ( $hostName == '127.0.0.1' ) {
        $dbuser = "root";
        $dbpass = "@mysql@";
        $dbcharset = 'utf8mb4';
        $h=2;
    } else {
        // upssssss msg
    }
    */

    hostSelected.addEventListener("click", () => {
        hostSelected.addEventListener("change", () => {
            // console.log('host Selected ' + hostSelected.value); 
            document.getElementById('hostNavIzq').innerHTML = hostSelected.value;  

            // call ajax function to display DB-info area   
            php_sql_url = './include/php_funct/ajax_Display_div_nav_izq.php?hostName='+hostSelected.value;
            console.log('ajax php=> ' + php_sql_url); 
            Display_div_nav_izq('html_div_nav_izq',php_sql_url);
        })
    })    

    // view Tree UL
    function openTree() {

        var toggler = document.getElementsByClassName("caret");
        var i;
        console.log('caret length ' + toggler.length);

        for (i = 0; i < toggler.length; i++) {
            toggler[i].addEventListener("click", function() {
                console.log('this class: ' + this.classList + ', tag: '+ this.tagName);
                console.log('parent El: ' + this.parentElement.tagName  + ', class: '+ this.parentElement.classList);
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
            });
        }

        /* For listening table display via sql query */
        var tableDisplay = document.getElementsByClassName("dispTbl");
        var j;
        var host_server = <?php echo json_encode($host_serv); ?>;
        //var host_db_tbl_array = <?php echo json_encode($host_db_array); ?>;

        for (j = 0; j < tableDisplay.length; j++) {    
            
            tableDisplay[j].addEventListener("click", function() {    
                
                // Parameters for calling ajax junction
                var point = this.getAttribute('point');
                var hostNumb = this.getAttribute('host');
                // var dbNumb = this.getAttribute('db');
                var tblName = this.getAttribute('table-name');   
                
                var dbName = this.getAttribute('db');

                // var hostName = host_db_tbl_array[hostNumb][point][0];
                // var dbName = host_db_tbl_array[hostNumb][point][1];   
                var _tag='display_sql_result';

                // if ( hostNumb == 1 ) { _tag='display_sql_1'; } else { _tag='display_sql_2'; }
                
                // call ajax table function
                DescribeTbl_js(_tag,'./include/php_funct/ajax_DescribeTbl.php?hostName='+host_server[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);    
                // DescribeTbl_js(_tag,'ajax_DescribeTbl.php?hostName='+hostName+'&dbName='+dbName+'&tblName='+tblName);    
                
            });      
      
        }

    }




</script>

</body>
</html>
