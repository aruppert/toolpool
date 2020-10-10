<?php

# Datenbankverbindung herstellen 

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "root";
$dbname = "toolpool";

# Verbindung aufbauen und "Verbindungskennung" in einer Variablen merken
$conn = @mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

# konnte keine Datenbankverbindung hergestellt werden, dann abbrechen
if (!$conn) {

    die("Es konnte keine Datenbankverbindung hergestellt werden");
}
