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
    <link rel="stylesheet" href="stylesheet/admin_unavailable.css">
    <title>Modifica Disponibilità</title>
</head>
<body>
    <?php include 'admin_nav.php' ?>
    <h2>Modifica Disponibilità</h2>
    <p id="info">Da questa pagina puoi ottenere una lista di tutti gli oggetti di un determinato centro (ordinati secondo il parametro desiterato) <br>e modificare il loro stato, che può essere DISPONIBILE, NOLEGGIATO o NON DISPONIBILE</p>

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
        
    <div id="legend-container">
        <h3 style="color:#fff;text-decoration:underline">LEGENDA:</h3>
        <p class="legend"><span class="available">DISPONIBILE</span>: Oggetto disponibile al noleggio</p>
        <p class="legend"><span class="rented">NOLEGGIATO</span>: Oggetto attualmente noleggiato</p>
        <p class="legend"><span class="unavailable">NON DISPONIBILE</span>: Oggetto non noleggiato e non disponibile al noleggio</p>
    </div>

<?php

if(isset($_GET["center"])) {
    $center_id = $_GET["center"];

    echo "<h3 id='available-table-title'>Lista oggetti DISPONIBILI nel centro scelto<br>Puoi cambiare il loro stato a \"NON NOLEGGIABILE\"</h3>";

    // LISTA DEGLI OGGGETTI DISPONIBILI

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
        echo "<table><tr id='available-table-head-row'> 
        <th>MODIFICA</th>
        <th>". ($_GET["orderBy"] == "type" ? "🠗 " : "") . "Tipo</th>
        <th>". ($_GET["orderBy"] == "name" ? "🠗 " : "") . "Nome Oggetto</th>
        <th>". ($_GET["orderBy"] == "maker" ? "🠗 " : "") . "Produttore/Autore</th>
        <th>Cod. Inventario</th>
        <th>Stato</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<td class='new-rent-button-container'><a href='admin_available_to_unavailable.php?id=". $row['id'] ."&center=". $_GET['center'] ."'>RENDI NON DISPONIBILE</a></td><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['ci'] . "</td><td class='available'>DISPONIBILE</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p id='new-rent-no-result' class='available'>Nessun articolo con stato \"DISPONIBILE\"</p>";
    }


    echo "<h3 id='rented-table-title'>Lista oggetti NOLEGGIATI nel centro scelto<br>Puoi cambiare il loro stato a \"NON NOLEGGIABILE\", ma così facendo eliminerai l'attuale noleggio</h3>";

    // LISTA DEGLI OGGGETTI NOLEGGIATI

    $sql = "SELECT * FROM users 
    JOIN rents ON users.id = rents.user
    JOIN items ON items.id = rents.item
    WHERE items.center = ? AND items.state = 'rented' ";

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
        echo "<table><tr id='rented-table-head-row'> 
        <th>MODIFICA</th>
        <th>Utente</th>
        <th>Data Noleggio</th>
        <th>". ($_GET["orderBy"] == "type" ? "🠗 " : "") . "Tipo Oggetto</th>
        <th>". ($_GET["orderBy"] == "name" ? "🠗 " : "") . "Nome Oggetto</th>
        <th>". ($_GET["orderBy"] == "maker" ? "🠗 " : "") . "Produttore/Autore</th>
        <th>Cod. Inventario</th>
        <th>Stato</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            $date = date("d/m/Y", strtotime($row['date']));
            echo "<td class='new-rent-button-container'><a href='admin_rented_to_unavailable.php?id=". $row['id'] ."&center=". $_GET['center'] ."'>RENDI NON DISPONIBILE</a></td><td>" . $row['email'] . "</td><td>" . $date . "</td><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['ci'] . "</td><td class='rented'>NOLEGGIATO</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p id='new-rent-no-result' class='rented'>Nessun articolo con stato \"NOLEGGIATO\"</p>";
    }



    echo "<h3 id='unavailable-table-title'>Lista oggetti NON NOLEGGIABILI nel centro scelto<br>Puoi cambiare il loro stato a \"DISPONIBILE\", rendendoli di nuovo disponibili</h3>";

    // LISTA DEGLI OGGGETTI NON NOLEGGIABILI

    $sql = "SELECT * FROM items WHERE center = ? AND state = 'unavailable' ";

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
        echo "<table><tr id='unavailable-table-head-row'> 
        <th>MODIFICA</th>
        <th>". ($_GET["orderBy"] == "type" ? "🠗 " : "") . "Tipo Oggetto</th>
        <th>". ($_GET["orderBy"] == "name" ? "🠗 " : "") . "Nome Oggetto</th>
        <th>". ($_GET["orderBy"] == "maker" ? "🠗 " : "") . "Produttore/Autore</th>
        <th>Cod. Inventario</th>
        <th>Stato</th> </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<td class='new-rent-button-container'><a href='admin_unavailable_to_available.php?id=". $row['id'] ."&center=". $_GET['center'] ."'>RENDI DISPONIBILE</a></td><td>" . $row['type'] . "</td><td>" . $row['item_name'] . "</td><td>" . $row['maker'] . "</td><td>" . $row['ci'] . "</td><td class='unavailable'>NON DISPONIBILE</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p id='new-rent-no-result' style='margin:50px' class='unavailable'>Nessun articolo con stato \"NON NOLEGGIABILE\"</p>";
    }

} else {
    echo "<p id='new-rent-not-selected'>Seleziona un centro e consulta gli oggetti disponibili al noleggio</p>";
}
?>

</body>
</html>