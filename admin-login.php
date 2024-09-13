<?php
session_start();
include 'db.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password (simple string comparison for plain text passwords)
        if ($password === $row['password']) {
            // Password is correct, start session and redirect to admin.php
            $_SESSION['admin_username'] = $username;
            header("Location: admin.php");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid password. Please try again.'); window.location.href = 'admin-login.php';</script>";
            exit();
        }
    } else {
        // Username not found
        echo "<script>alert('Invalid username. Please try again.'); window.location.href = 'admin-login.php';</script>";
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login - Employee Seat Reservation System</title>
    <link rel="stylesheet" href="login.css?v=1.0" />
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="navbar-logo">
          <img src="images/logo.png" alt="SLT Logo" />
        </div>
        <ul class="navbar-links">
          <li><a href="home.php">Home</a></li>
          <li><a href="#footer">About</a></li>
          <li><a href="#footer">Contact</a></li>
        </ul>
      </nav>
    </header>

    <main class="login-section">
      <div class="login-container">
        <div class="panel-links">
          <a href="user-login.php" class="panel-btn">User</a>
          <a href="#" class="panel-btn">Admin</a>
        </div>

        <h1>Admin-Login</h1>
        <form action="admin-login.php" method="POST">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />
          </div>
          <button class="hero-btn" type="submit">Login</button>
        </form>
        <p>
          <a href="change-pw.php" class="change-pw">Change the password</a>
        </p>
      </div>
    </main>

    
    <footer id="footer" class="footer">
      <div class="footer-container">
        <div class="contact-details">
          <h3>Contact us</h3>
          <p>support@slt.lk | +94 11 2 123456</p>
        </div>

        <div class="social-media">
          <div class="contact-details">
            <h3>Follow us</h3>
          <a
            href="https://www.facebook.com/slt"
            target="_blank"
            aria-label="Facebook"
          >
            <img src="images/facebook-icon.png" alt="Facebook" />
          </a>
          <a
            href="https://www.twitter.com/slt"
            target="_blank"
            aria-label="Twitter"
          >
            <img src="images/twitter-icon.png" alt="Twitter" />
          </a>
          <a
            href="https://www.instagram.com/slt"
            target="_blank"
            aria-label="Instagram"
          >
            <img src="images/instagram-icon.png" alt="Instagram" />
          </a>
          <a
            href="https://www.youtube.com/slt"
            target="_blank"
            aria-label="YouTube"
          >
            <img src="images/youtube-icon.png" alt="YouTube" />
          </a>
        </div>
      </div>

      <div class="footer-content">
        <p>
          &copy; 2024 SLT Employee Seat Reservation System. All rights reserved.
        </p>
      </div>
    </footer>
  </body>
</html>
