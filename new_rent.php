<?php
session_start();

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
    <form id="select-center-form" method="GET">
        <label for="center">Centro:</label>
        <select name="center" id="center">
            <option selected disabled>Seleziona un centro</option>
            <?php
            $sql = "SELECT * FROM centers";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['id'] . "\"" . ($_GET["center"] == $row["id"] ? " selected" : "") . ">" . $row['center_name'] . " - " . $row['address'] . "</option>";
            }
            ?>
        </select>

        <label for="orderBy">Ordina per:</label>
        <select name="orderBy" id="orderBy">
            <option value="name" selected>Nome</option>
            <option value="maker">Autore / Produttore</option>
            <option value="type">Tipo</option>
        </select>

        <input id="select-center-submit" type="submit">
    </form>

    

<?php

if(isset($_GET["center"])) {
    $center_id = $_GET["center"];

    echo "<h3 id='new-rent-table-title'>Articoli disponibili</h3>";

    $sql = "SELECT * FROM items WHERE center = ?  AND state = 'available' ";
    if ($_GET["orderBy"] == "type") {
        $sql .= "ORDER BY type";
    }
    else if ($_GET["orderBy"] == "name") {
        $sql .= "ORDER BY item_name";
    }
    else if ($_GET["orderBy"] == "maker") {
        $sql .= "ORDER BY maker";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $center_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<form method='POST' action='new_rent_action.php'>";
        echo "<table><tr> 
        <th>NOLEGGIA</th>
        <th>". ($_GET["orderBy"] == "type" ? "🠗 " : "") . "Tipo</th>
        <th>". ($_GET["orderBy"] == "name" ? "🠗 " : "") . "Nome Oggetto</th>
        <th>". ($_GET["orderBy"] == "maker" ? "🠗 " : "") . "Produttore/Autore</th>
        <th>Cod. Inventario</th>
        <th>Stato</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<td class='new-rent-button-container'><input class='new-rent-checkbox' type='checkbox' name='row[]' value='" . $row['id'] . "'></input></td><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['ci'] . "</td><td class='available'>DISPONIBILE</td></tr>";
        }
        echo "</table>";
        echo "<input id ='add-rent-button' type='submit' value='Noleggia oggetti selezionati'></input>";
        echo "</form>";
    } else {
        echo "<p id='new-rent-no-result'>Nessun articolo disponibile, prova con un altro centro</p>";
    }
} else {
    echo "<p id='new-rent-not-selected'>Seleziona un centro e consulta gli oggetti disponibili al noleggio</p>";
}
?>

</body>
</html>
