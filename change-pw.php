<?php
// Include the database connection file
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $emp_id = $_POST['username'];
    $nic = $_POST['nic'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match!');</script>";
    } else {
        // Prepare and execute SQL query to check if the username and nic match
        $stmt = $connection->prepare("SELECT * FROM users WHERE emp_id = ? AND nic = ?");
        $stmt->bind_param("ss", $emp_id, $nic);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any rows were returned (i.e., the username and nic match)
        if ($result->num_rows > 0) {
            // Update the password for the matching user
            $stmt = $connection->prepare("UPDATE users SET password = ? WHERE emp_id = ? AND nic = ?");
            $stmt->bind_param("sss", $new_password, $emp_id, $nic);

            if ($stmt->execute()) {
              echo "<script>alert('Password changed successfully!');</script>";
              // This will flush the alert to the browser, but won't work with the redirect
              echo "<script>window.location.href = 'user-login.php';</script>";
              exit; // Ensure no further code is executed
          } else {
              echo "<script>alert('Error updating password. Please try again.');</script>";
          }          
        } else {
            // Username and NIC do not match
            echo "<script>alert('Invalid Username or NIC!');</script>";
        }

        // Close the statement and connection
        $stmt->close();
    }
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Change the Password</title>
    <link rel="stylesheet" href="change-pw.css?v=1.0" />
  </head>
  <body>
    <header>
      <nav class="navbar">
        <div class="navbar-logo">
          <img src="images/logo.png" alt="SLT Logo" />
        </div>
        <ul class="navbar-links">
          <li><a href="home.html">Home</a></li>
          <li><a href="#footer">About</a></li>
          <li><a href="#footer">Contact</a></li>
        </ul>
      </nav>
    </header>

    <main class="signup-section">
      <div class="signup-container">
        <h1>Change the Password</h1>
        <form action="change-pw.php" method="POST">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-group">
            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required />
          </div>
          <div class="form-group">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required />
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required />
          </div>
          <button type="submit" class="hero-btn">Change Password</button>
        </form>
        <div class="login-link">
          <p>
            <a href="user-login.php" class="login">Log In</a>
          </p>
        </div>
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
