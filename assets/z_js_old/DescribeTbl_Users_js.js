/*


*/

function DescribeTbl_Users_js(php_origin,tag,php_sql_url){   
    console.log('php_origin ' + php_origin + ', tag ' + tag + ', php_sql_url ' + php_sql_url) 

    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()
        else
            throw new Error(response.status)
    })

    .then(data => {        
        document.getElementById(tag).innerHTML = data; 
        // document.getElementById(tag).innerHTML = "probando 1 2 3"; 
    })

    .catch(err => {
        console.error("Desde " + php_origin + ", ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "Desde " + php_origin + "ERROR: " + err.message; 

    });

}
