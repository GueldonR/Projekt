<?php
    session_start();
    session_destroy(); //förstör sessionen för att logga ut personen
    header('Location: prototyp-login.php'); //skickar personen tillbaka till login sidan efter att loggat ut