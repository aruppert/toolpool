<?php

# Datenbankverbindung aufbauen
require("../dbconn.php");

# Nur PHP Fehler anzeigen, keine Kommentare
error_reporting(E_ALL ^ E_NOTICE);

# Session beginnen 
session_start();

# Prüfen ob Client eingeloggt ist, sonst Script stoppen und folgendes zeigen
if (!isset($_SESSION["loggedin"])) {
    die('<h1>Anmeldung nötig</h1>
    <h2>Für diese Seite ist eine Anmeldung notwendig</h2>
    <a href="admin/index.php?next=form">Hier anmelden</a> <br/>
     <a href="index.php">Zurück zur Hauptseite</a>');
}

# Session Variablen definieren
$user_id = $_SESSION["user_id"];
$user_last_name = $_SESSION["user_last_name"];
$user_first_name = $_SESSION["user_first_name"];


# Formularfelder/-daten empfangen und in Variablen speichern
$buttonclicked = $_POST['button'];
$id = strip_tags(trim(substr($_REQUEST["id"], 0, 5)));
$name = strip_tags(trim(substr($_POST["name"], 0, 50)));
$status_id = strip_tags(trim(substr($_POST["status_id"], 0, 1)));
$description = strip_tags(trim(substr($_POST["description"], 0, 750)));
$picture = strip_tags(trim(substr($_POST["picture"], 0, 150)));
$link = strip_tags(trim(substr($_POST["link"], 0, 450)));
$requirements = strip_tags(trim(substr($_POST["requirements"], 0, 500)));
$year = strip_tags(trim(substr($_POST["year"], 0, 4)));
$category_id = strip_tags(trim(substr($_POST["category_id"], 0, 5)));
$owner_id = strip_tags(trim(substr($_POST["owner_id"], 0, 5)));

# Formulardaten prüfen und verarbeiten
# wurden Daten gesendet & empfangen?
if ($buttonclicked) {


    # Prüfung der Pflichtfelder
    # Name des Eintrags
    if (strlen($name) < 2) {

        $meldung[] = "Bitte geben Sie einen gültigen Namen an";
    }

    # Besitzer ID gültiges Format?
    if (strlen($owner_id) !== 5) {

        $meldung[] = "Bitte geben Sie ihre Mitgliedsnummer ein";
    }

    # Kategorie ausgewählt?
    if (!is_numeric($category_id)) {

        $meldung[] = "Bitte wählen Sie eine passende Kategorie aus";
    }

    # Verfügbarkeit ausgewählt?
    if (!is_numeric($status_id)) {

        $meldung[] = "Bitte wählen Sie einen Status aus";
    }

    # Verarbeitung des Formulars

    # wenn keine Eingabefehler, dann in die Datenbank speichern
    if (!isset($meldung)) {

        if ($year == "") {
            $sqlyear = 'NULL';
        } else {
            $sqlyear = $year;
        }

        #Daten speichern
        # wenn id=neu, neuen Eintrag anlegen
        if ($id == "neu") {

            $sql = "INSERT INTO tool (name, description, status_id, picture, link, requirements, year, category_id, owner_id)
            VALUES ('$name', '$description', $status_id, '$picture', '$link', '$requirements', $sqlyear, $category_id, $owner_id)";

            mysqli_query($conn, $sql);
        }
        # wenn id vorhanden, dann vorhandenen Eintrag aktualisieren
        elseif (is_numeric($id)) {

            $sql = "UPDATE tool SET name = '$name', description = '$description', status_id = $status_id, picture = '$picture', link = '$link', requirements = '$requirements', year = $sqlyear, category_id = $category_id, owner_id = $owner_id WHERE id = $id";

            mysqli_query($conn, $sql);
        }

        # möglichen SQL-Fehler ausgeben
        echo mysqli_error($conn);

        # automatisch zurück zur Liste
        header("Location: toollist.php");
    }
}

# vorhandene Daten über Eintrag aus der Datenbank holen

elseif ($id != "neu" && strlen($id) >= 1) {

    # vorhandene Daten aus der Datenbank holen, um sie im Formular darzustellen
    $sql = "SELECT * FROM tool WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $datensatz = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    # Daten in die Variablen speichern, welche im Formular verwendet/angezeigt werden
    $category_id = $datensatz["category_id"];
    $status_id = $datensatz["status_id"];
    $name = $datensatz["name"];
    $description = $datensatz["description"];
    $year = $datensatz["year"];
    $link = $datensatz["link"];
    $requirements = $datensatz["requirements"];
    $owner_id = $datensatz["owner_id"];
    $picture = $datensatz["picture"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Tool hinzufügen </title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>

    <div class="border">
        <h1>Tool hinzufügen - Account von <?php echo "$user_first_name  $user_last_name, Mitglied $user_id" ?></h1>
    </div>

    <div id="content" class="border">

        <div id="formular">

            <p class="fehler"><?php if (isset($meldung)) echo implode("<br>", $meldung); ?></p>

            <form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">

                <section id="section_select">

                    <!-- Kategorien -->
                    <label class="form_label" for="category_id">Kategorie *</label>
                    <select class="form_input_select" name="category_id" id="category_id">
                        <?php
                        # erstes Auswahlfeld, um eine Auswahl zu erzwingen
                        echo '<option class="form_option" value="0">Bitte auswählen</option>';

                        # alle Filmgesellschaften nach Name sortiert für das Auswahlfeld
                        $sql = "SELECT * FROM category ORDER BY name";
                        $result = mysqli_query($conn, $sql);
                        while ($datensatz = mysqli_fetch_assoc($result)) {

                            # vorausgewählte Filmgesellschaft
                            if ($category_id == $datensatz["id"]) {

                                $selected = "selected";
                            } else {
                                $selected = "";
                            }

                            echo "<option $selected class=\"form_option\" value=\"${datensatz["id"]}\">${datensatz["name"]}</option>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </select>
                    <label class="form_label" for="status_id">Status *</label>
                    <select class="form_input_select" name="status_id" id="status_id">
                        <?php
                        # erstes Auswahlfeld, um eine Auswahl zu erzwingen
                        echo '<option class="form_option" value="0">Bitte auswählen</option>';

                        # alle Kategorien nach Name sortiert für das Auswahlfeld
                        $sql = "SELECT * FROM status ORDER BY name";
                        $result = mysqli_query($conn, $sql);
                        # dropdown Menü mit Schleife erstellen
                        while ($datensatz = mysqli_fetch_assoc($result)) {

                            # vorher ausgewählte Kategorie
                            if ($status_id == $datensatz["id"]) {

                                $selected = "selected";
                            } else {
                                $selected = "";
                            }

                            echo "<option $selected class=\"form_option\" value=\"${datensatz["id"]}\">${datensatz["name"]}</option>";
                        }
                        mysqli_free_result($result);
                        ?>
                    </select>
                </section>

                <!-- restliches Formular -->
                <section id="section_input">

                    <label class="form_label" for="name">Werkzeug-/Gerätename *</label>
                    <input class="form_input" type="text" name="name" id="name" maxlength="50" value="<?php echo str_replace("\"", "&quot;", $name); ?>">

                    <label class="form_label" for="description">Beschreibung (max. 750 Zeichen)</label>
                    <textarea class="form_text" name="description" id="description"><?php echo $description; ?></textarea>

                    <label class="form_label" for="year">Jahr</label>
                    <input class="form_input" type="text" name="year" id="year" maxlength="4" value="<?php echo $year; ?>">

                    <label class="form_label" for="link">Link zu weiterführenden Info</label>
                    <input class="form_input" type="text" name="link" id="link" maxlength="450" value="<?php echo $link; ?>">

                    <label class="form_label" for="requirements">Anforderungen (z.B. Führerschein, Batterien o.Ä.)</label>
                    <input class="form_input" type="text" name="requirements" id="requirements" maxlength="500" value="<?php echo $requirements; ?>">

                    <label class="form_label" for="owner_id">Mitgliedsnummer (fünfstellig) *</label>
                    <input class="form_input" type="text" name="owner_id" id="owner_id" maxlength="5" value="<?php echo $owner_id; ?>">

                    <label class="form_label" for="picture">Bild</label>
                    <input class="form_input" type="text" name="picture" id="picture" maxlength="150" value="<?php echo $picture; ?>">

                </section>

                <!-- versteckte Felder für ID -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <section id="section_submit">

                    <button class="form_button" type="submit" name="button" value="speichern">Speichern</button>
                    <button class="form_button_right" type="button" name="button" value="abbrechen" onClick="window.location.href = 'toollist.php';">Abbrechen</button>

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