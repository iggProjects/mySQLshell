/*
   Functions to read and write JSON's
*/


// recursive function
function json_level(json_key,json_file) {    
    console_Log('_____ key: "' + json_key + '", value: ' + json_file[json_key]  + '" _____','gray','yellow',2);
    console_Log('ENTRIES of ' + json_key + ', ' + json_file[json_key],'','green',1);    
    console.log(Object.entries(json_file[json_key]));
}

function write_json(_key,my_json_file) {
    var i=0;    

    console_Log('_______ analyze json using Objects.keys, Object.values y object.entries __________','#b3b3b3','blue',2);
    console_Log('WRITE_JSON  JSON.length:  ' + Object.keys(my_json_file).length,'','blue',1);
    console_Log('Keys:','','blue',1);
    console.log(Object.keys(my_json_file));
    console_Log('Values:','','blue',1);
    console.log(Object.values(my_json_file));
    console_Log('Entries:','','green',1);
    console.log(Object.entries(my_json_file));

    console_Log('__________________ loop with json key level 1  __________________','#b3b3b3','blue',2);
    for (key_act in my_json_file) {                 
        console_Log('key_act: "' + key_act + '" length: ' + Object.keys(my_json_file[key_act]).length,'','blue',1);
        console_Log('keys:','','green',1);
        console.log(Object.keys(my_json_file[key_act]));
        console_Log('values:','','green',1);
        console.log(Object.values(my_json_file[key_act]));        
    }

    console_Log('__________________ looping recursive level 1 __________________','#b3b3b3','blue',2);
    for (key_act in my_json_file) {
        if ( typeof my_json_file[key_act] === 'object' ) {        
            json_level(key_act,my_json_file);
          } else {
            console_Log('"' + key_act + '", value: "' + my_json_file[key_act]  + '", length: ' + Object.keys(my_json_file[key_act]).length,'','green',2);  
            console.log('value: ' + my_json_file[key_act]);            
            console.log('');
        }           
    }

    console_Log('__________________ looping recursive level full __________________','#b3b3b3','blue',2);
    for (key_act in my_json_file) {
        if ( typeof my_json_file[key_act] === 'object' ) {        
            json_level(key_act,my_json_file);
          } else {
            console_Log('"' + key_act + '", value: "' + my_json_file[key_act]  + '", length: ' + Object.keys(my_json_file[key_act]).length,'','green',2);  
            console.log('value: ' + my_json_file[key_act]);            
            console.log('');
        }           
    }

    /* OJO OJO OJO que no corre este pedacito
    console_Log('__________________ looping recursive mode __________________','#b3b3b3','blue',2);

    function json_recursive(json_key,json_value) {
    
        if ( typeof json_value === 'string' ) {
            console_Log('_____ recursive funct for key: "' + json_key + '", value: ' + json_value  + '" _____','gray','yellow',2);
            console_Log('ENTRIES of ' + json_key + ', ' + json_value[json_key],'','green',1);    
            console.log(Object.entries(json_value));
         } else {
            var _key= json_value[json_key];
            json_recursive(_key,json_value[json_key]);
        }
    
    }
    
    // main
    for (key_act in my_json_file) {
        console_Log('ENTRIES of ' + key_act + ', ' + my_json_file[key_act],'','green',1);
        json_recursive(key_act,my_json_file[key_act]);
    }
    */

    //
    //    III mode
    //
    
    console_Log('__________________ looping recursive mode II __________________','#b3b3b3','blue',2);
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
        separator+='n'+n+'-';
        return separator;                        
    }
        
    // key_ant key_act
    
    function write_json_level(lev,_key,_val){

        console_Log(`lev ${lev} | _key: ${_key}`,'','blue',1);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }
        console.log(`lev ${lev} | _key: ${_key} | typeof ${typeof _val} | isArray ${Array.isArray(_val)} `);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }
    
        for(const [k,v] of Object.entries(_val) ) {   

            // console_Log('key: ' + k + ' | typeof "value" '+ typeof v + ' |  isArray ' + Array.isArray(v),'','green',1);        
                        
            if ( typeof v === 'object' ) {
                // lev++;
                // separator=sep(lev,'');
                                
                if ( Array.isArray(v) ) {
                    
                    separator=sep(lev,'');                    
                    
                    for ( var i=0; i<v.length; i++ ) {                        
                        console.log(`${separator}[${_key}][${k}][${i}]: ${v[i]}`); 
                        // write_json_level(lev,k,v);                       
                    }
                    

                  } else { 
                    // lev++;
                    separator=sep(lev,'');
                    write_json_level(lev,k,v);

                }

              } else {                
                console.log(`${separator}[${_key}][${k}]: ${v}`);
                // console.log(`${separator}[${k}]: ${v}`);
            }
        }
    } 
    
    // main of II recursive mode
    for (const [key, value] of Object.entries(my_json_file)) {
        console.log('key: ' + key + ' val: ' + Object.entries(value) + ' | typeof value ' + typeof value);  
        // console_Log('key: ' + key + ' val: ' + Object.entries(value) + ' | typeof value ' + typeof value,'gray','white',2);  
        if ( typeof value !== 'string' ) {   

            // level++;
            separator=sep(level,'');               
            write_json_level(level,key,value); 

          } else {

            // console_Log(`lev ${level} _key: ${key} | typeof ${typeof value}`,'','blue',1);  // if ( flag ) {} else { acum_keys=acum_keys + ' -> ' + _key;  }
            // separator=sep(level,acum_keys);  
            console.log(`[${key}]: ${value} | level ${level},  key ${key}, typeof-> ${typeof value}`);

        }
 
    }
  
}

/* 
    Only for make HTML for JSON of 3 levels
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

