<?php

// Servers configuration

$i_serv = 0;

/*
 * First server: areafor DB server -> 'POAPMYSQL119.dns-servicio.com:3306'
*/

// count server iterator
$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = 'inaki2022';
$cfg_s['Servers'][$i_serv]['password'] = 'Inaki@2022';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = true;

// Bind to the localhost ipv4 address and tcp 
$cfg_s['Servers'][$i_serv]['host'] = 'POAPMYSQL119.dns-servicio.com:3306';
$cfg_s['Servers'][$i_serv]['hostShortName'] = 'Areafor DB Server';
$cfg_s['Servers'][$i_serv]['connect_type'] = 'tcp';

/*
 * Second server: Localhost
*/

$i_serv++;

// Authentication type and info 
$cfg_s['Servers'][$i_serv]['auth_type'] = 'config';
$cfg_s['Servers'][$i_serv]['user'] = 'root';
$cfg_s['Servers'][$i_serv]['password'] = '@mysql@';
$cfg_s['Servers'][$i_serv]['extension'] = 'mysqli';
$cfg_s['Servers'][$i_serv]['AllowNoPassword'] = false;

// Bind to the localhost ipv4 address and tcp 
$cfg_s['Servers'][$i_serv]['host'] = '127.0.0.1';
$cfg_s['Servers'][$i_serv]['hostShortName'] = 'Localhost DB server';
$cfg_s['Servers'][$i_serv]['connect_type'] = 'tcp';

// Change ARRAYS
$host_serv = [];
$host_serv_ShortName = [];
$host_serv_user = [];
$host_serv_pasw = [];

foreach ( $cfg_s as $server) { 
    for ( $k=0; $k < count($server); $k++ ) {         
        $host_serv[$k+1] = $server[$k+1]['host'];        
        $host_serv_ShortName[$k+1] = $server[$k+1]['hostShortName'];
        $host_serv_user[$k+1] = $server[$k+1]['user'];
        $host_serv_passw[$k+1] = $server[$k+1]['password'];
    }
};

$dbcharset = 'utf8mb4';

