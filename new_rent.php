<?php

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/nav.css">
    <link rel="stylesheet" href="stylesheet/default.css">
    <link rel="stylesheet" href="stylesheet/new_rent.css">
    <title>New Rent</title>
</head>
<body>
    <?php include 'nav.php' ?>
    <h2>Nuovo Noleggio</h2>

    <?php
    
    ?>
    <form method="GET">
        <label for="center">Centro:</label>
        <select name="center" id="center">
            <option selected disabled>Seleziona un centro</option>
            <?php
            $sql = "SELECT * FROM centers";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['id'] . "\">" . $row['center_name'] . " - " . $row['address'] . "</option>";
            }
            ?>
        </select>
        <input type="submit">
    </form>

    

<?php

if(isset($_GET["center"])) {
    $center_id = $_GET["center"];

    echo "<h3 id='new-rent-table-title'>Articoli disponibili</h3>";

    $stmt = $conn->prepare("SELECT * FROM items WHERE center = ?  AND state = 'available'");
    $stmt->bind_param("i", $center_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table><tr> <th>NOLEGGIA</th> <th>Tipo</th> <th>Nome Oggetto</th><th>Produttore/Autore</th><th>Cod. Inventario</th><th>Stato</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<td class='new-rent-button-container'><button class='new-rent-button'>NOLEGGIA</button></td><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['ci'] . "</td><td class='available'>DISPONIBILE</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p id='new-rent-no-result'>Nessun articolo disponibile, prova con un altro centro</p>";
    }
} else {
    echo "<p id='new-rent-not-selected'>Select a center and see the available items</p>";
}
?>

</body>
</html>
