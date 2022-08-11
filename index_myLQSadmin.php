<?php

include_once "./include/php_general_funct/my_PHP_functions.php";
include_once "./include/sql_funct/my_SQL_functions_servers.php";
include_once "./config/config.servers.php";

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
    <script type='text/javascript' src='./include/AJAX_php_js/my_AJAX_functions.js'></script>
    <script type='text/javascript' src='./include/AJAX_php_js/my_CANVAS_functions.js'></script>
  <style></style>
</head>
<body>

<?php

echo "    
    <div class='div-DB-view disp-row-center my-scroll-bar'>
        <div class='div-header-text'>
            <h2>myLQS@admin 1.0</h2>  
        </div>";

        echo "<div id='canvas-diagram' class='canvas-area' style='margin:auto; text-align: center;'>  
            <div><button style='width:100px;margin-left:50px;margin-right:50px;margin-bottom:10px;padding:3px;color:white;font-size:16px;background-color:gray; border-radius:10px;' onclick='clear_canvas()'><b>EXIT</b><button></div>  
            <canvas class='canvas-area' id='canvas' width='900px' height='600px' style='border:5px solid gray;'></canvas>
        </div>";
        
        echo "<div id='div-DB-info' class='DB-info'>";
        
            echo "<div id='div_nav_izq' class='nav-izq my-scroll-bar'>";  
                echo "<p style='margin-top:5px; margin-bottom:10px;color:#990000;'>USER:</p>"; 
                
                echo "<select class='servers_List' name='servers_List' id='serverList'>";                
                    echo "<option class='serverOpt' host_numb='' value='' selected>Select Server</option>"; 
                    for ( $k=0; $k < $i_serv; $k++ ) {                         
                        echo "<option class='serverOpt'  host_numb='" . ($k+1) . "'  value='" . $host_serv[$k+1] . "' >" . $host_serv_ShortName[$k+1] . "</option>"; 
                    }
                echo "</select>"; 

                echo "<p id='hostNavIzq' style='margin-top:5px; margin-bottom:10px; color:gray; font-size:12px;'><b></b></p>";     
                
                echo "<div id='html_div_nav_izq' style='width:98%;'></div>";

            echo "</div>";

            echo "<div class='div-der disp-row-center'>";

                    echo "<div class='nav-btns disp-col-center'>";
                        echo "<button id='btn-desc' class='nav-btn showBtn'>Desc<br>Table</button>";
                        echo "<button id='btn-view' class='nav-btn showBtn'>View<br>Table</button>";
                        echo "<button id='btn-sql' class='nav-btn showBtn'>QUERIES<br>AREA</button>";
                        echo "<button id='btn-diagram' class='nav-btn hideBtn'>Diagram</button>";                        
                        echo "<button id='btn-insert' class='nav-btn hideBtn'>Insert<br>Record</button>";
                        echo "<button id='btn-update' class='nav-btn hideBtn'>Update<br>Record</button>"; 
                        echo "<button id='btn-delete' class='nav-btn hideBtn'>Delete<br>Record</button>";  
                        echo "<button id='btn-users' class='nav-btn showBtn'>USERS</button>";                                               
                        echo "<button id='btn-export' class='nav-btn hideBtn'>Export</button>";
                        echo "<button id='btn-import' class='nav-btn hideBtn'>Import</button>";                        
                        echo "<button id='btn-backup' class='nav-btn showBtn'>Backup</button>";
                        echo "<button id='btn-restore' class='nav-btn showBtn'>Restore</button>";                        
                    echo "</div>";

                    echo "<div class='der-console disp-row-center' >";

                        echo "<div id='display_result' class='my-scroll-bar'>

                            <div class='display-result-nav'><p id='display-result-nav-title'></p></div> 

                            <div id='display_sql_result' class='showDiv'></div>

                            <div id='display-sql-console-Up' class='hideDiv my-scroll-bar'>

                                <div class='display-sql-console-Up-btns disp-row-center'>

                                    <div class='disp-row-center' style='width:150px;'>
                                        <button id='extend-console-up-btn' onclick='height_up()'><img src='./assets/img-igg/icons8-expand-48.png' alt='up' width='17' ></button>
                                        <button id='compress-console-up-btn' onclick='height_compress()'><img src='./assets/img-igg/compress-48.png' alt='up' width='17' ></button>
                                        <button id='go-back-btn' style='width:50px;padding:1px;color:blue;font-size:14px;' onclick='go_back()'><b>Exit</b></button>                                                                        
                                    </div>

                                    <button id='query-btn' onclick='execute_query()'><b>Process</b></button> 
                                    <button id='clear-query-btn' onclick='ClearSqlQueryAreas()'><b>Clear Area</b></button> 

                                    <div>
                                        <select class='queries-List' name='std-queries-List' id='std-queriesList'>
                                            <option class='queryOpt'  value='' selected>Sel Std Query\"</option>                
                                        </select> 
                                        <select class='queries-List' name='fav-queries-List' id='fav-queriesList'>  
                                            <option class='fav-queryOpt'  value='' selected>Sel Fav Query</option>              
                                        </select> 
        
                                        <!-- <button id='tbls-View' onclick='table_diagram()'>Diagram</button>  -->
                                    </div>

                                </div>

                                <textarea id='sql-query-area' spellcheck='false' placeholder='CHECK whether or not your QUERY requires the table name....'></textarea>       

                            </div>

                            <div id='display-sql-console-Down' class='my-scroll-bar hideDiv' placeholder='query result area' style='color:blue;'>____ query result area ____</div>
                        
                        </div>";

                        echo "<div id='right_aside' class='my-scroll-bar'>
                            <div class='display_right_aside-comment'><p id='p-comment'>INFO</p></div>
                            <div id='display_right_aside'></div>
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

            let host_n = event.target.selectedOptions[0].getAttribute("host_numb");    
            // alert('host bumber ' + host_n); 
            
            if (hostSelected.value != 0 ) {

                // call ajax function to display DB-info area in div_nav_izq
                php_sql_url = './include/AJAX_php_js/ajax_Display_div_nav_izq.php?host_numb=' + host_n + '&hostName='+hostSelected.value;
                console.log('ajax php=> ' + php_sql_url); 
                var host_array = <?php echo json_encode($host_serv); ?>;

                // select display-result-nav-title values
                var table_param = document.getElementById('display-result-nav-title');
                table_param.setAttribute('host_numb',host_n);
                table_param.setAttribute('host',hostSelected.value);
                table_param.innerHTML = "host_numb: " + host_n + " || HOST: " + hostSelected.value;                
                Display_div_nav_izq('html_div_nav_izq',host_array,php_sql_url);  
                
                // Display query "show databases" in tag "display_right_aside"                 
                document.getElementById('p-comment').innerHTML='DATABASES';        
                // tag for show tables of DB selected                   
                Fetch_js('display_right_aside','./include/AJAX_php_js/ajax_List_DB.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host'));

            } else {
                document.getElementById('html_div_nav_izq').innerHTML = ""; 
                document.getElementById('display-result-nav-title').innerHTML = ""; 
                document.getElementById('display_right_aside').innerHTML = ""; 
            }

        })
    });


    function doButtonAction(){

        var table_param = document.getElementById('display-result-nav-title');
        let host_n = table_param.getAttribute('host_numb')
        var _tag = 'display_sql_result';
        document.getElementById(_tag).innerHTML = "";        

        switch (this.id) {

            case 'btn-desc':
                if ( table_param.getAttribute('table') == null ) 
                    { alert( 'please, select a table' ); } 
                else {   
                    if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') ) { _tag = 'display-sql-console-Down'; }            
                    Fetch_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                }
                break;

            case 'btn-view':   
                if ( table_param.getAttribute('table') == null ) 
                    { alert( 'please, select a table' ); } 
                else {    
                    // Check if actualPage is active
                    // document.getElementById('sql-query-area').value = "SELECT * FROM " + table_param.getAttribute('table'); // for avoid conflicts with ajax_Sql_Query finction
                    // document.getElementById('sql-query-area').value = ''; // for avoid conflicts with ajax_Sql_Query finction

                    if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') ) { _tag = 'display-sql-console-Down'; }                         
                    Fetch_js(_tag,'./include/AJAX_php_js/ajax_ViewTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&table='+table_param.getAttribute('table')+'&page=1'+'&rec_num_init=0');
                }

                break;    

            case 'btn-diagram':   
                table_diagram();
                break;

            case 'btn-insert':
                if ( table_param.getAttribute('table') == null ) 
                    { alert( 'please, select a table' ); } 
                else { // write insert format in tag #sql-query-area
                    var insertMask = '';
                    insertMask = 'INSERT INTO ' + table_param.getAttribute('table') + ' \n\n';
                    insertMask += '(\' \',\' \',\' \',....) ' + '\n\n';   
                    insertMask += 'VALUES (\' \',\' \',\' \',....)';   
                    document.getElementById('sql-query-area').value=insertMask;
                    Fetch_js('display-sql-console-Down','./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                }
                break;

            case 'btn-update':
                if ( table_param.getAttribute('table') == null ) 
                    { alert( 'please, select a table' ); } 
                else {   
                    var updateMask = '';
                    updateMask = 'UPDATE ' + table_param.getAttribute('table') + ' \n\n';
                    updateMask += 'SET \'field\'=\'value\', ....' + '\n\n';   
                    updateMask += 'WHERE \'your condition\'';   
                    document.getElementById('sql-query-area').value=updateMask;
                    Fetch_js('display-sql-console-Down','./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                }
                break;

            case 'btn-delete':
                if ( table_param.getAttribute('table') == null ) 
                    { alert( 'please, select a table' ); } 
                else {   
                    var deleteMask = '';
                    deleteMask = 'DELETE FROM ' + table_param.getAttribute('table') + ' \n\n';                    
                    deleteMask += 'WHERE \'your condition\'';   
                    document.getElementById('sql-query-area').value=deleteMask;
                    Fetch_js('display-sql-console-Down','./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                }
                break;

            case 'btn-sql':              
                
                alert('first this.id: ' + this.id);
                // IF to check: host and DB exists & query is not empty
                // capture host and db from tag -> #display-result-nav-title
                var table_param = document.getElementById('display-result-nav-title');                

                if ( table_param.getAttribute('host') == null ) { 
                    alert('Please select a DB Server ! 😎');                    
                } 
                else {

                    // Hide 'display_sql_result'
                    document.getElementById('display_sql_result').classList.remove("showDiv");
                    document.getElementById('display_sql_result').classList.add("hideDiv"); 
                    // show 'display-sql-console-Up'
                    document.getElementById('display-sql-console-Up').classList.remove("hideDiv");
                    document.getElementById('display-sql-console-Up').classList.add("showDiv");
                    // clear textarea 'sql-query-area' 
                    document.getElementById("sql-query-area").value = '';  
                    // show 'display-sql-console-Down'
                    document.getElementById('display-sql-console-Down').classList.remove("hideDiv");
                    document.getElementById('display-sql-console-Down').classList.add("showDiv");
                    // hide button 'up'
                    document.getElementById('extend-console-up-btn').style.display='block';
                    // hide button 'compress'
                    document.getElementById('compress-console-up-btn').style.display='block';
                    // height for 'display-sql-console-Up'
                    document.getElementById('display-sql-console-Up').style.height='30%';
                    // height 'display-sql-console-Down'
                    document.getElementById('display-sql-console-Down').style.height='58%';

                    // Update tag display-result-nav-title with only Host and DB                    
                    let active_table = '';        
                    if ( table_param.getAttribute('table') != '' ) { active_table = table_param.getAttribute('table') } 
                    
                    table_param.innerHTML = 'HOST: \"' + table_param.getAttribute('host') + '\"' + ' || DB: \"' + table_param.getAttribute('db') + '<br><span style=\"font-size:20px;color:blue;\">' + active_table + '</span>';

                    // tag for display BUTTONS table in second NAV 
                    btns = document.querySelectorAll(".nav-btn");   
                    for ( var i=0; i<btns.length; i++ ) { 
                        if ( btns[i].id == 'btn-diagram' || btns[i].id == 'btn-insert' || btns[i].id == 'btn-update' || btns[i].id == 'btn-delete' || btns[i].id == 'btn-import' || btns[i].id == 'btn-export' || btns[i].id == 'btn-backup' || btns[i].id == 'btn-restore' ) {  
                            btns[i].classList.remove("hideBtn");
                            btns[i].classList.add("showBtn");
                        } else if ( btns[i].id == 'btn-users' || btns[i].id == 'btn-sql' ) {
                            btns[i].classList.remove("showBtn");
                            btns[i].classList.add("hideBtn");
                        } else {
                            // upsssss
                        }
                    }                

                    // tag for show options in "Std Queries" SELECT
                    _tag= 'std-queriesList';
                    _query = 'SELECT btn_name, comment, query FROM standard_queries'; 
                    Fetch_js(_tag,'./include/AJAX_php_js/ajax_SelectOptions_Query.php?hostName=127.0.0.1&dbName=my_lqs_admin&sql_query='+_query);                      
/*
                    // tag for show options in "Fav Queries" SELECT
                    _tag= 'fav-queriesList';
                    // OJO en este caso, la query tiene que ver con el usuario y la DB específica
                    // PENSAR BIEN como implementar                    
                    _query = 'SELECT btn_name, query FROM favorite_queries '; 
                    Fetch_js(_tag,'./include/AJAX_php_js/ajax_SelectOptions_Query.php?hostName=127.0.0.1&dbName=my_lqs_admin&tbl=favorite_queries&sql_query='+_query);                      
*/

                    // document.getElementById('display-result-nav-title').innerHTML="";
                    document.getElementById('p-comment').innerHTML='TABLES';        
                    // tag for show tables of DB selected
                    _tag= 'display_right_aside';                       
                    Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));

                /*    
                    if ( this.id='btn-sql' ) {
                        alert('second this.id: ' + this.id);
                        document.getElementById('sql-query-area').value = '';                                        
                    } else if ( this.id='btn-backup' ) {
                        alert('second this.id: ' + this.id);
                        if ( table_param.getAttribute('db') == null  ) 
                            { alert( 'please, select DB' ); } 
                        else {   
                            // mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql
                            var backupListMask = "";                 
                            backupListMask = '?hostName=' + table_param.getAttribute('host') + '&dbName=' + table_param.getAttribute('db') + '&tableList=\'table 1 table2 table3 ...\'';                     
                            document.getElementById('sql-query-area').value=backupListMask;
                            Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));
                            //Fetch_js('display-sql-console-Down','./include/AJAX_php_js/ajax_backup_DB.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
                        }
                    } else { 'upsss..........' }
                */    

                }

                break;    
           
                case 'btn-backup':
                    alert('this.id: ' + this.id);
                    if ( table_param.getAttribute('db') == null  ) 
                        { alert( 'please, select DB, or, if you wish, add the list of tables you want to back up' ); } 
                    else {
                        
                        // Hide 'display_sql_result'
                        document.getElementById('display_sql_result').classList.remove("showDiv");
                        document.getElementById('display_sql_result').classList.add("hideDiv"); 
                        // show 'display-sql-console-Up'
                        document.getElementById('display-sql-console-Up').classList.remove("hideDiv");
                        document.getElementById('display-sql-console-Up').classList.add("showDiv");
                        // clear textarea 'sql-query-area' 
                        document.getElementById("sql-query-area").value = '';  
                        // show 'display-sql-console-Down'
                        document.getElementById('display-sql-console-Down').classList.remove("hideDiv");
                        document.getElementById('display-sql-console-Down').classList.add("showDiv");
                        // hide button 'up'
                        document.getElementById('extend-console-up-btn').style.display='block';
                        // hide button 'compress'
                        document.getElementById('compress-console-up-btn').style.display='block';
                        // height for 'display-sql-console-Up'
                        document.getElementById('display-sql-console-Up').style.height='30%';
                        // height 'display-sql-console-Down'
                        document.getElementById('display-sql-console-Down').style.height='58%';
                        
                        // mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql
                        var backupListMask = "";                 
                        backupListMask = '?process=backup&hostName=' + table_param.getAttribute('host') + '&dbName=' + table_param.getAttribute('db') + '&tableList=\'table 1 table2 table3 ...\'';                     
                        document.getElementById('sql-query-area').value=backupListMask;
                        Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));                        
                    }
                break;
               

            default:    
                alert('Function avalaible in version 1.1 !');

        }
       
    } 


    var buttonSelected = document.getElementsByClassName('nav-btn');
    for (var i = 0; i < buttonSelected.length; i++) {
        buttonSelected[i].addEventListener('click', doButtonAction, false);
    }
  
    function doLeftAsideButtonAction(){

        // clear #sql-query-area & #display_sql_result
        // document.getElementById('sql-query-area').value = '';
        document.getElementById('display_sql_result').innerHTML='';

        // clear #display-sql-console-Down
        document.getElementById('display-sql-console-Down').innerText = '____ query result area ____';

        var table_Name = this.getAttribute('table-name');
        // alert('table name' + table_Name );
        
        var table_param = document.getElementById('display-result-nav-title');
        table_param.setAttribute('table',table_Name);      
        table_param.innerHTML = 'HOST: \"' + table_param.getAttribute('host') + '\"';
        table_param.innerHTML += ' || DB: \"' + table_param.getAttribute('db') + '<br>';
        table_param.innerHTML +='<span style=\"font-size:20px;color:blue;\">Table: ' + table_Name  + '</span>';           

        // update tag 'display_sql_result' with tbl fields
        let _tag = 'display_sql_result';
        Fetch_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + table_param.getAttribute('host_numb') + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    

    }    

    function go_back() {
        
        // show 'display_sql_result' and clear html
        document.getElementById('display_sql_result').classList.remove("hideDiv");
        document.getElementById('display_sql_result').classList.add("showDiv");     
        document.getElementById('display_sql_result').innerHTML = "";

        // change class of #display-sql-console-Up to hideDiv and clear html
        document.getElementById('display-sql-console-Up').classList.remove("showDiv");
        document.getElementById('display-sql-console-Up').classList.add("hideDiv");  
        // document.getElementById('display-sql-console-Up').innerHTML = "";      
        
        // change class of #display-sql-console-Down to hideDiv and clear html
        document.getElementById('display-sql-console-Down').classList.remove("showDiv");
        document.getElementById('display-sql-console-Down').classList.add("hideDiv");
        document.getElementById('display-sql-console-Down').innerHTML = "";      

        // tag for display BUTTONS table in first NAV (up)
        btns = document.querySelectorAll(".nav-btn");   
        for ( var i=0; i<btns.length; i++ ) { 
            if ( btns[i].id == 'btn-diagram' || btns[i].id == 'btn-insert' || btns[i].id == 'btn-update' || btns[i].id == 'btn-delete' || btns[i].id == 'btn-import' || btns[i].id == 'btn-export' ) {  
            //if ( btns[i].id != 'btn-desc' && btns[i].id != 'btn-view' && btns[i].id != 'btn-sql' && btns[i].id != 'btn-export' && btns[i].id != 'btn-import' ) {      
                btns[i].classList.remove("showBtn");
                btns[i].classList.add("hideBtn");
            } else {
                btns[i].classList.remove("hideBtn");
                btns[i].classList.add("showBtn");
            } 

        }  
    }

    function execute_query(){

        // read query
        var _query = document.getElementById("sql-query-area").value;   
        
        // Clear table in tag 'display-result-nav-title'
        var table_param = document.getElementById('display-result-nav-title');         

        // delete char ';' at the end of query string 
        if ( _query[_query.length-1] == ';' ) { _query = _query.slice(0, -1); }

        // IF to check: host and DB exists & query is not empty
        // capture host and db from tag -> #display-result-nav-title
        var sql_host_db = document.getElementById('display-result-nav-title');
        let host_n = sql_host_db.getAttribute('host_numb');

        if ( _query == "" || sql_host_db.getAttribute('host') == null || sql_host_db.getAttribute('db') == null ) { 
            alert('check if you select HOST and DB and you write an sql query ! 😎') 
        } else {

            // display button 'up'
            document.getElementById('extend-console-up-btn').style.display='block';
            // display button 'reduce'
            document.getElementById('compress-console-up-btn').style.display='block';

            // reducir altura 'display-sql-console-Up'
            document.getElementById('display-sql-console-Up').style.height='15%';
            // aumentar altura 'display-sql-console-Down'
            document.getElementById('display-sql-console-Down').style.height='73%';              

            // add 'LIMIT parameters' if is a SELECT query
            if ( _query.includes("select") || _query.includes("SELECT") ) { _query += ' limit 0,15'; }   
            
            var hostName = sql_host_db.getAttribute('host');
            var dbName = sql_host_db.getAttribute('db');

            // call AJAX for execute query            
            var _tag = 'display-sql-console-Down';
            //Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + host_n + '&hostName='+sql_host_db.getAttribute('host')+'&dbName='+sql_host_db.getAttribute('db')+'&sql_query='+_query);
            Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + host_n + '&hostName='+sql_host_db.getAttribute('host')+'&dbName='+sql_host_db.getAttribute('db')+'&sql_query='+_query+'&page=1');

        }

    }    


    function displayPage(char) {
        // document.getElementById('sql-table-result').innerHTML = '';
        var page = document.getElementById('actualPage').getAttribute('page');
        var table_param = document.getElementById('display-result-nav-title');
        var query = document.getElementById("actualQuery").textContent;  
        var num_rec_init = parseInt(document.getElementById('actualPage').getAttribute('num_rec_init'));
        var totRecords = parseInt(document.getElementById('actualPage').getAttribute('totRecords'));        
        // var newPage = 1;

        var do_it = 1; 

        switch (char) {

            case '1':
                if ( page == 1 ) { alert('You are in the first page !'); do_it=0; } else { num_rec_init = 0; page=1; }                
                //alert('Query: ' + query + '\n' + ', page: ' + page + ', num_rec_init: ' + num_rec_init + ', totRecords: ' + totRecords + '\n' + ', action: ' + char); 
                break;

            case '-1':                
                if ( parseInt(page) > 1 ) {  page = parseInt(page) -1 ; num_rec_init = num_rec_init - 15; } else { alert('You are in the first page !'); do_it = 0; }
                //alert('Query: ' + query + '\n' + ', page: ' + page + ', num_rec_init: ' + num_rec_init + ', totRecords: ' + totRecords + '\n' + ', action: ' + char); 
                break; 

            case '+1':
                // page = parseInt(page) + 1;                
                if ( num_rec_init > totRecords -15 ) { alert('You are in the last page !'); do_it = 0; } else { page = parseInt(page) + 1; num_rec_init = num_rec_init + 15; }                
                //alert('Query: ' + query + '\n' + ', page: ' + page + ', num_rec_init: ' + num_rec_init + ', totRecords: ' + totRecords + '\n' + ', action: ' + char); 
                break;   

            case '2':
                var last_page = Math.floor(totRecords / 15) +1;                
                if ( last_page == page ) { alert('You are in the last page !'); do_it = 0; } else { num_rec_init = (last_page-1)*15; page = last_page; }                
                //alert('Query: ' + query + '\n' + ', page: ' + page + ', num_rec_init: ' + num_rec_init + ', totRecords: ' + totRecords + '\n' + ', action: ' + char); 
                break;

            default:
                break;  

        }    
        
        // tag's:  display_sql_result and display-sql-console-Down  
        var post_str = ''; 
        if ( document.getElementById('display_sql_result').classList.contains('showDiv') && do_it == 1 ) {
            var tag = 'display_sql_result';
            post_str= "host_numb=" + table_param.getAttribute('host_numb');
            post_str += "&hostName=" + table_param.getAttribute('host');
            post_str += "&dbName=" + table_param.getAttribute('db');
            post_str += "&table=" + table_param.getAttribute('table');
            post_str += "&page=" + page + "&num_rec_init=" +num_rec_init + "&totRecords=" +totRecords;
            // post_str += "&sql_query=" + query + "&page=" + page + "&num_rec_init=" +num_rec_init;
            // alert('post_str' + post_str);
            Fetch_js(tag,'./include/AJAX_php_js/ajax_ViewTbl.php?'+post_str); 
        } else if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') && do_it == 1 )  {
            var tag = 'display-sql-console-Down'; 
            post_str= "host_numb=" + table_param.getAttribute('host_numb');
            post_str += "&hostName=" + table_param.getAttribute('host');
            post_str += "&dbName=" + table_param.getAttribute('db');
            post_str += "&sql_query=" + query;
            //post_str += "&table=" + table_param.getAttribute('table');
            post_str += "&page=" + page + "&num_rec_init=" +num_rec_init + "&totRecords=" +totRecords;
            Fetch_js(tag,'./include/AJAX_php_js/ajax_Sql_Query.php?'+post_str);
            //Fetch_js(tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + table_param.getAttribute('host_numb') + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&sql_query='+query+'&rec_numb='+rec_numb);
        } else { 
            // upssssss
        } 

    }


    function ClearSqlQueryAreas(){    
        document.getElementById('sql-query-area').value="";   
        document.getElementById('display-sql-console-Up').style.height="30%";  
        document.getElementById('display-sql-console-Down').innerHTML=""; 
        document.getElementById('display-sql-console-Down').style.height="58%"; 
    }                                    

