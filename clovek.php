<?php
include_once("./includes/db_connect.php");

// $clovekID = $_GET['clovek_id']
$clovekID = filter_input(INPUT_GET, 'clovek_id', FILTER_VALIDATE_INT);

if (!$clovekID) {
    include "404.php";
    exit();
}

$stmt = $pdo->prepare("SELECT e.name as jmeno, e.surname as prijmeni, e.job, e.wage, r.name as `room_name`, r2.name as `jmeno_klice`, r2.room_id 
FROM employee AS `e` 
Inner join room as `r` on (e.room = r.room_id) 
Inner join `key` as `k` on (k.employee = e.employee_id) 
Inner join room as r2 on (k.room = r.room_id) 
WHERE e.employee_id = ?; ");
$stmt->execute([$clovekID]);
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
    <title>Karta osoby <?php echo $row['prijmeni'] . " " . substr($row['jmeno'], 0,1) . "."; ?></title>
</head>

<body class="container">
    <?php
        echo "<h1>Karta osoby: <em>";
        echo $row['prijmeni'] . " " . substr($row['jmeno'], 0,1) . ".</em></h1><dl class='dl-horizontal'>";

        echo "<dt>Jméno</dt>";
        echo "<dd>{$row['jmeno']}</dd>";
        echo "<dt>Příjmení</dt>";
        echo "<dd>{$row['prijmeni']}</dd>";
        echo "<dt>Pozice</dt>";
        echo "<dd>{$row['job']}</dd>";
        echo "<dt>Mzda</dt>";
        echo "<dd>{$row['wage']}</dd>";
        echo "<dt>Místnost</dt>";
        echo "<dd><a>{$row['room_name']}</a></dd>";
        echo "<dt>Klíče</dt>";
        foreach($stmt as $roww){
            echo ("<dd><a href='/mistnost.php?mistnost=".$roww['room_id']."'>" . $roww['jmeno_klice'] . "</a><br /></dd>");
        }
        echo "</dl><br />";
    ?>

    <a href="/zamestnanci.php"><i class="bi bi-arrow-left"></i>Zpět na stránku zaměstnanců</a>
</body>

</html>