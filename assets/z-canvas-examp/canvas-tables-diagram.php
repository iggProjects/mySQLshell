<!-- //https://stackoverflow.com/questions/24565458/centering-text-inside-a-canvas-rectangle-button 

APPROACH: 

    Diagram based on the relationships of a single table. Left side, the tables that point to the target table. Right side, the tables pointed to by the target table.

    What we need: 

    1.- queries to prepare left and right tables arrays, and the trick to generate associative array of (x,y) values for draw each table and each line between tables.

    2.- check if overflow works for canvas tag
        - https://jsfiddle.net/diode/sHbKD/22/
        - https://codepen.io/justincavery/pen/ARZNRY 
        - https://stackoverflow.com/questions/8579923/scrollfunction-for-canvas-if-canvas-too-big

-->


<html>
<head>

<style>
    .canvas-area {
        position:relative;
        width:700px;
        height:600px;
        overflow:auto;
    }
</style>    

</head>
<body style="background: white;">

    <div class="canvas-area" style="margin:auto; margin-top:50px;  text-align: center;">    
        <canvas class="canvas-area" id="canvas" width="900px" height="700px" style="border:5px solid gray;"></canvas>
    </div>

    <script>
    </script>

    <script type="text/javascript" language="javascript">

        //  diagonal lines 
        //  https://www.cs.helsinki.fi/group/goa/mallinnus/lines/bresenh.html    

        // pair_points[i] = [{'x1':0,'y1':600},{'x2':300,'y2':300}];
        function draw_pair_points_x_y(pair_points) {
            alert(pair_points[0][0]['x1'] + ' (x1,y1) ' + pair_points[0][0]['y1']);
            alert(pair_points[0][1]['x2'] + ' (x2,y2) ' + pair_points[0][1]['y2']);
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
            alert(JSON.stringify(points_array));  
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

            /*  Testing */
            draw_table_relations_lines(left_lines_x_y_array);

        }
/*
        function draw_pair_points_x_y(x1,y1,x2,y2) {
            var ctx = document.getElementById("canvas").getContext("2d");
            ctx.beginPath();
            ctx.moveTo(x1,y1);
            ctx.lineTo(x2,y2);
            ctx.stroke();
        }
*/


        // MAIN        

        var table_ppal = ['NAME TABLE PPAL','id ','field ','field ','field ','field field field ','field ','field ','field '];

        var left_table = ['NAME LEFT TABLES ARRAY','id ','field ','field field field field ','field '];        

        var right_table = ['NAME RIGHT TABLES ARRAY','id ','field ','field ','field field '];

        var cv_w = document.getElementById("canvas").width;
        var cv_h = document.getElementById("canvas").height;
        
        // arrays for append de (x,y) coordinates of source and destiny points to make respective "relation lines"
        var left_lines_x_y_array = [];
        var right_lines_x_y_array = [];     
        
        // for testing
        left_lines_x_y_array[0] = [{'x1':0,'y1':400},{'x2':300,'y2':400}];
        left_lines_x_y_array[1] = [{'x1':0,'y1':450},{'x2':300,'y2':450}];

        right_lines_x_y_array[0] = [{'x1':600,'y1':300},{'x2':300,'y2':300}];
        right_lines_x_y_array[1] = [{'x1':600,'y1':500},{'x2':300,'y2':500}];   

        draw_db(cv_w,cv_h,table_ppal,left_table,right_table);        

        /*
         * testing circles
        */ 
        function draw_diagonal_line_of_circles(){
            var ctx = document.getElementById("canvas").getContext("2d");
            var counter = 0;
            for (var i=0;i<50;i++) {
                for (var j=0;j<50;j++) {
                    //Start from white and goes to black 42.5
                    //ctx.fillStyle = "rgb(" + Math.floor(255-22.5*i) + "," + Math.floor(255-22.5*i) + "," + Math.floor(255-22.5*j) + ")";
                    ctx.fillStyle = "black";
                    ctx.beginPath();
                    if (i === counter && j === counter) {
                        // creates the circles
                        // define slope 
                        ctx.arc(0+j*3,300-i*1,0.3,0,Math.PI*2,true);
                        ctx.fill();
                        //creates a border around the circles so white one will be vissible
                        ctx.stroke();
                    } 
                }
                counter++;
            }
        }

        draw_diagonal_line_of_circles();

        /* testing lines
         
        var ctx = document.getElementById("canvas").getContext("2d");
        ctx.beginPath();
        ctx.moveTo(0, 600);
        ctx.lineTo(300, 300);
        //ctx.moveTo(300, 300);
        ctx.lineTo(600, 600);

        ctx.stroke();
        */

</script>

        

    </script>


</body>
</html>