/*
    function tables_relations() {
        const relations_query = `SELECT TABLE_NAME TBL,COLUMN_NAME COL,CONSTRAINT_NAME IBFK, REFERENCED_TABLE_NAME REF_TBL,REFERENCED_COLUMN_NAME REF_COL \nFROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE \nWHERE REFERENCED_TABLE_SCHEMA = SCHEMA()`;
        document.getElementById('sql-query-area').value = relations_query;
    }

    function tables_size() {
        const size_query = `SELECT table_name TBL, round( (data_length / 1024 / 1024) , 2) SIZE_MB  \nFROM information_schema.TABLES \nWHERE table_schema = SCHEMA()`;
        document.getElementById('sql-query-area').value = size_query;
    }
*/

    // DIAGRAM FOR TABLE SELECTED
    function table_diagram() {

        // IF to check table exits 

        let table_param = document.getElementById('display-result-nav-title');
        let host_n = table_param.getAttribute('host_numb');
        let host_sel = table_param.getAttribute('host');
        let db_sel = table_param.getAttribute('db');
        let table_selected = table_param.getAttribute('table');      
        
        if ( table_selected === null ) { alert('Please, select a table !'); } 
        else {
            Fetch_canvas_data_array('./include/AJAX_php_js/ajax_Sql_Arrays.php?host_numb=' + host_n + '&hostName='+host_sel+'&dbName='+db_sel+'&tblName='+table_selected); 
        }           
    }

    /*
    * Clear html of 'der-console associated tag's'  
    */
    function clearDerConsoleAreas() {

        document.getElementById('display-result-nav-title').innerHTML = "";
        document.getElementById('display_sql_result').innerHTML = "";
        document.getElementById('display-result-nav-title').removeAttribute('table');

        //alert(document.getElementById('sql-query-area').value);
        if ( document.getElementById('sql-query-area').value != null ){
            document.getElementById('sql-query-area').value = '';
        };
        
        // clear table in display-sql-console-Down-result div
        if ( document.getElementById('sql-table-result') ) { document.getElementById('sql-table-result').innerHTML = ""; }

        document.getElementById('display_right_aside').innerHTML = "";

    }


    function height_up() {
        // reducir altura 'display-sql-console-Up'
        document.getElementById('display-sql-console-Up').style.height='60%';

        // aumentar altura 'display-sql-console-Down'
        document.getElementById('display-sql-console-Down').style.height='18%'; 
    }

    function height_compress() {
        // reducir altura 'display-sql-console-Up'
        document.getElementById('display-sql-console-Up').style.height='30%';

        // aumentar altura 'display-sql-console-Down'
        document.getElementById('display-sql-console-Down').style.height='58%'; 
    }

    function clear_canvas() {
        document.getElementById("div-DB-info").style.display="flex";
        document.getElementById("canvas-diagram").style.display="none";
        document.getElementById("canvas").innerHTML = "";
    }

    function console_Log (msG,bckgCol,col,lines){
        var linesJump=''; 
        for (i=1;i<parseInt(lines);i++){
            linesJump+='\n';
        }
        var msg='%c ' + msG + ' ' + linesJump;
        var colEffects='line-height:20px; background:'+bckgCol+'; color:'+col; 
        console.log(msg,colEffects);                
    }

</script>

</body>
</html>
