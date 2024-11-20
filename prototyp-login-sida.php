<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <title>Login</title>
</head>
<body>
    <!-- Header -->
    <header>
        <p>Mölndals Vårdcentral</p>
        <span class="material-symbols-outlined">search</span> <!--Sökfunktions ikon-->

        <nav>
            <ul>
                <li>
                    <a href="prototyp-login.php">Hem</a>
                </li>
                <li>
                    <a href="prototyp-login-sida.php" class="navigationcolor">Login</a>
                </li>
            </ul>
        </nav>
    </header>
    <div class="page-container">
        <h1 class="welcome">Välkommen</h1>
        <div class="container">

            <!-- Artiklar -->
            <div class="box">
                <div class="box-row">
                    <div class="box-cell box1">
                        <form method="POST" action="prototyp-login-sida.php">
                                <label> Personnummer
                                    <input type="text" name="login">
                                </label>
                            <input type="submit">
                        </form>
                        <?php

                            // SQL uppkoppling
                            $pdo = new PDO("mysql:dbname=grupp4;host=localhost", "sqllab", "Hare#2022");
                            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                            if (isset($_POST["login"])) {

                                //sql fråga för att fråga om det finns en patient i databasen med det personnumret
                                $sql = 'SELECT * FROM Patient WHERE PNR = :ulogin';
                                $stmt = $pdo->prepare($sql);
                                //binder parametern till sql frågan
                                $stmt->bindParam(':ulogin', $_POST["login"]);
                                $stmt->execute();

                                //hämtar raden
                                $patient = $stmt->fetch();

                                //om raden är satt och existerar körs koden
                                if ($patient) {
                                    echo "<div>";
                                    echo "<form method='POST' action='prototyp-login-sida.php'>";
                                    echo "<label> QR KOD VERIFIERA MED BANKID: ";
                                    echo "<input type='checkbox' name='verify'>";
                                    echo "</label>";
                                    echo "<input type='hidden' name='login_conf' value='1'>";
                                    echo "<input type='submit'>";
                                    echo "</form>";
                                    echo "</div>";

                                    $_SESSION["patient_namn_temp"] = $patient['NAMN'];
                                } else {
                                    //felmeddelande om något felaktigt skrivs in
                                    echo "<div class='start'><p>Felaktigt personnummer</p></div>";
                                }
                            }
                            if (isset($_POST["verify"])) {
                                //sessionen sätts till TRUE för att säga till de andra sidorna att de är inloggade
                                $_SESSION["loggedin"] = TRUE;
                                $_SESSION["patient_namn"] = $_SESSION["patient_namn_temp"];
                                unset($_SESSION["patient_namn_temp"]);
                                header('Location: minasidor.php'); //skickar personen till startsidan
                                exit();
                            } elseif (isset($_POST["login_conf"]) && !isset($_POST["verify"])) {
                                //felmeddelande om något felaktigt skrivs in
                                echo "<div class='start'><p>BANK ID FEL</p></div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div>
            <div>
                Adress:
                <address>
                  Adressgatan 90<br>
                  101 01 Mölndal
                </address>
            </div>
            <div>
                <span>Kontakt information:</span><br>
                <span>Telefon: 456 123 88 99</span><br>
                <span>Mejl: support@info.mail</span>
            </div>
            <div>
                Hittar du inte?<br>
                <span>Kolla in på våra vanliga frågor: <a href="">FAQ</a>!</span>
            </div>
        </div>
    </footer>
</body>
</html>