<?php
/*
 * This is needed for cookie based authentication to encrypt password in cookie
*/ 

// $cfg_s['blowfish_secret'] = 'xampp'; // YOU SHOULD CHANGE THIS FOR A MORE SECURE COOKIE AUTH! 

// Servers configuration

$i_serv = 0;

/*
 * First server: areafor DB server -> 'POAPMYSQL119.dns-servicio.com:3306'
*/

$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = '';
$cfg_s['Servers'][$i_serv]['password'] = '';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = true;
// $cfg_s['Lang'] = '';

// Bind to the localhost ipv4 address and tcp 
$cfg_s['Servers'][$i_serv]['host'] = 'POAPMYSQL119.dns-servicio.com:3306';
$cfg_s['Servers'][$i_serv]['hostShortName'] = 'Areafor DB Server';
$cfg_s['Servers'][$i_serv]['connect_type'] = 'tcp';

// $dbcharset = 'utf8mb4';

/*
 * Second server: Localhost
*/

$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = 'root';
//$cfg_s['Servers'][$i_serv]['password'] = '';
$cfg_s['Servers'][$i_serv]['password'] = '';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = false;
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

?>
