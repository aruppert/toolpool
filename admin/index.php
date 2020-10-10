<?php

# Datenbankverbindung einbinden
include("../dbconn.php");

# Nur PHP Fehler anzeigen, keine Kommentare
error_reporting(E_ALL ^ E_NOTICE);



# Daten empfangen und in Variablen speichern 
$next = @$_REQUEST["next"];
$email = @$_POST["email"];
$password = @$_POST["password"];
$button = @$_POST["button"];

# Logindaten prüfen und verarbeiten
# wurde Button geklickt?
if ($button) {
    # Daten über User anhand der email aus der DB holen
    $sql = "SELECT * FROM member WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $datensatz = mysqli_fetch_assoc($result);

    # ausgewählte Daten speichern 
    $user_email = $datensatz["email"];
    $user_password = $datensatz["password"];
    $user_id = $datensatz["id"];
    $user_last_name = $datensatz["last_name"];
    $user_first_name = $datensatz["first_name"];
    $user_district = $datensatz["district"];
    $user_zip_code = $datensatz["zip_code"];
    $user_city = $datensatz["city"];




    # Prüfung des Login Vorgangs
    # Passwort überprüfenund 
    if ($user_email == $email && password_verify($password, $user_password)) {
        # Session starten 
        session_start();

        # Session Variablen mit Daten aus db speichern
        $_SESSION["user_id"] = $user_id;
        $_SESSION["user_email"] = "$user_email";
        $_SESSION["user_last_name"] = "$user_last_name";
        $_SESSION["user_first_name"] = "$user_first_name";
        $_SESSION["user_district"] = "$user_district";
        $_SESSION["user_zip_code"] = $user_zip_code;
        $_SESSION["user_city"] = "$user_city";
        $_SESSION["loggedin"] = true;


        # Weiterleitung kreieren, abhängig vom next Parameter
        switch ($next) {
            case "list":
                $forward = "toollist.php";
                break;
            case "form":
                $forward = "toolform.php";
                break;
            case "memb":
                $forward = "../member.php";
                break;
            default:
                $forward = "toollist.php";
        }
        header("Location: $forward");
    } else {

        $meldung = "Login nicht korrekt";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">

</head>

<body>

    <div class="border">
        <h1>Login ToolPool</h1>
    </div>

    <div id="content" class="border">

        <p class="fehler"><?php if (isset($meldung)) echo $meldung; ?></p>

        <div id="formular">

            <form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post">

                <section id="section_input">
                    <label class="form_label" for="email">Email</label>
                    <input class="form_input_login" type="text" name="email" id="email">

                    <label class="form_label" for="password">Password</label>
                    <input class="form_input_login" type="password" name="password" id="password">
                </section>
                <input type="hidden" name="next" value="<?php echo $next; ?>">
                <section id="section_input">
                    <button class="form_button" type="submit" name="button" value="Login">Login</button>
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