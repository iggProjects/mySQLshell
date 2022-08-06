<?php

    
    /* BASIC FUNCTIONS */

    // function to write in log file
    function My_Log_Message ($mens,$log_file_path) {  
        $msg = "[" . date("j-M-Y H:i:s") . "] [" . $mens . "]";
        // $msg = "[" . date("D M j Y-m-d H:i:s") . "] [" . $mens . "]";                
        error_log($msg, 3, $log_file_path);
        error_log("\n", 3, $log_file_path);
    }   

    // function to write in JS Console
    function My_JS_Console ($mens,$var) {  
        $msg = strval( '[' . date('j-M-Y H:i:s') . '] ' . $mens . ' ' . $var );   
        echo "<script>console.log('$msg');</script>";  
    }   

    /* Funcion validarTexto 
     *
     * Valida si el contenido de campos de texto es correcto en cantidad de caracteres.
     *
     * @param  string		  $texto			 contenido del campo texto
     * @param  int 			  $longMax	   numero maximo de caracteres aceptado
     * @param  int			  $longMin		numero minimo de caracteres aceptado
     * @return int			  entero correspondiente al resultado
     *						  .- 0	si el texto es adecuado
     *						  .- 1	si el texto es muy largo
     *						  .- 2	si el texto es muy corto
    */

    function validarTexto($texto, $longMax, $longMin) {
        if ( strlen($texto) > $longMax ) {
            return 1;
        } else if ( strlen($texto) <= $longMin ) {
            return 2;
        }
        return 0;
    }

    /**
     * Funcion validarFecha 
     *
     * Valida si el formato y la fecha son correctas.
     *
     * @param string  $fecha    
     * @return int	  entero correspondiente al resultado
     *					.- 0  si la fecha es correcta
     *					.- 1  si la fecha esta mal formada
     *					.- 2  si la fecha no pertenece al calendario
    */
    function validarFecha($fecha) {
        if ( ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fecha) ) {
            return 1;
        } else {
            $fecha = explode('-', $fecha);
            if ( ! checkdate( $fecha[1], $fecha[2], $fecha[0]) ) {
                return 2;
            }
        }
        return 0;
    }

    /*
     * Funcion validarCorreo
     *
     * Valida si el formato de correo electronico es correcto
     *
     * @param string	$correo
     * @return boolean	buleano con el resultado
     *					.- true	   si el correo esta bien formado
     *					.- false   si no lo esta
    */
    function validarCorreo($correo) {
        if ( ! filter_var($correo, FILTER_VALIDATE_EMAIL) ) {
            return false;
        }
        return true;
    }

    /*
     * write 
    */
    function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');  
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    /*
     * Funcion recursive "verArreglo"
     *
     * Presenta la lista de elementos y claves de un arreglo.
     *
     * @param Array		$arreglo   Arreglo a presentar
     * @param string	$titulo	   Titulo
     * @param int		$nIndent   Nivel de Indentacion
    */
    function viewArray($arreglo, $titulo, $nIndent = 0) {
        echo "<div style='width:90%;'>";	
        // echo "<div style='width:280px; display: left; '>";	
            if ( is_array($arreglo) && isset($arreglo) ) {
                if ( empty($titulo) ) {
                    echo "" . str_repeat("\t",$nIndent) . "<ol>\n";
                } else {
                    echo "" . str_repeat("\t",$nIndent) . "<b>$titulo</b><br><br>\n";
                    echo "" . str_repeat("\t",$nIndent) . "<ol>\n";
                }
                foreach ($arreglo as $key => $value) {
                    if ( is_array($value) ) {
                        echo "" . str_repeat("\t",$nIndent + 1) . "<li>[" . $key . "] => Arreglo\n";
                        viewArray($value, "", $nIndent +1);
                    } else {
                        echo "" . str_repeat("\t",$nIndent + 1) . "<li>[" . $key . "] => " . $value . "\n";
                    }
                }
                echo "</ol>\n";
            } else {
                echo "<br><b>$titulo</b> no definido o no es arreglo.<br>\n";
            }
        echo "</div>";	
   }


    function global_Arrays(){

        echo "<div id='arreglo' style='margin-top:50px; padding-left:50px; width:80%; height:300px; overflow:scroll; font-size:14px; border:15px solid #e2e2e2;'>";
            echo "<br><h3 style='color:black; font-size:18px;'><b>Variables de entorno</b></h3><hr>";
            viewArray($_SESSION, '$_SESSION');
            echo "<br><hr><br>";
            viewArray($_POST, '$_POST');
            echo "<br><hr><br>";
            viewArray($_COOKIE, '$_COOKIE');
            echo "<br><hr><br>";
            viewArray($_SERVER, '$_SERVER');
            echo "<br><hr><br>";
            viewArray($_ENV, '$_ENV');
            echo "<br><hr><br>";
            viewArray($_GET, '$_GET');
        echo "</div>";

    }

    function viewObject($obj, $titulo, $nIndent=0) {
        echo "<div style='width:90%;  border:1px solid #cccccc;'>";	
        // echo "<div style='width:280px; display: left; '>";	
            if ( isset($obj) && ( gettype( $obj ) == 'object' || gettype( $obj ) == 'array' )  ) {
                if ( empty($titulo) ) {
                    echo "" . str_repeat("\t",$nIndent) . "<ol>\n";
                } else {
                    echo "" . str_repeat("\t",$nIndent) . "<b>$titulo</b><br><br>\n";
                    echo "" . str_repeat("\t",$nIndent) . "<ol>\n";
                }
                foreach ($obj as $key => $value) {
                    if ( gettype( $value ) == 'object' || gettype( $value ) == 'array' ) {
                        echo "" . str_repeat("\t",$nIndent + 1) . "<li>[" . $key . "] => " . gettype($value) . "\n";
                        viewObject($value, "", $nIndent +1);
                    } else {
                        echo "" . str_repeat("\t",$nIndent + 1) . "<li>[" . $key . "] => " . $value . "\n";
                    } 
                }
                echo "</ol>\n";
            } elseif ( gettype( $obj ) == 'string' || gettype( $obj ) == 'integer' || gettype( $obj ) == 'double' || gettype( $obj ) == 'boolean' || gettype( $obj ) == null )  {
                echo "" . str_repeat("\t",$nIndent + 1) . "value => " . $obj . "\n";
            } else {
                echo "upsssssss ....<b>object: '$obj', type:" . gettype($obj) . "</b> not included in type list<br>\n";
            }
        echo "</div>";	
    }





    // This function will take $_SERVER['REQUEST_URI'] and build a breadcrumb based on the user's current path
    function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {

        $server_doc_root = $_SERVER['DOCUMENT_ROOT'];
        $log_comments_path = $server_doc_root . "/lanbide2022/gaztelu/curso-backend-areafor-server/assets/log-files/log_comments.log";

        // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
        $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));   
        $path_json = json_encode($path);
        // My_Log_Message ("request uri-> $path_json",$log_comments_path);

        // This will build our "base URL" ... Also accounts for HTTPS :)

        // Probar aquí como incluir '/lanbide2022/gaztelu' como parte de la base de partida

        $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
        $breadcrumbs = Array("<a href=\"$base\">$home</a>");        

        // Find out the index for the last value in our path array
        $last = end(array_keys($path));

        // Build the rest of the breadcrumbs
        foreach ($path AS $x => $crumb) {
            // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
            $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
           // My_Log_Message ("title-> $title",$log_comments_path);

            //My_Log_Message ("basecrumb-> $base$crumb",$log_comments_path);

            if ($x != $last) {// If we are not on the last index, then display an <a> tag
                $breadcrumbs[] = "<a href=\" $base$crumb\">$title</a>"; 
                $base .= $crumb . "/";                 
            } else  // Otherwise, just display the title (minus)
                $breadcrumbs[] = $title;
        }

        My_Log_Message ("bread crumb array-> $breadcrumbs",$log_comments_path);        

        // My_Log_Message ("bread crumb array-> " . print_r($breadcrumbs) . " ",$log_comments_path);

        // Build our temporary array (pieces of bread) into one big string :)
        return implode($separator, $breadcrumbs);

    }

    function displaySelect($data_array){
    
        // CREATE SELECT OPTIONS FOR 'standard_queries'
        echo "<select class='servers_List' name='servers_List' id='serverList'>    
            <option class='queryOpt'  value='' selected>Sel Std Query</option>";
            for ( $k=0; $k < count($data_array); $k++ ) {                         
                echo "<option class='queryOpt'  title='" . $data_array[$k]['comment'] . "' host_numb=''  value='" . $data_array[$k]['query'] . "' >" . $data_array[$k]['btn_name'] . "</option>"; 
            }
        echo "</select>";   


    }

    function displayTable($_query,$table_width,$thead_titles_array,$data_array){

        // put IF here (ex: if _query contains 'SELECT')
        if ( str_contains($_query, 'SELECT') || str_contains($_query, 'select') ) {   

    /*        
            echo "<div class='pagination'>
                <button class='select-btns' page='1'>First</button>
                <button class='select-btns' page='-1'>Previous</button>
                <button class='select-btns' page='+1'>Next</button>
                <button class='select-btns' page='L'>Last</button>
            </div>";        
            echo "<p id='actualPage' page='" . $thead_titles_array . "' style='margin-top:5px;  margin-bottom:10px; text-align:center; font-size:12px; color:#990000'><span style='color:black;'>page: </span>" . $thead_titles_array . "</p>";
    */
        }    

        echo "<p style='margin-top:5px;  margin-bottom:10px; text-align:center; font-size:12px; color:#990000'>$_query</p>";

        $i=1;        
        echo "<table style='max-width: $table_width%;'>";          
        // echo "<table style='max-width: $table_width%; overflow:scroll;'>";          
        
            $tr_thead = "<tr>";
            $tr_thead .= "<th style='text-align:center; padding-right:10px; font-size:12px; color:#666666; '>#</th>";
            if ( count($data_array) > 0 ) {
                foreach ( $data_array[0] as $key => $value ) {  
                    $th = "<th style='padding:1px; font-size:13px; color:#666666; '>" . $key  . "</th>"; 
                    $tr_thead .= $th;
                }                
            }
            $tr_thead .="</tr>";            
            echo $tr_thead; 
            foreach ( $data_array as $row ) {
                echo "<tr>
                <td style='text-align:center; padding-right:10px; font-size:12px; color:green; '>$i → </td>";      
                foreach ( $row as $col ) {
                    if ( str_contains($_query, 'TABLES') ) {    
                        echo "<td table-name= " . $col . " class='left-aside-btn display-fields' style='text-align:center; font-size:13px; color:#1a1aff; padding-left:3px; padding-right:3px;'>" .$col . "</td>";
                    } else {
                        echo "<td style='text-align:center; font-size:13px; color:#1a1aff; padding-left:3px; padding-right:3px; '>" .$col . "</td>";
                    }    
                }
                echo "</tr>";
                $i++;
            }    

        echo "</table>";

    }


?>

