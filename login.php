<?php
session_start();
include "connect.php";
include "sendMail.php";

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM customer WHERE email=:email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Send login alert email
            sendMail($email, "Login Alert", "Hello {$user['username']},<br>You just logged in to your account.");

            header("Location: index.php#home");
            exit;
        } else {
            $message = "❌ Invalid password.";
            $messageClass = "error";
        }
    } else {
        $message = "❌ No account found with that email.";
        $messageClass = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-container">
    <div class="form-box">
      <h2>Login</h2>
      <p class="subtitle">Welcome back to your dining experience</p>

      <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="input-group">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <div class="input-group">
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <button type="submit" class="btn">Login</button>
        <div class="links">
          <a href="register.php">Create an Account</a> | 
          <a href="forgot_password.php">Forgot Password?</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
