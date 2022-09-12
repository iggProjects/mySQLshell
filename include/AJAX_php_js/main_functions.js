/*
    *  Functions  
*/

function doButtonAction(){

    var table_param = document.getElementById('display-result-nav-title');
    let host_n = table_param.getAttribute('host_numb')
    var _tag = 'display_sql_result';
    document.getElementById(_tag).innerHTML = "";        

    switch (this.id) {

        case 'btn-desc':
            if ( table_param.getAttribute('table') == null ) 
                { invoke_Alert_Window( 'please, select a table ! 😎' ); } 
            else {   

                // query value in tag #sql-query-area                    v 
                if ( document.getElementById('display-sql-console-Up').classList.contains('showDiv') ) { 
                    var table = table_param.getAttribute('table')
                    document.getElementById('sql-query-area').value = 'DESCRIBE ' +  table;
                }

                if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') ) { _tag = 'display-sql-console-Down'; }            
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
            }
            break;

        case 'btn-view':   
            if ( table_param.getAttribute('table') == null ) 
                { invoke_Alert_Window( 'please, select a table ! 😎' ); } 
            else {    
                // Check if actualPage is active
                // document.getElementById('sql-query-area').value = "SELECT * FROM " + table_param.getAttribute('table'); // for avoid conflicts with ajax_Sql_Query finction
                // document.getElementById('sql-query-area').value = ''; // for avoid conflicts with ajax_Sql_Query finction

                // query value in tag #sql-query-area                    v 
                if ( document.getElementById('display-sql-console-Up').classList.contains('showDiv') ) { 
                    var table = table_param.getAttribute('table')
                    document.getElementById('sql-query-area').value = 'SELECT * FROM ' +  table + " limit 0,15";
                }

                if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') ) { 
                    _tag = 'display-sql-console-Down';                        
                }                         
                document.getElementById(_tag).innerHTML =  'Please wait a bit, searching the data';
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_ViewTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&table='+table_param.getAttribute('table')+'&page=1'+'&rec_num_init=0');
            }

            break;    

        case 'btn-diagram':   
            table_diagram();
            break;

        case 'btn-insert':
            if ( table_param.getAttribute('table') == null ) 
                { invoke_Alert_Window( 'please, select a table ! 😎' ); } 
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
                { invoke_Alert_Window( 'please, select a table ! 😎' ); } 
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
                { invoke_Alert_Window( 'please, select a table ! 😎' ); } 
            else {   
                var deleteMask = '';
                deleteMask = 'DELETE FROM ' + table_param.getAttribute('table') + ' \n\n';                    
                deleteMask += 'WHERE \'your condition\'';   
                document.getElementById('sql-query-area').value=deleteMask;
                Fetch_js('display-sql-console-Down','./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
            }
            break;

        case 'btn-sql':              
            
            // invoke_Alert_Window('first this.id: ' + this.id);
            // IF to check: host and DB exists & query is not empty
            // capture host and db from tag -> #display-result-nav-title
            var table_param = document.getElementById('display-result-nav-title');                

            if ( table_param.getAttribute('host') == null ) { 
                invoke_Alert_Window('Please select a DB Server ! 😎');                    
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

                // show tables in DB                
                document.getElementById('p-comment').innerHTML='TABLES';        
                // tag for show tables of DB selected, in tag 'display_right_aside'
                _tag= 'display_right_aside';                       
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));

            }

            break;    
        
            case 'btn-backup':
                // alert('this.id: ' + this.id);
                if ( table_param.getAttribute('db') == null  ) 
                    { invoke_Alert_Window( 'please, select DB, or, if you wish, ' + '\n\n' + 'add the list of tables you want to back up 😎' ); } 
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
                    // clear 'display-sql-console-Down'
                    document.getElementById('display-sql-console-Down').innerHTML="";
                    
                    // mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql
                    document.getElementById('sql-query-area').value = 'process&process=backup&tableList=\'table 1 table2 table3 ...\'';
                    var _query =  document.getElementById('sql-query-area').value;
                    //Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + host_n + '&hostName='+sql_host_db.getAttribute('host')+'&dbName='+sql_host_db.getAttribute('db')+'&sql_query='+_query);
                    
                }
            break;

            case 'btn-restore':
                // alert('this.id: ' + this.id);
                if ( table_param.getAttribute('db') == null  ) 
                    { invoke_Alert_Window( 'please, select DB, or, if you wish,' + '\n\n' + 'add the list of tables you want to back up 😎' ); } 
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
                    // clear 'display-sql-console-Down'
                    document.getElementById('display-sql-console-Down').innerHTML="";
                    
                    // $restore_sql  = "/dir/subdir/database.sql";
                    // $cmd = "mysql -h {$server_name} -u {$username} -p{$password} {$database_name} < "/backup_area/backup.sql";
                    document.getElementById('sql-query-area').value = 'process&process=restore&backup_file=backup.sql';
                    var _query =  document.getElementById('sql-query-area').value;
                    // Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + host_n + '&hostName='+sql_host_db.getAttribute('host')+'&dbName='+sql_host_db.getAttribute('db')+'&sql_query='+_query);
                    
                }
            break;

        default:    
        invoke_Alert_Window('Function avalaible in version 1.1 ! 😎');

    }
    
} 

