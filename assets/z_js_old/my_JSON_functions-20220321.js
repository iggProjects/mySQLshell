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
        // console_Log(key_prev,'red','blue',3);
        
        
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

// Object.entries
    /* example
    const obj = { 10: 'adam', 200: 'billy', 35: 'chris' };
    console_Log('obj: ','','red',1);
    console.log(Object.entries(obj));
    console.log(Object.entries(obj)[1]);
    */

/* 
// recursive function
function json_recursive(json_key,json_file) {    
    console_Log('__________ recursive funct for key "' + json_key + '" __________','gray','yellow',2);

    console_Log( json_key + '.length: ' + Object.keys(json_file[json_key]).length + ' | ' +json_key+'.values: ','','blue',0);    
    console.log(Object.values(json_file[json_key]));

    console_Log('ENTRIES of json_file:','','green',1);
    console.log(Object.entries(json_file));
    console.log(Object.entries(json_file[json_key]));
}
*/

function write_json(_key,my_json_file) {
    var i=0;    

    console_Log('__________________ json __________________','','',2);
    console_Log('WRITE_JSON  JSON.length:  ' + Object.keys(my_json_file).length,'#b3b3b3','blue',1);
    console_Log('Keys:','','blue',1);
    console.log(Object.keys(my_json_file));
    console_Log('Values:','','blue',1);
    console.log(Object.values(my_json_file));
    console_Log('Entries:','','green',1);
    console.log(Object.entries(my_json_file));
/*
    console_Log('__________________ looping through the json I __________________','#b3b3b3','blue',2);
    for (key_act in my_json_file) {                 
        console_Log('key_act: "' + key_act + '" length: ' + Object.keys(my_json_file[key_act]).length,'#b3b3b3','blue',1);
        console_Log('keys:','','green',1);
        console.log(Object.keys(my_json_file[key_act]));
        console_Log('values:','','green',1);
        console.log(Object.values(my_json_file[key_act]));        
    }

    console_Log('__________________ looping through the json II __________________','#b3b3b3','blue',2);
    for (key_act in my_json_file) {          

        if ( typeof my_json_file[key_act] === 'object' ) {        
            json_recursive(key_act,my_json_file);
          } else {
            console_Log('"' + key_act + '", length: ' + Object.keys(my_json_file[key_act]).length,'','green',2);  
            console.log('value: ' + my_json_file[key_act]);            
            console.log('');
        }           
    }
*/
    console_Log('__________________ looping through the json III __________________','#b3b3b3','blue',2);
    let level=1;
    var separator='';
    // apuntador que acumula ruta de keys !
    var acum_keys='';
    var text='';    
    
    function sep(n,text){
        separator='';
        for (var i=0; i< parseInt(n)-1; i++) { 
            separator+='\t';
        }
        // separator+=text;
        return separator;                        
    }
        
    // key_ant key_act
    
    function write_json_level(lev,_key,_val){

        //console_Log(`level ${lev} | acum_keys ${acum_keys}`,'green','white',1);  
        console_Log(`lev ${lev} _key: ${_key} | typeof ${typeof _val} | isArray ${Array.isArray(_val)} `,'','blue',1);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }
        // console_Log(`acum_keys ${acum_keys} _key: ${_key} | _val: ${Object.entries(_val)} | typeof ${typeof _val} | isArray ${Array.isArray(_val)} `,'','blue',1);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }                        
        acum_keys = `${acum_keys}[${_key}]`;
        console.log('acum_keys-> ' + acum_keys);

        for(const [k,v] of Object.entries(_val) ) {   

            console_Log('key: ' + k + ' | typeof "value" '+ typeof v + ' |  isArray ' + Array.isArray(v),'','green',1);        
            // console_Log('key: ' + k + ' | value: ' + v +' | typeof "value" '+ typeof v + ' |  isArray ' + Array.isArray(v),'','green',1);        
            
            if ( typeof v === 'object' ) {

                // acum_keys = acum_keys + '[' + _key + ']';
                // acum_keys = '['+acum_keys+']' + '[' + k + ']';

                // console.log('acum_keys-> ' + acum_keys);

                // separator=sep(lev,acum_keys);                     
                
                if ( Array.isArray(v) ) {
                    // acum_keys = acum_keys + '['+_key+']';
                    // separator=sep(lev,acum_keys);
                    for ( var i=0; i<v.length; i++ ) {                         
                        
                        console.log(`[${_key}][${k}][${i}]:${v[i]}`);                       
                        // console.log(`${separator}[${i}]:${v[i]}`);
                    }

                    

                  } else { 
                    lev++;
                    write_json_level(lev,k,v);

                }

            } else {                
                console.log(`[${_key}] [${k}]: ${v}`);
                // console.log(`${separator}[${k}]: ${v}`);
            }
        }
    } 
    
    for (const [key, value] of Object.entries(my_json_file)) {
        // console_Log('key: ' + key + ' val: ' + Object.entries(value) + ' | typeof value ' + typeof value,'black','white',2);  
        if ( typeof value === 'object' ) {   
            // if ( Array.isArray(value) ) { acum_keys=key; } else { acum_keys='['+key+']'; }
            // acum_keys=key; 
            // separator=sep(level,acum_keys);               
            write_json_level(level,key,value); 
          } else {
            console_Log(`lev ${level} _key: ${key} | typeof ${typeof value}`,'','blue',1);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }
            // separator=sep(level,acum_keys);  
            console.log(`[${key}]: ${value} | typeof-> ${typeof value}`);

        }
 
    }
}










/* ***************************************************************************************** */

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

