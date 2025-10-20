<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Only access $_POST when the form is submitted
    $input = $_POST['email_or_username'] ?? '';
    $password = $_POST['password'] ?? '';

    $conn = new mysqli("localhost", "root", "", "ticketix");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query using actual database columns (fullName instead of email/username)
    $query = "SELECT * FROM user_account WHERE fullName = '$input'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare passwords using password_verify for hashed passwords
        if (password_verify($password, $row['user_password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['acc_id'];
            $_SESSION['user_name'] = $row['fullName'];
            $_SESSION['logged_in'] = true;
            
            // Update user status to online
            $update_query = "UPDATE user_account SET user_status = 'online' WHERE acc_id = " . $row['acc_id'];
            $conn->query($update_query);
            
            // Redirect to homepage
            header("Location: TICKETIX NI CLAIRE.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="brand x.png">

  <title>Login - Ticketix</title>
  <style>
    body {
      background-color: black;
      color: white;
      font-family: 'Montserrat', Helvetica, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    h2 {
      margin-bottom: 20px;
      color: white;
    }

    form {
      display: flex;
      flex-direction: column;
      background: linear-gradient(to bottom, #00BFFF, #3C50B2);
      padding: 30px;
      border-radius: 10px;
      width: 300px;
    }

    input {
      margin: 10px 0;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

    button {
      padding: 10px;
      background-color: #00BFFF;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #3C50B2;
    }

    a {
      color: white;
      text-decoration: none;
      text-align: center;
      margin-top: 10px;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h2>Login to Ticketix</h2>
  <?php if (isset($error_message)): ?>
    <div style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $error_message; ?></div>
  <?php endif; ?>
  <form action="login.php" method="POST">
    <input type="text" name="email_or_username" placeholder="Full Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <a href="signup.html">Don't have an account? Sign up</a>
    <a href="TICKETIX NI CLAIRE.php">Back to Home</a>
  </form>
</body>
</html>
