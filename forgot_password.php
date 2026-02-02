<?php
include "connect.php";

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password='$new_password' WHERE email='$email'";

    if ($conn->query($sql) === TRUE && $conn->affected_rows > 0) {
        $message = "✅ Password updated successfully!";
        $messageClass = "success";
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
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="auth-container">
    <div class="form-box">
      <h2>Reset Password</h2>
      <p class="subtitle">Enter your email and new password</p>

      <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?>">
          <?php echo $message; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="input-group">
          <input type="email" name="email" required>
          <label>Email</label>
        </div>
        <div class="input-group">
          <input type="password" name="new_password" required>
          <label>New Password</label>
        </div>
        <button type="submit" class="btn">Update Password</button>
        <div class="links">
          <a href="login.html">Back to Login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>