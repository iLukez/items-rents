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
    <link rel="stylesheet" href="stylesheet/home.css">
    <link rel="stylesheet" href="stylesheet/nav.css">
    <title>Home</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="new_rent.php">Noleggi disponibili</a></li>
            <li><a href="#">WIP</a></li>
            <li><a href="#">WIP</a></li>
        </ul>
    </nav>

    <h2>Noleggi utente: <?php echo $username ?></h2>
    <table>
        <tr>
            <th>Tipo</th>
            <th>Nome oggetto</th>
            <th>Produttore/Autore</th>
            <th>Centro</th>
            <th>Cod. Inventario</th>
            <th>Data</th>
        </tr>
        <?php 
        while ($row = $result->fetch_assoc()) {
            $date = date("d/m/Y - H:i", strtotime($row['date']));
            echo "<tr><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['center_name'] . "</td><td>" . $row['ci'] . "</td><td>" . $date . "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
