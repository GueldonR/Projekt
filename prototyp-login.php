<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css" />

    <!--Sökfunktions ikon stylesheet-->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <title>Mölndals Vårdcentral</title>
</head>

<body>
    <!-- Header -->
    <header>
        <p>Mölndals </p>
        <span class="material-symbols-outlined">search</span> <!--Sökfunktions ikon-->

        <!-- Login knappen-->
        <div class="moment">
            <button popovertarget="my-popover">
                Login
            </button>
        </div>
    </header>
    <!-- Personnummers prompten -->
    <div id="my-popover" popover>
        <form method="POST" action="prototyp-login.php">
            <label> Personnummer
                <input type="text" name="login">
            </label>
            <input type="submit">
        </form>
    </div>

    <!-- Artikel fältet-->
    <div class="page-container">
        <h1 class="welcome">Välkommen</h1>
        <div class="container">

            <!-- Artiklar -->
            <div class="box">
                <div class="box-row">
                    <div class="box-cell box1">
                        Artikel 1
                    </div>

                    <div class="box-cell box2">
                        Artikel 2
                    </div>
                    <div class="box-cell box3">
                        Artikel 3
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