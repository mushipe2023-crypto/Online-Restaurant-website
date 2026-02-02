<?php
include "connect.php";

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO customer (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Registration successful! You can now login.";
        $messageClass = "success";
    } else {
        $message = "❌ Error: " . $conn->error;
        $messageClass = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-container">
    <div class="form-box">
      <h2>Create Account</h2>
      <p class="subtitle">Join us for an amazing dining journey</p>

      <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form action="register.php" method="POST">
        <div class="input-group">
          <input type="text" name="username" required>
          <label>Username</label>
        </div>
        <div class="input-group">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <div class="input-group">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <button type="submit" class="btn">Register</button>
        <div class="links">
          <a href="login.php">Back to Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>