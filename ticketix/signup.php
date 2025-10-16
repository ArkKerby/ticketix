<?php
// Connect sa MySQL database mo
$conn = new mysqli("localhost", "root", "", "ticketix");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kunin ang data galing sa form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// I-encrypt ang password bago i-save
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Ipasok sa database (example table: user_account)
$sql = "INSERT INTO user_account (fName, lName, user_password, time_created, status)
        VALUES ('$username', '$email', '$hashed_password', NOW(), 'offline')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>