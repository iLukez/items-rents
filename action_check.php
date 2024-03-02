<?php
session_start();

if($_POST["action"] == "login") {
    // Assuming you have already established a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rent";

    $conn = new mysqli($servername, $username, $password, $dbname);

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
        $_SESSION['user_name'] = $row['name'];

        // Redirect to home.php
        header("Location: home.php");
        exit();
    } else {
        // Redirect to login_fail.php
        header("Location: login_fail.php");
        exit();
    }
}
else if ($_POST["action"] == "register") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rent";

    // Get the email and password from $_POST variables
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Create a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? and pw=? and username=?");

    $stmt->bind_param("sss", $email, $pw, $username);

    $stmt->execute();
    $result = $stmt->get_result();

    if(isset($result->num_rows) && $result->num_rows > 0){
        echo "<p>Utente già esistente!</p>";
        echo "<p>Torna a pagina di <a href=\"index.php\">login</a></p>";
    }
    else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, pw) Values (?, ?, ?)");

        $stmt->bind_param("sss", $username, $email, $pw);

        $stmt->execute();
        header("Location: home.php");
    }
}
else {
    echo "<p>Ops! C'è stato un errore nell'elaborazione della tua richiesta, <ahref='index.html'>riproviamo</a></p>";
}