<?php

# Datenbankverbindung einbinden
include("../dbconn.php");

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

# ID des Tools zum löschen & Löschung empfangen
$id = $_REQUEST["id"];
$delete = $_POST["delete"];

# wenn Löschen wurde geklickt, lösche den Eintrag aus db
if (isset($delete)) {
    $sql = "DELETE FROM tool WHERE id = $id";
    mysqli_query($conn, $sql);

    header("Location: toollist.php");
}

?>

<!DOCTYPE html>
<html lang="de">

<head>

    <meta charset="utf-8">
    <title>Löschung</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>

    <div class="border">
        <h1>Tool löschen</h1>
    </div>

    <div id="content" class="border">

        <section>
            <div class="row">
                <!-- den ausgewählten Artikel anzeigen  -->
                <?php

                $sql = "SELECT * FROM tool WHERE id = $id";

                $result = mysqli_query($conn, $sql);
                while ($datensatz = mysqli_fetch_assoc($result)) {

                    # Variablen zur angenehmeren Weiterverarbeitung erstellen 
                    $link = $datensatz["link"];
                    $year = $datensatz["year"];
                    $name = $datensatz["name"];
                    $picture = $datensatz["picture"];
                    $requirements = $datensatz["requirements"];
                    $description = $datensatz["description"];

                    # Beschreibung kürzen
                    $description_teaser = substr($datensatz["description"], 0, 300);

                    # '...' einblenden, sollte Beschreibung wirklich gekürzt wurden sein
                    if ($description_teaser == $description) {
                        $points = "";
                    } else {
                        $points = "...";
                    }

                    # Verfügbarkeit illustrieren
                    if ($datensatz["status_id"] == 1) {
                        $status = "✅";
                    } else {
                        $status = "🛑";
                    }

                    # weitere Info-Zeile anzeigen, sollte es requirements geben
                    if ($requirements) {
                        $extra_info = "<h5>Benötigt: $requirements</h5>";
                    } else {
                        $extra_info = "<br/>";
                    }

                    echo "<div class=\"col-4 col-6-medium col-12-small\">
                                					<section class=\"box\">
                                						<a href=\"#\" class=\"image featured\"><img src=\"../toolpics/$picture\" alt=\"$name\" /></a>
                                						<header>
                                							<h3>$name</h3>
                                                        </header>
                                                        <h4>Jahr: $year - Verfügbarkeit: $status</h4>
                                                        $extra_info
                                						<p>$description_teaser $points</p>
                                						<footer>
                                							<ul class=\"actions\">
                                								<li><a href=\"$link\" target=\"_blank\"  class=\"button alt\">Mehr info (extern)</a></li>
                                							</ul>
                                						</footer>
                                					</section>
                                				</div>";
                }
                mysqli_free_result($result);
                ?>
                <!-- Ende des Eintrags -->
                <form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button class="form_button" type="submit" name="delete" value="delete" onClick="window.location.href = 'toollist.php';">Löschen und zurück zur Liste</button>
                    <button class="form_button_right" type="button" name="button" value="abbrechen" onClick="window.location.href = 'toollist.php';">Abbrechen</button>

                </form>
            </div>
        </section>


    </div>

</body>

</html>
<?php
#Datenbankverbindung beenden
mysqli_close($conn);

?>