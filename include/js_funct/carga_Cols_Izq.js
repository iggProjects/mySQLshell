/* 
    JS carga columnas Izq
*/

nTag=1; 

function carga_inicial(){                                 
    // Ejecuto función que coloca la foto en el div "infoAmpliada" y actualiza los "val" y "opacity" respectivos                     
    showInfo(1);        
}

// coloca la foto elegida en el div de foto ampliada  
function showInfo(numTag) {	
    var tagList = document.querySelectorAll('.columna');
    for (var tag of tagList.values()) {                
        tag.className="columna hideTag";
    }
    document.getElementById('tag'+numTag).className="columna showTag";
    document.getElementById('divSelected').innerHTML = document.getElementById('div'+numTag).innerHTML;
}

// al cargar la página invocamos la función carga_inicial() para llenar el div con la foto grande
window.onload = carga_inicial;        
    
// <script src="/lanbide2022/gaztelu/curso-backend-areafor-server/assets/js/appsss.js"></script>
