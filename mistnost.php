<?php
include_once("./includes/db_connect.php");

$mistnostID = filter_input(INPUT_GET, 'mistnost', FILTER_VALIDATE_INT);

if (!$mistnostID) {
    include "404.php";
    exit();
}

$stmt = $pdo->prepare("SELECT room_id,r.no as roomNumber,  r.name as roomName, r.phone as roomPhone, e.name as jmeno, e.surname as prijmeni 
FROM `room` AS r 
INNER JOIN `key` as k ON r.room_id = k.room 
INNER JOIN `employee` as e ON k.employee = e.employee_id 
WHERE r.room_id = ?; ");
$stmt->execute([$mistnostID]);
$row = $stmt->fetch();

if (!$row) {
    include "404.php";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <title>Karta místnosti <?php echo $row['roomName']; ?></title>
</head>

<body class="container">
    <?php


$stmtplat = $pdo->prepare("SELECT ROUND(AVG(wage),2) as plat FROM employee WHERE employee.room = ?");
$stmtplat->execute([$mistnostID]);

$stmtosoba = $pdo->prepare("SELECT employee.wage,employee.surname,CONCAT(LEFT(employee.name, 1),'.') as nameshort,employee_id FROM employee WHERE employee.room = ?");
$stmtosoba->execute([$mistnostID]);




        echo "<h1>Karta Místnosti č.: ";
        echo $row['roomNumber']  ."</h1><dl class='dl-horizontal'>";

        echo "<dt>Číslo</dt>";
        echo "<dd>{$row['roomNumber']}</dd>";
        echo "<dt>Název</dt>";
        echo "<dd>{$row['roomName']}</dd>";
        echo "<dt>Telefon</dt>";
        echo "<dd>{$row['roomPhone']}</dd>";
        echo "<dt>Lidé</dt>";
        echo "<dd>Dodělat...</dd>";
        echo "<dt>Průměrná mzda</dt>";
        $plat = $stmtplat->fetch();
        echo "<dd>" . $plat['plat'] . "</dd>";
        echo "<dt>Klíče</dt>";
        foreach($stmt as $roww){
            echo ("<dd><a href='/clovek.php?clovekID=".$roww['clovekID']."'>" . $roww['jmeno'] ." ". $roww['prijmeni'] ."</a><br /></dd>");
        }
        echo "</dl><br />";
    ?>

    <a href="/mistnosti.php"><i class="bi bi-arrow-left"></i>Zpět na stránku místností</a>
</body>

</html>