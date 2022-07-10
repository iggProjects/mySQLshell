/*
    copia de w3.school.com
    read and update cookies
*/

    var cookies_array = [];

    cookies_array.push(['visitas',0]);

    // console_Log('cookies_array: ' + cookies_array,'blue','white',1);

    function upd_cookie(cook){    
      
        console_Log('function upd_cookie ✔','blue','white',2);

        var text_cook= ``;

        if (getCookie(cook)!="") {

            numVisita = Number(getCookie(cook));
            text_cook = `es tu visita ${numVisita}`;
            numVisita++;

        } else {

            text_cook= "Es tu primera visita</span><p>"
            numVisita = 1;

        }

        text_cook = `<p><span class="resaltado">${text_cook}</span></p>`;
        document.getElementById("my_cookies").innerHTML += text_cook;
        setCookie('visitas', numVisita, 90);

    }


    function setCookie(cname,cvalue,exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "; expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";exp=" + expires + ":path=/";
        console.log('Cookie y valores: ' + cname + '=' + cvalue + ' | ' + expires); 
        console.log(`Cookie y valores: ${document.cookie}`);
    }
  
    function getCookie(cname) {
      let name = cname + "=";
      let decodedCookie = decodeURIComponent(document.cookie);
      let ca = decodedCookie.split(';');
      for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') { c = c.substring(1); }
        if (c.indexOf(name) == 0) { return c.substring(name.length, c.length); }
      }
      return "";
    }  
  
    function recorrerCookie() {
      let resultado = '';
      let decodedCookie = decodeURIComponent(document.cookie);
      let arrayCookies;
      console.log('cookie ' + document.cookie);
      console.log('cookie decoded ' + decodedCookie);
      arrayCookies = decodedCookie.split(';');
      for (let item of arrayCookies){
        console.log('item cookie ', item);
        let parCookie=item.split("=" );
        console.log('name ' + parCookie[0] + 'valor ' + parCookie[1]);
        resultado += `<p class="resaltado">${parCookie[0]} = ${parCookie[1]}`;
      }
      return resultado;
    }
  
