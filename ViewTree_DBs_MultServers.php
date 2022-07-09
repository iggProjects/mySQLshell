<?php

include_once "./navegacion_servers.php";
include_once "./my_PHP_functions.php";
include_once "./my_SQL_functions_servers.php";
include_once "../../config.servers.php";

$host_serv = [];
$host_serv_ShortName = [];
// $host_serv_db= [];
$host_serv_user = [];
$host_serv_pasw = [];

foreach ( $cfg_s as $server) { 
    for ( $k=0; $k < count($server); $k++ ) { 
        // echo $server[$k+1]['host'] . "<br>"; 
        $host_serv[$k+1] = $server[$k+1]['host'];
        $host_serv_ShortName[$k+1] = $server[$k+1]['hostShortName'];
        $host_serv_user[$k+1] = $server[$k+1]['user'];
        $host_serv_passw[$k+1] = $server[$k+1]['password'];
    }
};

$dbcharset = 'utf8mb4';

$log_comments_path = "../../assets/log-files/log_comments.log";
$log_queries_path = "../../assets/log-files/log_queries.log";

# my configuration for redirect errors.log 
$php_errors_log =  "../../assets/log-files/php_errors.log";
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
    <script type='text/javascript' src='../../assets/js/my_AJAX_functions.js'></script>
