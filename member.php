<?php

# Datenbankverbindung einbinden
require("dbconn.php");

# Nur PHP Fehler anzeigen, keine Kommentare
error_reporting(E_ALL ^ E_NOTICE);

# Session beginnen 
session_start();

# Prüfen ob Client eingeloggt ist, sonst Script stoppen und folgendes zeigen
if (!isset($_SESSION["loggedin"])) {
    die('<h1>Anmeldung nötig</h1>
    <h2>Für diese Seite ist eine Anmeldung notwendig</h2>
    <a href="admin/index.php?next=memb">Hier anmelden</a> <br/>
     <a href="index.php">Zurück zur Hauptseite</a>');
}

# URL-Parameter holen
$order = substr(@$_GET["order"], 0, 4);

# Variablen mit Session Daten befüllt speichern
$user_id = $_SESSION["user_id"];
$user_last_name = $_SESSION["user_last_name"];
$user_first_name = $_SESSION["user_first_name"];
$user_zip = $_SESSION["user_zip_code"];
$user_district = $_SESSION["user_district"];
$user_city = $_SESSION["user_city"];


?>
<!DOCTYPE HTML>
<!--
	Dopetrope by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
    <title>ToolPool - don't be a Tool, use the Pool!</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="homepage is-preload">
    <div id="page-wrapper">

        <!-- Header -->
        <section id="header">

            <!-- Logo -->
            <h1><a href="index.php">ToolPool </a></h1>


            <!-- Banner -->
            <section id="banner" class="members">
                <header>
                    <h2>Willkommen <?php echo $user_first_name; ?> </h2>
                    <p>in deinem persönlichen Mitgliederbereich</p>
                </header>
            </section>


        </section>

        <!-- Main -->
        <section id="main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <section>
                            <header class="major">
                                <h2> Mitgliederbereich 🔐</h2>
                            </header>
                            <div>
                                <!-- Buttons als Links zum internen Bereich -->
                                <button onClick="window.location.href = 'admin/toollist.php';"> Tool Liste anzeigen 🛠📝 </button>
                                <button onClick="window.location.href = 'admin/toolform.php';"> Eigenes Werkzeug / Gerät anbieten 🛠➕ </button>
                                <button onClick="window.location.href = 'index.php';"> Toolansicht 🛠 </button>
                                <button onClick="window.location.href = 'admin/logout.php';"> Logout 🚪 </button>
                            </div>
                        </section>

                        <!-- Portfolio -->
                        <section>
                            <nav id="nav">
                                <ul>
                                    <?php
                                    # Sortierung und Filter Auswahl
                                    # Sortierung
                                    # Ergebnisse alphabetisch absteigend oder aufsteigend anzeigen lassen

                                    echo "<li class=\"\"><a href=\"${_SERVER["SCRIPT_NAME"]}?order=ASC\">A-Z</a></li>";
                                    echo "<li class=\"\"><a href=\"${_SERVER["SCRIPT_NAME"]}?order=DESC\">Z-A</a></li>";

                                    ?>
                                </ul>
                            </nav>

                            <?php
                            # individuelle Überschrift
                            echo ' <header class="major">';
                            echo " <h2>Pooler in deiner Nachbarschaft in $user_city, $user_district</h2>";
                            echo "</header>";
                            echo '<div class="row">';

                            # ein Eintrag

                            # Alle Mitglieder, ausser Eingeloggtes aus der Nachbarschaft (mit gleicher PLZ) anzeigen
                            # Daten holen
                            $sql = "SELECT * FROM member WHERE id != $user_id AND zip_code = $user_zip ORDER BY last_name $order";
                            $result = mysqli_query($conn, $sql);

                            # Ergebnisse ausgeben
                            while ($datensatz = mysqli_fetch_assoc($result)) {

                                # Variablen zur angenehmeren Weiterverarbeitung erstellen 
                                $nachname = $datensatz["last_name"];
                                $vorname = $datensatz["first_name"];
                                $email = $datensatz["email"];
                                $gender = $datensatz["gender"];

                                # Hintergrundfarbe der Nutzerkarten ändern je nach Geschlecht
                                switch ($gender) {
                                    case "F":
                                        $bg_color =  '#ffafd7';
                                        break;
                                    case "M":
                                        $bg_color =  '#add8e6';
                                        break;
                                    case "D":
                                        $bg_color =  '#fafad2';
                                        break;
                                }



                                echo "<div class=\"col-4 col-6-medium col-12-small\">
                                					<section class=\"box\"style=\"background-color:$bg_color\">
                                						
                                						<header>
                                							<h3>$nachname, $vorname</h3>
                                                        </header>
                                                        <h4>Email: $email </h4>
                                                       
                                						<footer>
                                							<ul class=\"actions\">
                                								<li><a href=\"\"   class=\"button alt\">Kontaktieren</a></li>
                                							</ul>
                                						</footer>
                                					</section>
                                				</div>";
                            }
                            mysqli_free_result($result);

                            ?>
                            <!-- Ende des Eintrags -->
                    </div>
                    <header class="major">
                        <h2>zusätliche Pooler in deiner Umgebung</h2>
                    </header>
                    <div class="row">
                        <!-- ein Eintrag -->
                        <?php

                        # Alle anderen Mitglieder aus der gleichen Stadt wie Eingeloggtes anzeigen
                        # Daten holen
                        $sql = "SELECT * FROM member WHERE zip_code != $user_zip AND city = '$user_city' ORDER BY last_name $order";
                        $result = mysqli_query($conn, $sql);
                        # Ergebnisse ausgeben
                        while ($datensatz = mysqli_fetch_assoc($result)) {

                            # Variablen zur angenehmeren Weiterverarbeitung erstellen 
                            $nachname = $datensatz["last_name"];
                            $vorname = $datensatz["first_name"];
                            $email = $datensatz["email"];
                            $district = $datensatz["district"];
                            $gender = $datensatz["gender"];

                            # Hintergrundfarbe der Nutzerkarten ändern je nach Geschlecht
                            switch ($gender) {
                                case "F":
                                    $bg_color =  '#ffafd7';
                                    break;
                                case "M":
                                    $bg_color =  '#add8e6';
                                    break;
                                case "D":
                                    $bg_color =  '#fafad2';
                                    break;
                            }


                            echo "<div class=\"col-4 col-6-medium col-12-small\">
                                					<section class=\"box\" style=\"background-color:$bg_color\">
                                					
                                						<header>
                                							<h3>$nachname, $vorname</h3>
                                                        </header>
                                                        <h4>Email: $email </h4>
                                                        <p>Wohnhaft in: $city, $district</p>
                                                       
                                						<footer>
                                							<ul class=\"actions\">
                                								<li><a href=\"\"   class=\"button alt\">Kontaktieren</a></li>
                                							</ul>
                                						</footer>
                                					</section>
                                				</div>";
                        }
                        mysqli_free_result($result);

                        ?>
                        <!-- Ende des Eintrags -->
                    </div>

        </section>

    </div>
    </div>
    </div>
    </section>

    <!-- Footer -->
    <section id="footer">
        <div class="container">
            <div class="row">
                <div class="col-4 col-6-medium col-12-small">
                    <section>
                        <header>
                            <h2>Werkzeuge im Wandel</h2>
                        </header>
                        <ul class="divided">
                            <li><a href="#">Interessanter Artikel folgt</a></li>

                        </ul>
                    </section>
                </div>
                <div class="col-4 col-6-medium col-12-small">
                    <section>
                        <header>
                            <h2>DIY - dein Leben, deine Hände</h2>
                        </header>
                        <ul class="divided">
                            <li><a href="#">Die besten Schritt-für-Schritt-Anleitungen</a></li>

                        </ul>
                    </section>
                </div>
                <div class="col-4 col-12-medium">
                    <section>
                        <header>
                            <h2>No Planet B</h2>
                        </header>
                        <ul class="social">
                            <li><a class="icon brands fa-facebook-f" href="#"><span class="label">Facebook</span></a></li>
                        </ul>
                    </section>
                </div>
                <div class="col-12">

                    <!-- Copyright -->
                    <div id="copyright">
                        <ul class="links">
                            <li>&copy; A. Ruppert. All rights reserved.</li>
                            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>