function doLeftAsideButtonAction(){

    // clear #sql-query-area & #display_sql_result
    // document.getElementById('sql-query-area').value = '';
    document.getElementById('display_sql_result').innerHTML='';

    // clear #display-sql-console-Down
    document.getElementById('display-sql-console-Down').innerText = '____ query result area ____';

    var table_Name = this.getAttribute('table-name');        
    
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
    
    // change class of #display-sql-console-Down to hideDiv and clear html
    document.getElementById('display-sql-console-Down').classList.remove("showDiv");
    document.getElementById('display-sql-console-Down').classList.add("hideDiv");
    document.getElementById('display-sql-console-Down').innerHTML = "";      

    // tag for display BUTTONS table in first NAV (up)
    btns = document.querySelectorAll(".nav-btn");   
    for ( var i=0; i<btns.length; i++ ) { 
        if ( btns[i].id == 'btn-diagram' || btns[i].id == 'btn-insert' || btns[i].id == 'btn-update' || btns[i].id == 'btn-delete' || btns[i].id == 'btn-import' || btns[i].id == 'btn-export' ) {              
            btns[i].classList.remove("showBtn");
            btns[i].classList.add("hideBtn");
        } else {
            btns[i].classList.remove("hideBtn");
            btns[i].classList.add("showBtn");
        } 

    }  
}

function analize_query() {

    var query = 'ANALYZE ' + document.getElementById("sql-query-area").value;

    // invoke_Alert_Window('Analyzing query  ⇓'); 
    // invoke_Alert_Window('analyzing query: ' + query); 

    execute_query(query);

}


function execute_query(q){

    if ( q == null ) {
        // read query from tag "sql-query-area"
        var _query = document.getElementById("sql-query-area").value;  
    } else {
        _query = q;
    }
    
    // delete char ';' at the end of query string 
    if ( _query[_query.length-1] == ';' ) { _query = _query.slice(0, -1); }

    // IF to check host and DB exists & query is not empty
    // capture host and db from tag -> #display-result-nav-title
    var sql_host_db = document.getElementById('display-result-nav-title');
    let host_n = sql_host_db.getAttribute('host_numb');

    if ( _query == "" || sql_host_db.getAttribute('host') == null || sql_host_db.getAttribute('db') == null ) { 
        invoke_Alert_Window('check if you select HOST and DB and you write an sql query ! 😎') 
    } else {

        // display button 'increase' or 'reduce'
        document.getElementById('extend-console-up-btn').style.display='block'; 
        document.getElementById('compress-console-up-btn').style.display='block';

        // reduce or increase hight 'display-sql-console-Up'
        document.getElementById('display-sql-console-Up').style.height='15%';
        document.getElementById('display-sql-console-Down').style.height='73%';              

        // add 'LIMIT parameters' if is a SELECT query
        if ( _query.includes("select") || _query.includes("SELECT") ) { _query += ' limit 0,15'; }   
        
        var hostName = sql_host_db.getAttribute('host');
        var dbName = sql_host_db.getAttribute('db');
        
        // Check if table is specified
        if ( sql_host_db.getAttribute('table')) {
            var db_table = sql_host_db.getAttribute('table'); 
        } else {
            var db_table = '';
        }

        // call AJAX for execute query            
        var _tag = 'display-sql-console-Down';   
        document.getElementById(_tag).innerHTML =  'Please wait a bit, searching the data';         
        Fetch_js(_tag,'./include/AJAX_php_js/ajax_Sql_Query.php?host_numb=' + host_n + '&hostName='+sql_host_db.getAttribute('host')+'&dbName='+sql_host_db.getAttribute('db')+'&sql_query='+_query+'&page=1&table=' + db_table);

    }

}    

function ClearSqlQueryAreas(){    
    document.getElementById('sql-query-area').value="";   
    document.getElementById('display-sql-console-Up').style.height="30%";  
    document.getElementById('display-sql-console-Down').innerHTML=""; 
    document.getElementById('display-sql-console-Down').style.height="58%"; 
}                                    


