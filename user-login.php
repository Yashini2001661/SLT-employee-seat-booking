<?php
session_start();
include 'db.php'; // This includes your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // SQL query to fetch information of registered users and finds user match.
    $query = "SELECT * FROM users WHERE emp_id='$emp_id' AND password='$password'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 1) {
        // Login successful
        $_SESSION['login_user'] = $emp_id;
        header("location: new-date.php"); // Redirect to welcome page
        exit(); // Ensure script stops after redirect
    } else {
        // Login failed
        echo "<script>alert('Invalid Username or Password');</script>";
    }

    mysqli_close($connection); // Close connection
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Employee Seat Reservation System</title>
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
          <a href="#" class="panel-btn">User</a>
          <a href="admin-login.php" class="panel-btn">Admin</a>
        </div>

        <h1>User-Login</h1>
        <form action="user-login.php" method="POST">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="emp_id" required />
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
