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

        // MAIN CALL 
        draw_db(cv_w,cv_h,table_ppal,left_table,right_table);

}

function draw_pair_points_array(pair_points) {
    var ctx = document.getElementById("canvas").getContext("2d");
    ctx.beginPath();
    /* testing */
    ctx.moveTo(pair_points[0][0]['x1'],pair_points[0][0]['y1']);
    ctx.lineTo(pair_points[0][1]['x2'],pair_points[0][1]['y2']);  
    ctx.moveTo(pair_points[1][0]['x1'],pair_points[1][0]['y1']);          
    ctx.lineTo(pair_points[1][1]['x2'],pair_points[1][1]['y2']);            
    ctx.stroke();
}

function draw_pair_points_x_y(_ctx,x1,y1,x2,y2) {
    _ctx.beginPath();
    /* testing */
    _ctx.moveTo(x1,y1);
    _ctx.lineTo(x2,y2);  
    _ctx.stroke();
}



/*  USED FOR "LEFT" AND "RIGHT" POINTS ARRAYS  */
function draw_table_relations_lines(points_array) {

    //alert(JSON.stringify(points_array));  
    draw_pair_points_x_y(points_array);   
    /* HERE: loop through array elements  */  

}      

function draw_table_row_title(_ctxx,_text,_xx,_yy,_ww,_hh) {
    // console.log('draw_table_row, text---> ' + _text);
    _ctxx.fillStyle = "#99ffcc";
    _ctxx.fillRect(_xx, _yy, _ww, _hh);  
    _ctxx.strokeRect(_xx, _yy, _ww, _hh);  
    _ctxx.fillStyle = "blue";
    _ctxx.fillText(_text,_xx+(_ww/2),_yy+(_hh/2));
}

function draw_table_row(_ctxx,_text,_xx,_yy,_ww,_hh) {
    // console.log('draw_table_row, text---> ' + _text);
    _ctxx.strokeRect(_xx, _yy, _ww, _hh);
    _ctxx.fillStyle = "black";
    _ctxx.fillText(_text,_xx+(_ww/2),_yy+(_hh/2));
}

function draw_ppal_table(_ctx,_table,_x,_y,_w,_h,cent_points_array){  
    console_Log('draw_table--> ','gray','white',2);      
    console.log(_table[0]);
    _x = _x - _w/2;    
    draw_table_row_title(_ctx,_table[0]['TBL'],_x,_y,_w,_h);
    _y += _h;
    let txt = '';
    for ( var i=0; i < _table.length; i++) {  
        txt = _table[i]['COL'];     
        draw_table_row(_ctx,txt,_x,_y,_w,_h);
        // fill ppal table points array   
        cent_points_array.push({'tbl': _table[0]['TBL'],'col': _table[i]['COL'],'x1_Left':_x,'y1_Left':(_y+_h/2),'x2_Right':_x+_w/2 ,'y2_right':(_y-_h/2)});
        _y += _h;
    }
    txt = '';
}


function draw_left_table(_ctx,_table,_x,_y,_w,_h,lf_points_array){  
    console_Log('draw_table--> ','gray','white',2);      
    console.log(_table[0]);
    _x = _x - _w/2;    
    draw_table_row_title(_ctx,_table[0]['TBL'],_x,_y,_w,_h);
    _y += _h;
    let txt = '';
    for ( var i=0; i < _table.length; i++) {  
        txt = _table[i]['COL'];    
        draw_table_row(_ctx,txt,_x,_y,_w,_h);
        //fill left points array
        lf_points_array.push({'tbl_From': _table[0]['TBL'],'col_From': _table[i]['COL'],'x1_From':_x+_w,'y1_From':(_y+_h/2),'col_To': _table[i]['REF_COL'],'tbl_To':_table[i]['REF_TBL']});
        _y += _h;
    }
    txt = '';
}

