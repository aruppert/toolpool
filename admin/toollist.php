<?php
# Datenbankverbindung einbinden
require("../dbconn.php");

# Nur PHP Fehler anzeigen, keine Kommentare
error_reporting(E_ALL ^ E_NOTICE);

# Session beginnen 
session_start();

# Prüfen ob Client eingeloggt ist, sonst Script stoppen und folgendes zeigen
if (!isset($_SESSION["loggedin"])) {
    die('<h1>Anmeldung nötig</h1>
    <h2>Für diese Seite ist eine Anmeldung notwendig</h2>
    <a href="admin/index.php?next=list">Hier anmelden</a> <br/>
     <a href="index.php">Zurück zur Hauptseite</a>');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Toollist</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>
    <?php

    echo "<div class=\"border\">";
    echo "<div id=\"userlogout\">\n";
    echo "Benutzer: &nbsp;&nbsp;&nbsp;<a href=\"logout.php\">Logout</a>";
    echo "</div>\n";

    echo '<h1>Alle Tools</h1>';
    echo "</div>";

    echo "<div id=\"content\" class=\"border\">";

    # Link um neues Tool hinzuzufügen
    echo '<h2><a class="linkneu" href="toolform.php?id=neu">neues Tool hinzufügen</a></h2>';

    # Alle Tools mit Namen, Kategorie, Verfügbarkeit, BesitzerNummer und Gebiet anzeigen lassen
    $sql = "SELECT t.id ToolID, t.name Tool, c.name Kategorie, s.name 
Verfügbarkeit, m.id Mitgliedsnummer, m.district Gebiet, t.picture picture
        FROM tool t
        INNER JOIN member m ON t.owner_id = m.id
        INNER JOIN category c ON t.category_id = c.id
        INNER JOIN status s ON t.status_id = s.id
        ORDER BY t.name";

    # SQL-Anweisung an MySQL übergeben
    $zeiger = mysqli_query($conn, $sql);

    # Tabelle
    echo '<table class="liste">';
    echo '<tr><th>Name</th><th>Kategorie</th><th>Verfügbarkeit</th><th>Gehört Mitglied Nr.</th><th>Angeboten in </th><th> </th><th> </th></tr>';
    # Schleife zur Ausgabe der Datensätze
    while ($datensatz = mysqli_fetch_assoc($zeiger)) {

        echo '<tr>';
        echo '<td><a class="name" href="toolform.php?id=' . $datensatz["ToolID"] . '">' . $datensatz["Tool"] . '</a></td>';
        echo '<td>' . $datensatz["Kategorie"] .  '</td>';
        echo '<td>' . $datensatz["Verfügbarkeit"] . '</td>';
        echo '<td>' .  $datensatz["Mitgliedsnummer"] . '</td>';
        echo '<td>' . $datensatz["Gebiet"] . '</td>';
        echo '<td><a href="uploadpicture.php?id=' . $datensatz["ToolID"] . '&picture=' . $datensatz["picture"] . '">Bild</a></td>';
        echo '<td><a href="deletetool.php?id=' . $datensatz["ToolID"] . '">löschen</a></td>';
        echo '</tr>';
    }
    echo '</table>';


    mysqli_free_result($zeiger);
    # Datenbankverbindung beenden
    mysqli_close($conn);
    ?>

    </div>

</body>

</html>