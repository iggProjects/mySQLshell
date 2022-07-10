/*
    Drag & Drop functions  (Los comentarios y console.log invocados pueden suprimirse en la versión final)
*/  

function dragstart_handler(ev) {
    console.log("dragStart");
    // Change the source element's background color to signify drag has started
    ev.currentTarget.style.border = "dashed red";
    // Add the id of the drag source element to the drag data payload so
    // it is available when the drop event is fired
    ev.dataTransfer.setData("text", ev.target.id);
    // Tell the browser both copy and move are possible
    ev.effectAllowed = "copyMove";
}

function dragover_handler(ev) {
    console.log("dragOver");
    // Change the target element's border to signify a drag over event
    // has occurred
    // ev.currentTarget.style.background = "lightblue";
    ev.preventDefault();
}

function drop_handler(ev) {
    console.log("Drop");
    ev.preventDefault();
    // Get the id of drag source element (that was added to the drag data
    // payload by the dragstart event handler)

    var id = ev.dataTransfer.getData("text");
    //vemos en consola navegador el contenido de esta data
    // console.log('%c id es: ' + id + ' ','background: blue; color: white','\n\n');
    listAtrib(id);
    
    // creamos variables para invocar la función JS "ampliaFoto()"
    var foto_movida = document.getElementById(id);
    var num_foto_movida = parseInt(foto_movida.getAttribute('val')); // parseInt() garantiza que lo leído se interprete como número entero
    console.log('%c num de la foto movida es: ' + num_foto_movida + ' ','color: green','\n\n');
    
    nFot=num_foto_movida;
    ampliaFoto(num_foto_movida);         

}

function dragend_handler(ev) {
    console.log("dragEnd");
    // Restore source's border
    ev.target.style.border = "solid green";
    // Remove all of the drag data
    ev.dataTransfer.clearData();
}

