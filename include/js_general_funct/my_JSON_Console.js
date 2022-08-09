/*

    Recursive function to view any json in console
    previous work -> Json-AssociativeArray-v1.html

*/

function json_recursive(previous_key,json_key,json_value) {      
    if ( json_value && (typeof json_value != 'object') ) { 
        previous_key += "["+json_key+"]";
        console_Log(previous_key +  ' = ' + json_value,'','green',1);         
      } else {        
        previous_key += "["+json_key+"]";
        for (k in json_value) { json_recursive(previous_key,k,json_value[k]); }
    }    
}

function json_console (json){
    console_Log('JSON','black','white',1);
    console.log(Object.entries(json));
    for (key_act in json) {
        if ( typeof json[key_act] != 'object' ) { 
            console_Log('[' + key_act + '] = ' + json[key_act],'','green',1); 
        } 
        else {
            var prev_key="";           
            json_recursive(prev_key,key_act,json[key_act]); 
        } 
    }  
}
