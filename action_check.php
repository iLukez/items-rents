<?php
session_start();

$servername = "localhost";
$svusername = "root";
$svpassword = "";
$dbname = "rent";

$conn = new mysqli($servername, $svusername, $svpassword, $dbname);

if($_POST["action"] == "login") {

    // Get the email and password from $_POST variables
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Create a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if ($result->num_rows > 0) {
        // Fetch the user record
        $row = $result->fetch_assoc();

        // Save the record's column as $_SESSION variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        if ($row['type'] == 'admin') {
            $_SESSION['admin'] = true;
            header("Location: home_admin.php");
        }
        else {
            header("Location: home.php");
        }
        exit();
    } else {
        // Redirect to login_fail.php
        header("Location: login_fail.php");
        exit();
    }
}
else if ($_POST["action"] == "register") {

    // Get the email and password from $_POST variables
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Create a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=? AND username=?");

    $stmt->bind_param("sss", $email, $password, $username);

    $stmt->execute();
    $result = $stmt->get_result();

    if(isset($result->num_rows) && $result->num_rows > 0){
        echo "<p>Utente già esistente!</p>";
        echo "<p>Torna a pagina di <a href=\"index.php\">login</a></p>";
    }
    else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) Values (?, ?, ?)");

        $stmt->bind_param("sss", $username, $email, $password);

        $stmt->execute();

        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
        header("Location: home.php");
    }
}
else {
    echo "<p>Ops! C'è stato un errore nell'elaborazione della tua richiesta, <ahref='index.html'>riproviamo</a></p>";
}