// INSERT my "favourite query" in my_sql_queries. 
function get_favourite_query() {
    invoke_Prompt_Window('Please write a short comment to describe your query ! 😎');
}

function displayPage(char) {
    var page = document.getElementById('actualPage').getAttribute('page');
    var table_param = document.getElementById('display-result-nav-title');
    var query = document.getElementById("actualQuery").textContent;  
    var num_rec_init = parseInt(document.getElementById('actualPage').getAttribute('num_rec_init'));
    var totRecords = parseInt(document.getElementById('actualPage').getAttribute('totRecords'));        

    var do_it = 1; 

    switch (char) {

        case '1':
            if ( page == 1 ) { invoke_Alert_Window('You are in the first page ! 😎'); do_it=0; } else { num_rec_init = 0; page=1; }                
            //invoke_Alert_Window('Query: ' + query + '\n' + ', page: ' + page + ', num_rec_init: ' + num_rec_init + ', totRecords: ' + totRecords + '\n' + ', action: ' + char); 
            break;

        case '-1':                
            if ( parseInt(page) > 1 ) {  page = parseInt(page) -1 ; num_rec_init = num_rec_init - 15; } else { invoke_Alert_Window('You are in the first page ! 😎'); do_it = 0; }
            break; 

        case '+1':
            if ( num_rec_init > totRecords -15 ) { invoke_Alert_Window('You are in the last page ! 😎'); do_it = 0; } else { page = parseInt(page) + 1; num_rec_init = num_rec_init + 15; }                
            break;   

        case '2':
            var last_page = Math.floor(totRecords / 15) +1;                
            if ( last_page == page ) { invoke_Alert_Window('You are in the last page ! 😎'); do_it = 0; } else { num_rec_init = (last_page-1)*15; page = last_page; }                
            break;

        default:
            break;  

    }    
    
    // tag's:  display_sql_result and display-sql-console-Down  
    var post_str = '';
    
    tag = ''; 
    if ( document.getElementById('display_sql_result').classList.contains('showDiv') && do_it == 1 ) {
        tag = 'display_sql_result';
        post_str= "host_numb=" + table_param.getAttribute('host_numb');
        post_str += "&hostName=" + table_param.getAttribute('host');
        post_str += "&dbName=" + table_param.getAttribute('db');
        post_str += "&table=" + table_param.getAttribute('table');
        post_str += "&page=" + page + "&num_rec_init=" +num_rec_init + "&totRecords=" +totRecords;
        // post_str += "&sql_query=" + query + "&page=" + page + "&num_rec_init=" +num_rec_init;
        // alert('post_str' + post_str);
        Fetch_js(tag,'./include/AJAX_php_js/ajax_ViewTbl.php?'+post_str); 
    } else if ( document.getElementById('display-sql-console-Down').classList.contains('showDiv') && do_it == 1 )  {
        tag = 'display-sql-console-Down'; 
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
        console.log('displayPage(): upsssssssssssss, something wrong');            
    } 

}

function table_to_csv() {        
    var _query = '';
    var _tag = '';
    var post_str = '';
    var table_param = document.getElementById('display-result-nav-title');

    console.log('get in table_to_csv()');
    
    if ( document.getElementById('display_sql_result').classList.contains('showDiv') ) {
        _query = 'SELECT * FROM ' + table_param.getAttribute('table'); 
        _tag='display_sql_result';  
    } else if (document.getElementById('display-sql-console-Down').classList.contains('showDiv') ) {
        _query = document.getElementById('sql-query-area').value;
        _tag='sql-query-area';  
    } else {
        // upssssssssssss
        console.log('table_to_csv(): upsssssssssssss, something wrong');            
    }           

    if ( _query != '' ) {
        post_str = "host_numb=" + table_param.getAttribute('host_numb');
        post_str += "&hostName=" + table_param.getAttribute('host');
        post_str += "&dbName=" + table_param.getAttribute('db');
        post_str += "&sql_query=" + _query;

        console.log('table_to_csv() post_str: ' + post_str);

        Fetch_js(_tag,'./include/AJAX_php_js/ajax_table_to_csv.php?'+post_str);
    }
}


// DIAGRAM FOR TABLE SELECTED
function table_diagram() {

    // IF to check table exits 

    let table_param = document.getElementById('display-result-nav-title');
    let host_n = table_param.getAttribute('host_numb');
    let host_sel = table_param.getAttribute('host');
    let db_sel = table_param.getAttribute('db');
    let table_selected = table_param.getAttribute('table');      
    
    if ( table_selected === null ) { invoke_Alert_Window('Please, select a table ! 😎'); } 
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
