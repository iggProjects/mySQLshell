/* my functionos for html collection analysis and print in console with color effects */

function object_descriptor (_method,tag,tag_object) {

    console_Log('method calling function: ' + _method,'black','white',1);    
    console_Log('html_objects: ' + tag + ' object.toString: ' + tag_object.toString(),'','green',1);
    console_Log('html_objects: ' + tag_object + ' typeof: ' + typeof tag_object,'','blue',1);
   
    switch(tag_object.toString()) {

        case "[object NodeList]":				
            console_Log('CASE: ' + tag,'','green',2);
            viewNodeList(tag_object)
            console.log('----------------------------------------')
            break;

        case "[object HTMLFieldSetElement]":				
            console_Log('CASE: ' + tag,'','green',2);
            // code block
            console.log('----------------------------------------')
            break;

        case "[object HTMLCollection]":				
            console_Log('CASE: ' + tag,'','green',2);
            // code block
            console.log('----------------------------------------')
            break;

        default:
            console_Log('html_objects: ' + tag + ' object.toString: ' + tag_object.toString(),'','green',2);
            console_Log('CASE default: element without case function ','','red',2);
            console.log('----------------------------------------')
        
    }
}



function object_properties(_object,idTag) {    

    //const _object = { a: 1, b: 2, c: 3 };
    html_text="";

    console.log('object keys: ' + Object.keys(_object) + ' | values: ' + Object.values(_object));

    for (const property in _object) {
        console.log(`${property}: ${_object[property]}`);
        html_text += "property: " + property + " | value: " + _object[property] + "<br>"; 
     }

    document.getElementById(idTag).innerHTML= html_text;

}

function showTableDataHtml(idTable,idInfoTable) {        

    var infoRows=document.getElementById(idInfoTable);
    infoRows.innerHTML="<br><b>Table \"Row-Cell\" innerHTML</b><br><br>";        
    
    var myTab = document.getElementById(idTable);        

    // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
    for (i = 1; i < myTab.rows.length; i++) {

        // separator and blank spaces variables. For style effects
        var sep = " - ";
        var blank_spaces = "&nbsp;&nbsp;&nbsp;";

        // GET THE CELLS COLLECTION OF THE CURRENT ROW.
        var objCells = myTab.rows.item(i).cells;
        infoRows.innerHTML +="Row " + i + " →" + blank_spaces;

        // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
        for (var j = 0; j < objCells.length; j++) {
            if ( j == objCells.length-1 ) { sep="" }; 
            infoRows.innerHTML = infoRows.innerHTML + ' ' + objCells.item(j).innerHTML + sep;
        }
        infoRows.innerHTML = infoRows.innerHTML + '<br><br>';     // ADD A BREAK (TAG).
    }
}

function showTableDataConsole(idTable) {
    // console.log(idTable);
    var infoRows="";        
    
    // document.getElementById('info').innerHTML = "";
    var myTab = document.getElementById(idTable);        

    // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
    for (i = 1; i < myTab.rows.length; i++) {

        // GET THE CELLS COLLECTION OF THE CURRENT ROW.
        var objCells = myTab.rows.item(i).cells;
        console.log('tr: ' + i);
        // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
        for (var j = 0; j < objCells.length; j++) {                
            console.log('\t' + objCells.item(j).innerHTML);
            // infoRows = infoRows + ' | ' + objCells.item(j).innerHTML;
        }
        // console.log('row ' + i + ' : ' + infoRows);
        infoRows="";
        // infoRows = infoRows + '\n';     // ADD A BREAK (TAG).                        
    }        
}

function listAtrib(el_id) {
    var el = document.getElementById(el_id);
    console_Log('listAtrib of: ' + el.tagName + ' | id: ' + el_id,'blue','white',2);
    for (var i = 0, atts = el.attributes, n = atts.length, arr = []; i < n; i++){
        // arr.push(atts[i].nodeName);
        console.log('attrib: ' + i + ' -> ' + atts[i].nodeName  + ' | value -> ' + atts[i].nodeValue);
    }
}

