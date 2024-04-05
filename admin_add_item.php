<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

// Get the item details from the form
$name = $_POST['item_name'];
$maker = $_POST['maker'];
$center = $_POST['center'];
$ci = $_POST['ci'];
$type = $_POST['type'];

// Check if $ci already exists in the "items" table
$checkSql = "SELECT * FROM items WHERE ci = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("s", $ci);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    header("Location: admin_new_resource.php?success=ci_exists");
    exit;
}

// SQL Prepared Statement
$sql = "INSERT INTO items (type, item_name, maker, center, ci, state) VALUES (?, ?, ?, ?, ?, 'available')";
$stmt = $conn->prepare($sql);

$stmt->bind_param("sssss", $type, $name, $maker, $center, $ci);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: admin_new_resource.php?success=true");
} else {
    echo "Failed to save item.";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>