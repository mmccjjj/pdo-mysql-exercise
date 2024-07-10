<?php
/*
    INCLUDE DATABASE CONNECTION
*/
include('utils/db.php');

/*
    SCHREIBE HIER DIE QUERIES
    Speichere diese immer in der Variable $queryString ab
    Bsp: SELECT * FROM books
*/

//FILTER

// Alle Bücher
$abfrage1= "SELECT * FROM books";

// Bücher auf 10 Einträge limitiert
$abfrage2= "SELECT * FROM books LIMIT 10";

// Bücher ab id 25 auf 10 Einträge limitiert
$abfrage3= "SELECT * FROM books WHERE id >= 25 LIMIT 10";

// Nur Buch mit ID 25 anzeigen
$abfrage4= "SELECT * FROM books WHERE id = 25";

// Nur englische Bücher
$abfrage5= "SELECT * FROM books WHERE language = 'english'";

// Nur nicht englische Bücher
$abfrage6= "SELECT * FROM books WHERE language != 'english'";

// Alle Bücher von Stephen King
$abfrage7= "SELECT * FROM books WHERE author = 'Stephen King'";

// Alle Bücher die weniger als 500 mal verkauft wurden
$abfrage8= "SELECT * FROM books WHERE sold_copies < 500";

// Alle Bücher die mehr als 800 mal verkauft wurden oder auf französisch sind
$abfrage9= "SELECT * FROM books WHERE sold_copies > 800 or language = 'französisch'";

// Alle Bücher die mehr als 500 mal verkauft wurden und auf englisch sind oder weniger als 400 mal verkauft wurden
$abfrage10= "SELECT * FROM books WHERE language = 'english' and sold_copies > 500 or sold_copies < 400";

// Alle Bücher die kein Publikationsdatum haben
$abfrage11= "SELECT * FROM books WHERE published_at is NULL";

// Alle Bücher die nach 1900 aber vor 1950 publiziert wurden
$abfrage12= "SELECT * FROM books WHERE published_at between '1900-01-01' and '1950-12-31'";

// Alle Bücher die im April publiziert wurden
$abfrage13= "SELECT * FROM books WHERE published_at like '%-04-%'";

// Alle Bücher die älter als 100 jahre alt sind
$abfrage14= "SELECT * FROM books WHERE published_at < '1924-07-10'";

// Alle Bücher die ein Rating zwischen 3 und 5 haben
$abfrage15= "SELECT * FROM books WHERE rating between 3 and 5";

// Alle Bücher mit "the" im Titel
$abfrage16= "SELECT * FROM books WHERE title like '%the%'";

// Alle Bücher die "the" nicht im subtitel haben
$abfrage17= "SELECT * FROM books WHERE subtitle not like '%the%'";

// Alle Bücher bei welchen der Autor einen Punkt im Namen hat
$abfrage18= "SELECT * FROM books WHERE author like '%.%'";

//SORTIERUNG

// Nach verkauften exemplaren (DESC/ absteigend)
$sortieren1= "SELECT * FROM books ORDER BY sold_copies DESC";

// Nach verkauften exemplaren (ASC/ aufsteigend)
$sortieren2= "SELECT * FROM books ORDER BY sold_copies ASC";

// Bücher aufsteigend nach Publikationsdatum - Bücher ohne Datum am Schluss (die abfrage "IS NULL" gibt den wert true (1) aus wenn es zutrifft und wird bei absteigender sortierung drum ans ende gesetzt)
$sortieren3= "SELECT * FROM books ORDER BY published_at IS NULL, published_at ASC";

// Zuhafällig
$sortieren2= "SELECT * FROM books ORDER BY sold_copies ASC";


$queryString = $sortieren3;



/*
    DATEN
    Hier kannst Du Platzhalter im Query mit Daten füllen
    Bsp: ':id' => 1
*/

$data = [];



/*
    DER QUERY WIRD AUSGEFÜHRT
    Die verschiedenen Schritte für PDO
*/

try{

    // überprüfe, ob Abfrage vorhanden ist
    if($queryString == ''){
        throw new \Exception('keine Abfrage in $queryString vorhanden');
    }

    // bereite die Abfrage vor
    $query = $dbConn->prepare($queryString);

    // füge Daten für Platzhalter ein, falls vorhanden
    $query->execute($data);

    // überprüfe, ob Daten zurück gegeben werden
    if($query->rowCount() == 0) {
        throw new \Exception('Deine Abfrage gibt keine Daten zurück');
    }

    // alle Daten werden aus der DB geholt und in einem assoziativen Array gespeichert
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    

} catch (PDOException $e) {
    die("Fehler: " . $e->getMessage());
}

catch (\Exception $e) {
    die("Fehler: " . $e->getMessage());
}
