# Tool Pool

Playlist app with iTunes API in Vanilla JS

## Description

ToolPool enables registered users who live in the same area to share their (power) tools with each other for free in order to conserve global and individual resources and to create supportive, real-life relationships with neighbors 

## Motivation

Small project for the module “PHP & MySQL“ at [cimdata](https://www.cimdata.de/) where no PHP framework was allowed and comments on the code were mandatory. 

## Tech/framework highlights

<b>Built mainly with </b>

- PHP
- MySQL

with the use of the ‘dope trope template by HTML5 UP’ to focus exclusively on the named above

## Features

General:
- Get an overview of all tools in the pool
- Sort and filter tools by availability, name (ascending/descending) and category 

Members:
- Login site to access member area
- Welcome page with list of poolers in your neighborhood
- Additionally see all poolers in your city
- Tool list with all tools and edit options
- Form to add new tools to the pool
- Detail page to edit or delete a tool
- Special picture upload for existing tools

## Code Example

```
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
```
