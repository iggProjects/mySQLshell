/*
 *  JS functions for ajax and other requirements
 *  JS functions for host sql queries to display html for div 'DB-info'
*/

function Display_div_nav_izq(tag,host_array,php_sql_url){

    console.log('tag=> ' + tag + '\nphp_sql_url=> ' + php_sql_url) 

    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()
        else
            throw new Error(response.status)
    })

    .then(data => {        
        document.getElementById(tag).innerHTML = data;  

        /* call function for display tree structure of tables by each DB in HOST*/
        openTree(host_array);       

    })

    .catch(err => {
        console.error("ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "ERROR: " + err.message; 

    });

}

    // view Tree UL
function openTree(host_arr) {

    var toggler = document.getElementsByClassName("caret");
    var i;
    // console.log('caret length ' + toggler.length);    

    // Define listeners for "caret" class 
    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            console.log('this class: ' + this.classList + ', tag: '+ this.tagName);
            console.log('parent El: ' + this.parentElement.tagName  + ', class: '+ this.parentElement.classList);

            // get host_numb
            let host_n = document.getElementById('display-result-nav-title').getAttribute('host_numb');
            // get host name
            var hostName = document.getElementById('display-result-nav-title').getAttribute('host');
            // get DB name
            var dbName = this.parentElement.getAttribute('db');   // needed?????

            // clear html of 'der-console associated tag's'
            clearDerConsoleAreas();        
            
            // clear 'display-sql-console-up & display-sql-console-Down'                
            ClearSqlQueryAreas(); 
        
            // tag for display host and DB           
            document.getElementById('display-result-nav-title').innerHTML = 'Host: \"' + hostName + '\"' + ', DB: \"' + dbName + '\"';

            // document.getElementById('display-result-nav-title').setAttribute('host',hostName);
            document.getElementById('display-result-nav-title').setAttribute('db',dbName);    

        /*  
         *   NOTE: This 2 statements open tree in DB in the left aside   
        */           

            if ( this.classList.contains("caret-down") ) {

                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down"); 
                // clear display_right_aside 
                document.getElementById('display_right_aside').innerHTML = '';

            } else {  // initialize the "ul-li" classes to  ul->"caret" & li->"nested" 
                var listCaretCaretDown = document.getElementsByClassName("caret caret-down");            
                for (var i=0; i<listCaretCaretDown.length; i++ ) { 
                    listCaretCaretDown[i].classList.remove("caret-down");             
                }            
                var listNestedActive = document.getElementsByClassName("nested active");            
                for (var i=0; i<listNestedActive.length; i++ ) { 
                    listNestedActive[i].classList.remove("active");
                }         
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down"); 

                // tag for call ajax function to show tables of DB selected
                var table_param = document.getElementById('display-result-nav-title');
                var _tag= 'display_right_aside';   
                document.getElementById('p-comment').innerHTML='TABLES';        
                Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));

            }    

            
        });
    }

    // Define listeners for "dispTbl" class, to display list of table's (via sql query) 
    var tableDisplay = document.getElementsByClassName("dispTbl");
    var j;
    // var host_server = <?php echo json_encode($host_serv); ?>;        

    for (j = 0; j < tableDisplay.length; j++) {    
        
        tableDisplay[j].addEventListener("click", function() {    
            
            // Clear infor of #display_sql_result
            document.getElementById('display_sql_result').innerHTML = "";

            // Parameters for calling ajax junction
            var point = this.getAttribute('point');

            var hostNumb = this.getAttribute('host_numb');
            //var hostNumb = this.getAttribute('host');

            var dbName = this.getAttribute('db');
            var tblName = this.getAttribute('table-name');   

            // tag for display host, DB, table in second NAV
            var _titleTag = 'display-result-nav-title';
            document.getElementById(_titleTag).innerHTML = 'Host: \"' + host_arr[hostNumb] + '\"' + ', DB: \"' + dbName + '\"' +  '<br><span style=\'color:blue;font-size:17px;\'>Table: \"' + tblName + '\" ';
            document.getElementById(_titleTag).setAttribute('host_numb',hostNumb);
            document.getElementById(_titleTag).setAttribute('host',host_arr[hostNumb]);
            document.getElementById(_titleTag).setAttribute('db',dbName);
            document.getElementById(_titleTag).setAttribute('table',tblName);

            var table_param = document.getElementById('display-result-nav-title');

            // call ajax List Table's function
            let host_n = table_param.getAttribute('host_numb')
            var _tag = 'display_sql_result';
            document.getElementById(_tag).innerHTML = "";    
            Fetch_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db')+'&tblName='+table_param.getAttribute('table'));                                    
            
        });      
    
    }    

}

/*
 *  JS functions for db sql queries
*/

/*   For describe table structure */ 
function Fetch_js(tag,php_sql_url){   
    console.log('tag=> ' + tag) 
    console.log('php_sql_url====> ' + php_sql_url) 
    
    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()
        else
            throw new Error(response.status)
    })

    .then(data => {        
        
        document.getElementById(tag).innerHTML = data;    

        // LISTENERS for case '#display_right_aside'  
        if ( tag == 'display_right_aside') {
            var leftAside_Btn_Selected = document.getElementsByClassName('left-aside-btn');    
            for (var i = 0; i < leftAside_Btn_Selected.length; i++) {
                leftAside_Btn_Selected[i].addEventListener('click', doLeftAsideButtonAction, false);
            }   
        }

        // LISTENERS for case select options in '#std-queriesList'
        // OJO: completar leyendo la tabla que está activa
        if ( tag == 'std-queriesList') {
            // Listener to select QUERY from "standard_queries" in "my_lqs_queries" DB
            var querySelected = document.getElementById("std-queriesList");
            // var tbl = document.getElementById("display-result-nav-title").getAttribute('table');
            querySelected.addEventListener("click", () => {
                querySelected.addEventListener("change", () => {                      
                    if (querySelected.value != '' ) {    
                        const relations_query = querySelected.value;
                        document.getElementById('sql-query-area').value = relations_query;
                        //document.getElementById('sql-query-area').value = relations_query + "'" + tbl + "'";
                    } else {   }  // upssssssss
                })
            });          
        }

    })

    .catch(err => {
        console.error("ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "ERROR: " + err.message; 

    });

}


