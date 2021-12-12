<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <style>
        a.sorted{
            color: orange;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Seznam místností</title>
</head>
<body class="container">
    <h1>Seznam místností</h1>
    <?php
    include_once("./includes/db_connect.php");


    $orderBy = "name ASC";

    $poradi = $_GET['poradi'] ?? "";

    $poradi_arr = explode('_', $poradi);
    // var_dump($poradi_dir);

    if(count($poradi_arr) === 2){
        switch($poradi_arr[0]){
            case "cislo":{
                $orderBy = "no ";
                break;
            }
            case "nazev":{
                $orderBy = "name ";
                break;
            }
            case "telefon":{
                $orderBy = "phone ";
                break;
            }
            default : {
                $orderBy = "name";
                break;
            }
        }

        switch($poradi_arr[1]){
            case "up":{
                $orderBy .= " DESC";
                break;
            }
            case "down":{
                $orderBy .= " ASC";
                break;
            }
            default:{
                $orderBy .= " ASC";
                break;
            }
        }
    }
    $stmt = $pdo->query("SELECT * FROM `room` ORDER BY {$orderBy};");

    if ($stmt->rowCount() === 0) {
        echo "Záznam neobsahuje žádná data";
    } else {
        // echo "<table class='table'><tbody>";
        echo("<table class='table'>
        <thead>
            <tr>
                <th>Název
                    <a href='?poradi=nazev_down' " . (($poradi == 'nazev_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></a>
                    <a href='?poradi=nazev_up'  " . (($poradi == 'nazev_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></a>
                </th>
                <th>Číslo
                    <a href='?poradi=cislo_down'  " . (($poradi == 'cislo_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></a>
                    <a href='?poradi=cislo_up'  " . (($poradi == 'cislo_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></a>
                </th>
                <th>Telefon
                    <a href='?poradi=telefon_down'  " . (($poradi == 'telefon_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></a>
                    <a href='?poradi=telefon_up'  " . (($poradi == 'telefon_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></a>
                </th>
            </tr>
            </thead>
            <tbody>
        ");
        foreach($stmt as $row){
            echo "<tr><td><a href='./mistnost.php?mistnost={$row['room_id']}'>{$row['name']}</a></td><td>{$row['no']}</td><td>{$row['phone']}</td></tr>";
        }
    }

    echo "</table>"
    ?>
</body>
</html>