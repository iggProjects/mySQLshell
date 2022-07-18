/*
 *  JS functions for ajax and other requirements
*/

/*
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

            // get host name
            var hostName = document.getElementById('display-result-nav-title').getAttribute('host');
            // get DB name
            var dbName = this.parentElement.getAttribute('db');

            // clear html of 'der-console associated tag's'
            clearDerConsoleAreas();            
        
            // tag for display host and DB
           
            document.getElementById('display-result-nav-title').innerHTML = 'Host: \"' + hostName + '\"' + ', DB: \"' + dbName + '\"';
            document.getElementById('display-result-nav-title').setAttribute('host',hostName);
            document.getElementById('display-result-nav-title').setAttribute('db',dbName);  
                      

            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
            
        });
    }

    // Define listeners for "dispTbl" class, to display table structure (via sql query) 
    var tableDisplay = document.getElementsByClassName("dispTbl");
    var j;
    // var host_server = <?php echo json_encode($host_serv); ?>;        

    for (j = 0; j < tableDisplay.length; j++) {    
        
        tableDisplay[j].addEventListener("click", function() {    
            
            // Clear infor of #display_sql_result
            document.getElementById('display_sql_result').innerHTML = "";

            // Parameters for calling ajax junction
            var point = this.getAttribute('point');
            var hostNumb = this.getAttribute('host');
            var dbName = this.getAttribute('db');
            var tblName = this.getAttribute('table-name');   

            // tag for display host, DB, table in second NAV
            var _titleTag = 'display-result-nav-title';
            document.getElementById(_titleTag).innerHTML = 'Host: \"' + host_arr[hostNumb] + '\"' + ', DB: \"' + dbName + '\"' +  '<br><span style=\'color:blue;font-size:20px;\'>Table: \"' + tblName + '\" ';
            document.getElementById(_titleTag).setAttribute('host',host_arr[hostNumb]);
            document.getElementById(_titleTag).setAttribute('db',dbName);
            document.getElementById(_titleTag).setAttribute('table',tblName);

            // call ajax table function
            Fetch_js('display_left_aside','./include/AJAX_php_js/ajax_SelectTbl.php?hostName='+host_arr[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);                    
            //ShowTblCols_Left_Aside_js(_tag,'./include/AJAX_php_js/ajax_SelectTbl.php?hostName='+host_arr[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);                    
            //DescribeTbl_js(_tag,'./include/AJAX_php_js/ajax_DescribeTbl.php?hostName='+host_arr[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);                    
            
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
    })

    .catch(err => {
        console.error("ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "ERROR: " + err.message; 

    });

}

