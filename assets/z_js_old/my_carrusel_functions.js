/* 
  my CARRUSEL functions with html attributes 
*/

// coloca la foto elegida en el div de foto ampliada  
function ampliaFoto(numFot) {		

console.log('input ampliaFoto: numFot es-> ' + numFot + ' | nFot es-> ' + nFot);	

// identifico foto en estatus "ampliada"    
var fotoAmpliada = document.getElementById("fotoGr");

/* 
    Identifico el id de la foto ampliada en la galería, y usamos la 
    función nativa parseInt() para garantizar que 'val' se lea como número
*/
var miFoto_carr = document.getElementById( 'foto' + parseInt(fotoAmpliada.getAttribute("val")) );

// actualizo atributo val en fotoAmpliada y opacity de dicha foto en la galería 
fotoAmpliada.setAttribute("val",numFot);
miFoto_carr.style.opacity="0.7";

// identifico tag foto seleccionada en la galería    
var fotoCarrSelec = document.getElementById('foto'+numFot);            

// Actualiza atributos restantes en ambas fotos    
fotoCarrSelec.style.opacity="1";
fotoAmpliada.src=fotoCarrSelec.src;
fotoAmpliada.val=numFot;    		      
document.getElementById('sep-title').innerHTML=fotoCarrSelec.title; 
document.getElementById('name-text').innerHTML=fotoCarrSelec.title; 
// actualizo el apuntador
nFot=numFot;
console.log('ampliaFoto: nFot es-> ' + nFot)

}

// se activa al pulsar los símbolos de anterior o posterior
function moverFoto(m) {		
// Usando función módulo 6, evalúo nuevo apuntador: (nFot + m) módulo 6, 
// y confirmo vía consola que la suma es un número
console.log('input moverFoto: m-> ' + m + ' | nFot es: ' + nFot + ' | m + nFot: ' + (m + nFot));        
nFot = (( nFot + m ) % 6 );  
if ( nFot == 0 && m==1 ) { nFot=1; }
if ( nFot == 0 && m==-1 ) { nFot=5; }            
console.log('output moverFoto: nFot es-> ' + nFot);        
ampliaFoto(nFot);
}        