function viewNodeList(node_list) {
    var node_l = node_list;
    console_Log('Node List: ' + node_l + ' | length: ' + node_l.length,'blue','white',2);
    for(var value of node_l.values()) {            
        console.log(value);
        for (var i = 0, atts = value.attributes, n = atts.length, arr = []; i < n; i++){
            // arr.push(atts[i].nodeName);
            console.log('attrib: ' + i + ' -> ' + atts[i].nodeName  + ' | value -> ' + atts[i].nodeValue);
        }

    }
} 
    
function tag_style (htmlTag){
    var styles = document.getElementById(htmlTag).style;
    var style_prop = '';
    var i=1;
    for (var prop in styles) {
        console_Log(i + ' ' + prop + ': ' + styles[prop] + ' | ' + styles[styles[prop]],'','',1);
        i++;
        // style_prop += '<b>' + prop + '</b>: ' + styles[prop] + ' ➙ ' + styles[styles[prop]] + ";<br/><br>";
    }

    // document.getElementById('tag_style').innerHTML = style_prop; 
    var msg= 'style del id: ' + htmlTag;
    console_Log(msg,'blue','white',3);    
    // console_Log(style_prop,'','',1);   
}        

function listHTML_tags(html_collection) {
    // var el = document.getElementsByName(html_val);
    // console.log('listAtrib of id: ' + html_collection);        
    // atts = html_collection.attributes;
    n = html_collection.length;
    // n = html_collection[0].attributes.length;
    console.log('object html: ' + html_collection[0] + ' | length of object html: ' + n);

    arr = [];

    for (var i = 0;  i < n; i++ ) {
        // arr.push(atts[i].nodeName);
        console.log('attrib: ' + i + ' -> ' + html_collection[i]  + ' | value -> ' + html_collection[i]);        
    }
    console.log('%c salí del FOR','background: blue; color: white','\n\n\n');
    
    Array.from(html_collection).forEach(function(element) {
        console.log('elemento');
        console.log(element);
    });

    console.log('%c salí del ARRAY.from','background: blue; color: white','\n\n\n');
    console_Log('%c salí del ARRAY.from','background: blue; color: white',3);

}

function querySel(idTag,tagSelect) {
    /*
        Function to know the DOM structure of, in this case, form tag. 
    */

    // Checking functions parameters
    console_Log('idTag es: ' + idTag + ' | nodeName: ' +document.getElementById(idTag).nodeName,'black','yellow',1);
    console_Log('tagSelect es: ' + tagSelect,'blue','white',2);
    
    // IN THIS CASE, "var x" get object [HTMLFieldSetElement]
    var x = document.getElementById(idTag);
    console_Log('getElementByID: ' + x + ' | nodeName: ' + x.nodeName,'green','white',2);

    // "var queryList" get [object NodeList] 
    var queryList = x.querySelectorAll(tagSelect);
    console_Log('queryList: ' + queryList + ' | lenght: ' + queryList.length,'yellow','black',2);

    // Loop through array elements of pairs 'attribute,value'
    var i=1;
    console_Log('tag Parent: ' + idTag + ' | tag querySelect: ' + tagSelect,'blue','white',2)
    for (var tag of queryList.values()) {
        console_Log(i + ' tag: ' + tag.nodeName + ', id->  ' + tag.id,'orange','black',1);   
        for ( var j=0; j<tag.attributes.length; j ++) {
            console_Log(j + ' - attribute: ' + tag.attributes[j].nodeName + ', value: '+ tag.attributes[j].value,'','red',1);   
        }		
        i++;
    }    
}


function console_Log (msG,bckgCol,col,lines){
    var linesJump=''; 
    for (i=1;i<parseInt(lines);i++){
        linesJump+='\n';
    }
    var msg='%c ' + msG + ' ' + linesJump;
    var colEffects='line-height:20px; background:'+bckgCol+'; color:'+col; 
    console.log(msg,colEffects);                
}

