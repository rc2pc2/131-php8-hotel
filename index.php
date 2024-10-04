<?php 
$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,
        'vote' => 4,
        'distance_to_center' => 10.4
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ],

];

// ! FILTRIAMO il nostro array di hotel:
    // * istanziamo un nuovo array filtrato come vuoto 
    // # controlliamo se ha il parcheggio oppure no 
        // % con un if che verifica se la checkbox con name parking sia on => preso dall'url $_GET
            // #  isset($_GET["parking"]) && $_GET["parking"] === "on" 
        // *

$filteredHotels;

if (isset($_GET["parking"]) && $_GET["parking"] === "on"){
    // var_dump("ho selezionato esclusivamente gli hotel con parcheggio");
    // ! voglio solo gli hotel con parcheggio
    $filteredHotels = [];

    // # per ogni hotels as hotel
    foreach ($hotels as $singleHotel){
        // % verifico che l'hotel su cui sto scorrendo abbia il parcheggio
        if ($singleHotel["parking"] == true){
            // # aggiungo l'hotel a filteredHotels
            $filteredHotels[] = $singleHotel;
        }
    }
} else {
    // var_dump("ho selezionato tutti gli hotel");
    $filteredHotels = $hotels;
    // $nina = "dnqiodbnqwid";
}

// ! controllo quale sia il numero che ho chiesto
if( isset($_GET["vote"]) && ($_GET["vote"] >= 1 && $_GET["vote"] <= 5 )){
    // * in base al numero che ho chiesto
    // # filtro i risultati a partire dal quel numero in poi >=
    $currentArray = [];

    foreach($filteredHotels as $singleHotel){
        // ? controllo che il dato sia <= al dato che e' presente nel singolo hotel
        if ($singleHotel["vote"] >= $_GET["vote"]){
            $currentArray[] = $singleHotel;
        }
    }

    $filteredHotels = $currentArray;
    // var_dump("voglio solo quelli con voto maggiore uguale di ". $_GET["vote"]);
}


// ! controllo che esista la chiave che sto per usare
if (isset($_GET["hotelName"]) && !empty($_GET["hotelName"])){
    // # prendo il dato inserito (hotelName)
    // % creo un nuovo array temporaneo dove inserire i dati filtrati
    $currentArray = [];

    // ! filtro l'array filtrato
    foreach ($filteredHotels as $singleHotel){ // % se il nome dell'hotel contiene la sottostringa della ricerca
        if (str_contains(strtolower($singleHotel["name"]), strtolower($_GET["hotelName"]))){
            $currentArray[] = $singleHotel;
        }
    }
    
    // % sovrascrivo l'array filtrato con quello nuovo
    $filteredHotels = $currentArray;
}

$parkingChecked = (isset($_GET["parking"]) && $_GET["parking"] === "on") ? "checked" : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 8 Hotel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <section class="row py-3">
            <div class="col-12">
                <h2 class="fw-bold text-center mb-3">
                    PHP Hotel
                </h2>
            </div>
            <div class="col-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Parcheggio</th>
                            <th>Voto</th>
                            <th>Distanza dal centro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ciclo -->
                        <?php foreach ($filteredHotels as $singleHotel) { ?>
                            <tr>
                                <td><?= $singleHotel["name"] ?></td>
                                <td><?= $singleHotel["description"] ?></td>
                                <td><?= ($singleHotel["parking"] == true) ? "presente" : "non presente"  ?></td>
                                <td><?= $singleHotel["vote"] ?></td>
                                <td><?= $singleHotel["distance_to_center"] ?></td>
                            </tr>
                        <!-- chiudo il ciclo -->
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <form action="index.php" method="GET" class="row justify-content-center">
                    <div class="mb-3 col-3  form-check">
                        <label for="parking" class="form-check-label">Parcheggio</label>
                        <input class="form-check-input" type="checkbox" name="parking" id="parking"
                                <?= $parkingChecked ?>>
                    </div>
                    <div class="mb-3 input-group col-3">
                        <span class="input-group-text">Voto</span>
                        <input class="form-control" type="number" name="vote" id="vote" min="0" max="5"
                            value="<?php if (isset($_GET["vote"])) echo $_GET["vote"] ?>" >
                    </div>
                    <div class="mb-3 input-group col-3">
                        <span class="input-group-text">Nome hotel</span>
                        <input class="form-control" type="text" name="hotelName" id="hotelName"
                            value="<?php if (isset($_GET["hotelName"])) echo $_GET["hotelName"] ?>" >
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-sm btn-primary">Cerca</button>
                        <button type="reset" class="btn btn-sm btn-warning">Pulisci i dati</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
</body>
</html>