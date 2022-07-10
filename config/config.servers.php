<?php
/*
 * This is needed for cookie based authentication to encrypt password in
 * cookie
*/ 

// $cfg_s['blowfish_secret'] = 'xampp'; // YOU SHOULD CHANGE THIS FOR A MORE SECURE COOKIE AUTH! 

// Servers configuration

$i_serv = 0;

/*
 * First server
*/

$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = 'inaki2022';
$cfg_s['Servers'][$i_serv]['password'] = 'Inaki@2022';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = true;
// $cfg_s['Lang'] = '';

// Bind to the localhost ipv4 address and tcp 
$cfg_s['Servers'][$i_serv]['host'] = 'POAPMYSQL119.dns-servicio.com:3306';
$cfg_s['Servers'][$i_serv]['hostShortName'] = 'Areafor DB Server';
$cfg_s['Servers'][$i_serv]['connect_type'] = 'tcp';

// $dbcharset = 'utf8mb4';

/*
 * Second server
*/

$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = 'root';
$cfg_s['Servers'][$i_serv]['password'] = '@mysql@';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = true;
// $cfg_s['Lang'] = '';

// Bind to the localhost ipv4 address and tcp 
$cfg_s['Servers'][$i_serv]['host'] = '127.0.0.1';
$cfg_s['Servers'][$i_serv]['hostShortName'] = 'Localhost DB server';
$cfg_s['Servers'][$i_serv]['connect_type'] = 'tcp';




// Change variable
$host_serv = [];
$host_serv_ShortName = [];
// $host_serv_db= [];
$host_serv_user = [];
$host_serv_pasw = [];

foreach ( $cfg_s as $server) { 
    for ( $k=0; $k < count($server); $k++ ) {         
        $host_serv[$k+1] = $server[$k+1]['host'];
        // echo $host_serv[$k+1] . "<br>";
        $host_serv_ShortName[$k+1] = $server[$k+1]['hostShortName'];
        $host_serv_user[$k+1] = $server[$k+1]['user'];
        $host_serv_passw[$k+1] = $server[$k+1]['password'];
    }
};

$dbcharset = 'utf8mb4';



/*

***************************************
        For every new server
****************************************

// User for advanced features 
$cfg_s['Servers'][$i_serv]['controluser'] = 'pma';
$cfg_s['Servers'][$i_serv]['controlpass'] = '';

// Advanced phpMyAdmin features 
$cfg_s['Servers'][$i_serv]['pmadb'] = 'phpmyadmin';
$cfg_s['Servers'][$i_serv]['bookmarktable'] = 'pma__bookmark';
$cfg_s['Servers'][$i_serv]['relation'] = 'pma__relation';
$cfg_s['Servers'][$i_serv]['table_info'] = 'pma__table_info';
$cfg_s['Servers'][$i_serv]['table_coords'] = 'pma__table_coords';
$cfg_s['Servers'][$i_serv]['pdf_pages'] = 'pma__pdf_pages';
$cfg_s['Servers'][$i_serv]['column_info'] = 'pma__column_info';
$cfg_s['Servers'][$i_serv]['history'] = 'pma__history';
$cfg_s['Servers'][$i_serv]['designer_coords'] = 'pma__designer_coords';
$cfg_s['Servers'][$i_serv]['tracking'] = 'pma__tracking';
$cfg_s['Servers'][$i_serv]['userconfig'] = 'pma__userconfig';
$cfg_s['Servers'][$i_serv]['recent'] = 'pma__recent';
$cfg_s['Servers'][$i_serv]['table_uiprefs'] = 'pma__table_uiprefs';
$cfg_s['Servers'][$i_serv]['users'] = 'pma__users';
$cfg_s['Servers'][$i_serv]['usergroups'] = 'pma__usergroups';
$cfg_s['Servers'][$i_serv]['navigationhiding'] = 'pma__navigationhiding';
$cfg_s['Servers'][$i_serv]['savedsearches'] = 'pma__savedsearches';
$cfg_s['Servers'][$i_serv]['central_columns'] = 'pma__central_columns';
$cfg_s['Servers'][$i_serv]['designer_settings'] = 'pma__designer_settings';
$cfg_s['Servers'][$i_serv]['export_templates'] = 'pma__export_templates';
$cfg_s['Servers'][$i_serv]['favorite'] = 'pma__favorite';

// End of servers configuration

*/

?>
