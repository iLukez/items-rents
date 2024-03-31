<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

if (isset($_GET["rent_id"]) && isset($_GET["item_id"])) {
    $rent_id = $_GET["rent_id"];
    $item_id = $_GET["item_id"];

    // Elimino il rent

    $stmt = $conn->prepare("DELETE FROM rents WHERE rent_id = ?");
    $stmt->bind_param("i", $rent_id);
    $stmt->execute();

    // Aggiorno lo stato dell'item, settandolo a "disponibile"

    $sql = "UPDATE items SET state = 'available' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
}

header("Location: home.php");