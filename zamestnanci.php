<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <!-- Bootstrap-->
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <style>
        a.sorted{
            color: orange;
        }
    </style>
    <title>Seznam zaměstnanců</title>
</head>
<body class="container">
    <h1>Seznam zaměstnanců</h1>
    <?php
    include_once("./includes/db_connect.php");
    // echo "a";

    $orderBy = "e.surname ASC";

    $poradi = $_GET['poradi'] ?? "";

    $poradi_arr = explode('_', $poradi);
    // var_dump($poradi_dir);

    if(count($poradi_arr) === 2){
        switch($poradi_arr[0]){
            case "prijmeni":{
                $orderBy = "e.surname ";
                break;
            }
            case "nazev":{
                $orderBy = "r.name ";
                break;
            }
            case "telefon":{
                $orderBy = "r.phone ";
                break;
            }
            case "pozice":{
                $orderBy = "e.job ";
                break;
            }
            default : {
                $orderBy = "e.surname";
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

    $stmt = $pdo->query("SELECT e.employee_id as `e_id`, e.name,e.surname, r.name as `room_name`, r.phone, e.job FROM `employee` e INNER JOIN room r ON e.room = r.room_id ORDER BY {$orderBy};");
    
    if ($stmt->rowCount() === 0) {
        echo "Záznam neobsahuje žádná data";
    } else {
        echo("<table class='table'>
        <thead>
            <tr>
                <th>Jméno
                    <a href='?poradi=prijmeni_down' " . (($poradi == 'prijmeni_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></span></a>
                    <a href='?poradi=prijmeni_up'  " . (($poradi == 'prijmeni_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></span></a>
                </th>
                <th>Mísnost
                    <a href='?poradi=nazev_down'  " . (($poradi == 'nazev_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></span></a>
                    <a href='?poradi=nazev_up'  " . (($poradi == 'nazev_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></span></a>
                </th>
                <th>Telefon
                    <a href='?poradi=telefon_down'  " . (($poradi == 'telefon_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></span></a>
                    <a href='?poradi=telefon_up'  " . (($poradi == 'telefon_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></span></a>
                </th>
                <th>Pozice
                    <a href='?poradi=poradi_down'  " . (($poradi == 'poradi_down') ? "class='sorted'" : '') . "><i class='bi bi-arrow-down'></i></span></a>
                    <a href='?poradi=poradi_up'  " . (($poradi == 'poradi_up') ? "class='sorted'" : '') . "><i class='bi bi-arrow-up'></i></span></a>
                </th>
            </tr>
            </thead>
            <tbody>
        ");
        foreach($stmt as $row){
            echo("
            <tr>
                <td><a href='/clovek.php?clovek_id={$row['e_id']}'>{$row['surname']} {$row['name']}</a></td>
                <td>{$row['room_name']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['job']}</td>
            </tr>");
        }
        echo "</tbody></table>";

    }

    unset($stmt);

    ?>
</body>
</html>