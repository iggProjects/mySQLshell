<?php

    include_once "./include/php_general_funct/my_PHP_functions.php";
    include_once "./include/sql_funct/my_SQL_functions_servers.php";
    include_once "./config/config.servers.php";

    # create (if not exits ) "/assets/log-files
    if (!file_exists('./assets/log-files')) {
        mkdir('./assets/log-files', 0777, true); // review permissions
    }  

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
    <link rel="stylesheet" href="./assets/css/myLQSadmin-v1.0.css">    
    <script type='text/javascript' src='./include/AJAX_php_js/my_AJAX_functions.js'></script>
    <script type='text/javascript' src='./include/AJAX_php_js/my_CANVAS_functions.js'></script>
    <script type='text/javascript' src='./include/AJAX_php_js/main_functions.js'></script>
  <style></style>
</head>
<body>

    <div id='div-DB-view'  class='div-DB-view disp-row-center my-scroll-bar'>
        <div class='div-header-text'>
            <h2>mySQLshell 1.0</h2>  
        </div> 

        <div id='canvas-diagram' class='canvas-area' style='margin:auto; text-align: center;'>  
            <div><button style='width:100px;margin-left:50px;margin-right:50px;margin-bottom:10px;padding:3px;color:white;font-size:16px;background-color:gray; border-radius:10px;' onclick='clear_canvas()'><b>EXIT</b><button></div>  
            <canvas class='canvas-area' id='canvas' width='900px' height='600px' style='border:5px solid gray;'></canvas>
        </div> 

        <div id="my-alert-window">
            <p id="p-alert-msg"></p>
            <button id="alert-close" class="alert-button" onclick = "close_Alert_Window()">Close<br>Window</button>
        </div>    

        <div id="my-prompt-window">
            <p id="p-prompt-msg"></p>
            <div class='disp-col-center' style='margin:auto; margin-bottom:10px;'> 
                <textarea id="prompt-comment"  placeholder="Write a short comment  ...... "></textarea>
                <textarea id="prompt-btn-name" placeholder="Write a short name for this query  ...... "></textarea>
            </div>
            <div class='disp-row-center'>
                <button id="prompt-close" class="prompt-button" onclick = "get_fav_query()">Save favourite<br>query</button>
                <button id="prompt-close" class="prompt-button" onclick = "close_Prompt_Window()">Close<br>Window</button>
            </div>
        </div>    

        <div id='div-DB-info' class='DB-info'> 
        
             <div id='div_nav_izq' class='nav-izq my-scroll-bar'>   
                <p style='margin-top:5px; margin-bottom:10px;color:#990000;font-size:20px;'>Servers Tree</p>  
            <?php    
                echo "<select id='serverList' class='servers_List' name='servers_List' >";                
                    echo "<option class='serverOpt' host_numb='' value='' selected>Select Server-User</option>"; 
                    for ( $k=0; $k < $i_serv; $k++ ) {                         
                        echo "<option class='serverOpt'  user='" . $host_serv_user[$k+1] . "' host_numb='" . ($k+1) . "'  value='" . $host_serv[$k+1] . "' >" . $host_serv_ShortName[$k+1] . " (" . $host_serv_user[$k+1] . ")</option>"; 
                    }
                echo "</select>"; 
            ?>    
                 <p id='hostNavIzq' style='margin-top:5px; margin-bottom:10px; color:gray; font-size:12px;'><b></b></p>      
                
                 <div id='html_div_nav_izq' style='width:98%;'></div> 

             </div> 

             <div class='div-der disp-row-center'> 

                     <div class='nav-btns disp-col-center'> 
                         <button id='btn-desc' class='nav-btn showBtn'>Desc<br>Table</button> 
                         <button id='btn-view' class='nav-btn showBtn'>View<br>Table</button> 
                         <button id='btn-sql' class='nav-btn showBtn'>QUERIES<br>AREA</button> 
                         <button id='btn-diagram' class='nav-btn hideBtn'>Diagram</button>                         
                         <button id='btn-insert' class='nav-btn hideBtn'>Insert<br>Record</button> 
                         <button id='btn-update' class='nav-btn hideBtn'>Update<br>Record</button>  
                         <button id='btn-delete' class='nav-btn hideBtn'>Delete<br>Record</button>  
                         <button id='btn-backup' class='nav-btn showBtn'>Backup</button> 
                         <button id='btn-restore' class='nav-btn showBtn'>Restore</button>  
                         <button id='btn-users' class='nav-btn showBtn'>USERS</button>                                                
                         <button id='btn-export' class='nav-btn hideBtn'>Export</button> 
                         <button id='btn-import' class='nav-btn hideBtn'>Import</button>                         
                     </div> 

                     <div id='der-console' class='der-console disp-row-center' > 

                         <div id='display_result' class='my-scroll-bar'>

                            <div class='display-result-nav'><p id='display-result-nav-title'></p></div> 

                            <div id='display_sql_result' class='showDiv'></div>

                            <div id='display-sql-console-Up' class='hideDiv my-scroll-bar'>

                                <div class='display-sql-console-Up-btns disp-row-center'>

                                    <div class='disp-row-center' style='width:150px;'>
                                        <button id='extend-console-up-btn' onclick='height_up()'><img src='./assets/img-igg/icons8-expand-48.png' alt='up' width='17' ></button>
                                        <button id='compress-console-up-btn' onclick='height_compress()'><img src='./assets/img-igg/compress-48.png' alt='up' width='17' ></button>
                                        <button id='go-back-btn' style='width:50px;padding:1px;color:blue;font-size:14px;' onclick='go_back()'><b>Exit</b></button>                                                                        
                                    </div>

                                    <button id='analyze-btn' onclick='analize_query()' title='The "ANALYZE statement" is similar to the EXPLAIN statement. ANALYZE statement will invoke the optimizer, execute the statement, and then produce EXPLAIN output instead of the result set.'><b>Analyze query</b></button> 
                                    <button id='query-btn' onclick='execute_query()' title='Process the "sql query" or the "php command".'><b>Process</b></button> 
                                    <button id='clear-query-btn' onclick='ClearSqlQueryAreas()'><b>Clear Area</b></button> 

                                    <div id='div-queriesList' class='disp-row-center'>
                                        <select id='std-queriesList' class='queries-List' name='std-queries-List' title='Select standard query' >
                                            <option class='queryOpt' value='' selected>Sel Std Query</option>                
                                        </select> 
                                        <select id='fav-queriesList' class='queries-List' name='fav-queries-List' title='Select your favourite query'  >  
                                            <option class='queryOpt' value='' selected>Sel Fav Query</option>              
                                        </select>   
                                        <button id='' style='width:23px; height:23px; border:none;' title='Save query' onclick='get_favourite_query()'><img style='width:16px; height:16px;padding-top:1px;' src='http://imgur.com/I0EwG.png'/></button>                                                     
                                    </div>

                                </div>

                                <textarea id='sql-query-area' spellcheck='false' placeholder='CHECK whether or not your QUERY requires the table name....'></textarea>       

                            </div>

                            <div id='display-sql-console-Down' class='my-scroll-bar hideDiv' placeholder='query result area' style='color:blue;'>____ query result area ____</div>
                        
                        </div> 

                         <div id='right_aside' class='my-scroll-bar'>
                            <div class='display_right_aside-comment'><p id='p-comment'>INFO</p></div>
                            <div id='display_right_aside'></div>
                        </div> 

                     </div> 
                    
             </div> 
         </div> 
    
     </div> 

