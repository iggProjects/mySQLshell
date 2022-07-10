/*
   Functions to read and write JSON's
*/

// Only for JSON of 3 levels
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


// recursive function

/* Object.keys(json_ex).length

function write_object(json_object,key_act,flag){
        
        // key_act_value = my_json_file[key_act];
        // console_Log(key_prev,'red','white',3);
        
        
        // try with while previos = next
        while ( flag ) {

            if ( typeof json_object[key_act] == 'object' && key_prev == key_act ) {
                    key_prev = key_act;
                    write_object(key_prev,json_object[key_act]);
            } else {
                    console_Log('my_json_file[key_act] :  [' + Object.keys(json_object[key_act]) + ':' + Object.values(json_object[key_act]) + ']','black','yellow',1);                    
                    // console_Log(i + ' object: ' + key_prev + ', key: '+ key_act + ', value: '+  key_act_value,'','green',2);
            }
        
        }   

}

*/

// recursive function
function json_recursive(json_key,json_file) {    
    console_Log('79- json_recursive | key: ' + json_key + ', length: ' + Object.keys(json_file[json_key]).length,'gray','white',0);
    console_Log('80- json_recursive | value: ' + Object.values(json_file[json_key]),'','red',0);
}


function write_json(_key,my_json_file) {
    var i=1;    

    console_Log('WRITE_JSON_82  JSON.length:  ' + Object.keys(my_json_file).length,'blue','white',1);
    console_Log('83- keys: [' + Object.keys(my_json_file) + ']','','red',1);
    console_Log('84- values: [' + Object.values(my_json_file) + ']','','red',1);

    for (key_act in my_json_file) {         
        console_Log('94- key_act: "' + key_act + '" length: ' + Object.keys(my_json_file[key_act]).length,'green','white',1);
        console_Log('95- keys:  [' + Object.keys(my_json_file[key_act]) + ']','','green',1);
        console_Log('96- values:  [' + Object.values(my_json_file[key_act]) + ']','','green',1);
    }

    /*
    for (key_act in my_json_file) {          
        console_Log('100- key_act: "' + key_act + '" length: ' + Object.keys(my_json_file[key_act]).length,'green','white',1);
        console_Log('101- key: ' + key_act,'','orange',1);
        console_Log('102- value: ' + my_json_file[key_act],'','orange',1);        
    }
    */
    console_Log('__________________ looping through the json __________________','','',2);

    for (key_act in my_json_file) {          

        if ( typeof my_json_file[key_act] === 'object' ) {        
            json_recursive(key_act,my_json_file);
          } else {
            console_Log('100- key_act: "' + key_act + '" length: ' + Object.keys(my_json_file[key_act]).length + ', value: ' + my_json_file[key_act],'','black',0);
        }   
        
    }


}











    /*
    https://www.delftstack.com/es/howto/javascript/json-stringify-pretty/
    function prettyString(json) {
        if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
            var str1 = 'number';
            if (/^"/.test(match)) {
                if (/:$/.test(match)) {
                    str1 = 'key';
                } else {
                    str1 = 'string';
                }
            } else if (/true|false/.test(match)) {
                str1 = 'boolean';
            } else if (/null/.test(match)) {
                str1 = 'null';
            }
            return '<span class="' + str1 + '">' + match + '</span>';
        });
   }
   */


/*  como array

    for ( i=0; i< json_ex.length; i++ ){
        if( typeof json_ex[i] == 'object' ) {
            for (key in json_ex[i]) { 
                if ( typeof json_ex[i][key] == 'object' ) {
                    for (key1 in json_ex[i][key] ) {                        
                        text += i + ' → json_ex[' + i + '][' + key + '][' + key1 + '] → ' + json_ex[i][key][key1] + '<br>';     
                    }
                } else {                
                    text += i + ' → json_ex[' + i + '][' + key + '] → ' + json_ex[i][key] + '<br>'; 
                }
            }
            text += '<br>';       
        }     
    }
*/

