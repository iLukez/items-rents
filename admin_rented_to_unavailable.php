<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    echo "<alert>id: $id</alert>";

    // Elimino il record contenente l'oggetto dalla tabella rents
    $sql = "DELETE FROM rents WHERE item = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Rendo NON DISPONIBILE l'oggetto

    $sql = "UPDATE items SET state = 'unavailable' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin_unavailable_resource.php?center=". $_GET['center'] . "&orderBy=\"type\"");