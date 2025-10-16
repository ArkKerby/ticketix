<?php
$servername = "localhost";
$username = "root"; // default sa XAMPP
$password = ""; // usually empty
$dbname = "ticketix";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from form
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

// Encrypt password (good practice)
$hashed = password_hash($pass, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO user_account (username, email, password) VALUES ('$user', '$email', '$hashed')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful! Welcome to Ticketix 🎟️";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
