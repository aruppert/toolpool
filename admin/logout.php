<?php

# Datenbankverbindung einbinden
include("../dbconn.php");

# Session übernehmen
session_start();

# Sessiondaten löschen
session_destroy();

# Session-Cookie löschen
setcookie("PHPSESSID", "", 0, "/");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Logout ToolPool</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>

    <div class="border">
        <h1>Logout ToolPool</h1>
    </div>

    <div id="content" class="border">
        <div id="formular">

            Sie wurden abgemeldet.<br><br>
            <a href="index.php">Hier erneut anmelden</a>

            <a href="../index.php">Zurück zur Startseite</a>
        </div>

    </div>

</body>

</html>