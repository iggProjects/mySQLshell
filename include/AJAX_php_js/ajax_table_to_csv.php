<?php

# Cabeceras de página/archivo para que el navegador solicite guardar en vez de presentar
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=ListaAsociados.csv');

# Puntero de archivo para la salida a guardar
$salida = fopen('php://output', 'w');

# Parametros conexion MySQL
$dbhost = 'localhost';
$dbname = 'penjub';
$dbuser = 'penjub';
$dbpass = 'penjub';
$dbcharset = 'utf8';

# Conexion MySQL
$conexion = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$dbcharset", $dbuser, $dbpass);

# Ejecuta consulta y construyo el CSV
$lines = $conexion->query($query)->fetchAll(PDO::FETCH_ASSOC);

// $first = true;
fputcsv($salida, $lines[0][$key]);

for ( $i=0; $i<count($lines); $i++ ) {

    fputcsv($salida, $lines[$i]);

}

/*
foreach($lines as $line) {
        fputcsv($salida, $line);
}
*/

?>