<style>

  .div-DB-view { width:95%; height:96vh; overflow-y: scroll; margin:auto; margin-top:10px; padding:5px; border:5px solid #d9d9d9; } 

  .div-DB-view p { color:blue; margin-left:5px;}

  .div-DB-view .div-header-text { width:100%; height: 40px; }

  .div-DB-view .div-header-text h2 {margin-top:3px;  text-align:center; color:gray;}
  
  .div-DB-view .DB-info { width:100%; height:95%; margin-top:0px;} 

  .div-DB-view .DB-info .nav-izq { width:20%; border: 5px solid #e6e6e6; padding-left:5px; overflow-wrap: break-word; overflow: scroll;}

  .div-DB-view .DB-info .nav-izq .spanPlus { font-size:16px; margin-left:10px; font-weight: bold; }  

  .div-DB-view .DB-info .nav-izq .servers_List { width:98%; min-height:30px; margin:auto;  margin-top:0px; margin-bottom:10px; color:blue; }

  .div-DB-view .DB-info .div-der { width:80%; border: 5px solid #e6e6e6; margin-top:0px; margin-left:10px; background-color: #f2f2f2;  overflow: scroll;} 

  .div-DB-view .DB-info .div-der .nav-btns { width:100%; height: 40px; margin:0px; background-color: #a6a6a6; }

  .nav-btns button {min-width: 80px; height: 30px; font-size:11px; border:1px solid orange; background-color:orange; border-radius: 5px;}

  button:hover{ 
    background-color: #80bfff; 
    border:1px solid #80bfff;
    height: 50px;
    font-size: 14px;
    color:#003300;
  }

  .div-DB-view .div-der .der-console { width:98%; min-height: 85%; margin-top:0px;  }
  
  .disp-row-center {
    display: flex;
	flex-direction: row;
	flex-wrap: wrap;
	justify-content: space-evenly;
	align-items: baseline;
	align-content: stretch;
  }

  .disp-col-center {
    display: flex;
	flex-direction: column;
	flex-wrap: wrap;
	justify-content: center;
	align-items: baseline;
	align-content: space-evenly;
  }  

  ul, #myUL, #myUL1 {
    list-style-type: none;
  }

  #myUL, #myUL1 {
    margin-left: 15px;
    padding: 3px;    
  }

  #myUL li { margin-top:5px; }

  #myUL1 li { margin-top:5px; }

  .caret {
    cursor: pointer;
    -webkit-user-select: none; /* Safari 3.1+ */
    -moz-user-select: none; /* Firefox 2+ */
    -ms-user-select: none; /* IE 10+ */
    user-select: none;
    color:green;
    font-size:15px;
  }

  .caret::before {
    /* content: "\25B6"; */
    content: "\002B";
    color: black;
    display: inline-block;
    margin-right: 3px;
    font-size: 20px;
  }

  .caret-down::before {
    transform: rotate(90deg);  
  }

  .nested {
    display: none;
    margin: 2px;
    padding-left: 20px;
    color:gray;
  }

  .active {
    display: block;
    font-size: 14px;
  }

</style>
</head>
<body>

<?php

echo "    
    <div class='div-DB-view disp-row-center'>
        <div class='div-header-text'>
            <h2>my SQL admin</h2>  
        </div>";

        $host_pointer = 1;   
        $db_pointer = 1;
        $array_pointer= 0;        
        $host_db_array = [ 1 => [] ];  

        $conex = try_catch_connect_host($host_serv[1],$host_serv_user[1],$host_serv_passw[1],$dbcharset,$log_queries_path);

        #  
        # SELECT query for display info of distintc DB in DB server
        # 

        $select_query = "SELECT TABLE_SCHEMA, TABLE_NAME, TABLE_TYPE, TABLE_ROWS, TABLE_COLLATION FROM information_schema.tables;";
        $result = SELECT_try_catch($conex,'',$host_serv_user[1],'information_schema.tables',$select_query,$log_queries_path);

        // Hacer if sobre $result objet (select ok) vs string (error)
        
        // DISPLAY HTML

        echo "<div class='DB-info' style='display:flex;'>";
            echo "<div class='nav-izq'>";  
                echo "<p><span style='color:#990000;'>SERVER:</span></p>"; 
                
                echo "<select class='servers_List' name='servers_List' id='serverList'>";                
                    echo "<option class='serverOpt' value='' selected>Select Server</option>"; 
                    for ( $k=0; $k < $i_serv; $k++ ) {                         
                        echo "<option class='serverOpt'  value='" . $host_serv[$k+1] . "'>" . $host_serv_ShortName[$k+1] . "</option>"; 
                    }
                echo "</select>"; 
                echo "<p id='hostNavIzq' style='margin-top:0px; color:gray; font-size:10px;'><b>Server:</b></p>";                

                echo "&nbsp;&nbsp;(Click on + to see tables)     

                <ul id='myUL'>";
                    $db_bf = $result[0]['TABLE_SCHEMA'];                        
                    echo "<li><span class='caret'>" . $result[0]['TABLE_SCHEMA'] . "</span>";
                    echo "<ul class='nested'>";
                    foreach ( $result as $row ) {                            
                        if ( $row['TABLE_SCHEMA'] == $db_bf ) {           
                            if( $row['TABLE_ROWS']==null ) { $num_rows = 0; } else { $num_rows = $row['TABLE_ROWS']; }
                            echo "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host='" . $host_pointer . "' db='" . $db_pointer  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span></li>";  
                            array_push($host_db_array[$host_pointer],[$host_serv[1],$db_bf,$row['TABLE_NAME']]);
                            // TABLE_TYPE, TABLE_ROWS, TABLE_COLLATION

                        } else {

                            $db_bf = $row['TABLE_SCHEMA'];                            
                            $db_pointer++;
                            echo "</ul>";
                            echo "<li><span class='caret'>" . $row['TABLE_SCHEMA'] . "</span>";
                            echo "<ul class='nested'>";
                            if( $row['TABLE_ROWS']==null ) { $num_rows = 0; } else { $num_rows = $row['TABLE_ROWS']; }
                            echo "<li class='li-mysql-table dispTbl' point='". $array_pointer ."' host='" . $host_pointer . "' db='" . $db_pointer  . "'  table-name='" . $row['TABLE_NAME'] . "'><span>" . $row['TABLE_NAME'] . " | " . $num_rows . " rows</span><span class='spanPlus'>+</span>";  
                            array_push($host_db_array[$host_pointer],[$host_serv[1],$db_bf,$row['TABLE_NAME']]);

                        }
                        $array_pointer++;
                    }
                echo "</ul>";  

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
                        echo "<div id='display_sql_1'></div>";
                    echo "</div>";
            echo "</div>";
        echo "</div>";
    
    echo "</div>";

?>

<script>
    /* For expand UL */
    var toggler = document.getElementsByClassName("caret");
    var i;
    // console.log('caret length ' + toggler.length);

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
    var host_db_tbl_array = <?php echo json_encode($host_db_array); ?>;

    for (j = 0; j < tableDisplay.length; j++) {    
        
        tableDisplay[j].addEventListener("click", function() {    
            
            // Parameters for calling ajax junction
            var point = this.getAttribute('point');
            var hostNumb = this.getAttribute('host');
            var dbNumb = this.getAttribute('db');
            var tblName = this.getAttribute('table-name');      

            var hostName = host_db_tbl_array[hostNumb][point][0];
            var dbName = host_db_tbl_array[hostNumb][point][1];   
            
            if ( hostNumb == 1 ) { _tag='display_sql_1'; } else { _tag='display_sql_2'; }
            
            DescribeTbl_js(_tag,'DescribeTbl_ajax.php?hostName='+hostName+'&dbName='+dbName+'&tblName='+tblName);    
            
        });       
      
    }

    var hostSelected = document.getElementById("serverList");

    hostSelected.addEventListener("click", () => {
        hostSelected.addEventListener("change", () => {
            console.log('host Selected ' + hostSelected.value); 
            document.getElementById('hostNavIzq').innerHTML = hostSelected.value;   
        })
        // call ajax function to display DB-info area
    })    

</script>

</body>
</html>
