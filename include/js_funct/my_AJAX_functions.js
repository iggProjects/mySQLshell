/*
 *  JS functions for ajax and other requirements
*/

/*
 *  JS functions for host sql queries to display html for div 'DB-info'
*/


function Display_div_nav_izq(tag,php_sql_url){

    console.log('tag=> ' + tag + '\nphp_sql_url=> ' + php_sql_url) 

    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()
        else
            throw new Error(response.status)
    })

    .then(data => {        
        document.getElementById(tag).innerHTML = data;  

        /* call function for display tree structure of tables by each DB in HOST*/
        openTree();          
    })

    .catch(err => {
        console.error("ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "ERROR: " + err.message; 

    });

}

/*
 *  JS functions for db sql queries
*/

/*   For describe table structure */ 
function DescribeTbl_js(tag,php_sql_url){   
    console.log('tag=> ' + tag) 
    console.log('php_sql_url=> ' + php_sql_url) 
    
    fetch(php_sql_url)

    .then(response => {
        if (response.ok)
            return response.text()
        else
            throw new Error(response.status)
    })

    .then(data => {        
        document.getElementById(tag).innerHTML = data;         
    })

    .catch(err => {
        console.error("ERROR: ", err.message);
        document.getElementById(tag).innerHTML = "ERROR: " + err.message; 

    });

}

