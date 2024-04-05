<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Aggiungi un oggetto</title>
    <link rel="stylesheet" href="stylesheet/default.css">
    <link rel="stylesheet" href="stylesheet/admin_home.css">
    <link rel="stylesheet" href="stylesheet/nav.css">
    <link rel="stylesheet" href="stylesheet/admin_new_resource.css">
</head>
<body>
    <?php include 'admin_nav.php' ?>
    <h1>Nuovo oggetto</h1>
    <form method="post" action="admin_add_item.php" onsubmit="return validateCI()">
        <label for="type">Tipo:</label>
        <input type="text" id="type" name="type" required><br>

        <label for="item_name">Nome:</label>
        <input type="text" id="item_name" name="item_name" required><br>

        <label for="maker">Autore / Produttore:</label>
        <input type="text" id="maker" name="maker" required><br>

        <label for="center">Centro:</label>
        <select name="center" id="center">
            <option selected disabled>Seleziona un centro</option>
            <?php
            $sql = "SELECT * FROM centers";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value=" . $row['id'] . ">" . $row['center_name'] . " - " . $row['address'] . "</option>";
            }
            ?>
        </select><br>

        <label for="ci">CI:</label>
        <input type="text" id="ci" name="ci" required minlength="6" maxlength="6"><br>

        <input type="submit" value="Aggiungi Oggetto">
    </form>

    <?php
    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        echo "<p id='admin-success'>Oggetto aggiunto con successo!</p>";
    }
    elseif (isset($_GET['success']) && $_GET['success'] == 'ci_exists') {
        echo "<p id='admin-error'>Errore: Il CI inserito è già presente nel database, riprova!</p>";
    }
    ?>

    <script>
        function validateCI() {
            var ciInput = document.getElementById("ci").value;
            var numbers = /^[0-9]+$/;
            if (!ciInput.match(numbers)) {
                alert("Il CI deve contenere solo numeri!");
                return false;
            }
            return true;
        }
    </script>
    
</body>
</html>