<script>


    /*
     *  Some Listeners  
    */
    
    // Listener to select HOST and Display TREE of DB and Tbl's
    var hostSelected = document.getElementById("serverList");
    hostSelected.addEventListener("click", () => {
        hostSelected.addEventListener("change", () => {  
                        
            document.getElementById('hostNavIzq').innerHTML = hostSelected.value;  
            
            let user_name = event.target.selectedOptions[0].getAttribute("user");                

            let host_n = event.target.selectedOptions[0].getAttribute("host_numb");            

            // clear html of 'der-console associated tag's'
            clearDerConsoleAreas();       
            // clear 'display-sql-console-up & display-sql-console-Down'                
            ClearSqlQueryAreas(); 
            // IF tal #display-sql-console-Up is active
            if ( document.getElementById('display-sql-console-Up').classList.contains('showDiv')) {
                go_back();
            }
           
            if (hostSelected.value != 0 ) {
                
                // call ajax function to display DB-info area in div_nav_izq
                php_sql_url = './include/AJAX_php_js/ajax_Display_div_nav_izq.php?host_numb=' + host_n + '&hostName='+hostSelected.value;
                
                var host_array = <?php echo json_encode($host_serv); ?>;

                // select display-result-nav-title values
                var table_param = document.getElementById('display-result-nav-title');

                table_param.setAttribute('user_name',user_name);
                table_param.setAttribute('host_numb',host_n);
                table_param.setAttribute('host',hostSelected.value);
                table_param.innerHTML = "user: " + user_name + " || host_numb: " + host_n + " || host url: " + hostSelected.value;  

                Display_div_nav_izq('html_div_nav_izq',host_array,php_sql_url);  
                
                // Display query "show databases" in tag "display_right_aside"                 
                document.getElementById('p-comment').innerHTML='DATABASES';        
                // tag for show tables of DB selected                   
                //Fetch_js('display_right_aside','./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host'));
                //Fetch_js('display_right_aside','./include/AJAX_php_js/ajax_List_DB.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host'));

            } else {
                document.getElementById('html_div_nav_izq').innerHTML = ""; 
                document.getElementById('display-result-nav-title').innerHTML = ""; 
                document.getElementById('display_sql_result').innerHTML = "";
                document.getElementById('display_right_aside').innerHTML = "";                 
            }

        })
    });


    var buttonSelected = document.getElementsByClassName('nav-btn');
    for (var i = 0; i < buttonSelected.length; i++) {
        buttonSelected[i].addEventListener('click', doButtonAction, false);
    }

    function invoke_Alert_Window(my_msg) {
        document.getElementById('p-alert-msg').innerHTML = my_msg;
        document.getElementById("my-alert-window").style.display = "block";
    }

    function close_Alert_Window() {
         document.getElementById("my-alert-window").style.display = "none";
    }

    function invoke_Prompt_Window(my_msg) {
        document.getElementById('p-prompt-msg').innerHTML = my_msg;
        document.getElementById('prompt-comment').value = '';
        document.getElementById("my-prompt-window").style.display = "block";
    }

    function close_Prompt_Window() {
        document.getElementById('sql-query-area').value = '';
        document.getElementById('prompt-comment').value = ''
        document.getElementById('prompt-btn-name').value = '';            
        document.getElementById("my-prompt-window").style.display = "none";
    }

    function get_fav_query() {
        // Read query, comment and btn-name if exists       
        
        if ( document.getElementById('sql-query-area').value != '' && document.getElementById('prompt-comment').value != '' && document.getElementById('prompt-btn-name').value != '' ) { 
           
            // MASK in tag "sql-query-area" for process ???
            //    Versus
            // FETCH           
            
            // Parameters in table favourites_queries:  Host, DB, User, Query, comment, option_name, html_msg for success or fail
            let sql_host_db = document.getElementById('display-result-nav-title');

            let user_name = sql_host_db.getAttribute('user_name');             
            let host_n = sql_host_db.getAttribute('host_numb');            
            let hostName = sql_host_db.getAttribute('host');
            let dbName = 'my_sql_shell';
            let db_table = 'favourite_queries'; 
            let fav_query = document.getElementById('sql-query-area').value;            
            let comment = document.getElementById('prompt-comment').value;
            let option_name = document.getElementById('prompt-btn-name').value;
            // document.getElementById("my-alert-window").style.zIndex = 1;
            
            // Write message in display-sql-console-Down
            // let html_msg = '<p style=\'margin-top:20px;\'>Your favourite query was succesfully saved</p>' + '<br>' + '<p style=\'width:60%; font-size:14; color:#900000\'>'+ document.getElementById('sql-query-area').value + '</p>'; 

            let _query = 'INSERT INTO ' + db_table + ' (host_name, user, db, comment, btn_name, query) ';
            _query += 'VALUES (\'' + hostName + '\',\'' + user_name + '\',\'' + dbName + '\',\'' + comment + '\',\'' + option_name + '\',\'' + fav_query + '\')';

            // call AJAX for execute query 
            let _tag = 'display-sql-console-Down';               
            post_string = 'host_numb=' + host_n + '&hostName=' + hostName;
            post_string += '&dbName=' + dbName + '&table=' + db_table;
            post_string += '&sql_query=' +_query;
            // post_string += '&comment=' + comment + '&btn_name=' + btn_name + '&sql_query=' +_query;

            document.getElementById(_tag).innerHTML =  'Processing query, please wait a bit,<br><br>' + _query;      
            close_Prompt_Window();  

            // Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?post_string');

            // set time before close
            //setInterval(document.getElementById('display-sql-console-Down').innerHTML=html_msg,1000);  

        } else {             
            document.getElementById("my-alert-window").style.zIndex = 1;
            if (document.getElementById('sql-query-area').value == '') {
                invoke_Alert_Window('Plis write your favourite query !');                   
            } else if ( document.getElementById('prompt-comment').value == '' ) {
                invoke_Alert_Window('Plis write a "short comment" for your favourite query !');                       
            } else if ( document.getElementById('prompt-btn-name').value == '' ) {
                invoke_Alert_Window('Plis write a "short name" for option list !');                           
            } else {
                invoke_Alert_Window('From favourite query, something is wrong 🙄 !');                       
            }
            
        }


    }

</script>

</body>
</html>
