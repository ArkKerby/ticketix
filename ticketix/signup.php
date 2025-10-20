<?php
session_start();

// Connect sa MySQL database mo
$conn = new mysqli("localhost", "root", "", "ticketix");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted and validate required fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['birthday']) || empty($_POST['contact'])) {
        die("Error: All fields are required!");
    }
    
    // Kunin ang data galing sa form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $contact = $_POST['contact'];
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format!");
    }
    
    // Validate contact number format (11 digits)
    if (!preg_match('/^[0-9]{11}$/', $contact)) {
        die("Error: Contact number must be exactly 11 digits!");
    }
    
    // I-encrypt ang password bago i-save
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Ipasok sa database (using actual column names from DATABASE FULL.sql)
    $sql = "INSERT INTO user_account (fullName, user_password, birthdate, contNo, time_created, user_status)
            VALUES ('$fullname', '$hashed_password', '$birthday', '$contact', NOW(), 'online')";
    
    if ($conn->query($sql) === TRUE) {
        // Get the newly created user's ID
        $user_id = $conn->insert_id;
        
        // Set session variables to automatically log the user in
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['logged_in'] = true;
        
        // Registration successful - redirect to homepage (user is now logged in)
        header("Location: TICKETIX NI CLAIRE.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirect to the signup form if accessed directly
    header("Location: signup.html");
    exit();
}

$conn->close();
?>