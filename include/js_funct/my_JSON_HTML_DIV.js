/*
    VIEW JSON in HTML ELEMENT. Now for only 3 levels
    --> pending to do recursive function
*/

function write_Json_as_Text(my_json_file,html_id) {

    var text="<b>JSON elements</b><br><br>";
    var i=1;    
    var indice = '00';

    function index(m){
        var n="";
        if ( m < 10 ) { n = '0' + m; } else { n = i;}
        return n;
    }

    for (key in my_json_file) {    
        
        indice=index(i);
        if( typeof my_json_file[key] == 'object' ) {

            for (key1 in my_json_file[key]) {

                indice=index(i);                 
                if ( typeof my_json_file[key][key1] == 'object' ) {
                    for (key2 in my_json_file[key][key1] ) {                         
                        indice=index(i);                   
                        // 3 level in key2                    
                        text += indice + ' → my_json_file[' + key + '][' + key1 + '][' + key2 + '] → ' + my_json_file[key][key1][key2] + '<br>';
                        i++;     
                    }
                  } else {                    
                    text += indice + ' → my_json_file[' + key + '][' + key1 + '] → ' + my_json_file[key][key1] + '<br>'; 
                    i++;
                }
            
            }
            text += '<br>';       
          
        } else {
            indice=index(i);              
            text += indice + ' → my_json_file[' + key + '] → ' + my_json_file[key] + '<br>'; 
            i++;
            text += '<br>';
        }   
    }

    return document.getElementById(html_id).innerHTML = text;

}

