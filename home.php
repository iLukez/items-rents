<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$sql = "SELECT * FROM rents R
        JOIN items I ON R.item = I.id
        JOIN centers C ON I.center = C.id
        WHERE user = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylesheet/default.css">
    <link rel="stylesheet" href="stylesheet/nav.css">
    <title>Home</title>
</head>
<body>
    <?php include 'nav.php' ?>

    <h2>Noleggi utente: <?php echo $username ?></h2>
    <table>
        <tr>
            <th>Tipo</th>
            <th>Nome oggetto</th>
            <th>Produttore/Autore</th>
            <th>Centro</th>
            <th>Cod. Inventario</th>
            <th>Data</th>
            <th>Azione</th>
        </tr>
        <?php 
        if ($result->num_rows == 0) {
            echo "<tr><td colspan='7' id='no-rents'>Nessun noleggio in corso per l'utente</td></tr>";
            echo "</table>";
            echo "<div style='text-align:center'><a id='no-rents-new-rent-button' href='new_rent.php'>Nuovo Noleggio</a></div>";
        }
        while ($row = $result->fetch_assoc()) {
            $date = date("d/m/Y", strtotime($row['date']));
            echo "<tr><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['center_name'] . "</td><td>" . $row['ci'] . "</td><td>" . $date . "</td><td><a href='delete_rent.php?rent_id=" . $row['rent_id'] . "&item_id=" . $row['item'] . "'>Fine Noleggio</a></td></tr>";
        }
        $_SESSION['new_rents'] = null;
        ?>
    </table>
</body>
</html>
