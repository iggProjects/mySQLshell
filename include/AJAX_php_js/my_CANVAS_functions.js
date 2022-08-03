/*
 *  JS functions for CANVAS and other requirements
*/

function Fetch_canvas_data_array(php_sql_url) {
//function Fetch_data_array(query_str,php_sql_url) {

    console.log('php_sql_url====> ' + php_sql_url); 

    fetch(php_sql_url)

    .then(response => {
        if (response.ok)        
            return response.text()  
        else
            throw new Error(response.status)
    })
    
    .then(data => {

        let data_array = JSON.parse(data);
/*
        console_Log ('data array: ','black','white',2);
        console.log(data_array);
        console_Log ('data array["table"]: ','black','white',2);
        console.log(data_array['table']);
        console_Log ('data array["left"]: ','black','white',2);
        console.log(data_array['left']);
        console_Log ('data array["right"]: ','black','white',2);
        console.log(data_array['right']);
*/
        draw_table_canvas(data_array,data_array['table'],data_array['left'],data_array['right']);

    })    

    .catch(err => {
        console.error("ERROR: ", err.message);
        alert("ERROR Fetch_canvas_data_array: " + err.message); 

    });
   
}

function draw_table_canvas(tables_data_array,table_ppal,left_table,right_table) {

        // using window.open and do the work in another url
        // let query_string = query_str;
        // window.open('http://localhost/curso-backend-areafor-server/myLQSadmin/assets/z-canvas-examp/canvas-tables-diagram.php'+query_string, '_blank');

        console.log('array tables rel ↓↓');
        console_Log('array tables rel ↓↓','blue','white',2);
        console.log(tables_data_array);   

        // using canvas tag
        document.getElementById('div-DB-info').style.display='none';
        document.getElementById('canvas-diagram').style.display='block';

        var cv_w = document.getElementById("canvas").width;
        var cv_h = document.getElementById("canvas").height;

        console_Log('canvas width and height','','blue',1)
        console.log(cv_w + ' | ' + cv_h);
        draw_db(cv_w,cv_h,table_ppal,left_table,right_table);

}

