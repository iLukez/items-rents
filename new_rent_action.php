<?php
session_start();

if (isset($_POST['row'])) {
    //$_SESSION['new_rents'] = $_POST['row'];
    $servername = "localhost";
    $svusername = "root";
    $svpassword = "";
    $dbname = "rent";

    $conn = new mysqli($servername, $svusername, $svpassword, $dbname);

    foreach ($_POST['row'] as $item_id) {
        $sql = "INSERT INTO rents (user, item) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_SESSION['user_id'], $item_id);
        $stmt->execute();

        $sql = "UPDATE items SET state = 'rented' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
    }
    header("Location: home.php");
}
else {
    header("Location: new_rent.php");
}