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

            // get host_numb
            let host_n = document.getElementById('display-result-nav-title').getAttribute('host_numb');
            // get host name
            var hostName = document.getElementById('display-result-nav-title').getAttribute('host');
            // get DB name
            var dbName = this.parentElement.getAttribute('db');

            // clear html of 'der-console associated tag's'
            clearDerConsoleAreas();            
        
            // tag for display host and DB
           
            document.getElementById('display-result-nav-title').innerHTML = 'Host: \"' + hostName + '\"' + ', DB: \"' + dbName + '\"';

            // document.getElementById('display-result-nav-title').setAttribute('host',hostName);
            document.getElementById('display-result-nav-title').setAttribute('db',dbName);                        


        /*  
         *   NOTE: This 2 statements open tree in DB in the left aside   
        */    
            //this.parentElement.querySelector(".nested").classList.toggle("active");
            //this.classList.toggle("caret-down");
            
            document.getElementById('p-comment').innerHTML='TABLES';        
            // tag for show tables of DB selected
            var table_param = document.getElementById('display-result-nav-title');
            var _tag= 'display_right_aside';   

            Fetch_js(_tag,'./include/AJAX_php_js/ajax_ListTables.php?host_numb=' + host_n + '&hostName='+table_param.getAttribute('host')+'&dbName='+table_param.getAttribute('db'));
            
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

            var hostNumb = this.getAttribute('host_numb');
            //var hostNumb = this.getAttribute('host');

            var dbName = this.getAttribute('db');
            var tblName = this.getAttribute('table-name');   

            // tag for display host, DB, table in second NAV
            var _titleTag = 'display-result-nav-title';
            document.getElementById(_titleTag).innerHTML = 'Host: \"' + host_arr[hostNumb] + '\"' + ', DB: \"' + dbName + '\"' +  '<br><span style=\'color:blue;font-size:20px;\'>Table: \"' + tblName + '\" ';
            document.getElementById(_titleTag).setAttribute('host_numb',hostNumb);
            document.getElementById(_titleTag).setAttribute('host',host_arr[hostNumb]);
            document.getElementById(_titleTag).setAttribute('db',dbName);
            document.getElementById(_titleTag).setAttribute('table',tblName);

            // call ajax table function
            Fetch_js('display_right_aside','./include/AJAX_php_js/ajax_SelectTbl.php?host_numb=' + table_param.getAttribute('host_numb') + '&hostName='+host_arr[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);                    
            //ShowTblCols_right_aside_js(_tag,'./include/AJAX_php_js/ajax_SelectTbl.php?hostName='+host_arr[hostNumb]+'&dbName='+dbName+'&tblName='+tblName);                    
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
            querySelected.addEventListener("click", () => {
                querySelected.addEventListener("change", () => {                                 
                    if (querySelected.value != '' ) {                        
                        const relations_query = querySelected.value;
                        document.getElementById('sql-query-area').value = relations_query;
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

function Fetch_data_array(query_str,php_sql_url) {

    console.log('php_sql_url====> ' + php_sql_url) 
    
    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()

        else
            throw new Error(response.status)
    })
    
    .then(data => {
        // alert('data ' + data);

        // using window.open
        //let query_string = query_str;
        //window.open('http://localhost/curso-backend-areafor-server/myLQSadmin/assets/z-canvas-examp/canvas-tables-diagram.php'+query_string, '_blank');

        // using canvas tag
        document.getElementById('div-DB-info').style.display='none';
        document.getElementById('canvas-diagram').style.display='block';

        var table_ppal = ['NAME TABLE PPAL','id ','field ','field ','field ','field field field ','field ','field ','field '];

        var left_table = ['NAME LEFT TABLES ARRAY','id ','field ','field field field field ','field '];        

        var right_table = ['NAME RIGHT TABLES ARRAY','id ','field ','field ','field field '];

        var cv_w = document.getElementById("canvas").width;
        var cv_h = document.getElementById("canvas").height;
        
        // arrays for append de (x,y) coordinates of source and destiny points to make respective "relation lines"
        var left_lines_x_y_array = [];
        var right_lines_x_y_array = [];     
        
        // for testing
        //left_lines_x_y_array[0] = [{'x1':0,'y1':400},{'x2':300,'y2':400}];
        //left_lines_x_y_array[1] = [{'x1':0,'y1':450},{'x2':300,'y2':450}];

        //right_lines_x_y_array[0] = [{'x1':600,'y1':300},{'x2':300,'y2':300}];
        //right_lines_x_y_array[1] = [{'x1':600,'y1':500},{'x2':300,'y2':500}];   

        draw_db(cv_w,cv_h,table_ppal,left_table,right_table);  
        
        /*  Testing */
        //draw_table_relations_lines(left_lines_x_y_array);


    })    

    .catch(err => {
        console.error("ERROR: ", err.message);
        alert("ERROR Fetch_data_array: " + err.message); 

    });
   
}

function draw_pair_points_x_y(pair_points) {
    //alert(pair_points[0][0]['x1'] + ' (x1,y1) ' + pair_points[0][0]['y1']);
    //alert(pair_points[0][1]['x2'] + ' (x2,y2) ' + pair_points[0][1]['y2']);
    var ctx = document.getElementById("canvas").getContext("2d");
    ctx.beginPath();

    /* testing */
    ctx.moveTo(pair_points[0][0]['x1'],pair_points[0][0]['y1']);
    ctx.lineTo(pair_points[0][1]['x2'],pair_points[0][1]['y2']);  
    ctx.moveTo(pair_points[1][0]['x1'],pair_points[1][0]['y1']);          
    ctx.lineTo(pair_points[1][1]['x2'],pair_points[1][1]['y2']);            
    ctx.stroke();
}

/*  USED FOR "LEFT" AND "RIGHT" POINTS ARRAYS  */
function draw_table_relations_lines(points_array) {
    //alert(JSON.stringify(points_array));  
    draw_pair_points_x_y(points_array);   
    /* HERE: loop through array elements  */  

}      

function draw_table_row(_ctxx,_text,_xx,_yy,_w,_hh) {
    _ctxx.strokeRect(_xx, _yy, _w, _hh);
    _ctxx.fillText(_text,_xx+(_w/2),_yy+(_hh/2));
}

function draw_table(_ctx,_table,_x,_y,_w,_h){
    
    _x = _x - _w/2;
    for ( var i=0; i < _table.length; i++) {  
        draw_table_row(_ctx,_table[i],_x,_y,_w,_h);
        _y += _h;
    }

}

function draw_db(w,h,ppal_table_array,left_tables_array,right_tables_array){

    var tot_lines_height = Math.max(ppal_table_array.length,left_tables_array.length,right_tables_array.length);                       
    
    // canvas parameters
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    var fontsize = 20;
    var fontface = 'arial';
    var row_h = fontsize * 1.1;
    ctx.lineWidth = 1.5;
    ctx.strokeStyle = "black"; // border color
    ctx.fillStyle = "blue";   // chars color            
    ctx.textAlign="center"; 
    ctx.textBaseline = "middle";                

    // parameters to draw ppal_table_array
    var x = w/2;
    var y = 10; 
    
    // max length text of elements in table
    var max_large_text = '';
    for ( var i=0; i < ppal_table_array.length; i++ ){  
        if ( max_large_text < ppal_table_array[i].length ) { max_large_text = ppal_table_array[i]; } 
    }
    var text_w = ctx.measureText(max_large_text).width * 1.1;              
    
    draw_table(ctx,ppal_table_array,x,y,text_w,row_h);

    // parameters to draw left_table_array
    x = 10;
    max_large_text = '';
    text_w = 0;
    for ( var i=0; i < left_tables_array.length; i++ ){  
        if ( max_large_text < left_tables_array[i].length ) { max_large_text = left_tables_array[i]; } 
    }
    text_w = ctx.measureText(max_large_text).width * 1.1;  
    x = 10 + text_w/2;             
    y =  10;            
    draw_table(ctx,left_tables_array,x,y,text_w,row_h);

    // parameters to draw right_table_array
    x = w-10;
    max_large_text = '';
    text_w = 0;
    for ( var i=0; i < right_tables_array.length; i++ ){  
        if ( max_large_text < right_tables_array[i].length ) { max_large_text = right_tables_array[i]; } 
    }
    text_w = ctx.measureText(max_large_text).width * 1.1;  
    x = x - text_w/2;             
    y = 10;
    draw_table(ctx,right_tables_array,x,y,text_w,row_h);

}
