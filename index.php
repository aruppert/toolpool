<?php

# Datenbankverbindung einbinden
require("dbconn.php");

# Nur PHP Fehler anzeigen, keine Kommentare
error_reporting(E_ALL ^ E_NOTICE);


# URL-Parameter holen
$category = substr(@$_GET["category"], 0, 5);
$order = substr(@$_GET["order"], 0, 4);
$status = substr(@$_GET["status"], 0, 1);


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
            <h1><a href="index.php">🛠 ToolPool</a></h1>

            <!-- Nav -->
            <nav id="nav">
                <ul>
                    <?php
                    # Nav erstellen mit Kategorien
                    # alle Kategorien nach Name sortiert
                    $sql = "SELECT * FROM category ORDER BY name";
                    $result = mysqli_query($conn, $sql);
                    while ($datensatz = mysqli_fetch_assoc($result)) {
                        # stimmt die geklickte Kategorie überein, hervorheben
                        if ($category == $datensatz["id"]) {
                            $highlighted = "current";
                        } else {
                            $highlighted = "";
                        }

                        echo "<li class=\"$highlighted\"><a href=\"${_SERVER["SCRIPT_NAME"]}?category=${datensatz["id"]}&order=$order\">${datensatz["name"]}</a></li>";
                    }
                    mysqli_free_result($result);

                    ?>
                </ul>
            </nav>

            <!-- Banner -->
            <section id="banner" class="tools">
                <header>
                    <h2>Werkzeug für alle</h2>
                    <p>Community-based shared economy</p>
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
                                <button onClick="window.location.href = 'admin/index.php?next=list';"> Tool Liste anzeigen 🛠📝 </button>
                                <button onClick="window.location.href = 'admin/index.php?next=form';"> Eigenes Werkzeug / Gerät anbieten 🛠➕ </button>
                                <button onClick="window.location.href = 'admin/index.php?next=memb';"> Mitgliederansicht 🔑 </button>
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

                                    echo "<li class=\"\"><a href=\"${_SERVER["SCRIPT_NAME"]}?category=$category&order=ASC&status=$status\">A-Z</a></li>";
                                    echo "<li class=\"\"><a href=\"${_SERVER["SCRIPT_NAME"]}?category=$category&order=DESC&status=$status\">Z-A</a></li>";


                                    # Filter nach Verfügbarkeit
                                    $sql = "SELECT * FROM status ORDER BY name";
                                    $result = mysqli_query($conn, $sql);
                                    # mögliche Verfügbarkeiten als Filteroptionen anzeigen lassen
                                    while ($datensatz = mysqli_fetch_assoc($result)) {
                                        # ausgewählte Verfügbarkeit hervorheben
                                        if ($status == $datensatz["id"]) {
                                            $highlighted = "current";
                                        } else {
                                            $highlighted = "";
                                        }

                                        echo "<li class=\"$highlighted\"><a href=\"${_SERVER["SCRIPT_NAME"]}?category=$category&order=$order&status=${datensatz["id"]}\">${datensatz["name"]}</a></li>";
                                    }
                                    mysqli_free_result($result);

                                    # kein Filter = alle anzeigen
                                    echo "<li class=\"\"><a href=\"${_SERVER["SCRIPT_NAME"]}?category=$category&order=$order&status=\">Alle anzeigen</a></li>";

                                    ?>
                                </ul>
                            </nav>
                            <header class="major">
                                <h2>Meine Auswahl</h2>
                            </header>
                            <div class="row">
                                <!-- ein Eintrag -->
                                <?php

                                # wurde ein Status-Filter ausgewählt ?
                                if (is_numeric($status)) {
                                    $status_filter = "status_id = $status";
                                } else {
                                    $status_filter = "";
                                }

                                # wurde eine Kategorie ausgewählt? 
                                if (is_numeric($category)) {
                                    $category_filter = "category_id = $category";
                                } else {
                                    $category_filter = "";
                                }

                                # wurde beides ausgewählt?
                                if (is_numeric($status) && is_numeric($category)) {
                                    $and = "AND";
                                } else {
                                    $and = "";
                                }

                                # SQL mit Hilfe der drei Variablen vorher kreieren 
                                if (is_numeric($status) || is_numeric($category)) {
                                    $sql = "SELECT * FROM tool WHERE $category_filter $and $status_filter ORDER BY name $order";
                                } else {
                                    $sql = "SELECT * FROM tool ORDER BY name $order";
                                }

                                $result = mysqli_query($conn, $sql);
                                # Ergebnisse ausgeben
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
                                						<a href=\"#\" class=\"image featured\"><img src=\"toolpics/$picture\" alt=\"$name\" /></a>
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