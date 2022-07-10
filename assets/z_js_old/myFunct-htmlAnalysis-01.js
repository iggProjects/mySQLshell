/* my functionos for html collection analysis and print in console with color effects */

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


    function listAtrib(el_id) {
        var el = document.getElementById(el_id);
        console.log('listAtrib of: ' + el.tagName + ' | id: ' + el_id);
        for (var i = 0, atts = el.attributes, n = atts.length, arr = []; i < n; i++){
            // arr.push(atts[i].nodeName);
            console.log('attrib: ' + i + ' -> ' + atts[i].nodeName  + ' | value -> ' + atts[i].nodeValue);
        }
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

    function console_Log (msG,bckgCol,col,lines){
        var msg='%c '+msG+' ';
        var colEffects='background:'+bckgCol+'; color:'+col;
        var linesJump=''; 
        for (i=1;i<lines;i++){
            linesJump+='\n';
        }
        console.log(msg,colEffects,linesJump);                
    }

    // PROBANDO LAS FUNCIONES 

    // console_Log('casas bonitas','blue','white',2);
    // console_Log('casas bonitas','','',1);
    // var id1='prueba';
    // listAtrib(id1);    
    // tag_style(id1);    