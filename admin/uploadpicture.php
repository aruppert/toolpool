<?php

# Einbindung der Datenbankverbindung
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

# Formularfelder/-daten empfangen und in Variablen speichern
$id = @$_REQUEST["id"];
$button = @$_POST["button"];
$datei = @$_FILES["datei"];

# Variablen vorbelegen
$dateigroesse_max = 5120 * 1024;
$pfad = "../toolpics/";
$zieldatei = $id . "_" . time() . ".jpg";


# Formulardaten prüfen und verarbeiten
# wurden Daten gesendet & empfangen?
if ($button) {


    # Fehlermeldung anzeigen, abhängig von Fehlernummer
    # keine Datei ausgewählt
    if ($datei["error"] == 4) {
        $meldung[] = "Bitte Datei auswählen";
    }

    # Datei zu groß 
    elseif ($datei["error"] == 2) {
        $meldung[] = "Datei ist größer als " . ($dateigroesse_max / 1024 / 1024) . " MB";
    }

    # Datei ist kein JPG
    elseif ($datei["type"] != "image/jpeg") {
        $meldung[] = "Datei ist kein JPG";
    }

    # Verarbeitung 
    # Name einzigartig machen mit time(), um Überschreiben zu verhindern
    $picture = $zieldatei;
    $sql = "UPDATE tool SET picture = '$picture' WHERE id = $id";
    mysqli_query($conn, $sql);
}
# Datei in Bilderordner verschieben
move_uploaded_file(@$datei["tmp_name"], "../toolpics/" . @$zieldatei);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Tool Bild bearbeiten</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>

    <div class="border">
        <h1>Aktuelles Tool Bild ersetzen</h1>
        <button class="form_button_right_upload" type="button" name="button" value="zurueck" onClick="window.location.href = 'toollist.php';">Zurück zur Toollist</button>
    </div>

    <div id="content" class="border">


        <?php

        # Info zu Tool aus DB holen mit ID
        $sql = "SELECT * FROM tool WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $datensatz = mysqli_fetch_assoc($result);
        $name = $datensatz["name"];
        $picture = $datensatz["picture"];

        # Eintrag anzeigen
        echo "<h2>Tool: $name </h2>";
        echo "<div class=\"datensatz\">\n";

        # Bild vorhanden, dann darstellen
        if (is_file($pfad . $picture)) {

            echo "<img class=\"adminpicture\" src=\"${pfad}${picture}\" alt=\"${name}\" title=\"${name}\" />";
        }
        # kein Bild vorhanden, dann Platzhalter zeigen
        else {

            echo "<img class=\"adminbild\" src=\"${pfad}default.jpg\" alt=\"kein Bild\" title=\"kein Bild\" />";
            echo "kein Bild vorhanden";
        }


        echo "</div>\n";
        echo "<div class=\"clearer\"></div>\n";

        mysqli_free_result($result);

        ?>

        <p class="fehler"><?php if (@$meldung) echo implode("<br>", $meldung); ?></p>

        <div id="formular">

            <form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" enctype="multipart/form-data">

                <section id="section_input">
                    <label class="form_label" for="datei">Neues Bild auswählen (*.jpg - 5MB max.)</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $dateigroesse_max; ?>">
                    <input class="form_input" type="file" name="datei" id="datei" size="32" maxlength="100">
                </section>

                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <section id="section_submit">
                    <button class="form_button" type="submit" name="button" value="speichern">Neues Bild Speichern</button>
                    <button class="form_button_right_upload" type="button" name="button" value="zurueck" onClick="window.location.href = 'toollist.php';">Zurück zur Toollist</button>
                </section>

            </form>

        </div>

    </div>

</body>

</html>


<?php

# Datenbankverbindung beenden
mysqli_close($conn);

?>