function draw_right_table(_ctx,_table,_x,_y,_w,_h,rg_points_array){    
    console_Log('draw_right_table--> ','blue','white',2);          
    console.log(_table[0]);
    _x = _x - _w/2;    
    let txt = '';
    draw_table_row_title(_ctx,_table[0]['REF_TBL'],_x,_y,_w,_h);
    _y += _h;
    for ( var i=0; i < _table.length; i++) {  
        txt = _table[i]['REF_COL'];
        draw_table_row(_ctx,txt,_x,_y,_w,_h);
        //fill right points array
        rg_points_array.push({'tbl_From': _table[0]['TBL'],'col_From': _table[i]['COL'],'x1_From':_x,'y1_From':(_y-_h/2),'col_To': _table[i]['REF_COL'],'tbl_To':_table[i]['REF_TBL']});
        _y += _h;
    }
    txt = '';
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

    //
    //  Arrays for pair of points to draw lines between tables (field to field)
    //      Pairs of (x,y) points, taking into account the relations 
    //      with the chosen table (left and right sides)    
    //

    var left_points_x_y_array = [];         
    // testing
    // left_points_x_y_array.push({'table': 'table1','field': 'field1','x1':0,'y1':400});

    var center_points_x_y_array = [];
    var right_points_x_y_array = []; 

    // array used to store data of different tables in left and right tables
    var temp_array = [];
    var temp_tbl_name = '';
    
    // parameters x,y to draw ppal_table_array in '2d'
    var x = w/2;
    var y = 50; 
    
    // max length text of elements in table
    var max_large_text = 250;
    text_w = max_large_text;
    
    // drawing main table in center position
    console_Log('---------------init ppal_table---------------','green','white',2);
    draw_ppal_table(ctx,ppal_table_array,x,y,text_w,row_h,center_points_x_y_array);

    console_Log('--------------end of ppal table-----------------','red','white',2);

    // Drawing left side of ppal table
    if ( left_tables_array.length > 0 ) {

        console_Log('----------------init left_tables----------------','green','white',2);

        console.log('left_tables_array');
        console.log(left_tables_array);

        text_w = max_large_text;
        // adjust x,y coordinates
        x = 20 + text_w/2;             
        y = 50;  

        //
        // Loop for differentiate distinct tables inside 'left_tables_array'
        //

        // clear array -> empty
        temp_array.length=0;
        
        // first table name in left_tables_array 
        temp_tbl_name = left_tables_array[0]['TBL'];
        
        for ( var i=0; i<left_tables_array.length; i++ ) {
            
            if ( temp_tbl_name == left_tables_array[i]['TBL'] ) { 
                temp_array.push(left_tables_array[i]);            
            }  
            else {             
                draw_left_table(ctx,temp_array,x,y,text_w,row_h,left_points_x_y_array);
                y += 100;            
                temp_array.length = 0;
                temp_array.push(left_tables_array[i]); 
                temp_tbl_name = left_tables_array[i]['TBL'];  
            }    

        }
        
        // falta un if de condición de borde en i
        draw_left_table(ctx,temp_array,x,y,text_w,row_h,left_points_x_y_array);
//        console.log('valor i: ' + i);
//        console.log('table_name i-2: ' + left_tables_array[i-2]['REF_TBL'] +  ' --- table_name i-1: ' +  left_tables_array[i-1]['REF_TBL']);

    }

    // Drawing right side (relations) of ppal table

    console_Log('-----------------end of left tables-------------------','red','white',2);

    if ( right_tables_array.length > 0 ) {
        // parameters to draw right_table_array

        console_Log('------------------ init right_tables-------------------','green','white',2);
        console.log('right_tables_array');
        console.log(right_tables_array);


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
                
                draw_right_table(ctx,temp_array,x,y,text_w,row_h,right_points_x_y_array);
                y += 100;                        
                temp_array.length = 0;
                temp_array.push(right_tables_array[i]); 
                temp_tbl_name = right_tables_array[i]['REF_TBL'];

            }    

        }

        // Chequear si falta un if de condición de borde en i
        draw_right_table(ctx,temp_array,x,y,text_w,row_h,right_points_x_y_array);
//        console.log('valor i: ' + i);
//        console.log('table_name i-2: ' + right_tables_array[i-2]['REF_TBL'] +  ' --- table_name i-1: ' +  right_tables_array[i-1]['REF_TBL']);

        console_Log('-----------------end of right tables-------------------','red','white',2);
    }

    console_Log('-----------------Left Points Array-------------------','blue','white',2);
    console.log(left_points_x_y_array);
    console_Log('-----------------Center Points Array-------------------','blue','white',2);
    console.log(center_points_x_y_array);
    console_Log('-----------------Right Points Array-------------------','blue','white',2);
    console.log(right_points_x_y_array);

    // draw table relations lines

    // Left Side
    var x_1=0;
    var y_1=0;
    var x_2=0;
    var y_2=0;
    var i=0;
    var j=0;

    for (i=0; i<left_points_x_y_array.length; i++ ) {
        console.log('Table From: ' + left_points_x_y_array[i]['tbl_From'] + ' | x1: ' + left_points_x_y_array[i]['x1_From'] + ', y1: ' + left_points_x_y_array[i]['y1_From']);
        x_1= left_points_x_y_array[i]['x1_From'];
        y_1= left_points_x_y_array[i]['y1_From'];

        // looking for point x_2,y_2 in central table
        for (j=0; j<center_points_x_y_array.length; j++) {
            if( center_points_x_y_array[j]['col'] == left_points_x_y_array[i]['col_To'] ) {
                x_2= center_points_x_y_array[j]['x1_Left'];
                y_2= center_points_x_y_array[j]['y1_Left'];;
            }
        }        

        console.log('pair points---> x1:' + x_1+ ', y1: ' + y_1 + ',x2: ' + x_2 + ',y2: '+ y_2 )
        draw_pair_points_x_y(ctx,x_1,y_1,x_2,y_2);
    }  

}


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

    var left_points_x_y_array = []; 
    // testing
    left_points_x_y_array.push({'table': 'table1','field': 'field1','x1':0,'y1':400});
    console.log('********************************');
    console.log('TESTING points left array ');
    console.log('table: ' + left_points_x_y_array[0]['table'] + ', field: ' + left_points_x_y_array[0]['field']);
    console.log('x1: ' + left_points_x_y_array[0]['x1']);
    console.log('y1: ' + left_points_x_y_array[0]['y1']);
    console.log('********************************');   



*/
