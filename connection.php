<?
// SQL uppkoppling
            $pdo = new PDO("mysql:dbname=grupp4;host=localhost", "sqllab", "Hare#2022");
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);