function draw_pair_points_x_y(pair_points) {
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

function draw_table_row_title(_ctxx,_text,_xx,_yy,_ww,_hh) {
    console.log('draw_table_row, text---> ' + _text);
    _ctxx.fillStyle = "#99ffcc";
    _ctxx.fillRect(_xx, _yy, _ww, _hh);  
    _ctxx.strokeRect(_xx, _yy, _ww, _hh);  
    _ctxx.fillStyle = "blue";
    _ctxx.fillText(_text,_xx+(_ww/2),_yy+(_hh/2));
}

function draw_table_row(_ctxx,_text,_xx,_yy,_ww,_hh) {
    console.log('draw_table_row, text---> ' + _text);
    _ctxx.strokeRect(_xx, _yy, _ww, _hh);
    _ctxx.fillStyle = "black";
    _ctxx.fillText(_text,_xx+(_ww/2),_yy+(_hh/2));
}

function draw_table(_ctx,_table,_x,_y,_w,_h){    
    console_Log('draw_table data ↓↓','gray','white',2);
    console.log(_table);
    _x = _x - _w/2;    
    draw_table_row_title(_ctx,_table[0]['TBL'],_x,_y,_w,_h);
    _y += _h;
    for ( var i=0; i < _table.length; i++) {  
        let txt = _table[i]['COL'];        
        // let txt = _table[i]['TBL'] + ' - ' +_table[i]['COL'];        
        draw_table_row(_ctx,txt,_x,_y,_w,_h);
        // draw_table_row(_ctx,_table[i]['COL'],_x,_y,_w,_h);
        _y += _h;
    }
}

function draw_right_table(_ctx,_table,_x,_y,_w,_h){    
    console_Log('draw_right_table data ↓↓','green','white',2);
    console.log(_table);
    _x = _x - _w/2;    
    draw_table_row_title(_ctx,_table[0]['REF_TBL'],_x,_y,_w,_h);
    _y += _h;
    for ( var i=0; i < _table.length; i++) {  
        let txt = _table[i]['REF_COL'];        
        // let txt = _table[i]['TBL'] + ' - ' +_table[i]['COL'];        
        draw_table_row(_ctx,txt,_x,_y,_w,_h);
        // draw_table_row(_ctx,_table[i]['COL'],_x,_y,_w,_h);
        _y += _h;
    }
}

function draw_db(w,h,ppal_table_array,left_tables_array,right_tables_array){  
    
    // canvas parameters
    var canvas = document.getElementById("canvas");    
    var ctx = canvas.getContext("2d");
    // clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    // font and line properties
    var fontsize = 20;
    var fontface = 'arial';
    var row_h = fontsize * 1.2;
    ctx.lineWidth = 1.5;
    ctx.strokeStyle = "black"; // border color
    ctx.fillStyle = "blue";   // chars color            
    ctx.textAlign="center"; 
    ctx.textBaseline = "middle";    
    ctx.font = '20px arial';    
    var table_param = document.getElementById('display-result-nav-title');
    var canvas_title = 'Table Relations with "' + table_param.getAttribute('table') + '"'; 
    ctx.fillText(canvas_title,(w/2-10),25);
    ctx.font = '13px arial';

    // array used to store data of different tables in left and right tables
    var temp_array = [];
    
    // parameters x,y to draw ppal_table_array in '2d'
    var x = w/2;
    var y = 50; 
    
    // max length text of elements in table
    var max_large_text = 250;
    text_w = max_large_text;

    // 
    // TEMPORAL TABLE TO DRAW LINES BETWEEN TABLES
    //      Pairs of (x,y) points, taking into account the relations 
    //      with the chosen table (left and right sides)    
    //

/*    
    var left_lines_x_y_array = []; 
    left_lines_x_y_array['left'] = [];
    left_lines_x_y_array['table'] = [];

    // testing
    left_lines_x_y_array['left'].push({'table': 'table1','field': 'field1','x1':0,'y1':400,'x2':50,'y2':200});   
    console.log('********************************');
    console.log('TESTING points left array ');
    console.log('table: ' + left_lines_x_y_array['left'][0]['table'] + ', field: ' + left_lines_x_y_array['left'][0]['field']);
    console.log('x1: ' + left_lines_x_y_array['left'][0]['x1']);
    console.log('y1: ' + left_lines_x_y_array['left'][0]['y1']);
    console.log('x2: ' + left_lines_x_y_array['left'][0]['x2']);
    console.log('y2: ' + left_lines_x_y_array['left'][0]['y2']);
    console.log('********************************');
*/
    var left_points_x_y_array = []; 
    // testing
    left_points_x_y_array.push({'table': 'table1','field': 'field1','x1':0,'y1':400});
    console.log('********************************');
    console.log('TESTING points left array ');
    console.log('table: ' + left_points_x_y_array[0]['table'] + ', field: ' + left_points_x_y_array[0]['field']);
    console.log('x1: ' + left_points_x_y_array[0]['x1']);
    console.log('y1: ' + left_points_x_y_array[0]['y1']);
    console.log('********************************');   

    var center_points_x_y_array = [];

    var right_points_x_y_array = []; 
    
    // drawing main table in center position
    draw_table(ctx,ppal_table_array,x,y,text_w,row_h);

    // Drawing left side of ppal table
    if ( left_tables_array.length > 0 ) {

        // fix x coordinate
        x = 20;        

        text_w = max_large_text;
        // console.log('draw_db, left text_w: ' + text_w);              
        x = 20 + text_w/2;             
        y = 50;  

        //
        // Loop for differentiate distinct tables inside 'left_tables_array'
        //

        // clear array -> empty
        temp_array.length=0;
        
        // first table name in left_tables_array 
        var temp_tbl_name = left_tables_array[0]['TBL'];
        
        for ( var i=0; i<left_tables_array.length; i++ ) {
            
            if ( temp_tbl_name == left_tables_array[i]['TBL'] ) { 
                temp_array.push(left_tables_array[i]);            
            }  
            else {             
                draw_table(ctx,temp_array,x,y,text_w,row_h);
                y += 100;            
                temp_array.length = 0;
                temp_array.push(left_tables_array[i]); 
                temp_tbl_name = left_tables_array[i]['TBL'];  
            }    

        }
        draw_table(ctx,temp_array,x,y,text_w,row_h);
    }

    // Drawing right side (relations) of ppal table

    if ( right_tables_array.length > 0 ) {
        // parameters to draw right_table_array
        x = w-20;
        max_large_text = 250;     

        text_w = max_large_text;
        // console.log('draw_db, right text_w: ' + text_w);              
        x = x - text_w/2;             
        y = 50;

        //
        // Loop for differentiate distinct tables inside 'right_tables_array'
        //
        temp_array.length=0;        
        temp_tbl_name = right_tables_array[0]['REF_TBL'];
        
        for ( var i=0; i<right_tables_array.length; i++ ) {
        
            if ( temp_tbl_name == right_tables_array[i]['REF_TBL'] ) { 
                temp_array.push(right_tables_array[i]);            
            }  
            else { 
                
                draw_right_table(ctx,temp_array,x,y,text_w,row_h);
                y += 100;                        
                temp_array.length = 0;
                temp_array.push(right_tables_array[i]); 
                temp_tbl_name = right_tables_array[i]['REF_TBL'];

            }    

        }

        draw_right_table(ctx,temp_array,x,y,text_w,row_h);

        temp_array.length=0;

        // var tables_pair_points

        //
        //  Capture pair points to draw lines between tables (field to field)
        //


        // draw_table_relations_lines(tables_pair_points);

    }

}
